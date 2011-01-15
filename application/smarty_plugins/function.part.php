<?php

function smarty_function_part($params, &$smarty) {
	extract($params);

	eval('$p='.$param.';');
	eval('$i = new Controller_'.$type.'(new Kohana_Request(""));');
	eval('$i->action_'.$action.'($p, $tpl);');
}

?>
