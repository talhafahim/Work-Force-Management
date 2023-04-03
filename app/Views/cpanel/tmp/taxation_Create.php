<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<style>
.red{
    color: red;
}
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Taxation <small>Create</small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                          <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
                            <span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
                        </a>
                    <?php } ?>
                    </div>
                </div>
                    <!-- <div class="col-sm-6">
                        <div class="float-right">
                          <a type="button" class="btn btn-primary btn-icon" href="<?= base_url();?>/package/create">
                            <span class="btn-icon-label"><i class="fa fa-plus mr-2"></i></span> Create New
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- end row -->
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Instruction</h4>
                        <ul>
                            <li>The field labels marked with <span class="red">*</span> are required input fields</li>
                                <!-- <li>Don't use any capital letter in Customer ID</li>
                                    <li>First character of user id should be alphabet</li> -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">    
                                <form oldid="custAddForm" id="form-horizontal" class="form-horizontal form-wizard-wrapper">
                                    <!-- <h5>Customer Detail</h5> -->
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group"> 
                                                        <label>For City<span class="red">*</span></label>
                                                        <select class="form-control select2" name="city" required>
                                                            <option value="">Select City</option>
                                                            <?php foreach($cities->get()->getResult() as $value){?>
                                                                <option value="<?= $value->city;?>"><?= $value->city;?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <br>
                                                                <label>Internet Rate (PKR)<span class="red">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input name="int-sst" id="int-sst" cat="int" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input name="int-adv" id="int-adv" cat="int" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                            <br>
                                                                <label>TV Rate (PKR)<span class="red">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input name="tv-sst" id="tv-sst" cat="tv" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input name="tv-adv" id="tv-adv" cat="tv" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                            <br>
                                                                <label>Phone Rate (PKR)<span class="red">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input name="ph-sst" id="ph-sst" cat="ph" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input name="ph-adv" id="ph-adv" cat="ph" type="number" class="form-control calculate" max="100" min="0" value="0" step="0.01" required>
                                                            </div>
                                                        </div>

                                                    </div>

  
                                                </div>

                                            </div>


                                        </div>


                                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light m-3" style="float:right;"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>

    <!-- content -->
  
<?php 
echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>
<!-- <script>
    $(document).on('change keyup','.calculate',function(){
        var cat = $(this).attr('cat');
        var rate = $("#"+cat+"-rate").val();
        var sst = $("#"+cat+"-sst").val();
        var adv = $("#"+cat+"-adv").val();
        //
        sst = (parseFloat(sst) / 100) * parseFloat(rate);
        adv = (parseFloat(adv) / 100) * parseFloat(rate);
        var sum = parseFloat(rate) + parseFloat(sst) + parseFloat(adv);
        $("#"+cat+"-sum").html(sum);
        //
        var subtotal = parseFloat($("#int-sum").html()) + parseFloat($("#tv-sum").html()) + parseFloat($("#ph-sum").html());
        $("#subtotal").html(subtotal);
    });
</script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $("#form-horizontal").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/taxation/create_txt',
                data:$("#form-horizontal").serialize(),
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        setTimeout(function(){ 
                            window.location.href = "<?= base_url();?>/taxation";
                        }, 2000);
                    }else{
                        setTimeout(function(){ 
                            $('#action_loader').modal('hide');
                            toastr.error(data);
                        }, 500);    
                    }
                },
                error: function(jqXHR, text, error){
                    setTimeout(function(){ 
                        $('#action_loader').modal('hide');
                        toastr.error(error);
                    }, 500);
                }
            });
            return false;
        });
    });
</script>



