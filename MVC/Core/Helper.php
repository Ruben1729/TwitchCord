<?php

	function uploadImg($file){

		$currentDir = getcwd();
    	$uploadDirectory = "\Pictures\\";

		$errors = []; // Store all foreseen and unforseen errors here
	    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

	    $fileName = $file['userImg']['name'];
	    $fileSize = $file['userImg']['size'];
	    $fileTmpName  = $file['userImg']['tmp_name'];
	    $fileType = $file['userImg']['type'];

	    $fileExtension = strtolower(end(explode('.',$fileName)));

	    $uploadPath = $currentDir . $uploadDirectory . uniqid() . '.' . $fileExtension;

	    if(empty($fileName)){
	    	return;
	    }

        if (! in_array($fileExtension,$fileExtensions)) {
            return "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 2000000) {
            return "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if (!$didUpload) {
                return "Unknown Error occurred. Please contact an admin.";
            }

        }

	}