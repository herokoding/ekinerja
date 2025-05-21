<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?= form_error('menu_name', '<div class="alert alert-danger" role="alert">','</div>') ?>
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
                                        <th>Role</th>
                                        <th>Department</th>
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
                                        <th>Role</th>
                                        <th>Department</th>
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
          <form id="formAddUser" class="form-horizontal" method="post" action="<?= site_url('admin/addUser') ?>">
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
                            <input type="text" class="form-control" name="user_email" id="email">
                        </div>
                        <div class="form-group row">
                            <label for="">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
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
                            <label for="">Role</label>
                            <select name="role_id" id="roleId" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($role as $item) : ?>
                                    <option value="<?= $item['role_id'] ?>"><?= $item['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="">Department</label>
                            <select name="department_id" id="departId" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($department as $item) : ?>
                                    <option value="<?= $item['depart_id'] ?>"><?= $item['depart_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password1" id="pw1">
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
    <!-- /.content -->
</div>
        <!-- /.content-wrapper -->