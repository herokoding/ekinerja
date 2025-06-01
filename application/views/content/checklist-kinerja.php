<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?=form_error('record_date', '<div class="alert alert-danger" role="alert">', '</div>')?>
            <?=$this->session->flashdata('message');?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Check Status Kinerja</h1>
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
                    <form action="<?= base_url('kinerja/checkStatus') ?>" method="get" id="filteredCheck">
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
                            <h3 class="card-title">Check Status Kinerja</h3>
                        </div>
                        <div class="card-body">
                            <table id="tblCheckKinerja" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Kinerja</th>
                                        <th>Uraian Kinerja</th>
                                        <th>Dokumen Eviden</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($kinerjaList as $item) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <?= date('j F Y', strtotime($item['record_date'])) ?>
                                        </td>
                                        <td><?= $item['record_desc'] ?></td>
                                        <td>
                                            <?php if (!empty($item['document_name'])) : ?>
                                                <a href="<?= base_url("/uploads/documents/" . $item['document_name']) ?>" target="_blank" title="View Document">
                                                    <i class="fas fa-eye"></i> See Document
                                                </a>
                                            <?php else : ?>
                                                No Document
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if ($item['record_status'] == 0) {
                                                echo "Submitted";
                                            } elseif ($item['record_status'] == 1) {
                                                echo "Approved";
                                            } else {
                                                echo "Rejected";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Kinerja</th>
                                    <th>Uraian Kinerja</th>
                                    <th>Dokumen Eviden</th>
                                    <th>Status</th>
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