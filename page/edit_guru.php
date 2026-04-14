<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];

// PERBAIKAN: SELECT harus pakai *
$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE kd_guru='$kd'");
$edit  = mysqli_fetch_array($query);

// Proses update
if (isset($_POST['tambah'])) {
    $kd_guru = $_POST['kd_guru'];
    $nm_guru = $_POST['nm_guru'];
    $jenkel = $_POST['jenkel'];
    $pend_terakhir = $_POST['pend_terakhir'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];

    // PERBAIKAN: tanda kutip kkm diperbaiki
    $update = mysqli_query($koneksi, "UPDATE guru 
        SET nm_guru='$nm_guru', jenkel='$jenkel', pend_terakhir='$pend_terakhir', hp='$hp', alamat='$alamat' 
        WHERE kd_guru='$kd_guru'
    ");

    if ($update) {
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
                            value="<?= $edit['kd_guru']; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nm_guru">Nama guru</label>
                        <input 
                            type="text" 
                            name="nm_guru" 
                            value="<?= $edit['nm_guru']; ?>" 
                            id="nm_guru" 
                            placeholder="Nama guru" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select class="form-control" name="jenkel" id="jenkel">
                            <option disabled selected>-- Pilih Jenis Kelamin -- </option>
                            <option value="Laki-laki" <?= ($edit['jenkel'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($edit['jenkel'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pend_terakhir">Pendidikan Terakhir</label>
                        <select class="form-control" name="pend_terakhir" id="pend_terakhir">
                            <option disabled selected>-- Pilih Pendidikan Terakhir --</option>
                            <option value="Strata 2" <?= ($edit['pend_terakhir'] == 'Strata 2') ? 'selected' : '' ?>>Strata 2</option>
                            <option value="Strata 1" <?= ($edit['pend_terakhir'] == 'Strata 1') ? 'selected' : '' ?>>Strata 1</option>
                            <option value="Diploma 3" <?= ($edit['pend_terakhir'] == 'Diploma 3') ? 'selected' : '' ?>>Diploma 3</option>
                            <option value="SMA Sederajat" <?= ($edit['pend_terakhir'] == 'SMA Sederajat') ? 'selected' : '' ?>>SMA Sederajat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hp">No. HP</label>
                        <input 
                            type="text" 
                            name="hp" 
                            value="<?= $edit['hp']; ?>"
                            id="hp"
                            placeholder="No. HP" 
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input 
                            type="text" 
                            name="alamat" 
                            value="<?= $edit['alamat']; ?>"
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