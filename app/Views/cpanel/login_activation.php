<?php
echo view('cpanel-layout/header.php');
?>
<style>
#output,#loading,#forgotDiv,#floading{
    display: none;
}
.right-text{
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
<div class="account-page-full-height bg-img">
    <div class="overlay-bg"></div>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-4 "style="padding-left: 0;padding-right: 0">
                <div class="account-page-full-height bg-login custom-width">
                    <div class="p-3">
                        <div>
                            <div class="text-center py-4">
                                <a href="index.html" class="logo"><img src="<?= base_url();?>/assets/images/bo-logo.png" height="80" alt="logo"></a>
                            </div>
                            <div class="text-left p-3">
                                <?php if($flag == 'no'){?>
                                    <h4 class="font-18 text-center">Thank you for choosing BlackOptic.</h4>
                                    <h4 class="font-18 text-center">JUST ONE MORE STEP</h4>
                                    <br>
                                    <p class="text-center" style="color: white;background-color: #8bc34a8c;border-radius: 10px;">Kindly check your mail and activate your account.</p>
                                    <p class="" style="text-align: justify;color:white;font-size:12px;">If you cannot see the email from "BlackOptic" in your inbox, make sure to check your SPAM folder</p>
                                <?php }else{?>
                                    <p class="text-center" style="color: #8bc34a8c;font-size:85px;"><i class="fa fa-check-circle"></i></p>
                                    <h4 class="font-18 text-center">Your account has been successfully activated. please login now!</h4>
                                    <center><a href="<?= base_url();?>/login/activation" class="btn btn-primary w-md waves-effect waves-light"  type="button">Log In</a></center>
                                <?php }?>

                                <!--  -->
                            </div>
                           <!--  <div class="mt-5 text-center">
                                <p>Don't have BlackOptic connection? <a href="pages-register-2.html" class="font-500 text-primary"> Apply Now </a> </p>
                            </div> -->
                        </div>
                    </div>

                </div>
                <footer style="width: 100%;">
                    <p class="text-center">© 2021 Blackoptics</p>
                    <p class="text-center">Powered by <i class="mdi mdi-heart text-danger"></i> Logon Broadband Private Ltd</p>
                </footer> 
                 </div>
            <div class="col-xl-9 col-lg-8 d-xl-block d-lg-block d-none" style="padding-top: 100px">
                <div class="container">
                    <div class="text-white pt--b__100">

                        <div class="row">
                            <div class="right-text mb-4" style="width: 75%; margin: auto;height: 120px" >
                                <h1 id="our-moto"></h1>
                            </div>
                        </div>
<!-- 
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4 text-center p-4">
                                            <div class="img-1">
                                                <img src="/assets/images/logo/internet.png" width="80">
                                            </div>
                                            <h5>Internet</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4 text-center p-4">
                                            <div class="img-2">
                                                <img src="/assets/images/logo/tv-logo.png" width="80">
                                            </div>
                                            <h5>TV</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4 text-center p-4">
                                            <div class="img-3">
                                                <img src="/assets/images/logo/phone.png" width="80">
                                            </div>
                                            <h5>Phone</h5>

                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div> 

                <?php
                echo view('cpanel-layout/login_footer.php'); ?>
                 <script src="<?= base_url();?>/assets/js/typeit.min.js"></script>


                <script type="text/javascript">
                    new TypeIt("#our-moto", {
                        strings: "BEST INTERNET SOLUTION INDUSTRY",
                        speed: 60,
                        loop: true
                    })
                    .move(-18)
                    .delete(8)
                    .type('TV', {delay: 500})
                    .pause(300)
                    .delete(2)
                    .type('PHONE', {delay: 500})
                    .pause(300)
                    .delete(5)
                    .type('INTERNET', {delay: 500})
                    .pause(300)
                    .go();
                </script>
                <script type="text/javascript">
                    $('.checkbox_check').click(function(){
                        var x = document.getElementById("password");
                        if ($($(this)).prop('checked')) {   
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#loginForm").submit(function() {
                            $("#loginbtn").hide();
                            $("#loading").show();
                            $('#output').hide();
                            $.ajax({
                                type: "POST",
                                url: '<?php echo base_url();?>/login/opt_confirmation',
                                data:$("#loginForm").serialize(),
                                success: function (data) {
                                    if (data == 'success'){
                                        setTimeout(function(){ window.location = "<?php echo base_url();?>/login"; }, 1000);
                                    }else{
                                        $("#loginbtn").show();
                                        $("#loading").hide();
                                    // snack('#d3514d',data,'times');
                                    $('#output').show();
                                    $('#output').html(data);
                                }
        // Inserting html into the result div on success
        $('#output').html(data);
        setTimeout(function(){ $('#output').fadeOut(); }, 2000);
    },
    error: function(jqXHR, text, error){
        // Displaying if there are any errors
        $('#output').html(error);
    }
});
                            return false;
                        });
                    });
                </script>