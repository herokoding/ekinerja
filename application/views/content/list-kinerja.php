<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?=form_error('record_date', '<div class="alert alert-danger" role="alert">', '</div>')?>
            <?=$this->session->flashdata('message');?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> List Data Kinerja</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Data Kinerja</li>
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
                    <form action="" method="get" id="filteredForm">
                        <div class="form-row align-items-center">
                            <div class="col-md-3">
                                <select name="month" id="month" class="form-control">
                                    <option value="">Pilih Bulan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" id="year" class="form-control">
                                    <option value="">Pilih Tahun</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-magenta">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Kinerja</h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-magenta btn-sm" data-toggle="modal" data-target="#addKinerja"><i class="fas fa-plus"></i> Tambah Kinerja</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tblKinerja" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Kinerja</th>
                                        <th>Uraian Kinerja</th>
                                        <th>Dokumen Eviden</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Kinerja</th>
                                        <th>Uraian Kinerja</th>
                                        <th>Dokumen Eviden</th>
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

    <div class="modal fade" id="addKinerja" tabindex="-1" role="dialog" aria-labelledby="addKinerjaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKinerjaLabel">Tambah Kinerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddKinerja" method="post" action="<?= site_url('kinerja/listKinerja') ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tanggal Kinerja</label>
                            <div class="input-group date" id="addkinerjaDate" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input"
                              data-target="#addkinerjaDate" name="record_date"/>
                              <div class="input-group-append" data-target="#addkinerjaDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Uraian Kinerja</label>
                        <textarea name="record_desc" cols="30" rows="10" id="recordDesc" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="">Upload Dokumen Kinerja</label>
                      <input type="file" id="document_name" name="document_name">
                      <i class="fas fa-upload"></i>
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

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kinerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="record_id" id="editRecordId">

                    <div class="form-group">
                        <label for="kinerjaDate">Tanggal Kinerja</label>
                        <div class="input-group date" id="editkinerjaDate" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#editkinerjaDate" name="record_date"/>
                          <div class="input-group-append" data-target="#editkinerjaDate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Uraian Kinerja</label>
                    <textarea name="record_desc" 
                    id="recordDesc" 
                    class="form-control" 
                    rows="5"
                    required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Dokumen Eviden</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="editDocument" name="document_name">
                        <label for="editDocument" class="custom-file-label">Pilih File..</label>
                    </div>
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin update file</small>
                    <div id="currentFile" class="mt-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-magenta">Update Changes</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>