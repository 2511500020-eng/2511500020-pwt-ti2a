<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Kode otomatis
$carikode = mysqli_query($koneksi, "SELECT MAX(id_ekstra020) FROM ekstra_2511500020") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "E-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "E-001";
}

$_SESSION["KODE"] = $hasilkode;

// Proses simpan
if (isset($_POST['tambah'])) {
    $id_ekstra020 = $_POST['id_ekstra020'];
    $nama_ekstra020 = $_POST['nama_ekstra020'];
    $ket020 = $_POST['ket020'];
    $semester020 = $_POST['semester020'];
    $thn_ajaran020 = $_POST['thn_ajaran020'];

    $insert = mysqli_query($koneksi, "INSERT INTO ekstra_2511500020 VALUES ('$id_ekstra020', '$nama_ekstra020', '$ket020', '$semester020', '$thn_ajaran020')");

    if ($insert) {
        echo '
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra2511500020">';
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
                        <label for="id_ekstra020">ID Ekstrakurikuler</label>
                        <input 
                            type="text" 
                            name="id_ekstra020" 
                            value="<?= $hasilkode; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama_ekstra020">Nama Ekstrakurikuler</label>
                        <input 
                            type="text" 
                            name="nama_ekstra020" 
                            id="nama_ekstra020"
                            placeholder="Nama Ekstrakurikuler" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="ket020">Keterangan</label>
                        <input 
                            type="text" 
                            name="ket020" 
                            id="ket020" 
                            placeholder="Keterangan Ekstrakurikuler" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="semester020">Semester</label>
                        <select class="form-control" name="semester020" id="semester020">
                            <option disabled selected>-- Pilih Semester --</option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="thn_ajaran020">Tahun Ajaran</label>
                        <select class="form-control" name="thn_ajaran020" id="thn_ajaran020">
                            <option disabled selected>-- Pilih Tahun Ajaran --</option>
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                        </select>
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