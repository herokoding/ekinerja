<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small><?= $title ?></small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        <li class="breadcrumb-item active">Profile Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <?=  $this->session->flashdata('message'); ?>
        <div class="container emp-profile">
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-img">
                        <img src="https://www.pngplay.com/wp-content/uploads/12/User-Avatar-Profile-Transparent-Free-PNG-Clip-Art.png" alt=""/>
                        <!-- <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file"/>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5><?= $userRow['user_fullname'] ?></h5>
                        <h6><?= $userRow['role_name'] ?></h6>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- Tombol Edit Profile -->
                    <button type="button"
                    class="btn profile-edit-btn"
                    data-toggle="modal"
                    data-target="#modalEditProfile">
                    Edit Profile
                </button>

                <!-- Tombol Ubah Password -->
                <button type="button"
                class="btn profile-edit-btn"
                data-toggle="modal"
                data-target="#modalChangePassword">
                Ubah Password
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-md-6">
                        <label>Username</label>
                    </div>
                    <div class="col-md-6">
                        <p><?= $userRow['username'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Name</label>
                    </div>
                    <div class="col-md-6">
                        <p><?= $userRow['user_fullname'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email</label>
                    </div>
                    <div class="col-md-6">
                        <p><?= $userRow['user_email'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Role</label>
                    </div>
                    <div class="col-md-6">
                        <p><?= $userRow['role_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Department</label>
                    </div>
                    <div class="col-md-6">
                        <p><?= $userRow['depart_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Supervisor</label>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <?php
                            $getUser = $this->db->get_where('users', ['role_id' => 2, 'is_supervisor' => 1])->row_array();

                            echo $getUser['user_fullname'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal Edit Profile -->
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-labelledby="modalEditProfileLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('user/update-profile') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditProfileLabel">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contoh field form edit profile -->
          <input type="hidden" name="id" value="<?= $userRow['user_id'] ?>">
          <div class="mb-3">
            <label for="edit-username" class="form-label">Username</label>
            <input type="text" class="form-control" id="edit-username" name="username" value="<?= $userRow['username'] ?>">
          </div>
          <div class="mb-3">
            <label for="edit-name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="edit-name" name="user_fullname" value="<?= $userRow['user_fullname'] ?>">
          </div>
          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-email" name="user_email" value="<?= $userRow['user_email'] ?>">
          </div>
          <div class="mb-3">
            <label for="edit-role" class="form-label">Jabatan</label>
            <select class="form-control" id="edit-role" name="role_id">
              <option value="">-- Pilih Jabatan --"></option>
              <?php foreach ($roles as $item) : ?>
                <option value="<?= $item['role_id'] ?>" <?=  $item['role_id'] == $userRow['role_id'] ? 'selected' : '' ?>><?= $item['role_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit-department" class="form-label">Bagian</label>
            <select class="form-control" id="edit-department" name="department_id">
              <option value="">-- Pilih Divisi --"></option>
              <?php foreach ($departments as $item) : ?>
                <option value="<?= $item['depart_id'] ?>" <?=  $item['depart_id'] == $userRow['department_id'] ? 'selected' : '' ?>><?= $item['depart_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Tambahkan field lain sesuai kebutuhan -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('user/update-password') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalChangePasswordLabel">Ubah Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Field form ubah password -->
          <div class="mb-3">
            <label for="current-password" class="form-label">Password Saat Ini</label>
            <input type="password" class="form-control" id="current-password" name="current_password" required>
          </div>
          <div class="mb-3">
            <label for="new-password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="new-password" name="new_password" required>
          </div>
          <div class="mb-3">
            <label for="confirm-password" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Ubah Password</button>
        </div>
      </form>
    </div>
  </div>
</div>