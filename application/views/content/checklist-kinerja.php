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
                                <tbody></tbody>
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