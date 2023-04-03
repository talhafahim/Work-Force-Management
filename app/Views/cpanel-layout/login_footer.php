<?php 
echo view('cpanel-layout/action_loader');
// echo view('cpanel-layout/logging_off_loader');
?>
<!-- ============================================================== -->
</div>
<!-- END wrapper --><!-- jQuery  -->
<script src="<?= base_url();?>/assets/js/jquery.min.js"></script>
<script src="<?= base_url();?>/assets/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?= base_url();?>/assets/js/metismenu.min.js"></script> -->
<!-- <script src="<?= base_url();?>/assets/js/jquery.slimscroll.js"></script> -->
<script src="<?= base_url();?>/assets/js/waves.min.js"></script>
<!--Chartist Chart-->
<!-- <script src="<?= base_url();?>/assets/plugins/chartist/js/chartist.min.js"></script> -->
<!-- <script src="<?= base_url();?>/assets/plugins/chartist/js/chartist-plugin-tooltip.min.js"></script> -->
<!-- peity JS -->
<!-- <script src="<?= base_url();?>/assets/plugins/peity-chart/jquery.peity.min.js"></script> -->

<!-- datepicker -->
<!-- <script src="<?= base_url();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
<!-- vector map  -->
<!-- <script src="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script> -->
<!-- <script src="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->

<!-- apexcharts -->
<!-- <script src="<?= base_url();?>/assets/plugins/apexcharts/apexcharts.min.js"></script> -->

<!-- <script src="<?= base_url();?>/assets/pages/dashboard.js"></script> -->
<!-- App js -->
<script src="<?= base_url();?>/assets/js/app.js"></script>
<!-- Toast -->
<!-- <script src="<?= base_url();?>/assets/js/toastr.min.js"></script> -->
<!-- <script src="<?= base_url();?>/assets/js/navToggle.js"></script> -->
<!-- Datatable -->
<!-- <script src="<?= base_url();?>/assets/plugins/datatables/jquery.dataTables.min.js"></script> -->
<!-- <script src="<?= base_url();?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script> -->
<!-- Buttons examples -->
<!-- <script src="<?= base_url();?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/buttons.colVis.min.js"></script> -->
<!-- Responsive examples -->
<!-- <script src="<?= base_url();?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url();?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script> -->
<!-- input mask -->
<!-- <script src="<?= base_url();?>/assets/js/jquery.inputmask.bundle.min.js"></script> -->
<!-- <script src="<?= base_url();?>/sw.js"></script> -->
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}
</script>
</body>

</html>