$(document).ready(function () {
    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadDepartmentGroup();

    function loadDepartmentGroup() {
        if ($.fn.DataTable.isDataTable('#departmentGrpTbl')) {
            $('#departmentGrpTbl').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class DepartmentGroupTable {
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
                Dashmix.onLoad(() => DepartmentGroupTable.init());
            } else {
                DepartmentGroupTable.init();
            }
        })();

        $('#departmentGrpTbl').DataTable({
            ajax: {
                url: '/department/group',
                type: 'GET',
                dataSrc: 'data'
            },
            dom: '<"d-flex justify-content-between align-items-center"<"custom-btn-group">f><"table-responsive"t><"bottom d-flex justify-content-between"ip>',
            order: [
                [1, "asc"]
            ],
            columns: [
                {
                    data: 'group_name'
                },
                {
                    data: 'headed_by'
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary btn-edit" data-id="${data}" title="Edit Selected">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${data}" title="Delete Selected">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets: [2],
                    className: "text-center"
                },
                {
                    targets: [0],
                },
                {
                    targets: [2],
                    width: "8%"
                },
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

                jQuery("#btnNew").on("click", function () {
                    jQuery("#modal-department-group").modal("show"); // Open modal
                });
            }
        });
    }

    // Clear modal function
    window.clearModal = function () {
        $('#groupName').val('');
        $('#headedBy').val('');
    }

    $('#departmentGroupForm').submit(function (event) {
        saveClassification(); 
    });


    // Enter key event
    $('#departmentGroupForm').keydown(function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            saveClassification(); // Call the save function
        }
    });

    
		//Save Classification
    window.saveClassification = function () {
        let id = $('#departmentGroupId').val();
        let group = $('#groupName').val().trim();
        let head = $('#headedBy').val();
        let url = id ? `/department/group/${id}/update` : '/department/group/store';

        if (!group) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Group Name field is required!'
            });
            return;
        }

        let formData = {
            group_name: group,
            headed_by: head,
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }

        // First, check if the classification already exists
        $.ajax({
            url: '/department/group/check',
            type: 'POST',
            data: {
                group_name: group
            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'This group name already exists in the database!'
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
                                $('#modal-department-group').modal('hide');
                                loadDepartmentGroup(); // Reload table
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
            url: `/department/group/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#departmentGroupId').val(data.id);
                $('#groupName').val(data.group_name);
                $('#headedBy').val(data.headed_by);
                $('#block-title').text("Edit Department Group");
                $('#modal-department-group').modal('show');
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
                    url: `/department/group/${id}/deactivate`,
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
