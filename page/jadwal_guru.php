<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Jadwal Guru</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <?php
                    $no = 1;
                    $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM guru WHERE kd_guru = '{$_SESSION['username']}'"));
                    $kd_guru = $guru['kd_guru'];
                    $query = mysqli_query($koneksi, "SELECT DISTINCT * FROM jad_kelas join kelas on jad_kelas.id_kelas = kelas.id_kelas join detail_jadwal on jad_kelas.id_jadwal = detail_jadwal.id_jadwal WHERE detail_jadwal.kd_guru = '$kd_guru'");
                    $result = mysqli_fetch_array($query) 
                ?>
                
                <div>
                    <h5><?= "Tahun Ajaran: " . $result['thn_ajaran'] ?></h5>
                    <h5><?= "Semester: " . $result['semester'] ?></h5>
                </div>
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
            </div>
        </div>
    </div>
</div>