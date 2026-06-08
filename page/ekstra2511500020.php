<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] == "hapus") {
        $id = $_GET['id'];

        $query = mysqli_query($koneksi, "DELETE FROM ekstra_2511500020 WHERE id_ekstra020 = '$id'");

        if ($query) {
            echo '
            <div class="alert alert-warning alert-dismissible">
                Berhasil Di Hapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra2511500020">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <a href="index.php?page=tambah_ekstra2511500020" class="btn btn-primary btn-sm">
                    Tambah Ekstrakurikuler
                </a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID Ekstrakurikuler</th>
                            <th>Nama Ekstrakurikuler</th>
                            <th>Keterangan</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi, "SELECT * FROM ekstra_2511500020");

                        while ($result = mysqli_fetch_array($query)) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $result['id_ekstra020']; ?></td>
                                <td><?= $result['nama_ekstra020']; ?></td>
                                <td><?= $result['ket020']; ?></td>
                                <td><?= $result['semester020']; ?></td>
                                <td><?= $result['thn_ajaran020']; ?></td>
                                <td>
                                    <a href="index.php?page=ekstra2511500020&action=hapus&id=<?= $result['id_ekstra020']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')">
                                        <span class="badge badge-danger">Hapus</span>
                                    </a>

                                    <a href="index.php?page=edit_ekstra2511500020&id=<?= $result['id_ekstra020']; ?>">
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