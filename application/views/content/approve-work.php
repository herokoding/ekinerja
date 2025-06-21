<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?=form_error('record_date', '<div class="alert alert-danger" role="alert">', '</div>')?>
            <?=$this->session->flashdata('message');?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Approve Kinerja</h1>
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
                    <form action="" method="get" id="approveForm">
                        <div class="form-row align-items-center">
                            <div class="col-md-2">
                                <select name="month" id="month" class="form-control">
                                    <option value="">Pilih Bulan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="year" id="year" class="form-control">
                                    <option value="">Pilih Tahun</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="user" id="user" class="form-control">
                                    <option value="">Pilih Pegawai</option>
                                    <?php foreach ($listUser as $items) : ?>
                                        <option value="<?= $items['user_id'] ?>" <?= ($this->input->get('user') === $items['user_id'] ) ? 'selected' : '' ?> ><?= $items['user_fullname'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="department" id="department" class="form-control">
                                    <option value="">Pilih Bagian</option>
                                    <?php foreach ($listDepart as $items) : ?>
                                        <option value="<?= $items['depart_id'] ?>" <?= ($this->input->get('department') === $items['depart_id']) ? 'selected' : '' ?>><?= $items['depart_name'] ?></option>
                                    <?php endforeach ?>
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
                        </div>
                        <div class="card-body">
                            <table id="tblApprove" class="table table-bordered table-hover">
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

</div>