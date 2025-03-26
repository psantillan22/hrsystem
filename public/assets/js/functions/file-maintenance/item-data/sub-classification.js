$(document).ready(function () {
    $('.js-select2').select2({
        placeholder: 'Select an option',
        dropdownParent: '#modal-sub-classification',
    });

    loadClassification();

    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadSubClassification();

    function loadSubClassification() {
        if ($.fn.DataTable.isDataTable('#subclassificationTable')) {
            $('#subclassificationTable').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class SubClassificationTable {
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
                Dashmix.onLoad(() => SubClassificationTable.init());
            } else {
                SubClassificationTable.init();
            }
        })();

        $('#subclassificationTable').DataTable({
            ajax: {
                url: '/sub_classification/data',
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
                    data: 'CLASSIFICATION_ID'
                },
                {
                    data: 'SUB_CLASSIFICATION'
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
                    targets: [3],
                    width: "7%"
                },
                {
                    targets: [0, 3],
                    className: "text-center"
                }
            ],
            pagingType: "full_numbers",
            pageLength: 15,
            lengthMenu: [
                [15, 20, 25],
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
                    jQuery("#modal-sub-classification").modal("show"); // Open modal
                });
                jQuery("#btnEdit").on("click", function () {
                    alert("Edit button clicked!");
                });
                jQuery("#btnDelete").on("click", function () {
                    alert("Delete button clicked!");
                });
                jQuery("#btnRefresh").on("click", function () {
                    location.reload();
                });
            }
        });
    }

    function loadClassification() {
        $.ajax({
            url: "/classification/list", // Laravel route
            type: "GET",
            success: function (data) {
                let options = '<option value="">Select Classification</option>';
                $.each(data, function (key, classification) {
                    options += `<option value="${classification.IDNo}">${classification.CLASSIFICATION}</option>`;
                });
                $("#selClassification").html(options);
            },
            error: function () {
                alert("Failed to load classifications.");
            }
        });
    }

    $("#selClassification").on("click", function () {
        loadClassification(); // Reload classifications
    });

    // Clear modal function
    window.clearModal = function () {
        $('#subclassificationId').val('');
        $('#selClassification').val('').trigger('change'); // Reset Select2 properly
        $('#subclassification').val('');
    }

    $('#subclassificationForm').keydown(function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            saveSubClassification(); // Call the save function
        }
    });

    // Save Sub Classification
    window.saveSubClassification = function () {
        let id = $('#subclassificationId').val();
        let classificationId = $('#selClassification').val().trim();
        let subclassification = $('#subclassification').val().trim();
        let url = id ? `/sub_classification/${id}/update` : '/sub_classification/store';

        if (!classificationId && !subclassification) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Classification field is required!'
            });
            return;
        }

        let formData = {
            CLASSIFICATION_ID: classificationId,
            SUB_CLASSIFICATION: subclassification
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }

        // First, check if the classification already exists
        $.ajax({
            url: '/sub_classification/check',
            type: 'POST',
            data: {
                CLASSIFICATION_ID: classificationId,
                SUB_CLASSIFICATION: subclassification
            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'This sub classification already exists in the database!'
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
                                $('#modal-sub-classification').modal('hide');
                                loadSubClassification(); // Reload table
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
                    text: 'Error checking sub classification. Please try again.'
                });
            }
        });
    };


    // Edit Sub Classification
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id");

        $.ajax({
            url: `/sub_classification/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#subclassificationId').val(data.IDNo);
                // $('#selClassification').val(data.CLASSIFICATION_ID);
                $('#subclassification').val(data.SUB_CLASSIFICATION);
                $('#block-title').text("Edit Sub Classification");

                // Ensure select options exist before setting the value
                if ($("#selClassification option[value='" + data.CLASSIFICATION_ID + "']").length > 0) {
                    $('#selClassification').val(data.CLASSIFICATION_ID).trigger('change');
                } else {
                    // If the option is not available, fetch classifications first
                    $.ajax({
                        url: '/classifications/data', // Change to the correct endpoint
                        type: "GET",
                        success: function (response) {
                            let classificationDropdown = $('#selClassification');
                            classificationDropdown.empty(); // Clear existing options
                            response.data.forEach(classification => {
                                classificationDropdown.append(new Option(classification.CLASSIFICATION, classification.IDNo));
                            });

                            // Set the value after loading options
                            classificationDropdown.val(data.CLASSIFICATION_ID).trigger('change');
                        }
                    });
                }

                $('#modal-sub-classification').modal('show');
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
                    url: `/sub_classification/${id}/deactivate`,
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
                            loadSubClassification(); // Reload table
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
