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

	// 将配置拆成数组
	$conf_arr = explode(',', $conf);

	// 组合配置与数据，拼接模板变量
	foreach ($conf_arr as $key => $value) {
		// 根据顺序，变量名为 "_arg_0", "_arg_1", etc.
		$smarty->assign('_arg_'.$key, $data[$value]);
	}

	// 判断是否有常量配置
	if (isset($prefix)) {
		if (is_string($prefix)) {
			// 常量为字符串，则输出模板变量"_prefix"
			$smarty->assign('_prefix', $prefix);
		} elseif (is_array($prefix)) {
			// 有多个常量（为数组时），输出 "_prefix_0", "_prefix_1", etc.
			foreach ($prefix as $key => $value) {
				$smarty->assign('_prefix_'.$key, $value);
			}
		}
	}

	// 根据$tpl变量找到对应的底层模板并返回
	return $smarty->display('system/snippet/'.$tpl.'.tpl');
}

?>