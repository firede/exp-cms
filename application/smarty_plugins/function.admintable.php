<?php

/**
 * 生成后台管理表格
 *
 * @example <{admintable data=$data conf=$conf empty=$empty}>
 *          data   <Array>
 *          conf   <Array>
 *          empty  <String>
 * @param <type> $params
 * @param <type> $smarty 
 */
function smarty_function_admintable ($params, &$smarty) {
	extract($params);

	// 初始化Smarty变量
	$smarty->assign('_admintable_empty', NULL);
	$smarty->assign('_admintable_conf', NULL);
	$smarty->assign('_admintable_data', NULL);


	// 如果数据为空，则返回空表格视图
	if(empty ($data)) {
		if (isset ($empty)) {
			$smarty->assign('_admintable_empty', $empty);
		}
		
		return $smarty->display('system/admintable_empty.tpl');
	} else {
		$smarty->assign('_admintable_conf', $conf);
		$smarty->assign('_admintable_data', $data);

		// 返回表格视图
		return $smarty->display('system/admintable.tpl');
	}
}

?>
