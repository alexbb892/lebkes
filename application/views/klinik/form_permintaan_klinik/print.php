<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  body {
    font-family: 'Arial', sans-serif;
    font-size: 9pt;
    color: #000;
  }

  /* ===== HEADER BARU ===== */
  .header {
    border-bottom: 1.5px solid #000;
    margin-bottom: 6px;
    padding-bottom: 4px;
  }

  .header-content {
    display: flex;
    align-items: center; /* sejajarkan vertikal logo dan teks */
    justify-content: center; /* teks tetap di tengah halaman */
    gap: 15px;
  }

  .logo-box img {
    width: 55px; /* ukuran logo */
    height: auto;
  }

  .text-box {
    text-align: center;
  }

  .text-box h2, 
  .text-box h3, 
  .text-box p {
    margin: 0;
    line-height: 1.2;
  }

  .text-box h2 { font-size: 12pt; font-weight: bold; }
  .text-box h3 { font-size: 10pt; font-weight: bold; }
  .text-box p  { font-size: 9pt; }

  .title {
    text-align: center;
    font-weight: bold;
    font-size: 10pt;
    text-decoration: underline;
    margin: 6px 0 8px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5pt;
  }

  th, td {
    padding: 3px 5px;
    vertical-align: top;
  }

  .bordered {
    border: 1px solid #000;
  }

  .section-title {
    background: #f2f2f2;
    font-weight: bold;
    text-align: center;
    border: 1px solid #000;
    padding: 3px;
    font-size: 9pt;
  }

  .triple-col {
    width: 33.33%;
    border: 1px solid #000;
    height: 100%;
  }

  .content {
    padding: 4px 6px;
  }

  .subtable td {
    border: none;
    padding: 2px 4px;
  }

  .label {
    width: 46%;
    font-weight: bold;
  }

  .mt-2 { margin-top: 6px; }
  .mt-3 { margin-top: 10px; }

  .center { text-align: center; }
  .bold { font-weight: bold; }
  .underline { text-decoration: underline; }

  .small-text { font-size: 8pt; }

  /* Tabel pemeriksaan */
  .tbl-pemeriksaan th, 
  .tbl-pemeriksaan td {
    border: 1px solid #000;
    vertical-align: middle;
    font-size: 8.5pt;
    line-height: 1.3;
  }
  .tbl-pemeriksaan th {
    padding-top: 4px;
    padding-bottom: 4px;
  }
  .tbl-pemeriksaan td {
    padding-top: 2px;
    padding-bottom: 2px;
    padding-left: 10px;
  }

</style>
</head>
<body>

<!-- HEADER -->
<table style="width:100%; border-bottom:1.5px solid #000; margin-bottom:6px; padding-bottom:4px;">
  <tr>
    <!-- KIRI: LOGO -->
    <td style="width:100px; text-align:center; vertical-align:middle;">
      <img src="<?= base_url('assets/img/logolabkes.png') ?>" alt="Logo" style="width:100px; height:auto;">
    </td>

    <!-- TENGAH: TEKS HEADER (BENAR-BENAR DI TENGAH HALAMAN) -->
    <td style="text-align:center; vertical-align:middle;">
      <h2 style="margin:0; font-size:12pt; font-weight:bold;">PEMERINTAH KOTA PANGKALPINANG</h2>
      <h3 style="margin:0; font-size:10pt; font-weight:bold;">DINAS KESEHATAN</h3>
      <p style="margin:0; font-size:9pt;"><strong>UPTD LABORATORIUM KESEHATAN</strong></p>
      <p style="margin:0; font-size:8pt;">Jalan Delima Siam VI Girimaya Pangkal Pinang - Telp (0717) 9120759</p>
    </td>

    <!-- KANAN: KOTAK KOSONG UNTUK BALANCE -->
    <td style="width:100px;"></td>
  </tr>
</table>

<!-- TITLE -->
<div class="title" style="text-align:center; font-weight:bold; font-size:10pt; text-decoration:underline; margin:6px 0 8px;">
  FORMULIR PERMINTAAN PEMERIKSAAN LABORATORIUM KLINIK
</div>

<!-- IDENTITAS -->
<table class="bordered" style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
  <tr>
    <!-- === IDENTITAS PASIEN === -->
    <td class="triple-col" style="vertical-align: top; border: 1px solid #000; width: 33.3%; padding: 0;">
      <div class="" 
           style="">
        <strong>IDENTITAS PASIEN</strong>
      </div>
      <div class="content" style="padding: 4px 8px; font-size: 10pt;">
        <table class="subtable" style="width: 100%; border-collapse: collapse;">
          <tr><td style="width: 45%;">No. Register</td><td>: <?= $form->no_register ?></td></tr>
          <tr><td>Nama Pasien</td><td>: <?= $form->nama_pasien ?></td></tr>
          <tr><td>NIK</td><td>: <?= $form->nik ?></td></tr>
          <tr><td>Jenis Kelamin</td><td>: <?= $form->gender ?></td></tr>
          <tr><td>Tgl Lahir / Umur</td><td>: <?= $form->tgl_lahir ?> / <?= $form->umur ?></td></tr>
          <tr><td>No. Telp</td><td>: <?= $form->no_telp ?></td></tr>
          <tr><td>Alamat</td><td>: <?= nl2br($form->alamat) ?></td></tr>
        </table>
      </div>
    </td>

    <!-- === IDENTITAS PENGIRIM === -->
    <td class="triple-col" style="vertical-align: top; border: 1px solid #000; width: 33.3%; padding: 0;">
      <div class="label" 
           style="">
        IDENTITAS PENGIRIM
      </div>
      <div class="content" style="padding: 4px 8px; font-size: 10pt;">
        <table class="subtable" style="width: 100%; border-collapse: collapse;">
          <tr><td style="width: 45%;">Nama Dokter</td><td>: <?= $form->nama_dokter ?></td></tr>
          <tr><td>No. Telp Dokter</td><td>: <?= $form->telp_pengirim ?></td></tr>
          <tr><td>Alamat Dokter</td><td>: <?= nl2br($form->alamat_pengirim) ?></td></tr>
          <tr><td>Tanggal Form</td><td>: <?= $form->tgl_form ?></td></tr>
        </table>
      </div>
    </td>

    <!-- === DIAGNOSA KLINIS === -->
    <td class="triple-col" style="vertical-align: top; border: 1px solid #000; width: 33.3%; padding: 0;">
      <div class="" 
           style="">
        <strong>DIAGNOSA KLINIS</strong>
      </div>
      <div class="content" style="padding: 4px 8px; font-size: 10pt;">
        <table class="subtable" style="width: 100%; border-collapse: collapse;">
          <tr><td style="width: 45%;">Diagnosa Klinik</td><td>: <?= nl2br($form->diagnosa_klinis) ?></td></tr>
          <tr><td>Obat Dikonsumsi</td><td>: <?= nl2br($form->obat_dikonsumsi) ?></td></tr>
          <tr><td>Tanda Tangan Pengirim</td><td> : </td></tr>
        </table>
      </div>
    </td>
  </tr>
</table>


<!-- DATA SPESIMEN -->
<div class="mt-3">
  <div class="section-title">DATA SPESIMEN</div>
  <table class="tbl-spesimen">
    <tr>
      <td class="">Asal Sampel</td><td>: <?= $form->asal_sampel ?></td>
      <td class="">Status Puasa</td><td>: <?= $form->puasa ?> - <?= $form->keterangan_puasa ?></td>
    </tr>
    <tr>
      <td class="">Lokasi Pengambilan</td>
      <td>: <?= $form->lokasi_pengambilan ?><?= $form->lokasi_lainnya ? ', '.$form->lokasi_lainnya : '' ?></td>
      <td class="">Jenis Spesimen</td>
      <td>: <?= $form->jenis_spesimen ?><?= $form->spesimen_lainnya ? ', '.$form->spesimen_lainnya : '' ?></td>
    </tr>
    <tr>
      <td class="">Tanggal Permintaan</td><td>: <?= $form->tgl_permintaan ?></td>
      <td class="">Prioritas</td><td>: <?= $form->prioritas ?></td>
    </tr>
    <tr>
      <td class="">Tanggal Pengambilan</td><td>: <?= $form->tgl_pengambilan ?></td>
      <td class="">Volume Spesimen</td><td>: <?= $form->volume_spesimen ?></td>
    </tr>
    <tr>
      <td class="">Jam Pengambilan</td><td>: <?= $form->jam_pengambilan ?></td>
      <td class="">Informasi Tambahan</td><td>: <?= nl2br($form->info_tambahan) ?></td>
    </tr>
  </table>
</div>

<style>
/* 🔹 Styling tabel DATA SPESIMEN agar lebih rapat */
.tbl-spesimen {
  width: 100%;
  border: 1px solid #000;      /* tetap ada garis luar */
  border-collapse: collapse;
  margin-top: 2px;
}

/* Hapus garis dalam tabel */
.tbl-spesimen td {
  border: none !important;     /* hilangkan garis antar sel */
  padding: 1.5px 5px !important;
  line-height: 1.1;
  font-size: 8.5pt;
}

/* Tetap tegas untuk label kiri */
.tbl-spesimen .label {
  width: 25%;
  font-weight: bold;
  color: #000;
}

/* Tambah garis luar halus di sekeliling tabel */
.tbl-spesimen tr:first-child td {
  border-top: none;
}
.tbl-spesimen tr:last-child td {
  border-bottom: none;
}

</style>
<!-- TABEL PEMERIKSAAN -->
<table style="width:100%; border-collapse: collapse; font-size: 9pt;">
<thead>
<tr>
  <th style="border:1px solid #000; padding:5px; width:5%; text-align:center;">No</th>
  <th style="border:1px solid #000; padding:5px; width:95%;">Jenis Pemeriksaan</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;
$kategori = '';
$sub = '';

foreach ($detail as $d):

    // === HEADER KATEGORI ===
    if ($kategori != $d->kategori):
        $kategori = $d->kategori;
        $sub = '';
        $no = 1;
?>
<tr style="background:#e6e6e6; font-weight:bold;">
    <td colspan="2" style="border:1px solid #000; padding:5px;">
        <?= strtoupper($kategori) ?>
    </td>
</tr>
<?php endif; ?>


<?php
    // === HEADER SUBKATEGORI ===
    if ($sub != $d->sub_kategori && $d->sub_kategori != ''):
        $sub = $d->sub_kategori;
?>
<tr style="background:#f7f7f7; font-weight:bold;">
    <td colspan="2" style="border:1px solid #000; padding:5px 5px 5px 20px;">
        <?= strtoupper($sub) ?>
    </td>
</tr>
<?php endif; ?>


<!-- === ROW JENIS PEMERIKSAAN === -->
<tr>
    <td style="border:1px solid #000; text-align:center; padding:5px;"><?= $no++ ?></td>
    <td style="border:1px solid #000; padding:5px;">
        <?= htmlspecialchars($d->nama_jenis) ?>
    </td>
</tr>

<?php endforeach; ?>
</tbody>
</table>

</div>

<style>
.tbl-pemeriksaan th, 
.tbl-pemeriksaan td {
  border: 1px solid #000;
  vertical-align: middle;
  font-size: 8.5pt;
  line-height: 1.3;
}
.tbl-pemeriksaan th {
  padding: 4px 0;
}
.tbl-pemeriksaan td {
  padding: 2px 0;
}
.center { text-align: center; }
.row-kategori { background:#e6e6e6; }
.row-sub { background:#f7f7f7; }
</style>



<!-- KAJI ULANG PERMINTAAN PEMERIKSAAN -->
<div class="mt-3">
  <div class="section-title">KAJI ULANG PERMINTAAN PEMERIKSAAN</div>
  <table class="bordered" style="width: 100%; border-collapse: collapse; margin-top: 0;">
        <tr>
      <!-- === KELAYAKAN SAMPEL === -->
      <td class="double-col">
        <div class="label">KELAYAKAN SAMPEL</div>
        <div class="content">
          <table class="subtable">
            <tr><td class="">Status</td><td>: <?= $kelayakan['status'] ?></td></tr>
            <?php if ($kelayakan['status'] == 'Tidak Layak'): ?>
            <tr><td class="">Alasan</td><td>: <?= $kelayakan['alasan'] ?></td></tr>
            <?php endif; ?>
            <tr>
              <td width="40%">Volume Sampel</td>
              <td width="60%">: <?= $form->volume_sampel_kaji_ulang ? htmlspecialchars($form->volume_sampel_kaji_ulang) : '-' ?></td>
            </tr>
          </table>
        </div>
      </td>

      <!-- === INFORMASI PEMBAYARAN === -->
      <td class="double-col">
        <div class="label">INFORMASI PEMBAYARAN</div>
        <div class="content">
          <table class="subtable">
            <tr><td class="">Jumlah Biaya</td><td>: Rp <?= number_format($pembayaran->jumlah_biaya, 0, ',', '.') ?></td></tr> 
            <tr><td class="">Metode Pembayaran</td><td>: <?= $pembayaran->metode_pembayaran ?></td></tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
</div>


<style>
  /* === GAYA DOUBLE COLUMN === */
  .bordered {
    width: 100%;
    border: 1.5px solid #000;
    border-collapse: collapse;
  }

  .bordered td {
    border: 1px solid #000;
    vertical-align: top;
    padding: 5px;
  }

  .double-col {
    width: 50%;
  }

  .section-title {
    background: #e6e6e6;
    border-bottom: 1px solid #000;
    text-align: center;
    font-weight: bold;
    font-size: 10pt;
    text-transform: uppercase;
    padding: 4px 0;
  }

  .content {
    padding: 5px 6px;
  }

  .subtable {
    width: 100%;
    border-collapse: collapse;
    font-size: 9pt;
  }

  .subtable td {
    padding: 2px 4px;
    vertical-align: top;
  }

  .label {
    width: 45%;
    font-weight: bold;
  }

  /* === Print-friendly === */
  @media print {
    .bordered, .bordered td {
      border: 1px solid #000;
    }
    .section-title {
      background: #f0f0f0 !important;
    }
  }
</style>

      <!-- PERNYATAAN PASIEN & PETUGAS -->
<div class="mt-3">
  <table style="width:100%; border:1px solid #000; border-collapse:collapse; font-size:8.5pt;">
    <tr>
      <td style="padding:5px;">
        <p>
          Dengan ini saya menyatakan bahwa informasi yang saya berikan adalah benar dan saya memahami serta menyetujui
          untuk dilakukan pengambilan, penyimpanan, dan tindakan pemeriksaan yang dilakukan oleh
          UPTD Labkes Kota Pangkalpinang untuk pemeriksaan saya.
        </p>
      </td>
      <td style="width:25%; vertical-align:top; text-align:center;">
  <p>Tgl: <?= date('d-m-Y', strtotime($form->tgl_form)) ?></p>
  <p><strong>Tanda Tangan Pasien</strong></p><br><br>
  <p> <?= $form->nama_pasien ?? '-' ?> </p>
</td>
    </tr>
  </table>

  <table style="width:100%; border:1px solid #000; border-collapse:collapse; font-size:9.5pt; margin-top:4px;">
  <tr style="text-align:center; font-weight:bold;">
    <td style="width:40%; vertical-align:top;">
      <strong>Petugas Pendaftaran</strong>
      <br><br><br><br>
      <p style="margin:0; font-weight:normal; font-size:10pt;">
        <?= !empty($form->petugas_pendaftaran) ? $form->petugas_pendaftaran : '_______________________' ?>
      </p>
    </td>
    <td style="width:40%; vertical-align:top;">
      <strong>Petugas Pengambil Sampel</strong>
      <br><br><br><br>
      <p style="margin:0; font-weight:normal; font-size:10pt;">
        <?= !empty($form->petugas_pengambil) ? $form->petugas_pengambil : '_______________________' ?>
      </p>
    </td>
    <td style="width:40%; vertical-align:top;">
      <strong>Petugas Verifikasi</strong>
      <br><br><br><br>
      <p style="margin:0; font-weight:normal; font-size:10pt;">
        <?= !empty($form->petugas_verifikasi) ? $form->petugas_verifikasi : '_______________________' ?>
      </p>
    </td>

    <td style="width:40%; vertical-align:top;">
      <strong>Petugas Validasi</strong>
      <br><br><br><br>
      <p style="margin:0; font-weight:normal; font-size:10pt;">
        <?= !empty($form->petugas_validasi) ? $form->petugas_validasi : '_______________________' ?>
      </p>
    </td>
    <tr style="height:50px;">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
</div>

<!-- KARTU KENDALI WAKTU PEMERIKSAAN LABORATORIUM -->
<div class="mt-3">
  <div class="section-title" style="font-weight:bold; margin-bottom:5px;">
    KARTU KENDALI WAKTU PEMERIKSAAN LABORATORIUM
  </div>

  <table style="width:100%; border:1px solid #000; border-collapse:collapse; font-size:8.5pt; text-align:center;">
    <thead style="font-weight:bold;">
      <tr>
        <td style="width:15%; border:1px solid #000;">Pengambilan Sampel</td>
        <td style="width:7%; border:1px solid #000;">Paraf</td>
        <td style="width:15%; border:1px solid #000;">Sampel Diterima Laboratorium</td>
        <td style="width:7%; border:1px solid #000;">Paraf</td>
        <td style="width:15%; border:1px solid #000;">Pengerjaan Sampel</td>
        <td style="width:7%; border:1px solid #000;">Paraf</td>
        <td style="width:15%; border:1px solid #000;">Input Hasil Pemeriksaan</td>
        <td style="width:7%; border:1px solid #000;">Paraf</td>
        <td style="width:15%; border:1px solid #000;">Cetak Lembar Hasil Uji</td>
        <td style="width:7%; border:1px solid #000;">Paraf</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #000; height:18px;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
        <td style="border:1px solid #000;"></td>
      </tr>
      <tr>
        <td colspan="10" style="border-top:2px solid #000; font-weight:bold; text-align:left;">CATATAN :</td>
      </tr>
    </tbody>
  </table>
</div>



<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>