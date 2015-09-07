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
			case "calendar-data":
				include "../inc/blob.php";
				
				$koneksi = new koneksi();
				$events = array();
				$idCatering = $_SESSION['majt-admin-id-catering'];
				
				if ($result = $koneksi->runQuery("SELECT tgl FROM jadwal_catering WHERE id_catering = '$idCatering'")) {
					while ($rs = $result->fetch_array()) {
						$e = array();
						
						$e['start'] = $rs['tgl'];
						$e['end'] = $rs['tgl'];
						$e['allDay'] = true;
						
						$qKet = "SELECT `booking`.`tgl`, `gedung`.`nama`, `booking`.`waktu` FROM `booking_catering` 
								INNER JOIN `booking` ON (`booking_catering`.`id_booking` = `booking`.`id`) 
								INNER JOIN `gedung` ON (`booking`.`id_gedung` = `gedung`.`id`) WHERE `booking_catering`.`id_catering` = '$idCatering';";
						
						if ($resCek = $koneksi->runQuery($qKet)) {
							if ($resCek->num_rows > 0) {
								$rsCek = $resCek->fetch_array();
								$waktu = ($rsCek["waktu"]=="1")?"Siang":"Malam";
								$e['title'] = $rsCek["nama"]." ".$waktu;
							} else {
								$e['title'] = "";
							}
						}
						
						array_push($events, $e);
					}
				}
				
				echo json_encode($events);
				break;
		}
	}
?>