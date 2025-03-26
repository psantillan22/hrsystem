$(document).ready(function () {
    $('.js-select2').select2({
        placeholder: 'Select an option',
        dropdownParent: '#modal-item-master',
    });

    loadSubClassification();

    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadItemMaster();

    function loadItemMaster() {
        if ($.fn.DataTable.isDataTable('#itemMasterTable')) {
            $('#itemMasterTable').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class ItemMasterTable {
                static initDataTables() {
                    jQuery.extend(jQuery.fn.dataTable.ext.classes, {
                        sWrapper: "dataTables_wrapper dt-bootstrap5",
                        sFilterInput: "form-control",
                        sLengthSelect: "form-select",
                    });

                    jQuery.extend(!0, jQuery.fn.dataTable.defaults, {
                        language: {
                            ordering: false,
                            lengthMenu: "_MENU_",
                            search: "_INPUT_",
                            searchPlaceholder: "Search..",
                            info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
                            paginate: {
                                first: '<i class="fa fa-angle-double-left"></i>',
                                previous: '<i class="fa fa-angle-left"></i>',
                                next: '<i class="fa fa-angle-right"></i>',
                                last: '<i class="fa fa-angle-double-right"></i>',
                            },
                        },
                    });
                }

                static init() {
                    this.initDataTables();
                }
            }

            // Ensure Dashmix is available before calling it
            if (typeof Dashmix !== "undefined") {
                Dashmix.onLoad(() => ItemMasterTable.init());
            } else {
                ItemMasterTable.init();
            }
        })();

        $('#itemMasterTable').DataTable({
            ajax: {
                url: '/item_master/data',
                type: 'GET',
                dataSrc: 'data'
            },
            dom: '<"d-flex justify-content-between align-items-center"<"custom-btn-group">f><"table-responsive"t><"bottom d-flex justify-content-between"ip>',
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: 'IDNo'
                },
                {
                    data: 'DESCRIPTION'
                },
                {
                    data: 'MODEL'
                },
                {
                    data: 'DIMENSION'
                },
                {
                    data: 'COLOR'
                },
                {
                    data: 'SUB_CLASSIFICATION'
                },
                {
                    data: 'CLASSIFICATION'
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary btn-edit" data-id="${row.IDNo}" title="Edit Selected">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.IDNo}" title="Delete Selected">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [2]
                },
                {
                    targets: [0],
                    width: "5%"
                },
                {
                    targets: [1],
                    width: "25%"
                },
                {
                    targets: [2, 3, 4],
                    width: "10%"
                },
                {
                    targets: [5,6],
                    width: "15%"
                },
                {
                    targets: [7],
                    width: "7%"
                },
                {
                    targets: [0, 7],
                    className: "text-center"
                }
            ],
            pagingType: "full_numbers",
            pageLength: 15,
            lengthMenu: [
                [15, 20, 25]
            ],
            autoWidth: false,
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search..."
            },
            initComplete: function () {
                let buttonGroup = `
                        <div class="btn-group mb-2">
                            <button class="btn btn-primary btn-lg" id="btnNew" title="New Record">
                                <i class="fa fa-file"></i>
                            </button>
                        </div>
                    `;
                jQuery(".custom-btn-group").html(buttonGroup);

                // Add event listeners
                jQuery("#btnNew").on("click", function () {
                    jQuery("#modal-item-master").modal("show"); // Open modal
                });
            }
        });
    }

    //Load Classification
    function loadSubClassification() {
        $.ajax({
            url: "/sub_classification/list", // Laravel route
            type: "GET",
            success: function (data) {
                let options = '<option value="">Select Sub Classification</option>';
                $.each(data, function (key, sub_classification) {
                    const optText = `${sub_classification.SUB_CLASSIFICATION} [${sub_classification.CLASSIFICATION}]`;
                    options += `<option value="${sub_classification.IDNo}">${optText}</option>`;
                });
                $("#selSubClassification").html(options);
            },
            error: function () {
                alert("Failed to load sub classifications.");
            }
        });
    }

    $("#selSubClassification").on("click", function () {
        loadClassification(); // Reload classifications
    });

    // Clear modal function
    window.clearModal = function () {
        $('#itemId').val('');
        $('#selSubClassification').val('').trigger('change'); // Reset Select2 properly
        $('#description').val('');
        $('#model').val('');
        $('#color').val('');
        $('#dimension').val('');
    }

    // Enter key event
    $('#itemForm').keydown(function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            saveItem(); // Call the save function
        }
    });

    // Save Item
    window.saveItem = function () {
        let id = $('#itemId').val();
        let subClassification = $('#selSubClassification').val().trim();
        let description = $('#description').val().trim();
        let model = $('#model').val().trim();
        let color = $('#color').val().trim();
        let dimension = $('#dimension').val().trim();
        let url = id ? `/item_master/${id}/update` : '/item_master/store';

        if (!subClassification && !description) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Sub Classification fields is required!'
            });
            return;
        }

        if (!description) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Description fields is required!'
            });
            return;
        }

        let formData = {
            SUB_CLASSIFICATION_ID: subClassification,
            DESCRIPTION: description,
            MODEL: model,
            COLOR: color,
            DIMENSION: dimension
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }

        // First, check if the item already exists
        $.ajax({
            url: '/item_master/check',
            type: 'POST',
            data: {
								formData,
            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'This item already exists in the database!'
                    });
                } else {
                    // If not a duplicate, proceed with saving
                    $.ajax({
                        url: url,
                        type: 'POST', // Always send as POST
                        data: formData,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                clearModal(); // Clear modal fields after saving
                                $('#modal-item-master').modal('hide');
                                loadItemMaster(); // Reload table
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error checking item. Please try again.'
                });
            }
        });
    };

    // Edit Sub Item
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id");

        $.ajax({
            url: `/item_master/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#itemId').val(data.IDNo);
                $('#description').val(data.DESCRIPTION);
                $('#model').val(data.MODEL);
                $('#color').val(data.COLOR);
                $('#dimension').val(data.DIMENSION);
                $('#block-title').text("Edit Item");

                // Ensure select options exist before setting the value
                if ($("#selSubClassification option[value='" + data.SUB_CLASSIFICATION_ID + "']").length > 0) {
                    $('#selSubClassification').val(data.SUB_CLASSIFICATION_ID).trigger('change');
                } else {
                    // If the option is not available, fetch classifications first
                    $.ajax({
                        url: '/item_master/data', // Change to the correct endpoint
                        type: "GET",
                        success: function (response) {
                            let subclassificationDropdown = $('#selSubClassification');
                            subclassificationDropdown.empty(); // Clear existing options
                            response.data.forEach(sub_classification => {
                                subclassificationDropdown.append(new Option(sub_classification.SUB_CLASSIFICATION_ID, sub_classification.IDNo));
                            });

                            // Set the value after loading options
                            subclassificationDropdown.val(data.SUB_CLASSIFICATION_ID).trigger('change');
                        }
                    });
                }

                $('#modal-item-master').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch data.'
                });
            }
        });
    });

    // Delete Classification
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This item will be marked as inactive!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, deactivate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/item_master/${id}/deactivate`,
                    type: 'POST',
                    data: {
                        _method: 'PUT'
                    }, // Simulating PUT request
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deactivated!',
                            text: response.success,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            loadItemMaster(); // Reload table
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            }
        });
    });
});
