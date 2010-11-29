<?php

/**
 * 生成后台管理表格
 *
 * @example <{admintable data=$data conf=$conf}>
 * @param <type> $params
 * @param <type> $smarty 
 */
function smarty_function_admintable ($params, &$smarty) {
	extract($params);

	if(empty ($data)) {
		if (isset ($empty)) {
			$smarty->assign('_empty', $empty);
		}
		
		return $smarty->display('system/admintable_empty.tpl');
	}

	$smarty->assign('_column', $conf['column']);
	$smarty->assign('_data', $data);

	return $smarty->display('system/admintable.tpl');
}

?>
