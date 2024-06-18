<?php
require_once '../layout/_top.php';
require_once '../helper/connection.php';

$mahasiswa = mysqli_query($connection, "SELECT COUNT(*) FROM mahasiswa");
$dosen = mysqli_query($connection, "SELECT COUNT(*) FROM dosen");
$matakuliah = mysqli_query($connection, "SELECT COUNT(*) FROM matakuliah");
$nilai = mysqli_query($connection, "SELECT COUNT(*) FROM nilai");

$total_mahasiswa = mysqli_fetch_array($mahasiswa)[0];
$total_dosen = mysqli_fetch_array($dosen)[0];
$total_matakuliah = mysqli_fetch_array($matakuliah)[0];
$total_nilai = mysqli_fetch_array($nilai)[0];
?>

<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="columns is-multiline">
    <div class="column is-one-quarter">
      <div class="box">
        <article class="media">
          <div class="media-left">
            <span class="icon has-text-primary">
              <i class="far fa-user fa-2x"></i>
            </span>
          </div>
          <div class="media-content">
            <div class="content">
              <h4 class="title is-4">Total Dosen</h4>
              <p class="subtitle is-5"><?= $total_dosen ?></p>
            </div>
          </div>
        </article>
      </div>
    </div>
    <div class="column is-one-quarter">
      <div class="box">
        <article class="media">
          <div class="media-left">
            <span class="icon has-text-danger">
              <i class="far fa-user fa-2x"></i>
            </span>
          </div>
          <div class="media-content">
            <div class="content">
              <h4 class="title is-4">Total Mahasiswa</h4>
              <p class="subtitle is-5"><?= $total_mahasiswa ?></p>
            </div>
          </div>
        </article>
      </div>
    </div>
    <div class="column is-one-quarter">
      <div class="box">
        <article class="media">
          <div class="media-left">
            <span class="icon has-text-warning">
              <i class="far fa-file fa-2x"></i>
            </span>
          </div>
          <div class="media-content">
            <div class="content">
              <h4 class="title is-4">Total Mata Kuliah</h4>
              <p class="subtitle is-5"><?= $total_matakuliah ?></p>
            </div>
          </div>
        </article>
      </div>
    </div>
    <div class="column is-one-quarter">
      <div class="box">
        <article class="media">
          <div class="media-left">
            <span class="icon has-text-success">
              <i class="far fa-newspaper fa-2x"></i>
            </span>
          </div>
          <div class="media-content">
            <div class="content">
              <h4 class="title is-4">Total Nilai Masuk</h4>
              <p class="subtitle is-5"><?= $total_nilai ?></p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<?php
require_once '../layout/_bottom.php';
?>
