
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>Login | <?= get_setting_value('App Title');?></title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Themesbrand" name="author">
    
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />

    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" href="<?= base_url();?>/assets/images/logo-sm.png?t=<?php echo time(); ?>">
    <!--Chartist Chart CSS -->
    <!-- datepicker -->
    <link href="<?= base_url();?>/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- jvectormap -->
    <link href="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <!--  -->
    <link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- Toast -->
    <link href="<?= base_url();?>/assets/css/toastr.min.css" rel="stylesheet" type="text/css">
    <!-- DATATABLE -->
    <link href="<?= base_url();?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url();?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url();?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />   

    <link href="<?= base_url();?>/assets/css/responsive.css" rel="stylesheet" type="text/css" />   
    <link href="<?= base_url();?>/assets/css/notification_style.css" rel="stylesheet" type="text/css" />   
    <!--  -->
    <style>
        ::-webkit-scrollbar {
            height: 4px;
            width: 4px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #383c40; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #9ea5ab; 
        }
        #output,#loading,#forgotDiv,#floading{
        display: none;
    }
    </style>
</head>
<body>

<div class="account-pages  pt-5 bg-img">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern shadow-none">
                    <div class="card-body">
                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="<?= base_url();?>" class="logo"><img src="<?= base_url();?>/assets/images/logo.png?t=<?php echo time(); ?>" height="50" alt="logo"></a>
                                <h5><?= $appTitle->parameter;?></h5>
                            </div>
                        </div>
                        <div class="p-3"> 
                            <!-- <h4 class="font-18 text-center"><?= $appTitle->parameter;?></h4> -->
                            <!-- <p class="text-muted text-center mb-4">Sign in to continue to Veltrix.</p> -->
                            <form class="form-horizontal" id="loginForm">

                                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="output">
                                    <!-- text here -->
                                </div>
                                <div class="form-group">
                                    <label for="username" class="small-font">Email ID</label>
                                    <input type="email" class="form-control" name="username" id="username" placeholder="Enter email ID or Username" required>
                                </div>

                                <div class="form-group">
                                    <label for="userpassword" class="small-font">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                </div>

                                <!-- <div class="form-group row" id="loginbtn"> -->
                                    <div class="d-flex align-items-center justify-content-between mb-3" >
                                        <div class="">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_check" id="customControlInline">
                                                <label class="custom-control-label small-font" for="customControlInline" style="line-height:2.2"> Show password</label>
                                            </div>
                                        </div>
                                        <div class="">
                                            <!-- <div class="col-12 mt-3"> -->
                                                <!-- <a href="pages-recoverpw-2.html"><i class="mdi mdi-lock"></i> <span class="small-font">Forgot your password?</span></a> -->
                                                <!-- </div> -->
                                            </div>
                                        <!-- <div class="col-sm-6 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light"  type="submit">Log In</button>
                                        </div> -->
                                    </div>
                                    
                                    
                                    <!-- <div class="verification-wrapper">
                                        <input type="hidden" name="recaptchaQ" id="recaptchaQ">
                                        <p class="text-center">Verify that you are human, please choose <span id="shapes" class="font-weight-bold"></span></p>
                                        <div class="shape-wrapper">
                                            <label class="shape-box">
                                                <input type="radio" name="shapAns" value="circle">
                                                <span class="checkmark circle"><img src="assets/images/shapes/new-moon.png" alt="" class="w-100"></span>
                                            </label>
                                            <label class="shape-box">
                                                <input type="radio" name="shapAns" value="triangle">
                                                <span class="checkmark triangle"><img src="assets/images/shapes/up-arrow.png" alt="" class="w-100"></span>
                                            </label>
                                            <label class="shape-box">
                                                <input type="radio" name="shapAns" value="square">
                                                <span class="checkmark square"><img src="assets/images/shapes/square.png" alt="" class="w-100"></span>
                                            </label>
                                            <label class="shape-box">
                                                <input type="radio" name="shapAns" value="star">
                                                <span class="checkmark square"><img src="assets/images/shapes/star.png" alt="" class="w-100"></span>
                                            </label>

                                        </div>
                                    </div> -->
                                    <center>
                                        <div class="spinner-border text-primary" role="status" id="loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </center>
                                    <div class="col-sm-12 text-right mt-4" id="loginbtn">
                                        <button class="btn btn-primary w-md waves-effect waves-light"  type="submit">Log In</button>
                                    </div>
                                    <!-- <div class="form-group mt-2 mb-0 row">
                                        <div class="col-12 mt-3">
                                            <a href="pages-recoverpw-2.html"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                        </div>
                                    </div> -->


                                </form>

                            </div>

                        </div>
                    </div>
                    <!-- <div class="mt-5 text-center text-white-50">
                        
                    </div> -->

                </div>
            </div>
        </div>
    </div>

    <?php
    echo view('cpanel-layout/login_footer.php'); ?>
    <script src="<?= base_url();?>/assets/js/typeit.min.js"></script>


        <!-- <script type="text/javascript">
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
        </script> -->
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
        <script>
            // $(function () {
            //     var parent = $(".shape-wrapper");
            //     var divs = parent.children();
            //     while (divs.length) {
            //         parent.append(divs.splice(Math.floor(Math.random() * divs.length), 1)[0]);
            //     }
            // });
            // $(".shape-wrapper").shuffleChildren();

            // $(document).ready(function() {

            //     $.fn.shuffleChildren = function() {
            //         $.each(this.get(), function(index, el) {
            //             var $el = $(el);
            //             var $find = $el.children();

            //             $find.sort(function() {
            //             return 0.5 - Math.random();
            //             });

            //             $el.empty();
            //             $find.appendTo($el);
            //         });
            //     };
            // })

        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                // var shapes = ['square', 'circle', 'triangle', 'star']
                // var generate = shapes[Math.random()*shapes.length | 0]
                // document.getElementById('shapes').innerHTML = generate;
                // $('#recaptchaQ').val(generate);

                $("#loginForm").submit(function() {
                    // var value = $('input[name="radio"]:checked').val();
                    // var result = generate.localeCompare(value);
                    // if(result == 0){
                        // alert('true');
                    $("#loginbtn").hide();
                    $("#loading").show();
                    $('#output').hide();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url();?>/login/loginCheck',
                        data:$("#loginForm").serialize(),
                        success: function (data) {

                            if(data == 'OTP'){
                                setTimeout(function(){
                                    window.location.href = "<?= base_url();?>/login/generate_otp";
                                }, 2000);
                            }else{
                                $('#loading').show();
                                setTimeout(function(){
                                    window.location.href = "<?= base_url();?>/dashboard";
                                }, 3000);
                            }





        //                     if (data == 'success'){
        //                         setTimeout(function(){ window.location = "<?php echo base_url();?>/login"; }, 1000);
        //                     }else if(data == 'user' || data == 'admin'){
        //                         setTimeout(function(){ window.location = "<?php echo base_url();?>/login/generate_otp"; }, 1000);
        //                     }else if(data == 'customer'){
        //                         setTimeout(function(){ window.location = "<?php echo base_url();?>/login/activation"; }, 1000);
        //                     }else{
        //                         $("#loginbtn").show();
        //                         $("#loading").hide();
        //                             // snack('#d3514d',data,'times');
        //                             $('#output').show();
        //                             $('#output').html(data);
        //                         }
        // // Inserting html into the result div on success
        // $('#output').html(data);
        // setTimeout(function(){ $('#output').fadeOut(); }, 2000);
                        },
                        error: function(jqXHR, text, error){
        // Displaying if there are any errors
                            $('#output').show();
                            $('#output').html(error);
                            $("#loginbtn").show();
                            $("#loading").hide();
                        }
                    });
                    return false;
                    // }else{
                    //     alert('Shape not matched');
                    //     return
                    // }
                    
                });
            });
        </script>
