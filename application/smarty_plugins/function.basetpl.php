<?php

/**
 * 通过底层模板、配置、变量数组自动生成代码
 *
 * @param <type> $params
 * @param <type> $smarty
 */
function smarty_function_basetpl($params, &$smarty) {
	extract($params);

	$conf_arr = explode(',', $conf);
	
	foreach ($conf_arr as $key => $value) {
		$smarty->assign('_arg_'.$key, $data[$value]);
	}

	if (isset($prefix)) {
		if (is_string($prefix)) {
			$smarty->assign('_prefix', $prefix);
		} elseif (is_array($prefix)) {
			foreach ($prefix as $key => $value) {
				$smarty->assign('_prefix_'.$key, $value);
			}
		}
	}
	
	$smarty->display($tpl);
}

?>