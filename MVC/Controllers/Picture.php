<?php
	class Picture extends Controller{
		public function Gallery(){
			$data['pics'] = $this->model('picturemodel')->getAllPictures($_SESSION['uid']);

			$this->view('Picture/Gallery', $data);
		}

		public function POST_Gallery(){
			$this->view('Picture/Gallery');
		}
	}