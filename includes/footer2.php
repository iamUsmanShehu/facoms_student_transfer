
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- <script src="../plugins/jquery/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/3.2.2/dataTables.bootstrap4.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.5.0/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.5.0/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.4.2/buttons.bootstrap4.min.js"></script>


<!-- <script src="../plugins/datatables/jquery.dataTables.min.js"></script> -->
<!-- <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<script>
    // $('#myTable').DataTable(responsive: true)
  $(function () {
    $("#myTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
    $(".myTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
  $('#myCustomeTable').DataTable();
</script>