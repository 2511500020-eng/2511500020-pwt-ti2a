<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Kode otomatis
$carikode = mysqli_query($koneksi, "SELECT MAX(kd_guru) FROM guru") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "G-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "G-001";
}

$_SESSION["KODE"] = $hasilkode;

// Proses simpan
if (isset($_POST['tambah'])) {
    $kd_guru = $_POST['kd_guru'];
    $nm_guru = $_POST['nm_guru'];
    $jenkel = $_POST['jenkel'];
    $pend_terakhir = $_POST['pend_terakhir'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($koneksi, "INSERT INTO guru VALUES ('$kd_guru', '$nm_guru', '$jenkel', '$pend_terakhir', '$hp', '$alamat')");
    $insertUser = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$kd_guru', '1234', 'guru')");

    if ($insert) {
        echo '
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
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
                        <label for="kd_guru">Kode guru</label>
                        <input 
                            type="text" 
                            name="kd_guru" 
                            value="<?= $hasilkode; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nm_guru">Nama guru</label>
                        <input 
                            type="text" 
                            name="nm_guru" 
                            id="nm_guru"
                            placeholder="Nama guru" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select class="form-control" name="jenkel" id="jenkel">
                            <option disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                        <select class="form-control" name="pend_terakhir" id="pend_terakhir">
                            <option disabled selected>-- Pilih Pendidikan Terakhir --</option>
                            <option value="Strata 2">Strata 2</option>
                            <option value="Strata 1">Strata 1</option>
                            <option value="Diploma 3">Diploma 3</option> 
                            <option value="SMA Sederajat">SMA Sederajat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hp">No. HP</label>
                        <input 
                            type="text" 
                            name="hp" 
                            id="hp"
                            placeholder="No. HP" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input 
                            type="text" 
                            name="alamat" 
                            id="alamat"
                            placeholder="Alamat" 
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