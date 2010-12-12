<?php

function smarty_function_formelement($params, &$smarty) {
	extract($params);

	if(isset ($data)) {
		$smarty->assign('_formel', $data);
		$smarty->display('system/formelement/'.$data['type'].'.tpl');
	}
}

?>
