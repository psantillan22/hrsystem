!(function () {
    class a {
        static initDataTables_accounts() {
            jQuery.extend(jQuery.fn.dataTable.ext.classes, {
                    sWrapper: "dataTables_wrapper dt-bootstrap5",
                    sFilterInput: "form-control",
                    sLengthSelect: "form-select",
                }),
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
                }),
                jQuery(".js-dataTable-responsive").DataTable({
                    dom: '<"top d-flex justify-content-end"<"custom-btn-group">><"d-flex justify-content-between align-items-center"lf><"table-responsive"t><"bottom d-flex justify-content-between"ip>',
                    order: [
                        [1, "desc"]
                    ],
                    columnDefs: [{
                            orderable: false,
                            target: '_all'
                        },
                        {
                            targets: [0],
                            width: "3%"
                        },
                    ],
                    pagingType: "full_numbers",
                    pageLength: 15,
                    lengthMenu: [
                        [15, 20, 25],
                        [15, 20, 25],
                    ],
                    autoWidth: !1,
                    responsive: !0,
                    initComplete: function () {
                        let buttonGroup = `
                        <div class="btn-group mb-2">
                            <button class="btn btn-primary btn-lg" id="btnNew" title="New Record">
                                <i class="fa fa-file"></i>
                            </button>
                            <button class="btn btn-primary btn-lg" id="btnEdit" title="Edit Record">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-primary btn-lg" id="btnDelete" title="Delete Record">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button class="btn btn-primary btn-lg" id="btnRefresh" title="Refresh">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    `;
                        jQuery(".custom-btn-group").html(buttonGroup);

                        // Add event listeners
                        jQuery("#btnNew").on("click", function () {
                            jQuery("#modal-create-user").modal("show"); // Open modal
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
        static init() {
            this.initDataTables_accounts();
        }
    }
    Dashmix.onLoad(() => a.init());
})();
