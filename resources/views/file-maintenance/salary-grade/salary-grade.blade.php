@extends('layout')
@section('title', 'File Maintenance - Salary Grade')

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
                                <li class="breadcrumb-item ">File Maintenance</li>
                                <li class="breadcrumb-item active" aria-current="page">Salary Grade</li>
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
                    <table id ="salaryGradeTbl"
                        class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                        <thead>
                            <tr>
                                <th>DESCRIPTION</th>
                                <th>SALARY TYPE</th>
                                <th>DATE EFFECTIVE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- END Page Content -->
    </main>


    <!-- END Main Container -->
@endsection

@include('file-maintenance.salary-grade.modals.salary-grade')

@push('scripts')
    <script src="{{ url('/assets/js/functions/file-maintenance/salary-grade/salary-grade.js') }}"></script>
@endpush
