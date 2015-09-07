<?php
	session_start();
	if (isset($_POST['apa']) && $_POST['apa'] != "" ) {
		switch ($_POST['apa']) {
			case "cek-login":
				include "../../admin/inc/blob.php";
				
				$arr = array();
				
				if (isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "") {
					$user = $_POST['user'];
					$pass = $_POST['pass'];
					$koneksi = new koneksi();
					
					if ($result = $koneksi->runQuery("SELECT * FROM pelanggan WHERE username = '$user' AND password = '$pass'")) {
						if ($result->num_rows > 0) {
							$rs = $result->fetch_array();
							$_SESSION['majt-id'] = $rs['id'];
							$_SESSION['majt-nama'] = $rs['nama'];
							$arr['status']=TRUE;
						} else {
							$arr['status']=FALSE;
							$arr['msg']="Login gagal! Silahkan periksa kembali username dan password anda..";
						}
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi username dan password dengan lengkap..";
				}
				
				echo json_encode($arr);
				break;
			case "daftar-baru":
				include "../../admin/inc/blob.php";
				
				$arr = array();
				
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['gender']) && $_POST['gender'] != "" && 
				isset($_POST['alamat']) && $_POST['alamat'] != "" && isset($_POST['telp']) && $_POST['telp'] != "" && 
				isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "") {
					$nama = $_POST['nama'];
					$gender = $_POST['gender'];
					$alamat = $_POST['alamat'];
					$telp = $_POST['telp'];
					$email = $_POST['email'];
					$user = $_POST['user'];
					$pass = $_POST['pass'];
					$koneksi = new koneksi();
					
					$query = "INSERT INTO pelanggan(nama, gender, alamat, email, telp, username, password, status) 
								VALUES('$nama', '$gender', '$alamat', '$email', '$telp', '$user', '$pass', '1');";
					
					if ($result = $koneksi->runQuery($query)) {
						$arr['status']=TRUE;
						$arr['msg']="Pendaftaran berhasil! Silahkan login untuk melanjutkan..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Pendaftaran gagal! Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data pendaftaran dengan lengkap..";
				}
				
				echo json_encode($arr);
				break;
			case "calendar-data":
				include "../../admin/inc/blob.php";
				
				$koneksi = new koneksi();
				$events = array();
				
				//Lihat dulu jumlah gedung yang ada
				if ($result = $koneksi->runQuery("SELECT COUNT(id) FROM gedung")) {
					$rs = $result->fetch_array();
					$jumlahGedung = $rs[0];
				}
				
				$jumlahGedung = $jumlahGedung * 2;
				
				if ($result = $koneksi->runQuery("SELECT tgl, COUNT(id) FROM booking WHERE acc <> '2' GROUP BY tgl ASC")) {
					while ($rs = $result->fetch_array()) {
						$e = array();
						
						$e['start'] = $rs['tgl'];
						$e['end'] = $rs['tgl'];
						$e['allDay'] = true;
						
						if ($rs[1] == $jumlahGedung) {
							$e['title'] = "Penuh";
							$e['color'] = "red";
						} else if ($rs[1] < $jumlahGedung) {
							$e['title'] = ($jumlahGedung - $rs[1])." ruangan tersedia.";
							$e['color'] = "blue";
						}
						
						
							
						array_push($events, $e);
					}
				}
				
				echo json_encode($events);
				break;
		}
	}
?>