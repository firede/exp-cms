<{foreach from=$_arg.0 item=_flag_item key=_flag_key}>
<span class="flag-icon-<{$_flag_key}>"><{$_flag_item}></span>
<{foreachelse}>
无
<{/foreach}>
