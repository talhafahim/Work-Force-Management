<?php 
echo view('cpanel-layout/action_loader');
echo view('cpanel/popup/popup_gateway_report');
echo view('cpanel/popup/popup_equipment_report');
echo view('cpanel/popup/popup_device_tools_report');
echo view('cpanel/popup/popup_task_report');
echo view('cpanel/popup/popup_users_report');
echo view('cpanel/popup/popup_sim_report');
echo view('cpanel/popup/popup_profie_loss_report');
echo view('cpanel/popup/popup_day_routine_report');
?>
<style>
  .call-wrapper{
    display: flex;
    column-gap: 20px;
  }
  .call-container ul li{
    margin: 10px 0;
    padding-bottom: 10px;

  }
  .call-container ul li:not(:last-child){
    border-bottom: 1px solid #aaa;
  }
  
  .caller-pic{
    width: 50px;
    height: 50px;
    /* background: rgb(251,227,63);
    background-image: linear-gradient(to right bottom, #371005, #5c3419, #7c5d2c, #958b46, #a4bc6c); */
    border-radius: 50%;
    /* border: 2px solid #000; */
  }
  .caller-detail{
    display: inline-flex;
    flex-direction: column;
    justify-content: center;
    /* align-items: center; */
    flex: 1 0 auto;
  }

  .caller-detail p:first-child{
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    letter-spacing: 2px;
  }
  .calling-icon{
    width: 50px;
    height: 50px;
    background-color: green;
    border-radius: 50%;
    
  }
  .calling-icon i{
    font-size: 20px;
    color: #fff;
    padding: 16px;
    animation: shake 0.5s;
    animation-iteration-count: infinite;
  }
  .caller-pic i{
    font-size: 20px;
    color: #fff;
    padding: 14px;
  }
  @keyframes shake {
    0% { transform: translate(1px, 1px) rotate(0deg); }
    10% { transform: translate(-1px, -2px) rotate(-1deg); }
    20% { transform: translate(-3px, 0px) rotate(1deg); }
    30% { transform: translate(3px, 2px) rotate(0deg); }
    40% { transform: translate(1px, -1px) rotate(1deg); }
    50% { transform: translate(-1px, 2px) rotate(-1deg); }
    60% { transform: translate(-3px, 1px) rotate(0deg); }
    70% { transform: translate(3px, 1px) rotate(-1deg); }
    80% { transform: translate(-1px, -1px) rotate(1deg); }
    90% { transform: translate(1px, 2px) rotate(0deg); }
    100% { transform: translate(1px, -2px) rotate(-1deg); }
  }
</style>

<!-- active call modal -->
<div class="modal" tabindex="-1" role="dialog" id="call_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <!--  <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">
        <div class="call-container">
          <ul class="list-unstyled mb-0" id="callList">
            <!-- <li>
              <div class="d-flex" style="column-gap: 20px">
                <div class="calling-icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="caller-detail">
                  <p class="mb-0">UNKNOWN</p>
                  <p class="mb-0">+922103212134</p>
                  <p class="mb-0">Calling...</p>
                </div>
              </div>
            </li> -->

          </ul>
        </div>
        <!-- <p>Modal body text goes here.</p> -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<!-- active call modal -->



<!-- ============================================================== -->
<!-- <footer class="footer">© 2021 <span class="d-none d-sm-inline-block">- Design & Developed with <i class="mdi mdi-heart text-danger"></i> by SquadCloud</span>.</footer> -->
</div>
</div>
<!-- END wrapper --><!-- jQuery  -->
<script src="<?= base_url();?>/assets/js/jquery.min.js"></script>
<script src="<?= base_url();?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url();?>/assets/js/metismenu.min.js"></script>
<script src="<?= base_url();?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url();?>/assets/js/waves.min.js"></script>
<!--Chartist Chart-->
<script src="<?= base_url();?>/assets/plugins/chartist/js/chartist.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
<!-- peity JS -->
<script src="<?= base_url();?>/assets/plugins/peity-chart/jquery.peity.min.js"></script>

<!-- datepicker -->
<script src="<?= base_url();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- vector map  -->
<script src="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- apexcharts -->
<!-- <script src="<?= base_url();?>/assets/plugins/apexcharts/apexcharts.min.js"></script> -->

<!-- <script src="<?= base_url();?>/assets/pages/dashboard.js"></script> -->
<!-- App js -->
<script src="<?= base_url();?>/assets/js/app.js"></script>
<!-- Toast -->
<script src="<?= base_url();?>/assets/js/toastr.min.js"></script>
<script src="<?= base_url();?>/assets/js/navToggle.js"></script>
<!-- Datatable -->
<script src="<?= base_url();?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url();?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url();?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<!-- input mask -->
<script src="<?= base_url();?>/assets/js/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url();?>/assets/js/select2.min.js"></script>
<script>
  $(function(){
    //////////////////////////////////
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>/user/global_user_list",
      // data:'id='+val,
      dataType : 'json',
      success: function(data){
        jQuery.each(data, function(index, item) {
          $('.globalUserList').append('<option value="'+item.id+'">'+item.firstname+' '+item.lastname+'</option>');
                });
                //
      },error: function(jqXHR, text, error){
        toastr.error(error);
      }
    });
    //////////////////////////////////
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>/general/global_equipment_list",
      // data:'id='+val,
      dataType : 'json',
      success: function(data){
        jQuery.each(data, function(index, item) {
          $('.globalEquipmentList').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
                //
      },error: function(jqXHR, text, error){
        toastr.error(error);
      }
    });
    //////////////////////////////////
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>/general/global_deviceTools_list",
      // data:'id='+val,
      dataType : 'json',
      success: function(data){
        jQuery.each(data, function(index, item) {
          $('.globalDeviceList').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
                //
      },error: function(jqXHR, text, error){
        toastr.error(error);
      }
    });
  })
  /////////////////////////////////////////
  $(document).on('click','.switchBtn',function(){
    if($(this).is(':checked')){
      $(this).attr('checked', true);
    }else{
      $(this).attr('checked', false);
    }  
  });
</script> 
<script>
  $(document).on('click','#logoutBtn',function(){
    $('#action_loader').modal('show');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>/login/logout",
      success: function(data){
       setTimeout(function() { 
        location.reload();
      }, 2000);
     }
   });
  });
</script>

<script>
  $(document).ready(function(){
    $("#search_input").click(function(){
     $('.search_dropdown').toggleClass('open');
   });
  });

  $(document).click(function(e) 
  {
    var container = $(".search_dropdown");
    if (!container.is(e.target)) 
    {
      container.removeClass('open');
    }
  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
    var loader = '<a href="javascript:void(0);" class="dropdown-item notify-item active"><span class="text-muted"><center><div class="spinner-border text-primary" role="status" id="loading"></div></center></span></a>';
    $(document).on('keyup','#search_input',function(){
      var text = $(this).val(); 
      if(text.length > 3){
              // console.log(text);
        $.ajax({
          type: "POST",
          url: '<?php echo base_url();?>/settings/search',
          data:'text='+text,
          success: function (data) {
            $('.search_dropdown .slim--dropdown').html(loader); 
            $('.search_dropdown').addClass('open'); 
            $('.slim--dropdown').css('height', 'auto');
            setTimeout(function() { 
              $('.search_dropdown .slim--dropdown').html(data);
            }, 1000);
          },
          error: function(jqXHR, text, error){
                    // Displaying if there are any errors
            toastr.error(error);
          }
        });
        return false;
      }
      else{
        $('.search_dropdown').removeClass('open'); 
      }
    });
  });
</script>

<script>

  $(document).ready(function(){

    function checkNewReminder() {
      $.ajax({
        url: '<?php echo base_url();?>/tools/checkNewReminder',
        type: 'POST',
      })
      .done(function(response) {
        var obj = JSON.parse(response);
        if (obj != null) {
          var append = '';
          $.each(obj, function(index, val) {
            append += `
            <li class="reminder_li clearfix" data-read_id="`+val.read_id+`" data-rem_id="`+val.rem_id+`">
            <span class="from_remind"><i class="fa fa-angle-double-right"></i><b> `+val.firstname+` `+val.lastname+`</b></span>
            <span class="remind_shot_text">`+val.title+`</span>
            </li>`;
          });

          $('.remindersList').html(append);

          if($(".remindersList").not(":visible")){
            $(".reminder_body").fadeIn('slow');
          }
        }
        
      });
      
    }

    checkNewReminder();
    setInterval(function(){ checkNewReminder(); }, 10000);

    // Notification box
    $.ajax({
      url: '<?php echo base_url();?>/tools/alert',
      type: 'POST',
    })
    .done(function(response) {
      $('#menu1').html(response);
    })
    .fail(function() {
      location.reload();
    });

    // Read Reminder
    $(document).on('click', '.reminder_li', function(e) {
      e.preventDefault();
      var $this = $(this);
      var read_id = $this.data('read_id');
      var rem_id = $this.data('rem_id');
      $this.parent('ul').hide();
      $('.remind_head').hide();
      $('.right_bar_content').show();
      $this.remove();
      
      $.ajax({
        url: '<?php echo base_url();?>/tools/markRead',
        type: 'POST',
        data: {read_id: read_id, rem_id: rem_id}
      })
      .done(function(response) {
        var obj = JSON.parse(response);
        $('.remind_heading').text(obj.reminders.title);
        $('.dateTime').text(obj.reminders.remind_date +' '+ obj.reminders.time);
        $('.remind_text').html(obj.reminders.text);
        $('.fromUser').html(obj.reminders.firstname+" "+obj.reminders.lastname);
      })
      .fail(function() {
        location.reload();
      });
    });


//read all
    $(document).on('click', '.readAllNotification',function(e){

     console.log('work console');
     e.preventDefault();
     $.ajax({
      url: '<?php echo base_url();?>/tools/markReadAll',
      type: 'POST',
      data: {read_id: null}
    })
     .done(function(response) {
      $('.reminder_body').hide();
    })
   });


    // back to reminders
    $('.right_bar_content .back_btn').click(function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.parent('.right_bar_content').hide();
      $('.right_bar_remind ul').show();
      $('.remind_head').show();
      var unreadReminds = $(document).find('.reminder_li').length;
      if (unreadReminds < 1) {
        $('.reminder_body').hide();
      }
    });

    // open view reminder modal
    $(document).on('click', '.ViewRemind', function(e) {
      e.preventDefault();
      var $this = $(this);
      var modal = '#ViewRemind';
      var rem_id = $this.data('rem_id');
      var myReminder = $this.data('my_reminder');
      $('.top_loader').removeClass('hide');
      $(document).find('.usersFor').remove();

      $.ajax({
        url: '<?php echo base_url("/tools/getReminderById") ?>',
        type: 'POST',
        data: {rem_id: rem_id},
      })
      .done(function(response) {
        var result = JSON.parse(response);
        if (response != 'NULL') {

          if (myReminder == '1') {
            users = '<div class="form-group usersFor"><label>For:</label><div>';
            $.each(result.remindersUsers, function(index, val) {
              var read = '';
              if (val.status == '1') {
                read = '<i class="fa fa-check" aria-hidden="true" style="color:#8bc34a;"></i> ';
              }
              users += ' <span class="badge badge-secondary">'+read+val.username+' </span>';
            });
            users += '</div></div>';
            $(users).insertAfter('.viewTitle');
          }


          $(modal+' input[name=reminderDate]').val(result.reminders.remind_date+' '+result.reminders.time);
          $(modal+' input[name=title]').val(result.reminders.title);
          $(modal+' #content').html(result.reminders.text);

          $('.top_loader').addClass('hide');
          $(modal).modal('show');
        }
      })
      .fail(function() {
        location.reload();
      });

    });

  });

///////////////////
$(document).ready(function() {
    $('.js-select2').select2();
});
</script>
</body>

</html>