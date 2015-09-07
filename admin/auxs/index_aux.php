<?php
	session_start();
	if (isset($_POST['apa']) && $_POST['apa'] != "" ) {
		switch ($_POST['apa']) {
			case "cek-login":
				include "../inc/blob.php";
				
				$arr = array();
				
				if (isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "" && isset($_POST['hak']) && $_POST['hak'] != "") {
					$user = $_POST['user'];
					$pass = $_POST['pass'];
					$hak = $_POST['hak'];
					$koneksi = new koneksi();
					
					if ($result = $koneksi->runQuery("SELECT * FROM user WHERE username = '$user' AND password = '$pass' AND privilege = '$hak'")) {
						if ($result->num_rows > 0) {
							$rs = $result->fetch_array();
							$_SESSION['majt-admin-id'] = $rs['id'];
							$_SESSION['majt-admin-nama'] = $rs['nama'];
							$_SESSION['majt-admin-id-catering'] = $rs['id_catering'];
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
		}
	}
?>