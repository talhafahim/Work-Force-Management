  <!-- Top Bar Start -->
 <style>
   .search_dropdown{
      display:none;
    position: absolute;
    /* bottom: 0; */
    width: 100%;
    max-height: 200px;
    /*overflow-y: auto;*/
    background: #000;
    margin-top: 7px;
    /* padding: 10px; */
    border-radius: 3px;
   }
   .search_dropdown.open{
      display: block;
   }
   .search_dropdown li{
      padding: 10px 0;
   }
 </style>
 <!-- Top Bar Start -->
 <div class="topbar">
   <!-- LOGO -->
   <div class="topbar-left"><a href="" class="logo">
   	<span class="mini-logo">
        <img src="<?= base_url();?>/assets/images/logo-sm.png?t=<?php echo time(); ?>" alt="" height="50">

        <!-- <img src="<= base_url();?>/assets/images/bo-logo.png" alt="" height="50">  -->
        <!-- <p style="color:white;">BLACK OPTIC</p> -->
     </span>
     <span class="large-logo">
     <img src="<?= base_url();?>/assets/images/logo.png?t=<?php echo time(); ?>" alt="" width="150">

     </span>
     <!-- <i> -->
        <!-- <img src="<?= base_url();?>/assets/images/bo-logo-sm.png" alt="" height="50"> -->
        <!-- {{asset('img/loading.gif')}} -->
        <!-- <p style="color:white;">BLACK OPTIC</p> -->
     <!-- </i> -->
   </a></div>
   <?php $searchClass = (session()->get('status') == 'customer') ? 'd-none' : '';?>
     <nav class="navbar-custom">
      <ul class="navbar-right list-inline float-right mb-0">
         <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
            <!-- <form role="search" class="app-search <?=$searchClass;?>">
               <div class="form-group mb-0">
                  <input type="text" class="form-control" placeholder="Search.." id="search_input" autocomplete="off"> 
                  <button type="submit"><i class="fa fa-search"></i></button>
               </div>
            </form> -->
            <!-- <div class="search_dropdown">

               <div class="slim--dropdown slimscroll notification-item-list" style="height:auto !important">
                  

               </div>
            </div> -->
         </li>
         <!-- language-->
        <!--  <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
            <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><img src="assets/images/flags/us_flag.jpg" class="mr-2" height="12" alt=""> English <span class="mdi mdi-chevron-down"></span></a>
            <div class="dropdown-menu dropdown-menu-right language-switch"><a class="dropdown-item" href="#"><img src="assets/images/flags/germany_flag.jpg" alt="" height="16"><span>German </span></a><a class="dropdown-item" href="#"><img src="assets/images/flags/italy_flag.jpg" alt="" height="16"><span>Italian </span></a><a class="dropdown-item" href="#"><img src="assets/images/flags/french_flag.jpg" alt="" height="16"><span>French </span></a><a class="dropdown-item" href="#"><img src="assets/images/flags/spain_flag.jpg" alt="" height="16"><span>Spanish </span></a><a class="dropdown-item" href="#"><img src="assets/images/flags/russia_flag.jpg" alt="" height="16"><span>Russian</span></a></div>
         </li> -->
         <!-- full screen -->
         <!-- <li class="dropdown notification-list list-inline-item d-none d-md-inline-block"><a class="nav-link waves-effect" href="#" id="btn-fullscreen"><i class="mdi mdi-fullscreen noti-icon"></i></a></li> -->
         <!-- notification -->
         <li class="dropdown notification-list list-inline-item <?=$searchClass;?>">
            <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><i class="mdi mdi-bell-outline noti-icon"></i> <span class="badge badge-pill badge-danger noti-icon-badge">3</span></a> -->
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
               <!-- item-->
               <h6 class="dropdown-item-text">Notifications (258)</h6>
               <div class="slimscroll notification-item-list">
                  <!-- item--> 
                  <a href="javascript:void(0);" class="dropdown-item notify-item active">
                     <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                     <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                  </a>
                  <!-- item--> 
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                     <div class="notify-icon bg-warning"><i class="mdi mdi-message-text-outline"></i></div>
                     <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                  </a>
                  <!-- item--> 
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                     <div class="notify-icon bg-info"><i class="mdi mdi-glass-cocktail"></i></div>
                     <p class="notify-details">Your item is shipped<span class="text-muted">It is a long established fact that a reader will</span></p>
                  </a>
                  <!-- item--> 
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                     <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                     <p class="notify-details">Your order is placed<span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                  </a>
                  <!-- item--> 
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                     <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                     <p class="notify-details">New Message received<span class="text-muted">You have 87 unread messages</span></p>
                  </a>
               </div>
               <!-- All--> <a href="javascript:void(0);" class="dropdown-item text-center text-primary">View all <i class="fi-arrow-right"></i></a>
            </div>
         </li>
         <li class="dropdown notification-list list-inline-item">
            <div class="dropdown notification-list nav-pro-img">
               <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                  <img src="<?= base_url();?>/assets/images/bo-avatar.png" alt="user" class="rounded-circle">
               </a>
               <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                  <!-- item--> 
                  <?php if(session()->get('status') == 'admin'){?>
                     <a class="dropdown-item" href="<?= base_url();?>/settings"><i class="fa fa-cog"></i> Settings</a> 
                  <?php } if(session()->get('status') == 'customer'){?>
                  <a class="dropdown-item" href="<?= base_url();?>/customer/profile"><i class="fa fa-user-circle"></i> Profile</a> 
               <?php }else{?>
                  <a class="dropdown-item" href="<?= base_url();?>/user/user-profile"><i class="fa fa-user-circle"></i> Profile</a>
               <?php }?>
                  <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5"></i> My Wallet</a> -->
                  <!-- <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings m-r-5"></i> Settings</a>  -->
                  <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a> -->
                  
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" id="logoutBtn" href="#"><i class="fa fa-power-off"></i> Logout</a>
               </div>
            </div>
         </li>
      </ul>
      <ul class="list-inline menu-left mb-0">
         <li class="float-left"><button class="button-menu-mobile open-left waves-effect"><i class="mdi mdi-menu"></i></button></li>
         <!-- <li class="d-none d-sm-block">
            <div class="dropdown pt-3 d-inline-block">
               <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create</a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Separated link</a>
               </div>
            </div>
         </li> -->
      </ul>
   </nav>
</div>
         <!-- Top Bar End -->