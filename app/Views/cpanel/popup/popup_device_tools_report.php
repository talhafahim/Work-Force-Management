<!-- sample modal content -->
<div id="popup_device_tools_report" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Device & Tools Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deviceReportForm" method="POST" target="_blank" action="<?= base_url();?>/report/device_tools_report" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Device & Tools</label>
                                <select class="form-control globalDeviceList" name="device">
                                    <option value="">select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Status</label>
                                <select class="form-control" name="status">
                                    <option value="">select</option>
                                    <option value="in stock">In Stock</option>
                                    <option value="assigned">Assigned</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Assign To</label>
                                <select class="form-control globalUserList js-select2" name="assignto">
                                    <option value="">select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Serial#</label>
                                <input type="text" class="form-control" name="serial">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Format</label><br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="float:left;">
                                    <label class="btn btn-danger btn-toggle btn-sm ">
                                        <input type="radio" name="format" autocomplete="off" required value="pdf"> <i class="fas fa-file-pdf"></i> PDF
                                    </label>
                                    <label class="btn btn-success btn-toggle btn-sm ">
                                        <input type="radio" name="format" autocomplete="off" required value="excel"> <i class="fas fa-file-excel">  </i> EXCEL
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Generate</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- content -->