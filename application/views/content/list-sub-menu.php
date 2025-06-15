<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?= form_error('menu_name', '<div class="alert alert-danger" role="alert">','</div>') ?>
            <?= $this->session->flashdata('message'); ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> List Data Sub Menu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item"><a href="#">Data Menu</a></li>
                        <li class="breadcrumb-item active">Data Sub Menu</li>
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
                            <h3 class="card-title">Data Sub Menu</h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-magenta btn-sm" data-toggle="modal" data-target="#addSubMenu"><i class="fas fa-plus"></i> Tambah Sub Menu</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tblSubMenu" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sub Menu Name</th>
                                        <th>Menu Name</th>
                                        <th>Menu Url</th>
                                        <th>Menu Icon</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Sub Menu Name</th>
                                        <th>Menu Name</th>
                                        <th>Menu Url</th>
                                        <th>Menu Icon</th>
                                        <th>Active</th>
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
    <div class="modal fade" id="addSubMenu" tabindex="-1" role="dialog" aria-labelledby="addSubMenuLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="addSubMenuLabel">Tambah Sub Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- Body with Form -->
          <form id="formAddSubMenu" method="post" action="<?= site_url('admin/addSubMenu') ?>">
            <div class="modal-body">
              <div class="form-group">
                <label for="menuName">Nama Sub Menu</label>
                <input type="text" class="form-control" id="menuSubName" name="sub_title" placeholder="Masukkan nama sub menu">
              </div>
              <div class="form-group">
                  <label for="">Nama Menu</label>
                  <select name="menu_id" id="menuId" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($menu as $m) :?>
                        <option value="<?= $m['menu_id'] ?>"><?= $m['menu_name'] ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="form-group">
                  <label for="">Sub Menu Url</label>
                  <input type="text" class="form-control" id="subUrl" name="sub_url" placeholder="Sub URL">
              </div>
              <div class="form-group">
                  <label for="">Sub Icon</label>
                  <input type="text" class="form-control" id="subIcon" name="sub_icon" placeholder="Sub Icon">
              </div>
              <div class="form-group">
                  <div class="form-check">
                      <input type="checkbox" class="form-check-input" value="1" name="is_active" id="idActive" checked>
                      <label for="is_active" class="form-check-label">Active?</label>
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

    <div class="modal fade" id="editSubMenu" tabindex="-1" role="dialog" aria-labelledby="editSubMenuLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="editSubMenuLabel">Edit Sub Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- Body with Form -->
          <form id="formEditSubMenu" action="">
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id" id="submenuId">
                <label for="subTitle">Nama Sub Menu</label>
                <input type="text" class="form-control <?= form_error('sub_title') ? 'is-invalid' : '' ?>" id="subTitle" name="sub_title">
                <?= form_error('sub_title', '<div class="invalid-feedback">', '</div>') ?>
              </div>
              <div class="form-group">
                  <label for="">Nama Menu</label>
                  <select name="menu_id" id="menuId" class="form-control">
                      <option value="">Select</option>
                  </select>
              </div>
              <div class="form-group">
                  <label for="">Sub Menu Url</label>
                  <input type="text" class="form-control" id="subUrl" name="sub_url">
              </div>
              <div class="form-group">
                  <label for="">Sub Icon</label>
                  <input type="text" class="form-control" id="subIcon" name="sub_icon">
              </div>
              <div class="form-group">
                  <div class="form-check">
                      <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                      <label for="is_active" class="form-check-label">Active?</label>
                  </div>
              </div>
            </div>
            <!-- Footer with Actions -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-magenta btn-sm">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus Sub Menu <strong class="user-name"></strong>?</p>
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