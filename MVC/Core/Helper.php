<?php

	function getToken($code){
		$prefix = "\"access_token\":\"";
		$suffix = "\",\"expires_in\"";

		$client_id = "bo0nrcahpqfeh6i73cthasv3ysbz1r";
		$client_secret = "8bm969bpoi4c5lnma2o6ixu8hj9gmw";
		$redirect_uri = "http://localhost/Channel/Link";
		$url = "https://id.twitch.tv/oauth2/token";
		$data = http_build_query(array( 'client_id' => $client_id, 'client_secret'=> $client_secret, 'code' => $code, 'grant_type' => 'authorization_code', 'redirect_uri' => $redirect_uri ));

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded",
		        'method'  => 'POST',
		        'content' => $data,
		    ),
		);

		$context = stream_context_create( $options );

		$result = file_get_contents( $url, false, $context );

		$beginIndex = strpos($result, $prefix)+ strlen($prefix);
		$endIndex = strpos($result, $suffix) - $beginIndex;
		$token = substr($result, $beginIndex, $endIndex);
		//$token = $result['acces_token'];
		//echo "$token";

		return getDisplayname($token, $client_id);
	}

	function getDisplayname($token, $client_id){
		$prefix = "display_name\":\"";
		$suffix = "\",\"type";

		$url = "https://api.twitch.tv/helix/users";

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
							 "client-id: $client_id\r\n" .
							 "authorization: Bearer $token\r\n",
		        'method'  => 'GET',
		    ),
		);

		$context = stream_context_create( $options );
		$result = file_get_contents($url, false, $context);

		$beginIndex = strpos($result, $prefix)+ strlen($prefix);
		$endIndex = strpos($result, $suffix) - $beginIndex;

		$displayname = (substr($result, $beginIndex, $endIndex));

		return $displayname;
	}

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