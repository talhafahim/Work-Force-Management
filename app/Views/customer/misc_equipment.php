<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Equipment <small></small></h4>
					</div>
                    <!-- <div class="col-sm-6">
                        <div class="float-right">
                          <button type="button" class="btn btn-primary btn-icon" onclick="$('#addUserModel').modal('show');">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span>Add New User
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- end row -->
        <!-- <div class="d-flex justify-content-end">
            <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div> -->
        
        <!-- <div class="collapse" id="collapseExample">
            <div class="card">
                <div class="card-body">
                    <form id="addNewCityForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                               <input type="text" class="form-control" placeholder="Equipment Name" name="name" required>
                           </div>
                           <div class="col-md-3 mb-3">
                               <input type="number" step="0.1" class="form-control" placeholder="Stock" name="stock" required>
                           </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    <div class="row">


        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div style="overflow-x:scroll;">
                        <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>In Stock</th>
                                    <th>Utilized</th>
                                    <th>UOM</th>
                                    <th>Rate (<?= get_setting_value('Currency');?>)</th>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                                <?php 
                                $user_id = session()->get('id');
                                //
                                foreach($misc_equipment->get()->getResult() as $key => $value){
                                   $equipInfo = $modelGeneral->get_misc_equipment($value->equip_id)->get()->getRow();
                                   $equipCount = $modelGeneral->get_task_equip_count(null,null,$user_id,null,$value->equip_id)->select('sum(equi.qty) as qty')->get()->getRow();
                                    ?>
                                    <tr>
                                        <td><?= $key+1;?></td>
                                        <td><?= $equipInfo->name;?></td>
                                        <td><?= $value->stock;?></td>
                                        <td><?= $equipCount->qty;?></td>
                                        <td><?= $equipInfo->uom;?></td>
                                        <td><?= $value->rate;?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->
</div>


<!-- sample modal content -->
<div id="updateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Update Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="miscEquipUpdForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    <div class="row">
                            <input type="hidden" name="id" id="id">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="stock" step="0.1" min="0" name="stock" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- content -->

<!-- content -->
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>
<script type="text/javascript">
    $(document).ready( function () {
        $('#table1').DataTable();
    } );
</script>


