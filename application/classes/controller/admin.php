<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_AdminTemplate {

	public $template = 'admin/base/layout';

	public function action_index() {
		$this->template = '如果已经登录则跳转到默认页，否则进入登录页面';
	}

	public function action_post() {
		// 测试分页
		$pagination = new Pagination(array(
			'current_page'      => array('source' => 'query_string', 'key' => 'page'),
			'total_items'       => 1234,
			'items_per_page'    => 20,
			'view'              => 'pagination/admin',
			'auto_hide'         => TRUE,
			'first_page_in_url' => FALSE,
		));

		// 模拟后台取到的数据
		$items = array(
			array(
				'id'            => 1,
				'title'         => '测试个数据',
				'cate_id'       => 1,
				'cate_name'     => 'Kohana',         // 我要cate的名字
				'pub_time'      => '2010-11-22',     // 假设已经格式化完毕
				'user_id'       => 1,
				'user_name'     => '火德',            // 也要UserName
				'status'        => 1,
				'status_name'   => '待审核',           // 既然别的传了Name，这个也传吧 >_<
				'read_count'    => 123,
				'flag'          => array('0'),
			),
			array(
				'id'            => 2,
				'title'         => '加勒个油！',
				'cate_id'       => 2,
				'cate_name'     => '魔兽世界',        // 我要cate的名字
				'pub_time'      => '2010-11-23',     // 假设已经格式化完毕
				'user_id'       => 2,
				'user_name'     => '犀牛啊犀牛',       // 也要UserName
				'status'        => 2,
				'status_name'   => '已发布',           // 既然别的传了Name，这个也传吧 >_<
				'read_count'    => 552,
				'flag'          => array('1'),
			),
		);

		// 用来测试admin views的代码
		$this->template->title = '后台管理';

		$this->template->layout_main = View::factory('admin/post/list', array(
			'pagination' => $pagination,
			'items'      => $items,
		));
	}

}