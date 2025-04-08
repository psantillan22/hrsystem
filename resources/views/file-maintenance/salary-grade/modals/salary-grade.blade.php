<div class="modal fade" id="modal-new-salary-grade" role="dialog" aria-labelledby="modal-default-popout" aria-hidden="true"
    data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="block-title">New Salary Grade</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row mb-2">
                        <form id="salaryGradeForm" method="POST">
                            @csrf
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <input type="hidden" id="sgId">
                                    <input type="text" class="form-control" id="description"
                                        placeholder="Group Name" required>
                                    <label for="">Description</label>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <select name="salaryType" id="salaryType" class="form-control">
                                        <option value="" disabled selected>--SALARY TYPE--</option>
                                        <option value="JL">Job Level</option>
                                        <option value="SG">Salary Grade</option>
                                        <option value="JG">Job Grade</option>
                                    </select>
                                    <label for="">SALARY TYPE</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateStart">
                                        <label for="">Date Start</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateEnd">
                                        <label for="">Date End</label>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="submit" class="btn btn-md btn-primary" onclick="saveSG()">Save</button>
                    <button type="button" class="btn btn-md btn-alt-secondary" data-bs-dismiss="modal" onclick="clearModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
