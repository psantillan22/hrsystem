$(document).ready(function () {
    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadItemSource();

    function loadItemSource() {
        if ($.fn.DataTable.isDataTable('#itemSourceTable')) {
            $('#itemSourceTable').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class ItemSourceTable {
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
                Dashmix.onLoad(() => ItemSourceTable.init());
            } else {
                ItemSourceTable.init();
            }
        })();

        $('#itemSourceTable').DataTable({
            ajax: {
                url: '/item_source/data',
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
                    data: 'ITEM_SOURCE'
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
                    jQuery("#modal-item-source").modal("show"); // Open modal
                });
            }
        });
    }

    // Clear modal function
    window.clearModal = function () {
        $('#itemSourceId').val('');
        $('#itemSource').val('');
    }

    // Enter key event
    $('#itemSourceForm').keydown(function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            saveItemSource(); // Call the save function
        }
    });

		//Save ItemSource
    window.saveItemSource = function () {
        let id = $('#itemSourceId').val();
        let itemSource = $('#itemSource').val().trim();
        let url = id ? `/item_source/${id}/update` : '/item_source/store';

        if (!itemSource) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Item Source field is required!'
            });
            return;
        }

        let formData = {
            ITEM_SOURCE: itemSource
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }

        // First, check if the Item Source already exists
        $.ajax({
            url: '/item_source/check',
            type: 'POST',
            data: {
                ITEM_SOURCE: itemSource
            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'This Item source already exists in the database!'
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
                                $('#modal-item-source').modal('hide');
                                loadItemSource(); // Reload table
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
                    text: 'Error checking item source. Please try again.'
                });
            }
        });
    };


    // Edit Item Source
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id");

        $.ajax({
            url: `/item_source/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#itemSourceId').val(data.IDNo);
                $('#itemSource').val(data.ITEM_SOURCE);
                $('#block-title').text("Edit Item Source");
                $('#modal-item-source').modal('show');
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

    // Delete Item Source
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
                    url: `/item_source/${id}/deactivate`,
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
                            loadItemSource(); // Reload table
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
