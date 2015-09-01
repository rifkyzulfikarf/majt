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
				<li><a href="#head" class="active">Home</a></li>
				<li><a href="#pesanan">Daftar Pesanan</a></li>
				<li><a href="#logout" id="logout">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>


<!-- Main (Home) section -->
<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">	
				<div id="calendar"></div>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>

<!-- Second (Daftar Pesanan) section -->
<section class="section" id="pesanan">
	
</section>

<section class="section" id="logout">
	
</section>

<div class="alert alert-danger flyover flyover-top" id="alert-failed"></div>
<div class="alert alert-success flyover flyover-top" id="alert-success"></div>

<!-- Load js libs only when the page is loaded. -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.custom.72241.js"></script>
<script src="assets/js/moment.js"></script>
<script src="assets/js/fullcalendar.min.js"></script>
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