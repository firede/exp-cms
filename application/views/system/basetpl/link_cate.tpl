<{* 链接类型模板 *}>
<{if $_arg.0 == -1}>
无
<{else}>
<a href="<{$BASE_URL|default}><{if $_prefix}><{$_prefix.0|default}><{/if}><{$_arg.0|default}><{if $_prefix}><{$_prefix.1|default}><{/if}>" title="<{$_arg.1|default}>"><{$_arg.1|default}></a>
<{/if}>