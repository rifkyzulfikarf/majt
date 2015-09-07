<?php
session_start();
if (isset($_SESSION['majt-admin-id'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah">
	<meta name="author"      content="">
	
	<title>Admin Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah</title>

	<link rel="shortcut icon" href="../assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<!-- Full Calendar styles -->
	<link rel="stylesheet" href="../assets/css/fullcalendar.min.css">
	
	<!-- Datatables styles -->
	<link rel="stylesheet" href="../assets/css/jquery.dataTables.css">
	<link rel="stylesheet" href="../assets/css/dataTables.bootstrap.css">
	
	<!-- jQuery UI styles -->
	<link rel="stylesheet" href="../assets/css/jquery-ui.min.css">
	
	<!-- Dropzone JS styles -->
	<link rel="stylesheet" href="../assets/css/dropzone.min.css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="../assets/css/magister.css">

	<!-- Fonts -->
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='../assets/css/font.css' rel='stylesheet' type='text/css'>
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
				<li><a href="#gedung" id="menu-gedung">Gedung</a></li>
				<li><a href="#catering" id="menu-catering">Catering</a></li>
				<li><a href="#pelanggan" id="menu-pelanggan">Pelanggan</a></li>
				<li><a href="#logout" id="logout">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>


<!-- Main (Home) section -->
<section class="section" id="head">
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
							<th>Konfirm</th>
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
	</div>
</section>

<!-- Second (Gedung) section -->
<section class="section" id="gedung">
	<div class="container">
		<div class="row" id="daftar-gedung-box">
			<div class="col-sm-10 col-sm-offset-2">
				<h2 class="text-center title">Daftar Gedung</h2>
				<div><button type="button" class="btn btn-default pull-right btn-show-gedung" data-mode="tambah">Tambah Data</button></div><br><br>
				<table class="table table-bordered" id="tabel-gedung">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Kapasitas</th>
							<th>DP</th>
							<th>Image</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- Third (Catering) section -->
<section class="section" id="catering">
	<div class="container">
		<div class="row" id="daftar-catering-box">
			<div class="col-sm-10 col-sm-offset-2">
				<h2 class="text-center title">Daftar Catering</h2>
				<div><button type="button" class="btn btn-default pull-right btn-show-catering" data-mode="tambah">Tambah Data</button></div><br><br>
				<table class="table table-bordered" id="tabel-catering">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Telp</th>
							<th>DP</th>
							<th>Img</th>
							<th>Brosur</th>
							<th>Link</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- Fourth (Pelanggan) section -->
<section class="section" id="pelanggan">
	<div class="container">
		<div class="row" id="daftar-pelanggan-box">
			<div class="col-sm-10 col-sm-offset-2">
				<h2 class="text-center title">Daftar Pelanggan</h2>
				<table class="table table-bordered" id="tabel-pelanggan">
					<thead>
						<tr>
							<th>Nama</th>
							<th>JK</th>
							<th>Alamat</th>
							<th>Email</th>
							<th>Telp</th>
							<th>Username</th>
							<th>Password</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
</section>

<section class="section" id="logout">
	
</section>

<div class="alert alert-danger flyover flyover-top" id="alert-failed"></div>
<div class="alert alert-success flyover flyover-top" id="alert-success"></div>

<div class="modal fade" id="modal-show-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Konfirmasi Pembayaran</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="tgltransfer" class="col-sm-3 control-label">Tanggal Transfer</label>
						<div class="col-sm-9">
							<input type="text" name="tgltransfer" id="tgltransfer" class="form-control " placeholder="Tanggal Transfer" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="banktransfer" class="col-sm-3 control-label">Dari Bank</label>
						<div class="col-sm-9">
							<input type="text" name="banktransfer" id="banktransfer" class="form-control " placeholder="Bank Transfer" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="atasnama" class="col-sm-3 control-label">Atas Nama</label>
						<div class="col-sm-9">
							<input type="text" name="atasnama" id="atasnama" class="form-control " placeholder="Atas Nama" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="jmltransfer" class="col-sm-3 control-label">Jumlah Transfer</label>
						<div class="col-sm-9">
							<input type="text" name="jmltransfer" id="jmltransfer" class="form-control " placeholder="Jumlah Transfer" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
						<div class="col-sm-9">
							<input type="text" name="keterangan" id="keterangan" class="form-control " placeholder="Keterangan" readonly>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-data-gedung">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Data Gedung</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" id="id-gedung" class="form-control">
				<input type="hidden" name="mode" id="mode-gedung" class="form-control">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="namagedung" class="col-sm-3 control-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" name="namagedung" id="nama-gedung" class="form-control " placeholder="Nama Gedung">
						</div>
					</div>
					<div class="form-group">
						<label for="kapasitas" class="col-sm-3 control-label">Kapasitas</label>
						<div class="col-sm-9">
							<input type="text" name="kapasitas" id="kapasitas" class="form-control " placeholder="Kapasitas">
						</div>
					</div>
					<div class="form-group">
						<label for="dpgedung" class="col-sm-3 control-label">DP</label>
						<div class="col-sm-9">
							<input type="text" name="dpgedung" id="dp-gedung" class="form-control " placeholder="DP">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-simpan-gedung">Simpan</button>
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-upload-gedung">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Gambar Gedung</h4>
			</div>
			<div class="modal-body">
				<div id="dropzone-gedung" class="dropzone"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-data-catering">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Data Catering</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" id="id-catering" class="form-control">
				<input type="hidden" name="mode" id="mode-catering" class="form-control">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="nama-catering" class="col-sm-3 control-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" name="namacatering" id="nama-catering" class="form-control " placeholder="Nama Catering">
						</div>
					</div>
					<div class="form-group">
						<label for="alamat-catering" class="col-sm-3 control-label">Alamat</label>
						<div class="col-sm-9">
							<input type="text" name="alamat-catering" id="alamat-catering" class="form-control " placeholder="Alamat">
						</div>
					</div>
					<div class="form-group">
						<label for="telp-catering" class="col-sm-3 control-label">Telp</label>
						<div class="col-sm-9">
							<input type="text" name="telp-catering" id="telp-catering" class="form-control " placeholder="Telp">
						</div>
					</div>
					<div class="form-group">
						<label for="dp-catering" class="col-sm-3 control-label">DP</label>
						<div class="col-sm-9">
							<input type="text" name="dp-catering" id="dp-catering" class="form-control " placeholder="Telp">
						</div>
					</div>
					<div class="form-group">
						<label for="link-catering" class="col-sm-3 control-label">Link</label>
						<div class="col-sm-9">
							<input type="text" name="link-catering" id="link-catering" class="form-control " placeholder="Telp">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-simpan-catering">Simpan</button>
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-upload-catering">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Upload Gambar Catering</h4>
			</div>
			<div class="modal-body">
				<div id="dropzone-catering" class="dropzone"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-data-pelanggan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Data Pelanggan</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" id="id-pelanggan" class="form-control">
				<input type="hidden" name="mode" id="mode-pelanggan" class="form-control">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="nama-pelanggan" class="col-sm-3 control-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" name="namapelanggan" id="nama-pelanggan" class="form-control " placeholder="Nama Pelanggan">
						</div>
					</div>
					<div class="form-group">
						<label for="gender-pelanggan" class="col-sm-3 control-label">JK</label>
						<div class="col-sm-9">
							<input type="text" name="genderpelanggan" id="gender-pelanggan" class="form-control " placeholder="L / P">
						</div>
					</div>
					<div class="form-group">
						<label for="alamat-pelanggan" class="col-sm-3 control-label">Alamat</label>
						<div class="col-sm-9">
							<input type="text" name="alamat-pelanggan" id="alamat-pelanggan" class="form-control " placeholder="Alamat">
						</div>
					</div>
					<div class="form-group">
						<label for="email-pelanggan" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="text" name="email-pelanggan" id="email-pelanggan" class="form-control " placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="telp-pelanggan" class="col-sm-3 control-label">Telp</label>
						<div class="col-sm-9">
							<input type="text" name="telp-pelanggan" id="telp-pelanggan" class="form-control " placeholder="Telp">
						</div>
					</div>
					<div class="form-group">
						<label for="user-pelanggan" class="col-sm-3 control-label">Username</label>
						<div class="col-sm-9">
							<input type="text" name="user-pelanggan" id="user-pelanggan" class="form-control " placeholder="Username">
						</div>
					</div>
					<div class="form-group">
						<label for="pass-pelanggan" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
							<input type="text" name="pass-pelanggan" id="pass-pelanggan" class="form-control " placeholder="Password">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="btn-simpan-pelanggan">Simpan</button>
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Load js libs only when the page is loaded. -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery-ui.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/modernizr.custom.72241.js"></script>
<script src="../assets/js/moment.js"></script>
<script src="../assets/js/fullcalendar.min.js"></script>
<script src="../assets/js/dataTables.bootstrap.js"></script>
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dropzone.min.js"></script>
<!-- Custom template scripts -->
<script src="js/admin.js"></script>
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
	
	<title>Admin Sistem Informasi Peminjaman Fasilitas Gedung Masjid Agung Jawa Tengah</title>

	<link rel="shortcut icon" href="../assets/images/gt_favicon.png">
	
	<!-- Bootstrap itself -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="../assets/css/magister.css">

	<!-- Fonts -->
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='../assets/css/font.css' rel='stylesheet' type='text/css'>
</head>
<body class="text-shadows">
	<h1 class="title text-center">Forbidden Access !!!</h1>
	<h2 class="subtitle text-center">Please <a href="index.html">Login</a> first...</h2>
</body>
</html>
<?php
}
?>