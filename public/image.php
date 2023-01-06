<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
/*
 * Additional header for app
 */
header('Content-Type:application/json');

if(!empty($_FILES)){ 
    // File path configuration 
    $uploadDir = "items/"; 
    $fileName = time().'_'.basename($_FILES['file']['name']); 
    $uploadFilePath = $uploadDir.$fileName; 
     
    // Upload file to server 
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)){ 
        // Insert file information in the database 
        //$insert = $db->query("INSERT INTO files (file_name, uploaded_on) VALUES ('".$fileName."', NOW())"); 
    $base_url = "http://demo91.co.in/dev/fdx/public/items/";
    $file_link = $base_url.$fileName;
	die(json_encode(array("status"=>"1","file_link"=>$file_link)));
    } 
} 
?>