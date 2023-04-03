<div class="reminder_body">
    <div class="reminder_popup clearfix">
      <div class="left_bar">
        <img class="remind_img1" src="<?php echo base_url(); ?>/assets/images/msg.png" style="width:35%;filter: invert(1);">
      </div>
      <div class="right_bar_remind">
        <button type="button" class="btn btn-default btn-sm float-right readAllNotification"><i class="fa fa-check" aria-hidden="true"></i> Mark all as read</button>
        <h2 class="remind_head"> New Message </h2>
        <ul class="list-unstyled remindersList"></ul>
        <div class="right_bar_content text-right">
          <span class="fromUser float-left label label-success"></span>
          <span class="dateTime float-left"></span>
          <button type="button" class="btn btn-default btn-sm back_btn float-right" style="margin-right:5px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
          <h2 class="remind_heading text-center" style="width: 100%;display: inline-block;"></h2>
          <div class="remind_text text-left"></div>
        </div>
      </div>
    </div>
  </div>