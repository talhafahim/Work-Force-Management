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
						<h4 class="page-title">Package <small>Create (TV)</small></h4>
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
                                                <div class="col-sm-3">
                                                    <div class="form-group"> 
                                                        <label>For City<span class="red">*</span></label>
                                                        <select class="form-control select2 city" name="city" required>
                                                            <option value="">Select City</option>
                                                            <?php foreach($cities->get()->getResult() as $value){?>
                                                                <option value="<?= $value->city;?>"><?= $value->city;?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group"> 
                                                        <label>Package Name<span class="red">*</span></label>
                                                        <input name="pkgname" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                 <div class="col-sm-3">
                                                    <div class="form-group"> 
                                                        <label>TV Box</label>
                                                        <input name="tvBox" type="number" class="form-control" required min="1">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <!-- <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>Rate (PKR)<span class="red">*</span></label>
                                                                <input name="int-rate" id="int-rate" cat="int" type="number" class="form-control calculate" min="0" value="0" step="0.1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input id="int-sst" cat="int" type="hidden" class="calculate" value="0">
                                                                <h5 id="int-sst-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input id="int-adv" cat="int" type="hidden" class="calculate" value="0">
                                                                <h5 id="int-adv-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label><span class="red"></span></label>
                                                            <h1><center>=</center></h1>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label><span class="red"></span></label>
                                                            <h1><center id="int-sum">0</center></h1>
                                                        </div>
                                                    </div> -->

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>TV Rate (PKR)<span class="red">*</span></label>
                                                                <input name="tv-rate" id="tv-rate" cat="tv" type="number" class="form-control calculate" min="0" value="0" step="0.1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input id="tv-sst" cat="tv" type="hidden" class="calculate">
                                                                <h5 id="tv-sst-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input id="tv-adv" cat="tv" type="hidden" class="calculate">
                                                                <h5 id="tv-adv-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h1><center>=</center></h1>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h1><center id="tv-sum">0</center></h1>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group"> 
                                                                <label>Phone Rate (PKR)<span class="red">*</span></label>
                                                                <input name="ph-rate" id="ph-rate" cat="ph" type="number" class="form-control calculate" min="0" value="0" step="0.1" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>SS Tax (%)<span class="red">*</span></label>
                                                                <input id="ph-sst" cat="ph" type="hidden" class="calculate">
                                                                <h5 id="ph-sst-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group"> 
                                                                <label>ADV Tax (%)<span class="red">*</span></label>
                                                                <input id="ph-adv" cat="ph" type="hidden" class="calculate">
                                                                <h5 id="ph-adv-h5">0.00</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h1><center>=</center></h1>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h1><center id="ph-sum">0</center></h1>
                                                        </div>
                                                    </div> -->

                                                   <!--  <div class="row">
                                                        <div class="col-sm-8">
                                                         <h3 style="float:right;">Sub Total</h3> 
                                                     </div>
                                                     <div class="col-sm-2">
                                                        <h3><center>=</center></h3>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <h3><center id="subtotal">0</center></h3>
                                                    </div>
                                                </div> -->

                                            </div>


                                        </div>


                                        <button type="submit" class="btn btn-success mr-1 waves-effect waves-light pull-right" style="float:left;">Create Package  </button>
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
<script>
    $(document).on('change keyup','.calculate',function(){
        calculate();
    });

    function calculate(){

        const array = ["int", "tv", "ph"];
        
        array.forEach(function (item, index) {
        //    
        var cat = item;
        // var cat = $(this).attr('cat');
        var rate = $("#"+cat+"-rate").val();
        var sst = $("#"+cat+"-sst").val();
        var adv = $("#"+cat+"-adv").val();
        //
        sst = (parseFloat(sst) / 100) * parseFloat(rate);
        adv = (parseFloat(adv) / 100) * parseFloat(rate);
        var sum = parseFloat(rate) + parseFloat(sst) + parseFloat(adv);
        $("#"+cat+"-sum").html(sum);
        //
        });
        //
        var subtotal = parseFloat($("#int-sum").html()) + parseFloat($("#tv-sum").html()) + parseFloat($("#ph-sum").html());
        subtotal = parseFloat(subtotal).toFixed(2);
        //
        $("#subtotal").html(subtotal);
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#form-horizontal").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/package/create_tv_pkg_action',
                data:$("#form-horizontal").serialize(),
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        setTimeout(function(){ 
                            window.location.href = "<?= base_url();?>/package/tv";
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

<script>
    $(document).on('change','.city',function(){
        var city = $(this).val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?php echo base_url();?>/package/get_tax',
            data:'city='+city,
    //for posting multiple variable
    // data:'name='+val+'&age='+age,
    success: function(data){
        // for get return data
        $('#int-sst').val(data.int_sst);
        $('#int-sst-h5').html(data.int_sst);
        $('#int-adv').val(data.int_adv);
        $('#int-adv-h5').html(data.int_adv);
        //
        $('#tv-sst').val(data.tv_sst);
        $('#tv-sst-h5').html(data.tv_sst);
        $('#tv-adv').val(data.tv_adv);
        $('#tv-adv-h5').html(data.tv_adv);
        //
        $('#ph-sst').val(data.phone_sst);
        $('#ph-sst-h5').html(data.phone_sst);
        $('#ph-adv').val(data.phone_adv);
        $('#ph-adv-h5').html(data.phone_adv);
        //
        calculate();
    }
});
    });
</script>



