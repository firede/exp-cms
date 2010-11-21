<?php  defined('SYSPATH') or die('No direct script access.');
	class Controller_TestDb extends Controller  {
		public function action_index(){
			$dao = Database::instance();//ʵ����ݿ���ʶ���
		//	$query = DB::query(Database::SELECT, 'SELECT * FROM user WHERE username = :user');
$query = DB::select()->from('user')->where('username', '=', 'admin1');
		//	$query->param(':user','admin');
			echo Kohana::debug((string) $query);
			$userobj=$query->execute();
			//echo Kohana::debug($userobj);
                        $userobj->as_array();
                        echo Kohana::debug($userobj->as_array());
			/*foreach($userobj as $row ) {
                          echo Kohana::debug( $row);
				//echo $row->get('username');
			}*/

		}
	}

?>