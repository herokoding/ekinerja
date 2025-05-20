<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/js/adminlte.min.js"></script>

<!-- Additional Script -->
<script>
  $(document).ready(function() {
    // Wait 4 seconds, then fade and slide up
    window.setTimeout(function() {
      $('.alert')
        .fadeTo(500, 0)        // over 0.5 s fade to opacity 0
        .slideUp(500, function() {
          $(this).remove();    // then remove from the DOM
        });
    }, 4000);
  });
</script>
<script>
  const API_GET_MENU = "<?= site_url('admin/api/getMenu') ?>";
  const API_GET_SUB_MENU = "<?= site_url('admin/api/getSubMenu') ?>";
  const API_GET_ROLE = "<?= site_url('admin/api/getRole') ?>";
  const API_GET_DEPART = "<?= site_url('admin/api/getDepart') ?>";
  const API_GET_USER = "<?= site_url('admin/api/getUser') ?>";
</script>
<script src="<?= base_url('assets/js/myScript.js') ?>"></script>
</body>

</html>