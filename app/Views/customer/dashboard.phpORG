<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<style type="text/css">
    .timeBtn{
        height: 50px;
        font-size: 20px;
        display:none;
        border-radius:0px;
    }
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons" style="width:100%">
                          
                                <button class="btn btn-success  timeBtn" data-status="start"><i class="fa fa-play"></i> DAY START</button>

                                <button class="btn btn-primary  timeBtn" data-status="break"><i class="fa fa-pause"></i> BREAK</button>

                                <button class="btn btn-primary  timeBtn" data-status="resume"><i class="fa fa-pause"></i> RESUME</button>

                                <button class="btn btn-info  timeBtn" data-status="end"><i class="fa fa-stop"></i> DAY END</button>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="gatewaychartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- end row -->
        </div>
        <!-- container-fluid -->
        
    </div>
    
    <!-- content -->
    
    <?php 
    echo view('cpanel-layout/action_loader');
    echo view('cpanel-layout/footer');
    ?>
    <script src="<?= base_url();?>/assets/canvasjs/canvasjs.min.js"></script>

    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "dark2",
                title:{
                    text: "Daily Staff Wise Report"
                },  
                axisY: {
                    title: "Number of Task",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"
                },  
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor:"pointer",
                    itemclick: toggleDataSeries
                },
                data: [

                {
                    type: "column",
                    name: "schedule",
                    legendText: "Schedule",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['schedule'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['schedule'][$key]['username'].'", y: '.$dailyStaffWise['schedule'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },
                {
                    type: "column",
                    name: "travelling",
                    legendText: "Travelling",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['travelling'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['travelling'][$key]['username'].'", y: '.$dailyStaffWise['travelling'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },
                {
                    type: "column",
                    name: "on site",
                    legendText: "On Site",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['on site'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['on site'][$key]['username'].'", y: '.$dailyStaffWise['on site'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },
                {
                    type: "column",
                    name: "installed",
                    legendText: "Installed",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['complete'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['complete'][$key]['username'].'", y: '.$dailyStaffWise['complete'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },
                {
                    type: "column",
                    name: "return",
                    legendText: "Return",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['reject'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['reject'][$key]['username'].'", y: '.$dailyStaffWise['reject'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },
                {
                    type: "column",
                    name: "commission",
                    legendText: "Commission",
                    showInLegend: true, 
                    dataPoints:[
            // { label: "a", y: 266.21 },
                        <?php
                        foreach ($dailyStaffWise['commission'] as $key => $value) {
                            echo '{ label: "'.$dailyStaffWise['commission'][$key]['username'].'", y: '.$dailyStaffWise['commission'][$key]['count'].' },';
                        }
                        ?>

                        ]
                },

                ]
            });
chart.render();

function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chart.render();
}



var chart2 = new CanvasJS.Chart("gatewaychartContainer", {
    theme: "dark2", // "light1", "light2", "dark1", "dark2"
    exportEnabled: true,
    animationEnabled: true,
    title: {
        text: "Gateway Report"
    },
    data: [{
        type: "pie",
        startAngle: 25,
        toolTipContent: "<b>{label}</b>: {y}%",
        showInLegend: "true",
        legendText: "{label}",
        indexLabelFontSize: 16,
        indexLabel: "{label} - {y}%",
        dataPoints: [
            // { y: 51.08, label: "In Stock",exploded: true },
            <?php
            foreach ($gatewayReport as $key => $value) {
                echo '{ y: '.$gatewayReport[$key]['count'].', label: "'.$gatewayReport[$key]['status'].'",exploded: true },';
            }
            ?>
            ]
    }]
});
chart2.render();

}
</script>

<script type="text/javascript">
    $(document).on('click','.timeBtn',function(){
        var status = $(this).attr('data-status');
        if(confirm('Do you really want to '+status+' your day?')){
        $('#action_loader').modal('show');
        //
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url();?>/dashboard/update_day_status',
            data:'status='+status,
            // 
            success: function(data){
               setTimeout(function(){ 
                $('#action_loader').modal('hide');
                toastr.success(data);
                // $('button[data-status="'+status+'"]').hide();
                checkStatus();
            }, 1000);
           },
           error: function(jqXHR, text, error){
            setTimeout(function(){
                $('#action_loader').modal('hide');
                toastr.error(error);
            }, 1000);
        }
    })
}
    });

    ////////////////////////////////
    $(document).ready(function(){
        checkStatus();
    });
        //
        function checkStatus(){
            $.ajax({
                method: 'POST',
                url: '<?php echo base_url();?>/dashboard/check_day_status',
                dataType: "json",
            // 
                success: function(data){
                     // toastr.error(data);
                    console.log(data.disableList);
                    console.log(data.enableList);
                    // 
                    if(data.disableList.includes('start')){
                        $('button[data-status="start"]').hide();
                    }if(data.disableList.includes('end')){
                        $('button[data-status="end"]').hide();
                    }if(data.disableList.includes('break')){
                        $('button[data-status="break"]').hide();
                    }if(data.disableList.includes('resume')){
                        $('button[data-status="resume"]').hide();
                    }
                    //
                    if(data.enableList.includes('start')){
                        $('button[data-status="start"]').show();
                    }if(data.enableList.includes('end')){
                        $('button[data-status="end"]').show();
                    }if(data.enableList.includes('break')){
                        $('button[data-status="break"]').show();
                    }if(data.enableList.includes('resume')){
                        $('button[data-status="resume"]').show();
                    }


                }
            })
        }
    
</script>

