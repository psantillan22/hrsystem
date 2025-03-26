@section('css')
    
@endsection

@push('scripts_top')
@endpush

<div class="modal fade" id="modal-create-user" role="dialog" aria-labelledby="modal-default-popout" aria-hidden="true"
    data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">New Account</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input type="text" class="form-control"name="txtFirstname" placeholder="First Name">
                                <label for="">First Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="txtLastname" placeholder="Last Name">
                                <label for="">Last Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">

                            <div class="form-floating">
                                <input type="email" class="form-control" name="txtEmail" placeholder="Email Address">
                                <label for="">Email Address</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">

                            <div class="form-floating">
                                <input type="password" class="form-control" name="txtPassword" placeholder="Password">
                                <label for="">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="txtConPassword"
                                    placeholder="Confirm Password">
                                <label for="">Confirm Password</label>
                            </div>

                        </div>
                    </div>

                    <div class ="mb-3">
                        <select class="form-select js-select2 uom" id="val-selectUOM3" name="cboUom3" style="width: 100%; height: 100px;;" data-placeholder="Unit of Measurement" required>
                            <option></option>
                            <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="javascript">JavaScript</option>
                            <option value="angular">Angular</option>
                            <option value="react">React</option>
                            <option value="vuejs">Vue.js</option>
                            <option value="ruby">Ruby</option>
                            <option value="php">PHP</option>
                            <option value="asp">ASP.NET</option>
                            <option value="python">Python</option>
                            <option value="mysql">MySQL</option>
                        </select>
                    </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-md btn-primary" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-md btn-alt-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- <script src="{{ url('/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.js-select2').select2({
            placeholder: 'Select an option',
            dropdownParent: '#modal-create-user'
        });
    </script>
    <script>
        Dashmix.helpersOnLoad(['jq-select2']);
    </script> --}}
@endpush
