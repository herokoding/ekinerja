<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <?=form_error('record_date', '<div class="alert alert-danger" role="alert">', '</div>')?>
            <?=$this->session->flashdata('message');?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Cetak Report Kinerja</h1>
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
                    <form action="<?= base_url('kinerja/reportPrint') ?>" method="get" id="filteredCheck">
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
                            <h3 class="card-title">Cetak Report Kinerja</h3>
                            <div class="float-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-magenta btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-print"></i> Print Report
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?= base_url('kinerja/exportPdf') ?>?month=<?= $month ?>&year=<?= $year ?>" target="_blank">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal Kinerja</th>
                                        <th>Uraian Kinerja</th>
                                        <th>Dokumen Eviden</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($kinerjaList as $tgl => $items) : 
                                        $rowspan = count($items); 
                                        $subIndex = 1;
                                        foreach ($items as $key => $item) :
                                            echo "<tr>";

                                            if ($key === 0) {
                                                $formattedDate = date('j F Y', strtotime($tgl));
                                                echo "<td rowspan=\"{$rowspan}\">{$formattedDate}</td>";
                                            }

                                            echo "<td>" . htmlspecialchars($item['record_desc']) . "</td>";

                                            if (!empty($item['document_name'])) {
                                                $docUrl = base_url("uploads/documents/" . $item['document_name']);
                                                echo "<td><a href=\"{$docUrl}\" target=\"_blank\" title=\"View Document\">
                                                <i class=\"fas fa-eye\"></i> See Document
                                                </a></td>";
                                            } else {
                                                echo "<td>No Document</td>";
                                            }

                                            $statusText = 'Submitted';
                                            if ($item['record_status'] == 1) {
                                                $statusText = 'Approved';
                                            } elseif ($item['record_status'] == 2) {
                                                $statusText = 'Rejected';
                                            }
                                            echo "<td>{$statusText}</td>";

                                            echo "</tr>";
                                        endforeach;
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
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