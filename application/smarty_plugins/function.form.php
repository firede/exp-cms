<?php

function smarty_function_form($params, &$smarty) {
	extract($params);

	if (isset ($data)) {
		$smarty->assign('_form', $data);
		$smarty->display('system/form.tpl');
	}
}

?>
