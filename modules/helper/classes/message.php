<?php defined('SYSPATH') or die('No direct script access.');

class Message {
	public static function admin_render($view_data) {
		if ($view_data['success'] === FALSE) {
			echo '<div class="message-error radius_all">'
					.$view_data['message']
					.' <a href="javascript:window.history.go(-1);">返回上一页</a>'
				.'</div>';
			exit;
		} elseif ($view_data['success'] === TRUE) {
			echo ($view_data['success'] === '')
				? ''
				: '<div class="message-success radius_all">'.$view_data['message'].'</div>';
		}
	}
}

?>
