@extends('layout')
@section('title', 'User Management - Accounts')

@section('css')

@endsection

@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
					<div class="block-header block-header-default">
							<h3 class="block-title">
									<div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
											<h1 class="flex-grow-1 fs-4 fw-semibold my-2 my-sm-3">
													<ol class="breadcrumb">
															<li class="breadcrumb-item ">User Management</li>
															<li class="breadcrumb-item active" aria-current="page">Accounts</li>
													</ol>
											</h1>
									</div>
							</h3>
					</div>
        </div>

        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table id ="tbl-account-list" class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th>Username</th>
                                <th class="d-none d-sm-table-cell">Email</th>
                                <th class="d-none d-sm-table-cell">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><input type="checkbox" class="form-check-input" id=""></td>
                                <td>Thomas Riley</td>
                                <td>jeff@email.com</td>
                                <td><span class="badge bg-info status-badge">Business</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- END Page Content -->
    </main>


    <!-- END Main Container -->
@endsection

@include('user-management.modals.account')

@push('scripts')
	<script src="{{ url('/assets/js/functions/user-management/accounts.js') }}"></script>

	<script>
			$('.js-select2').select2({
					dropdownParent: '#modal-create-user'
			});  
	</script>
@endpush
