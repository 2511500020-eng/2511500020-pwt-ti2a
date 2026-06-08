<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
$id = $_GET['id'];

// PERBAIKAN: SELECT harus pakai *
$query_jadwal = mysqli_query($koneksi, "SELECT * FROM jad_kelas WHERE id_jadwal='$id'");
$edit_jadwal = mysqli_fetch_array($query_jadwal);

$query_detail = mysqli_query($koneksi, "SELECT * FROM detail_jadwal WHERE id_jadwal='$id'");

// Proses update
if (isset($_POST['tambah'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $guru = $_POST['guru'];
    $semester = $_POST['semester'];
    $thn_ajaran = $_POST['thn_ajaran'];
    $mapel = $_POST['mapel'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $update_jadwal = mysqli_query($koneksi, "UPDATE jad_kelas 
        SET kd_guru='$guru', thn_ajaran='$thn_ajaran', semester='$semester' 
        WHERE id_jadwal='$id_jadwal'
    ");

    $update_detail = mysqli_query($koneksi, "UPDATE detail_jadwal
        SET kd_mapel='$mapel', id_kelas='$kelas', hari='$hari' , jam_mulai='$jam_mulai', jam_selesai='$jam_selesai'
        WHERE id_jadwal='$id_jadwal'
    ");

    if ($update_jadwal && $update_detail) {
        echo '
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
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
                        <label for="id_jadwal">ID jadwal</label>
                        <input 
                            type="text" 
                            name="id_jadwal" 
                            value="<?= $edit_jadwal['id_jadwal']; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="guru">Guru</label>
                        <select class="form-control" name="guru" id="guru">
                            <option disabled>-- Pilih Guru --</option>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM guru");
                            while ($g = mysqli_fetch_array($query)) {
                                echo "<option value='$g[kd_guru]'" . ($edit_jadwal['kd_guru'] == $g['kd_guru'] ? 'selected' : '') . ">$g[nm_guru]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="thn_ajaran">Tahun Ajaran</label>
                        <select class="form-control" name="thn_ajaran" id="thn_ajaran">
                            <option disabled>-- Pilih Tahun Ajaran --</option>
                            <option value="2026/2025" <?= ($edit_jadwal['thn_ajaran'] == '2026/2025') ? 'selected' : '' ?>>2026/2025</option>
                            <option value="2024/2025" <?= ($edit_jadwal['thn_ajaran'] == '2024/2025') ? 'selected' : '' ?>>2024/2025</option>
                            <option value="2023/2024" <?= ($edit_jadwal['thn_ajaran'] == '2023/2024') ? 'selected' : '' ?>>2023/2024</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester">
                            <option disabled>-- Pilih Semester --</option>
                            <option value='Ganjil' <?= ($edit_jadwal['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                            <option value='Genap' <?= ($edit_jadwal['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                        </select>
                    </div>

                    <hr>
                    <h5>Detail Jadwal</h5>
                    <div id="detail-jadwal">
                    
                    <?php while ($detail = mysqli_fetch_array($query_detail)) { ?>

                        <div class="row mb-2">

                            <div class="col-md-3">
                                <select name="mapel[]" class="form-control">
                                    <option disabled>-- Pilih Mata Pelajaran --</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
                                        while ($m = mysqli_fetch_array($query)) {
                                            echo "<option value='$m[kd_mapel]'" . ($detail['kd_mapel'] == $m['kd_mapel'] ? 'selected' : '') . ">$m[nm_mapel]</option>";
                                        }
                                        ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select class="form-control" name="kelas[]" id="kelas[]">
                                    <option disabled>-- Pilih Kelas --</option>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                                    while ($k = mysqli_fetch_array($query)) {
                                        echo "<option value='$k[id_kelas]'" . ($detail['id_kelas'] == $k['id_kelas'] ? 'selected' : '') . ">$k[nm_kelas]</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="hari[]" class="form-control">
                                    <option disabled>-- Pilih Hari --</option>
                                    <option value="Senin" <?= ($detail['hari'] == 'Senin') ? 'selected' : '' ?>>Senin</option>
                                    <option value="Selasa" <?= ($detail['hari'] == 'Selasa') ? 'selected' : '' ?>>Selasa</option>
                                    <option value="Rabu" <?= ($detail['hari'] == 'Rabu') ? 'selected' : '' ?>>Rabu</option>
                                    <option value="Kamis" <?= ($detail['hari'] == 'Kamis') ? 'selected' : '' ?>>Kamis</option>
                                    <option value="Jumat" <?= ($detail['hari'] == 'Jumat') ? 'selected' : '' ?>>Jumat</option>
                                    <option value="Sabtu" <?= ($detail['hari'] == 'Sabtu') ? 'selected' : '' ?>>Sabtu</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="jam_mulai[]" class="form-control">
                                    <option disabled>-- Jam Mulai --</option>
                                    <option value="07.00" <?= ($detail['jam_mulai'] == '07.00') ? 'selected' : '' ?>>07.00</option>
                                    <option value="07.40" <?= ($detail['jam_mulai'] == '07.40') ? 'selected' : '' ?>>07.40</option>
                                    <option value="08.20" <?= ($detail['jam_mulai'] == '08.20') ? 'selected' : '' ?>>08.20</option>
                                    <option value="09.40" <?= ($detail['jam_mulai'] == '09.40') ? 'selected' : '' ?>>09.40</option>
                                    <option value="10.20" <?= ($detail['jam_mulai'] == '10.20') ? 'selected' : '' ?>>10.20</option>
                                    <option value="11.00" <?= ($detail['jam_mulai'] == '11.00') ? 'selected' : '' ?>>11.00</option>
                                    <option value="11.40" <?= ($detail['jam_mulai'] == '11.40') ? 'selected' : '' ?>>11.40</option>
                                    <option value="13.00" <?= ($detail['jam_mulai'] == '13.00') ? 'selected' : '' ?>>13.00</option>
                                    <option value="13.40" <?= ($detail['jam_mulai'] == '13.40') ? 'selected' : '' ?>>13.40</option>
                                </select>
                            </div>

                            <div class="col-md-2" style="">
                                <select name="jam_selesai[]" class="form-control">
                                    <option disabled>-- Jam Selesai --</option>
                                    <option value="07.40" <?= ($detail['jam_selesai'] == '07.40') ? 'selected' : '' ?>>07.40</option>
                                    <option value="08.20" <?= ($detail['jam_selesai'] == '08.20') ? 'selected' : '' ?>>08.20</option>
                                    <option value="09.00" <?= ($detail['jam_selesai'] == '09.00') ? 'selected' : '' ?>>09.00</option>
                                    <option value="10.20" <?= ($detail['jam_selesai'] == '10.20') ? 'selected' : '' ?>>10.20</option>
                                    <option value="11.00" <?= ($detail['jam_selesai'] == '11.00') ? 'selected' : '' ?>>11.00</option>
                                    <option value="11.40" <?= ($detail['jam_selesai'] == '11.40') ? 'selected' : '' ?>>11.40</option>
                                    <option value="12.20" <?= ($detail['jam_selesai'] == '12.20') ? 'selected' : '' ?>>12.20</option>
                                    <option value="13.40" <?= ($detail['jam_selesai'] == '13.40') ? 'selected' : '' ?>>13.40</option>
                                    <option value="14.20" <?= ($detail['jam_selesai'] == '14.20') ? 'selected' : '' ?>>14.20</option>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
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