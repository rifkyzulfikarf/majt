<?php
session_start();
$ds          = DIRECTORY_SEPARATOR;
 
if (!empty($_FILES)) {
	
	include "../inc/blob.php";
	
	$id = $_POST['id'];
     
    $tempFile = $_FILES['file']['tmp_name'];
      
    $targetPath = "../../assets/images/gedung/";
     
	$temp = explode(".",$_FILES["file"]["name"]);
	
	$newFileName = rand(1,99999999) . '.' .end($temp);
	
	$targetFile =  $targetPath. $newFileName;
	
	$koneksi = new koneksi();
	
	if ($simpan = $koneksi->runQuery("UPDATE gedung SET img = '$newFileName' WHERE id = '$id'")) {
		move_uploaded_file($tempFile,$targetFile);
    }
}
?>