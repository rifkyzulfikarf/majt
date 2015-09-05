<?php
session_start();
$ds          = DIRECTORY_SEPARATOR;
 
if (!empty($_FILES)) {
	
	include "../../admin/inc/blob.php";
	
	$id = $_POST['id'];
     
    $tempFile = $_FILES['file']['tmp_name'];
      
    $targetPath = "../images/bukti-bayar/";
     
	$temp = explode(".",$_FILES["file"]["name"]);
	
	$newFileName = rand(1,99999999) . '.' .end($temp);
	
	$targetFile =  $targetPath. $newFileName;
	
	$koneksi = new koneksi();
	
	if ($simpan = $koneksi->runQuery("UPDATE konfirmasi SET img = '$newFileName' WHERE id_booking = '$id'")) {
		move_uploaded_file($tempFile,$targetFile);
    }
}
?>