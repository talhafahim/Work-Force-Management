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
						<h4 class="page-title">Settings</h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
                          <form class="p-x-xs" id="settingsForm">
                            <input type="hidden" name="loginOTP" value="disable">

                            <div class="form-group row" style="display:none;">
                                <label class="col-sm-2 col-form-label">Login OTP</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-2">
                                         <div class="form-group">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="loginOTP" id="loginOTP" switch="success" value="enable"  <?= ($loginOTP->value == 'enable') ? 'checked' : ''; ?> />
                                            <label for="loginOTP" data-on-label="Yes" data-off-label="No"></label>									
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Maintanance Mode</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-2">
                                     <div class="form-group">
                                        <input type="hidden" name="mMode" value="disable"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="mMode" id="mMode" switch="success" value="enable" <?= ($mMode->value == 'enable') ? 'checked' : ''; ?> />
                                        <label for="mMode" data-on-label="Yes" data-off-label="No"></label>									
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="mModeIPs" placeholder="Allow IPs" value="<?= $mMode->parameter;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Application Title</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="appTitle" placeholder="App Title" value="<?= $appTitle->parameter;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Application Logo</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="appLogo">
                                </div>
                                <div class="col-md-4">
                                    <img src="<?= base_url();?>/assets/images/logo.png?t=<?php echo time(); ?>" style="width:100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Small Logo & Favicon</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="smLogo">
                                </div>
                                <div class="col-md-4">
                                    <img src="<?= base_url();?>/assets/images/logo-sm.png?t=<?php echo time(); ?>" style="width:100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Login Page Background Image</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="backImage">
                                </div>
                                <div class="col-md-4">
                                    <img src="<?= base_url();?>/assets/images/bank/loginBackground.jpg?t=<?php echo time(); ?>" style="width:100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Currency</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-4">
                                   <select class="form-control" name="currency">
                                       <option <?= ($currency->parameter == 'USD') ? 'selected' : '';?> >USD</option>
                                       <option <?= ($currency->parameter == 'AED') ? 'selected' : '';?> >AED</option>
                                       <option <?= ($currency->parameter == 'PKR') ? 'selected' : '';?> >PKR</option>
                                       <option <?= ($currency->parameter == 'EUR') ? 'selected' : '';?> >EUR</option>
                                   </select>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Footer Text</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="footerText" placeholder="Footer Text" value="<?= $footerText->parameter;?>">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <!-- <label class="col-sm-2 col-form-label">Maintanance Mode</label> -->
                                <div class="col-sm-12 ">
                                    <div class="d-flex justify-content-end">
                                       <button class="btn btn-primary" type="submit">Save</button>

                                   </div>
                                   
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
echo view('cpanel-layout/footer');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#settingsForm").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/settings/update',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    toastr.success(data);
                    setTimeout(function() { 
                        $('#action_loader').modal('hide');
                        location.reload();
                    }, 1000);
                    
                },  
                error: function(jqXHR, text, error){
                    // Displaying if there are any errors
                    $('#action_loader').modal('hide');
                    toastr.danger(error); 
                    
                }
            });
            return false;
        });
    });
</script>
