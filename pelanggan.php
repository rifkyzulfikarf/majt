<?php
session_start();
if (isset($_SESSION['majt-id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah">
	<meta name="author"      content="">
	
	<title>Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<!-- Full Calendar styles -->
	<link rel="stylesheet" href="assets/css/fullcalendar.min.css">
	
	<!-- Datatables styles -->
	<link rel="stylesheet" href="assets/css/jquery.dataTables.css">
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap.css">
	
	<!-- jQuery UI styles -->
	<link rel="stylesheet" href="assets/css/jquery-ui.min.css">
	
	<!-- Dropzone JS styles -->
	<link rel="stylesheet" href="assets/css/dropzone.min.css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="assets/css/magister.css">

	<!-- Fonts -->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='assets/css/font.css' rel='stylesheet' type='text/css'>
</head>

<!-- use "theme-invert" class on bright backgrounds, also try "text-shadows" class -->
<body class="text-shadows">

<nav class="mainmenu">
	<div class="container">
		<div class="dropdown">
			<button type="button" class="navbar-toggle" data-toggle="dropdown"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<!-- <a data-toggle="dropdown" href="#">Dropdown trigger</a> -->
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a href="#head" class="active" id="menu-home">Home</a></li>
				<li><a href="#pesanan" id="menu-pesanan">Daftar Pesanan</a></li>
				<li><a href="#logout" id="logout">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>


<!-- Main (Home) section -->
<section class="section" id="head">
	<div class="container">

		<div class="row" id="calendar-box">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	
				<div id="calendar"></div>
			</div>
		</div>
		
		<div class="row" id="orderable-box">
			
		</div>
		
		<div class="row" id="booking-form-box">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="thumbnail">
					<div class="caption">
						<h2 class="text-center title">Konfirmasi Pemesanan</h2>
						<input type="text" id="tgl" class="form-control" placeholder="Tanggal" required readonly><br>
						<input type="hidden" id="id-gedung" class="form-control" placeholder="ID Gedung" required readonly>
						<input type="text" id="nama-gedung" class="form-control" placeholder="Nama Gedung" required readonly><br>
						<input type="hidden" id="id-waktu" class="form-control" placeholder="ID Waktu" required readonly>
						<input type="text" id="waktu" class="form-control" placeholder="Waktu" required readonly><br>
						<input type="text" id="harga" class="form-control" placeholder="Harga" required readonly><br>
						<input type="text" id="nama" class="form-control" placeholder="Nama Pemesan" required autofocus><br>
						<input type="text" id="alamat" class="form-control" placeholder="Alamat" required><br>
						<div class="btn-group btn-block"><a class="btn btn-default dropdown-toggle btn-select" data-toggle="dropdown" data-target="#" id="provinsi">Pilih Provinsi <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a>Aceh, D.I</a></li><li><a>Bali</a></li><li><a>Banten</a></li><li><a>Bengkulu</a></li><li><a>DKI Jakarta</a></li><li><a>Gorontalo</a></li><li><a>Irian Jaya Barat</a></li><li><a>Jambi</a></li><li><a>Jawa Barat</a></li><li><a>Jawa Tengah</a></li><li><a>Jawa Timur</a></li><li><a>Kalimantan Barat</a></li><li><a>Kalimantan Selatan</a></li><li><a>Kalimantan Tengah</a></li><li><a>Kalimantan Timur</a></li><li><a>Kepulauan Bangka Belitung</a></li><li><a>Kepulauan Riau</a></li><li><a>Lampung</a></li><li><a>Maluku</a></li><li><a>Maluku Utara</a></li><li><a>Nusa Tenggara Barat</a></li><li><a>Nusa Tenggara Timur</a></li><li><a>Papua</a></li><li><a>Riau</a></li><li><a>Sulawesi Barat</a></li><li><a>Sulawesi Selatan</a></li><li><a>Sulawesi Tengah</a></li><li><a>Sulawesi Tenggara</a></li><li><a>Sulawesi Utara</a></li><li><a>Sumatera Barat</a></li><li><a>Sumatera Selatan</a></li><li><a>Yogyakarta, D.I</a></li>
							</ul>
						</div><br><br>
						<input type="text" id="kota" class="form-control" placeholder="Kota" required><br>
						<input type="text" id="kodepos" class="form-control" placeholder="Kode Pos" required><br>
						<input type="text" id="telp" class="form-control" placeholder="Telepon" required><br>
						<button class="btn btn-lg btn-primary btn-block" id="btn-pesan">Pesan</button>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</section>

<!-- Second (Daftar Pesanan) section -->
<section class="section" id="pesanan">
	<div class="container">
		<div class="row" id="daftar-pesanan-box">
			<div class="col-sm-10 col-sm-offset-2">
				<h2 class="text-center title">Daftar Pemesanan</h2>
				<table class="table table-bordered" id="tabel-pesanan">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Pemesan</th>
							<th>Gedung</th>
							<th>Harga</th>
							<th>Acc</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
		
		<div class="row" id="catering-box">
			
		</div>
	</div>
</section>

<section class="section" id="logout">
	
</section>

<div class="alert alert-danger flyover flyover-top" id="alert-failed"></div>
<div class="alert alert-success flyover flyover-top" id="alert-success"></div>

<div class="modal fade" id="modal-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Konfirmasi Pembayaran</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idpesanan" id="idpesanan">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="tgltransfer" class="col-sm-3 control-label">Tanggal Transfer</label>
						<div class="col-sm-9">
							<input type="text" name="tgltransfer" id="tgltransfer" class="form-control " placeholder="Tanggal Transfer">
						</div>
					</div>
					<div class="form-group">
						<label for="banktransfer" class="col-sm-3 control-label">Dari Bank</label>
						<div class="col-sm-9">
							<input type="text" name="banktransfer" id="banktransfer" class="form-control " placeholder="Bank Transfer">
						</div>
					</div>
					<div class="form-group">
						<label for="atasnama" class="col-sm-3 control-label">Atas Nama</label>
						<div class="col-sm-9">
							<input type="text" name="atasnama" id="atasnama" class="form-control " placeholder="Atas Nama">
						</div>
					</div>
					<div class="form-group">
						<label for="jmltransfer" class="col-sm-3 control-label">Jumlah Transfer</label>
						<div class="col-sm-9">
							<input type="text" name="jmltransfer" id="jmltransfer" class="form-control " placeholder="Jumlah Transfer">
						</div>
					</div>
					<div class="form-group">
						<label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
						<div class="col-sm-9">
							<input type="text" name="keterangan" id="keterangan" class="form-control " placeholder="Keterangan">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-simpan-confirm">Simpan dan Upload Bukti Bayar</button>
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-upload-bukti">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Bukti Bayar</h4>
			</div>
			<div class="modal-body">
				<div id="dropzone" class="dropzone"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Load js libs only when the page is loaded. -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.custom.72241.js"></script>
<script src="assets/js/moment.js"></script>
<script src="assets/js/fullcalendar.min.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dropzone.min.js"></script>
<!-- Custom template scripts -->
<script src="assets/js/pelanggan.js"></script>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah">
	<meta name="author"      content="">
	
	<title>Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="assets/css/magister.css">

	<!-- Fonts -->
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='assets/css/font.css' rel='stylesheet' type='text/css'>
</head>
<body class="text-shadows">
	<h1 class="title text-center">Forbidden Access !!!</h1>
	<h2 class="subtitle text-center">Please <a href="index.html">Login</a> first...</h2>
</body>
</html>
<?php
}
?>