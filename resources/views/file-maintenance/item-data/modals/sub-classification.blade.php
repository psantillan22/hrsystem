<div class="modal fade" id="modal-sub-classification" role="dialog" aria-labelledby="modal-default-popout"
    aria-hidden="true" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="block-title">New Sub Classification</h3>
                </div>
                <div class="block-content">
                    <div class="row mb-2">
                        <form id="subclassificationForm" method="POST">
                            @csrf
                            <input type="hidden" id="subclassificationId">

                            <div class="row mb-2">
                                <div class="sm-12">
                                    <div class="form-floating">
                                        <select class="form-select js-select2" id="selClassification"
                                            style="width: 100%; height: 100px;;"
                                            data-placeholder="Select Classification" required>
                                            <option></option>
                                        </select>
                                        <label for=""></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subclassification"
                                            placeholder="Sub Classification" required>
                                        <label for="">Sub Classification</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="submit" class="btn btn-md btn-primary"
                        onclick="saveSubClassification()">Save</button>
                    <button type="button" class="btn btn-md btn-alt-secondary" data-bs-dismiss="modal" onclick="clearModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
