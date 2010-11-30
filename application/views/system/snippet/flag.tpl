<{foreach from=$_arg.0 item=_item key=_key}>
<span class="flag-icon-<{$_key}>"><{$_item}></span>
<{foreachelse}>
无
<{/foreach}>
