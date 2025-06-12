<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?= $this->session->flashdata('message'); ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> List Data User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item"><a href="#">Data User</a></li>
                        <li class="breadcrumb-item active">Data User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data User</h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-magenta btn-sm" data-toggle="modal" data-target="#addUser"><i class="fas fa-plus"></i> Tambah User</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tblUser" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>Status Active</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>Status Active</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Add Menu Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="addUserLabel">Tambah User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- Body with Form -->
          <form id="formAddUser" class="form-horizontal" method="post" action="<?= base_url('admin/addUser') ?>">
            <div class="modal-body">
                <div class="container row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label>NIK</label>
                            <input type="text" class="form-control" name="user_nik" id="nik">
                        </div>
                        <div class="form-group row">
                            <label for="">Nama Lengkap</label>
                            <input type="text" class="form-control" name="user_fullname" id="fullname">
                        </div>
                        <div class="form-group row">
                            <label for="">Email</label>
                            <input type="text" class="form-control <?= form_error('user_email') ? 'is-invalid' : '' ?>" name="user_email" id="email">
                            <?= form_error('user_email', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="form-group row">
                            <label for="">Username</label>
                            <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" name="username" id="username">
                            <?= form_error('username', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label">Gender</label>
                            <div class="col-sm-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_gender" id="genderL" value="L">
                                    <label class="form-check-label" for="genderL">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_gender" id="genderP" value="P">
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="">Jabatan</label>
                            <select name="role_id" id="roleId" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($role as $item) : ?>
                                    <option value="<?= $item['role_id'] ?>"><?= $item['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="">Divisi</label>
                            <select name="department_id" id="departId" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($department as $item) : ?>
                                    <option value="<?= $item['depart_id'] ?>"><?= $item['depart_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="">Password</label>
                            <input type="password" class="form-control <?= form_error('password1') ? 'is-invalid' : '' ?>" name="password1" id="pw1">
                            <?= form_error('password1', '<div class="invalid-feedback">', '</div>') ?>
                        </div>
                        <div class="form-group row">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="password2" id="pw2">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer with Actions -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-magenta btn-sm">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php if (validation_errors()): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#addUser').modal('show');
            });
        </script>
    <?php endif; ?>

    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="post" class="form-horizontal" id="editUserForm">
                    <div class="modal-body">
                        <div class="container row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="">NIK</label>
                                    <input type="hidden" name="user_id" id="userId">
                                    <input type="text" name="user_nik" id="userNik" class="form-control">
                                </div>
                                <div class="form-group row">
                                    <label for="">Nama Lengkap</label>
                                    <input type="text" name="user_fullname" id="fullName" class="form-control">
                                </div>
                                <div class="form-group row">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="user_email" id="userEmail">
                                </div>
                                <div class="form-group row">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control" name="username" id="userName">
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-12 col-form-label">Gender</label>
                                    <div class="col-sm-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="user_gender" id="genderL" value="L">
                                            <label class="form-check-label" for="genderL">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="user_gender" id="genderP" value="P">
                                            <label class="form-check-label" for="genderP">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="">Jabatan</label>
                                    <select name="role_id" id="roleId" class="form-control">
                                        <option value="">-- Pilih Jabatan --</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="">Divisi</label>
                                    <select name="department_id" id="departId" class="form-control">
                                        <option value="">-- Pilih Divisi --</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label>Ubah Password?</label>
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="change_password" id="changePwYes" value="1">
                                            <label class="form-check-label" for="changePwYes">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="change_password" id="changePwNo" value="0" checked>
                                            <label class="form-check-label" for="changePwNo">Tidak</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="passwordFields" style="display:none">
                                    <div class="form-group row">
                                        <label for="">Password Baru</label>
                                        <input type="password" name="password1" id="pw1" class="form-control" disabled>
                                    </div>
                                    <div class="form-group row">
                                        <label for="">Konfirmasi Password</label>
                                        <input type="password" name="password2" id="pw2" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-magenta btn-sm">Simpan</button>
                  </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus user <strong class="user-name"></strong>?</p>
                    <p class="text-danger">Data yang dihapus tidak dapat dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
        <!-- /.content-wrapper -->