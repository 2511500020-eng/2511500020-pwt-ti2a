<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Mata Pelajaran</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Kode otomatis
$carikode = mysqli_query($koneksi, "SELECT MAX(id_kelas) FROM kelas") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "K-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "K-001";
}

$_SESSION["KODE"] = $hasilkode;

// Proses simpan
if (isset($_POST['tambah'])) {
    $id_kelas = $_POST['id_kelas'];
    $nm_kelas = $_POST['nm_kelas'];

    $insert = mysqli_query($koneksi, "INSERT INTO kelas VALUES ('$id_kelas', '$nm_kelas')");

    if ($insert) {
        echo '
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
    } else {
        echo '
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Gagal Disimpan</h4>
        </div>';
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">

                <form method="POST" action="">

                    <div class="form-group">
                        <label for="id_kelas">Kode kelas</label>
                        <input 
                            type="text" 
                            name="id_kelas" 
                            value="<?= $hasilkode; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nm_kelas">Nama kelas</label>
                        <input 
                            type="text" 
                            name="nm_kelas" 
                            id="nm_kelas"
                            placeholder="Nama kelas" 
                            class="form-control">
                    </div>

                    <div class="card-footer">
                        <input 
                            type="submit" 
                            class="btn btn-primary" 
                            name="tambah" 
                            value="Simpan">
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>