<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
// Kode otomatis
$carikode = mysqli_query($koneksi, "SELECT MAX(id_jadwal) FROM jad_kelas") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "J-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "J-001";
}

$_SESSION["KODE"] = $hasilkode;

// Proses simpan
if (isset($_POST['tambah'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $guru = $_POST['guru'];
    $semester = $_POST['semester'];
    $thn_ajaran = $_POST['thn_ajaran'];
    $mapel = $_POST['mapel'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $kelas = $_POST['kelas'];

    $insert = mysqli_query($koneksi, "INSERT INTO jad_kelas VALUES ('$id_jadwal', '$guru', '$thn_ajaran', '$semester')");
    
    if (!$insert) {
        echo "Gagal insert ke tabel jadwal: " . mysqli_error($koneksi);
        die;
    }

    $allSuccess = true;
    for ($i = 0; $i < count($mapel); $i++) {
        $insertdetail = mysqli_query($koneksi, "INSERT INTO detail_jadwal (id_jadwal, kd_mapel, id_kelas, hari, jam_mulai, jam_selesai) VALUES ('$id_jadwal', '{$mapel[$i]}', '{$kelas[$i]}', '{$hari[$i]}', '{$jam_mulai[$i]}', '{$jam_selesai[$i]}')");
        if (!$insertdetail) {
            $allSuccess = false;
            echo "Gagal insert detail ke-{$i}: " . mysqli_error($koneksi);
        }
    }

    if ($allSuccess) {
        echo '
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Berhasil Disimpan</h4>
        </div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
        //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    } else {
        echo '
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <h5><i class="icon fas fa-info"></i> Info</h5>
            <h4>Gagal menyimpan sebagian atau seluruh data detail</h4>
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
                            value="<?= $hasilkode; ?>" 
                            class="form-control" 
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="guru">Guru</label>
                        <select class="form-control" name="guru" id="guru">
                            <option disabled selected>-- Pilih Guru --</option>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM guru");
                            while ($g = mysqli_fetch_array($query)) {
                                echo "<option value='$g[kd_guru]'>$g[nm_guru]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="thn_ajaran">Tahun Ajaran</label>
                        <select class="form-control" name="thn_ajaran" id="thn_ajaran">
                            <option disabled selected>-- Pilih Tahun Ajaran --</option>
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester">
                            <option disabled selected>-- Pilih Semester --</option>
                            <option value='Ganjil'>Ganjil</option>
                            <option value='Genap'>Genap</option>
                        </select>
                    </div>

                    <hr>
                    <h5>Detail Jadwal</h5>
                    <div id="detail-jadwal" style="display:flex; justify-content:center; gap:8px;>
                        <div class="row mb-2">

                            <div class="col-md-3">
                                <select name="mapel[]" class="form-control">
                                    <option disabled selected>-- Pilih Mata Pelajaran --</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
                                        while ($m = mysqli_fetch_array($query)) {
                                            echo "<option value='$m[kd_mapel]'>$m[nm_mapel]</option>";
                                        }
                                        ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select class="form-control" name="kelas[]" id="kelas[]">
                                    <option disabled selected>-- Pilih Kelas --</option>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                                    while ($k = mysqli_fetch_array($query)) {
                                        echo "<option value='$k[id_kelas]'>$k[nm_kelas]</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="hari[]" class="form-control">
                                    <option disabled selected>-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="jam_mulai[]" class="form-control">
                                    <option disabled selected>-- Jam Mulai --</option>
                                    <option value="07.00">07.00</option>
                                    <option value="07.40">07.40</option>
                                    <option value="08.20">08.20</option>
                                    <option value="09.40">09.40</option>
                                    <option value="10.20">10.20</option>
                                    <option value="11.00">11.00</option>
                                    <option value="11.40">11.40</option>
                                    <option value="13.00">13.00</option>
                                    <option value="13.40">13.40</option>
                                </select>
                            </div>

                            <div class="col-md-2" style="">
                                <select name="jam_selesai[]" class="form-control">
                                    <option disabled selected>-- Jam Selesai --</option>
                                    <option value="07.40">07.00</option>
                                    <option value="08.20">08.20</option>
                                    <option value="09.00">09.00</option>
                                    <option value="10.20">10.20</option>
                                    <option value="11.00">11.00</option>
                                    <option value="11.40">11.40</option>
                                    <option value="12.20">12.20</option>
                                    <option value="13.40">13.40</option>
                                    <option value="14.20">14.20</option>
                                </select>
                            </div>

                        </div>
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