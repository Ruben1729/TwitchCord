<?php
	
	class Profile extends Controller{
		
		public function Index(){

			$this->view('Profile/index');

		}

		public function Settings(){

			$this->view('Profile/settings');

		}

		public function Create(){

			$this->view('Profile/create');

		}

		public function POST_Create(){

		    //Stores the filename as it was on the client computer.
		    print_r($_FILES);
		    $imagename = $_FILES['fileElem']['name'];
		    //Stores the filetype e.g image/jpeg
		    $imagetype = $_FILES['fileElem']['type'];
		    //Stores any error codes from the upload.
		    $imageerror = $_FILES['fileElem']['error'];
		    //Stores the tempname as it is given by the host when uploaded.
		    $imagetemp = $_FILES['fileElem']['tmp_name'];

		    //The path you wish to upload the image to
		    $imagePath = dirname(__FILE__);

		    if(is_uploaded_file($imagetemp)) {
		        if(move_uploaded_file($imagetemp, $imagePath . $imagename)) {
		            echo "Sussecfully uploaded your image.";
		        }
		        else {
		            echo "Failed to move your image.";
		        }
		    }
		    else {
		        echo "Failed to upload your image.";
		    }

			$this->view('Profile/create');

		}

	}