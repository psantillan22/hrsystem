$(document).ready(function () {

    // Automatically add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadSalaryGrade();

    function loadSalaryGrade() {
        if ($.fn.DataTable.isDataTable('#salaryGradeTbl')) {
            $('#salaryGradeTbl').DataTable().destroy(); // Destroy existing instance
        }

        (function () {
            class SalaryGradeTable {
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
                Dashmix.onLoad(() => SalaryGradeTable.init());
            } else {
                SalaryGradeTable.init();
            }
        })();

        $('#salaryGradeTbl').DataTable({
            ajax: {
                url: '/salary-grade',
                type: 'GET',
                dataSrc: 'data'
            },
            dom: '<"d-flex justify-content-between align-items-center"<"custom-btn-group">f><"table-responsive"t><"bottom d-flex justify-content-between"ip>',
            order: [
                [0, "asc"]
            ],
            columns: [
                {
                    data: 'description'
                },
                {
                    data: 'salary_type',
                    render: function (data, type, row) {
                       if(data == 'JL') {
                        return '<span class="badge bg-info">JOB LEVEL<span>';
                       } else if(data == 'SG') {
                        return '<span class="badge bg-info">SALARY GRADE<span>';
                       } else {
                        return '<span class="badge bg-info">JOB GRADE<span>';
                       }
                    },
                },
                {
                    data: 'date_start',
                    render: function (data, type, row) {
                        let date_end = row['date_end'];

                        return `${moment(data).format("MMM DD, YYYY")} - ${moment(date_end).format("MMM DD, YYYY")}`;
                    },
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info btn-edit" data-id="${data}" title="View Selected">
                                    <i class="fa fa-eye"></i>
                                </button>
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
                    targets: [0],
                },
                {
                    targets: [1,3],
                    width: "10%",
                    className: "text-center"

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
                    jQuery("#modal-new-salary-grade").modal("show"); // Open modal
                });
            }
        });
    }

    // Clear modal function
    window.clearModal = function () {
        $('#description').val('');
        $('#salaryType').val('');
        $('#dateStart').val('');
        $('#dateEnd').val('');
    }

    $('#salaryGradeTbl').submit(function (event) {
        saveSG(); 
    });


    // Enter key event
    // $('#departmentForm').keydown(function (event) {
    //     if (event.key === "Enter") {
    //         event.preventDefault(); // Prevent form submission
    //         saveDepartment(); // Call the save function
    //     }
    // });

    //Save Position
    window.saveSG = function () {
        let id = $('#sgId').val();
        let description = $('#description').val();
        let salaryType = $('#salaryType').val();
        let dateStart = $('#dateStart').val();
        let dateEnd = $('#dateEnd').val();
        let url = id ? `/salary-grade/${id}/update` : '/salary-grade/store';

        if (!description || !salaryType || !dateStart || !dateEnd) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Fields is required!'
            });
            return;
        }

        let formData = {
            description: description,
            salary_type: salaryType,
            date_start: dateStart,
            date_end: dateEnd,
        };

        if (id) {
            formData._method = 'PUT'; // Tells Laravel to handle it as a PUT request
        }
       
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
                    $('#modal-new-salary-grade').modal('hide');
                    loadSalaryGrade(); // Reload table
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
    };


    // Edit Classification
    $(document).on("click", ".btn-edit", function () {
        let id = $(this).data("id");

        $.ajax({
            url: `/salary-grade/${id}/edit`,
            type: "GET",
            success: function (data) {
                $('#sgId').val(data.id);
                $('#description').val(data.description);
                $('#salaryType').val(data.salary_type);
                $('#dateStart').val(data.date_start);
                $('#dateEnd').val(data.date_end);
                $('#block-title').text("Edit Salary Grade");
                $('#modal-new-salary-grade').modal('show');
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
                    url: `/salary-grade/${id}/deactivate`,
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
                            loadSalaryGrade(); // Reload table
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
