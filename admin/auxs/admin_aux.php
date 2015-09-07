<?php
	session_start();
	if (isset($_POST['apa']) && $_POST['apa'] != "" ) {
		switch ($_POST['apa']) {
			case "logout":
				$arr = array();
				
				session_destroy();
				
				$arr['status']=TRUE;
				
				echo json_encode($arr);
				break;
			case "daftar-pesanan":
				include "../inc/blob.php";
				
				$koneksi = new koneksi();
				$collect = array();
				
				$query = "SELECT `booking`.`id`, `booking`.`tgl`, `booking`.`id_pelanggan`, `booking`.`id_gedung`, `booking`.`nama_pemesan`, 
						`booking`.`alamat`, `booking`.`provinsi`, `booking`.`kota`, `booking`.`kodepos`, `booking`.`telp`, `booking`.`waktu`, 
						`booking`.`harga`, `booking`.`konfirmasi`, `booking`.`acc`, `gedung`.`nama` FROM `booking` INNER JOIN `gedung` 
						ON (`booking`.`id_gedung` = `gedung`.`id`);";
				
				if ($result = $koneksi->runQuery($query)) {
					while ($rs = $result->fetch_array()) {
						
						if ($rs["konfirmasi"] == "0") {
							$konfirmasi = "Belum";
							$aksi = "";
						} else {
							$konfirmasi = "Sudah";
							$aksi = "<a class='btn btn-default btn-sm btn-cek-confirm' role='button' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></a> 
									<a class='btn btn-default btn-sm btn-cek-bukti' role='button' data-id='".$rs["id"]."'><i class='fa fa-credit-card'></i></a> ";
						}
						
						if ($rs["acc"] == "0") {
							$acc = "Belum";
						} elseif ($rs["acc"] == "1") {
							$acc = "Ya";
						} else {
							$acc = "Tidak";
						}
						
						if ($rs["konfirmasi"] == "1" && $rs["acc"] == "0") {
							$aksi .= "<a class='btn btn-default btn-sm btn-acc' role='button' data-id='".$rs["id"]."'><i class='fa fa-check-square-o'></i></a> 
									<a class='btn btn-default btn-sm btn-tolak' role='button' data-id='".$rs["id"]."'><i class='fa fa-minus-square'></i></a>";
						}
					
						$detail = array();
						array_push($detail, $rs["tgl"]);
						array_push($detail, $rs["nama_pemesan"]);
						array_push($detail, ($rs["waktu"]=="1")?$rs["nama"]." "."Siang":$rs["nama"]." "."Malam");
						array_push($detail, $konfirmasi);
						array_push($detail, $acc);
						array_push($detail, $aksi);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
				break;
			case "daftar-gedung":
				include "../inc/blob.php";
				
				$koneksi = new koneksi();
				$collect = array();
				
				$query = "SELECT * FROM gedung;";
				
				if ($result = $koneksi->runQuery($query)) {
					while ($rs = $result->fetch_array()) {
						$aksi = "<a class='btn btn-default btn-sm btn-show-gedung' role='button' data-id='".$rs["id"]."' data-mode='ubah'><i class='fa fa-pencil'></i></a> 
								<a class='btn btn-default btn-sm btn-upload-gedung' role='button' data-id='".$rs["id"]."'><i class='fa fa-upload'></i></a>";
					
						$detail = array();
						array_push($detail, $rs["nama"]);
						array_push($detail, $rs["kapasitas"]);
						array_push($detail, $rs["dp"]);
						array_push($detail, $rs["img"]);
						array_push($detail, $aksi);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
				break;
			case "daftar-catering":
				include "../inc/blob.php";
				
				$koneksi = new koneksi();
				$collect = array();
				
				$query = "SELECT * FROM catering;";
				
				if ($result = $koneksi->runQuery($query)) {
					while ($rs = $result->fetch_array()) {
						$aksi = "<a class='btn btn-default btn-sm btn-show-catering' role='button' data-id='".$rs["id"]."' data-mode='ubah'><i class='fa fa-pencil'></i></a> 
								<a class='btn btn-default btn-sm btn-upload-catering' role='button' data-id='".$rs["id"]."'><i class='fa fa-upload'></i></a>";
					
						$detail = array();
						array_push($detail, $rs["nama"]);
						array_push($detail, $rs["alamat"]);
						array_push($detail, $rs["telepon"]);
						array_push($detail, $rs["dp"]);
						array_push($detail, $rs["img"]);
						array_push($detail, $rs["brosur"]);
						array_push($detail, $rs["link"]);
						array_push($detail, $aksi);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
				break;
			case "daftar-pelanggan":
				include "../inc/blob.php";
				
				$koneksi = new koneksi();
				$collect = array();
				
				$query = "SELECT * FROM pelanggan;";
				
				if ($result = $koneksi->runQuery($query)) {
					while ($rs = $result->fetch_array()) {
						$aksi = "<a class='btn btn-default btn-sm btn-show-pelanggan' role='button' data-id='".$rs["id"]."' data-mode='ubah'><i class='fa fa-pencil'></i></a>";
					
						$detail = array();
						array_push($detail, $rs["nama"]);
						array_push($detail, $rs["gender"]);
						array_push($detail, $rs["alamat"]);
						array_push($detail, $rs["email"]);
						array_push($detail, $rs["telp"]);
						array_push($detail, $rs["username"]);
						array_push($detail, $rs["password"]);
						array_push($detail, $aksi);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
				break;
			case "cek-confirm":
				$arr = array();
				if (isset($_POST['id']) && $_POST['id'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					
					$qCek = "SELECT * FROM konfirmasi WHERE id_booking = '$id'";
					
					if ($resCek = $koneksi->runQuery($qCek)) {
						$rsCek = $resCek->fetch_array();
						
						$arr['status']=TRUE;
						$arr['tgl']=$rsCek["tgl"];
						$arr['bank']=$rsCek["bank"];
						$arr['nama']=$rsCek["nama"];
						$arr['jml']=$rsCek["jumlah"];
						$arr['ket']=$rsCek["keterangan"];
						
					}
				}
				echo json_encode($arr);
				break;
			case "cek-bukti":
				$arr = array();
				if (isset($_POST['id']) && $_POST['id'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					
					$qCek = "SELECT img FROM konfirmasi WHERE id_booking = '$id'";
					
					if ($resCek = $koneksi->runQuery($qCek)) {
						$rsCek = $resCek->fetch_array();
						
						$arr['status']=TRUE;
						$arr['img']=$rsCek["img"];
						
					}
				}
				echo json_encode($arr);
				break;
			case "acc-pesanan":
				$arr = array();
				if (isset($_POST['id']) && $_POST['id'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					
					$query = "UPDATE booking SET acc = '1' WHERE id = '$id'";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Acc pesanan berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Acc pesanan gagal.. Kesalahan pada sistem..";
					}
				}
				echo json_encode($arr);
				break;
			case "tolak-pesanan":
				$arr = array();
				if (isset($_POST['id']) && $_POST['id'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					
					$query = "UPDATE booking SET acc = '2' WHERE id = '$id'";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Tolak pesanan berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Tolak pesanan gagal.. Kesalahan pada sistem..";
					}
				}
				echo json_encode($arr);
				break;
			case "simpan-gedung":
				$arr = array();
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['kapasitas']) && $_POST['kapasitas'] != "" && 
				isset($_POST['dp']) && $_POST['dp'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$nama = $_POST['nama'];
					$kapasitas = $_POST['kapasitas'];
					$dp = $_POST['dp'];
					
					$query = "INSERT INTO gedung(nama, kapasitas, dp, img) VALUES('$nama', '$kapasitas', '$dp', '-')";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Simpan data berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan data gagal.. Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data dengan lengkap..";
				}
				echo json_encode($arr);
				break;
			case "ubah-gedung":
				$arr = array();
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['kapasitas']) && $_POST['kapasitas'] != "" && 
				isset($_POST['dp']) && $_POST['dp'] != "" && isset($_POST['id']) && $_POST['id'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					$nama = $_POST['nama'];
					$kapasitas = $_POST['kapasitas'];
					$dp = $_POST['dp'];
					
					$query = "UPDATE gedung SET nama = '$nama', kapasitas = '$kapasitas', dp = '$dp' WHERE id = '$id'";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Simpan data berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan data gagal.. Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data dengan lengkap..";
				}
				echo json_encode($arr);
				break;
			case "simpan-catering":
				$arr = array();
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['alamat']) && $_POST['alamat'] != "" && 
				isset($_POST['telp']) && $_POST['telp'] != "" && isset($_POST['dp']) && $_POST['dp'] != "" && isset($_POST['link']) && $_POST['link'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$nama = $_POST['nama'];
					$alamat = $_POST['alamat'];
					$telepon = $_POST['telp'];
					$dp = $_POST['dp'];
					$link = $_POST['link'];
					
					$query = "INSERT INTO catering(nama, alamat, telepon, dp, img, brosur, link) VALUES('$nama', '$alamat', '$telepon', '$dp', '-', '-', '$link')";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Simpan data berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan data gagal.. Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data dengan lengkap..";
				}
				echo json_encode($arr);
				break;
			case "ubah-catering":
				$arr = array();
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['alamat']) && $_POST['alamat'] != "" && 
				isset($_POST['dp']) && $_POST['dp'] != "" && isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['telp']) && $_POST['telp'] != "" && 
				isset($_POST['link']) && $_POST['link'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					$nama = $_POST['nama'];
					$alamat = $_POST['alamat'];
					$telepon = $_POST['telp'];
					$dp = $_POST['dp'];
					$link = $_POST['link'];
					
					$query = "UPDATE catering SET nama = '$nama', alamat = '$alamat', telepon = '$telepon', dp = '$dp', link = '$link' WHERE id = '$id'";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Simpan data berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan data gagal.. Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data dengan lengkap..";
				}
				echo json_encode($arr);
				break;
			case "ubah-pelanggan":
				$arr = array();
				if (isset($_POST['nama']) && $_POST['nama'] != "" && isset($_POST['gender']) && $_POST['gender'] != "" && 
				isset($_POST['alamat']) && $_POST['alamat'] != "" && isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['telp']) && $_POST['telp'] != "" && 
				isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "") {
					include "../inc/blob.php";
					
					$koneksi = new koneksi();
					$id = $_POST['id'];
					$nama = $_POST['nama'];
					$gender = $_POST['gender'];
					$alamat = $_POST['alamat'];
					$email = $_POST['email'];
					$telp = $_POST['telp'];
					$user = $_POST['user'];
					$pass = $_POST['pass'];
					
					$query = "UPDATE pelanggan SET nama = '$nama', gender = '$gender', alamat = '$alamat', email = '$email', telp = '$telp', username = '$user', password = '$pass' WHERE id = '$id'";
					
					if ($result = $koneksi->runQuery($query)) {						
						$arr['status']=TRUE;
						$arr['msg']="Simpan data berhasil..";
					} else {
						$arr['status']=FALSE;
						$arr['msg']="Simpan data gagal.. Kesalahan pada sistem..";
					}
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Harap isi data dengan lengkap..";
				}
				echo json_encode($arr);
				break;
		}
	}
?>