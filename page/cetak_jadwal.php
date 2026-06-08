<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cetak Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">   
                <a class="btn btn-primary btn-sm" onclick="window.print()">
                    Print
                </a>
                <br><br>

                <style>

                    .header{
                        width: 100%;
                        border-bottom: 3px solid black;
                        padding-bottom: 10px;
                        margin-bottom: 20px;
                    }

                    .header table{
                        width: 100%;
                    }

                    .header img{
                        width: 90px;
                    }

                    .identitas{
                        text-align: center;
                    }

                    .identitas h2,
                    .identitas p{
                        margin: 2px;
                    }

                    table.jadwal{
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    table.jadwal th,
                    table.jadwal td{
                        border: 1px solid black;
                        padding: 8px;
                    }

                    table.jadwal th{
                        text-align: center;
                    }

                    .text-center{
                        text-align: center;
                    }

                    #print-area{
                        width:210mm;
                        min-height:297mm;
                        margin:auto;
                        padding:0;
                        background:white;
                        box-shadow:0 0 10px rgba(0,0,0,.2);
                    }

                    @media print {

                        body * {
                            visibility: hidden;
                        }

                        #print-area,
                        #print-area * {
                            visibility: visible;
                        }

                        #print-area {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                        }
                    }

                    @page {
                        size: A4;
                        margin: 0;
                    }

                </style>
                    
                <div id="print-area">
                    <div class="header">
                        <table>
                            <tr>
                                <td width="15%" class="text-center">
                                    <img src="logo_yosef.png" alt="Logo Sekolah">
                                </td>

                                <td width="85%" class="identitas">
                                    <h2 style="font-size: 28px;">SMA SANTO YOSEF PANGKALPINANG</h2>
                                    <p>Jl. Solihin GP, Kota Pangkalpinang</p>
                                    <p>Telp. 082181295533</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <?php if ($_SESSION['role'] == "admin") { ?>

                        <table class="jadwal">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Kode Jadwal</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Detail Jadwal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $query = mysqli_query($koneksi, "SELECT * FROM jad_kelas join kelas on jad_kelas.id_kelas = kelas.id_kelas");
                                while ($result = mysqli_fetch_array($query)) {
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $result['id_jadwal']; ?></td>
                                        <td><?= $result['nm_kelas']; ?></td>
                                        <td><?= $result['thn_ajaran']; ?></td>
                                        <td><?= $result['semester']; ?></td>
                                        <td>
                                            <?php
                                                $det = mysqli_query($koneksi, "SELECT * FROM detail_jadwal JOIN guru ON detail_jadwal.kd_guru = guru.kd_guru JOIN mapel ON detail_jadwal.kd_mapel = mapel.kd_mapel WHERE detail_jadwal.id_jadwal = '{$result['id_jadwal']}'");
                                                while ($d = mysqli_fetch_assoc($det)) {
                                                    echo "{$d['nm_mapel']} - {$d['nm_guru']} - {$d['hari']} - {$d['jam_mulai']}-{$d['jam_selesai']} <br>";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } else if ($_SESSION['role'] == "guru") {                     
                        $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM guru WHERE kd_guru = '{$_SESSION['username']}'"));
                        $kd_guru = $guru['kd_guru'];
                        $query = mysqli_query($koneksi, "SELECT DISTINCT * FROM jad_kelas join kelas on jad_kelas.id_kelas = kelas.id_kelas join detail_jadwal on jad_kelas.id_jadwal = detail_jadwal.id_jadwal WHERE detail_jadwal.kd_guru = '$kd_guru'");
                        $result = mysqli_fetch_array($query);
                    ?>

                        <h5><?= "Tahun Ajaran: " . $result['thn_ajaran'] ?></h5>
                        <h5><?= "Semester: " . $result['semester'] ?></h5>
                        <br>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $no = 1; 
                                    $det = mysqli_query($koneksi, "SELECT * FROM detail_jadwal join jad_kelas on detail_jadwal.id_jadwal = jad_kelas.id_jadwal JOIN kelas ON jad_kelas.id_kelas = kelas.id_kelas JOIN mapel ON detail_jadwal.kd_mapel = mapel.kd_mapel  WHERE detail_jadwal.id_jadwal = '{$result['id_jadwal']}' AND detail_jadwal.kd_guru = '$kd_guru'");
                                    while ($d = mysqli_fetch_assoc($det)) {
                                ?>

                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $d['nm_mapel'] ?></td>
                                    <td><?= $d['nm_kelas'] ?></td>
                                    <td><?= $d['hari'] ?></td>
                                    <td><?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?></td>
                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } else if ($_SESSION['role'] == "siswa") { 
                        $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '{$_SESSION['username']}'"));
                        $id_kelas = $siswa['id_kelas'];
                        $query = mysqli_query($koneksi, "SELECT DISTINCT * FROM jad_kelas join kelas on jad_kelas.id_kelas = kelas.id_kelas join detail_jadwal on jad_kelas.id_jadwal = detail_jadwal.id_jadwal WHERE jad_kelas.id_kelas = '$id_kelas'");
                        $result = mysqli_fetch_array($query);
                    ?>

                        <h5><?= "Tahun Ajaran: " . $result['thn_ajaran'] ?></h5>
                        <h5><?= "Semester: " . $result['semester'] ?></h5>
                        <h5><?= "Kelas: " . $result['nm_kelas'] ?></h5>
                        <br>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $no = 1;
                                    $det = mysqli_query($koneksi, "SELECT * FROM detail_jadwal JOIN guru ON detail_jadwal.kd_guru = guru.kd_guru JOIN mapel ON detail_jadwal.kd_mapel = mapel.kd_mapel join jad_kelas on detail_jadwal.id_jadwal = jad_kelas.id_jadwal WHERE detail_jadwal.id_jadwal = '{$result['id_jadwal']}' AND jad_kelas.id_kelas = '$id_kelas'");
                                    while ($d = mysqli_fetch_assoc($det)) {
                                ?>

                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $d['nm_mapel'] ?></td>
                                    <td><?= $d['nm_guru'] ?></td>
                                    <td><?= $d['hari'] ?></td>
                                    <td><?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?></td>
                                </tr>

                                <?php } ?>`
                            </tbody>
                        </table>

                    <?php } ?>
                        
                </div>

            </div>
        </div>
    </div>
</div>