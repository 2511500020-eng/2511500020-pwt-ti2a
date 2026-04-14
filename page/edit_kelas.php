<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Mata Pelajaran</h1>
            </div>
        </div>
    </div>
</div>

<?php
$id = $_GET['id'];

// PERBAIKAN: SELECT harus pakai *
$query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id'");
$edit  = mysqli_fetch_array($query);

// Proses update
if (isset($_POST['tambah'])) {
    $id_kelas = $_POST['id_kelas'];
    $nm_kelas = $_POST['nm_kelas'];

    // PERBAIKAN: tanda kutip kkm diperbaiki
    $update = mysqli_query($koneksi, "UPDATE kelas 
        SET nm_kelas='$nm_kelas'
        WHERE id_kelas='$id_kelas'
    ");

    if ($update) {
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
                            value="<?= $edit['id_kelas']; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="nm_kelas">Nama kelas</label>
                        <input 
                            type="text" 
                            name="nm_kelas" 
                            value="<?= $edit['nm_kelas']; ?>" 
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