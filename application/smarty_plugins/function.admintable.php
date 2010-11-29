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

	// 如果数据为空，则返回空表格视图
	if(empty ($data)) {
		if (isset ($empty)) {
			$smarty->assign('_empty', $empty);
		}
		
		return $smarty->display('system/admintable_empty.tpl');
	}

	if(!empty ($conf['muti_operation'])) {
		$smarty->assign('_muti_operation', $conf['muti_operation']);
	}

	if(!empty ($conf['operation'])) {
		$smarty->assign('_operation', $conf['operation']);
	}

	// 将配置和数据给模板
	$smarty->assign('_column', $conf['column']);
	$smarty->assign('_data', $data);

	// 返回表格视图
	return $smarty->display('system/admintable.tpl');
}

?>
