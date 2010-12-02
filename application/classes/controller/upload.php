<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller_BaseUser {

        public function action_toupload() {
        $this->template = View::factory('smarty:upload/uptest', array(
                ));
        }

        public function action_up_img()
	{
            echo Kohana::debug($_FILES);
            Upload::save($_FILES["file"], $_FILES["file"]["name"], "C://", "777");
            
	}
        
        public function action_up_file()
	{

	}

} // End Welcome
