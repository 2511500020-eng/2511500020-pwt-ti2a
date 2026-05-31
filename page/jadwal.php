<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] == "hapus") {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE id_jadwal = '$id'");
        $query = mysqli_query($koneksi, "DELETE FROM jad_kelas WHERE id_jadwal = '$id'");

        if ($query) {
            echo '
            <div class="alert alert-warning alert-dismissible">
                Berhasil Di Hapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">
                    Tambah Jadwal
                </a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kode Jadwal</th>
                            <th>Guru</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM jad_kelas join guru on jad_kelas.kd_guru = guru.kd_guru");
                        while ($result = mysqli_fetch_array($query)) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $result['id_jadwal']; ?></td>
                                <td><?= $result['nm_guru']; ?></td>
                                <td><?= $result['semester']; ?></td>
                                <td><?= $result['thn_ajaran']; ?></td>
                                <td>
                                        <?php
                                            $det = mysqli_query($koneksi, "SELECT detail_jadwal.*, mapel.nm_mapel, kelas.nm_kelas FROM detail_jadwal JOIN kelas ON detail_jadwal.id_kelas = kelas.id_kelas JOIN mapel ON detail_jadwal.kd_mapel = mapel.kd_mapel WHERE detail_jadwal.id_jadwal = '{$result['id_jadwal']}'");
                                            while ($d = mysqli_fetch_assoc($det)) {
                                                echo "{$d['nm_mapel']} - {$d['hari']} - {$d['jam_mulai']}-{$d['jam_selesai']} - {$d['nm_kelas']}";
                                            }
                                        ?>
                                </td>
                                <td>
                                    <a href="index.php?page=jadwal&action=hapus&id=<?= $result['id_jadwal']; ?>">
                                        <span class="badge badge-danger">Hapus</span>
                                    </a>

                                    <a href="index.php?page=edit_jadwal&id=<?= $result['id_jadwal']; ?>&thn_ajaran=<?= $result['thn_ajaran']; ?>&semester=<?= $result['semester']; ?>&kelas=<?= $result['nm_kelas']; ?>">
                                        <span class="badge badge-warning">Edit</span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>