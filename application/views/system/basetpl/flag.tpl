<{if $_arg.0|default}>
	<{foreach from=$_arg.0 item=_flag_item key=_flag_key}>
	<span class="table-icon js-flag icon-flag-<{$_flag_key}>" val="<{$_flag_key}>" title="<{$_flag_item}>"></span>
	<{/foreach}>
<{/if}>