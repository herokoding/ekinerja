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
<!-- Popper -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/popper/umd/popper.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Fontawesome -->
<script src="<?= base_url('assets/vendor/fontawesome-5') ?>/js/fontawesome.js"></script>
<!-- InputMask -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<!-- <script src="<?//= base_url('assets/vendor/adminlte3') ?>/plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/vendor/adminlte3') ?>/js/adminlte.min.js"></script>

<!-- Additional Script -->
<script>
  const API_GET_MENU = "<?= site_url('admin/api/getMenu') ?>";
  const API_GET_SUB_MENU = "<?= site_url('admin/api/getSubMenu') ?>";
  const API_GET_ROLE = "<?= site_url('admin/api/getRole') ?>";
  const API_GET_DEPART = "<?= site_url('admin/api/getDepart') ?>";
  const API_GET_USER = "<?= site_url('admin/api/getUser') ?>";
  const API_GET_PERFORMANCE = "<?= site_url('kinerja/api/getListKinerja') ?>";
  const API_EDIT_PERFORMANCE = "<?= site_url('kinerja/api/editKinerja/') ?>";
  const API_EDIT_USER = "<?= site_url('admin/api/editUser/') ?>";
  const API_EDIT_SUBMENU = "<?= site_url('admin/api/editSubMenu/') ?>";
  const API_EDIT_MENU = "<?= site_url('admin/api/editMenu/') ?>";
  const API_EDIT_ROLE = "<?= site_url('admin/api/editRole/') ?>";
  const API_EDIT_DEPART = "<?= site_url('admin/api/editDepart/') ?>";
  const API_UPDATE_MENU = "<?= site_url('admin/api/updateMenu/') ?>";
  const API_UPDATE_ROLE = "<?= site_url('admin/api/updateRole/') ?>";
  const API_UPDATE_DEPART = "<?= site_url('admin/api/updateDepart/') ?>";
  const API_UPDATE_SUBMENU = "<?= site_url('admin/api/updateSubMenu/') ?>";
  const API_UPDATE_USER = "<?= site_url('admin/api/updateUser/') ?>";
  const API_DELETE_USER = "<?= site_url('admin/api/deleteUser') ?>";
  const API_DELETE_MENU = "<?= site_url('admin/api/deleteMenu') ?>";
  const API_DELETE_ROLE = "<?= site_url('admin/api/deleteRole') ?>";
  const API_DELETE_DEPART = "<?= site_url('admin/api/deleteDepart') ?>";
  const API_DELETE_SUBMENU = "<?= site_url('admin/api/deleteSubMenu') ?>";
  const API_UPDATE_PERFORMANCE = "<?= site_url('kinerja/api/updateKinerja/') ?>";
  const API_DELETE_PERFORMANCE = "<?= site_url('kinerja/api/deleteKinerja/') ?>";
  const API_APPROVAL = "<?= site_url('approval/api/getList') ?>";
  const API_CHECK_ACCESS = "<?= site_url('admin/api/checkAccess') ?>";
  const BASE_ADMIN_ROLE_ACCESS = '<?= base_url("admin/roleAccess/") ?>';
</script>
<script src="<?= base_url('assets/js/myScript.js') ?>"></script>
</body>

</html>