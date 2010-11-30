<?php

/**
 * 通过底层模板、配置、变量数组自动生成代码
 *
 * @example <{basetpl data=$data conf=$conf prefix=$prefix tpl="link"}>
 *          data   <Array>
 *          conf   <Array>
 *          prefix <String|Array>
 *          tpl    <String>
 * @param <type> $params
 * @param <type> $smarty
 */
function smarty_function_basetpl($params, &$smarty) {
	extract($params);

	// 初始化_prefix, _arg
	$_prefix = array();
	$_arg = array();

	// 初始化Smarty变量
	$smarty->assign('_prefix', NULL);
	$smarty->assign('_arg', NULL);

	// 将配置拆成数组
	$conf_arr = explode(',', $conf);

	if (!empty($conf_arr)) {
		// 组合配置与数据，拼接模板变量
		foreach ($conf_arr as $key => $value) {
			$_arg[$key] = $data[$value];
		}
	}
	
	if (isset($prefix)) {
		$_prefix = $prefix;
	}

	// 设置Smarty变量
	$smarty->assign('_prefix', $_prefix);
	$smarty->assign('_arg', $_arg);

	// 根据$tpl变量找到对应的底层模板并返回
	return $smarty->display('system/snippet/'.$tpl.'.tpl');
}

?>