<div class="modal fade" id="modal-position" role="dialog" aria-labelledby="modal-default-popout" aria-hidden="true"
    data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="block-title">New Position</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row mb-2">
                        <form id="positionForm" method="POST">
                            @csrf
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <input type="hidden" id="positionId">
                                    <input type="text" class="form-control" id="positionName"
                                        placeholder="Group Name" required>
                                    <label for="">Position Name</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-floating">
                                    <textarea name="jobDescription" id="jobDescription" class="form-control"></textarea>
                                    <label for="">Job Description</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="submit" class="btn btn-md btn-primary" onclick="savePosition()">Save</button>
                    <button type="button" class="btn btn-md btn-alt-secondary" data-bs-dismiss="modal" onclick="clearModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
