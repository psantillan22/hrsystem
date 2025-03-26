$(document).ready(function () {
    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadClassification();

    function loadClassification() {
        if ($.fn.DataTable.isDataTable('#classificationTable')) {
            $('#classificationTable').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class ClassificationTable {
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
                Dashmix.onLoad(() => ClassificationTable.init());
            } else {
                ClassificationTable.init();
            }
        })();

        $('#classificationTable').DataTable({
            ajax: {
                url: '/classifications/data',
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
                    targets: [2],
                    width: "7%"
                },
                {
                    targets: [0, 2],
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
                    jQuery("#modal-classification").modal("show"); // Open modal
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

    // Clear modal function
    window.clearModal = function () {
        $('#classificationId').val('');
        $('#classificationName').val('');
    }

    // Enter key event
    $('#classificationForm').keydown(function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            saveClassification(); // Call the save function
        }
    });

		//Save Classification
    window.saveClassification = function () {
        let id = $('#classificationId').val();
        let classification = $('#classificationName').val().trim();
        let url = id ? `/classification/${id}/update` : '/classification/store';

        if (!classification) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Classification field is required!'
            });
            return;
        }

        let formData = {
            CLASSIFICATION: classification
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }

        // First, check if the classification already exists
        $.ajax({
            url: '/classification/check',
            type: 'POST',
            data: {
                CLASSIFICATION: classification
            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'This classification already exists in the database!'
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
                                $('#modal-classification').modal('hide');
                                loadClassification(); // Reload table
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
                    text: 'Error checking classification. Please try again.'
                });
            }
        });
    };


    // Edit Classification
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id");

        $.ajax({
            url: `/classification/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#classificationId').val(data.IDNo);
                $('#classificationName').val(data.CLASSIFICATION);
                $('#block-title').text("Edit Classification");
                $('#modal-classification').modal('show');
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
                    url: `/classification/${id}/deactivate`,
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
                            loadClassification(); // Reload table
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
