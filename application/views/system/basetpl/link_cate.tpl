<{* 链接类型模板 *}>
<{if $_arg.0 == -1}>
无
<{else}>
<a href="<{$BASE_URL|default}><{$_prefix.0|default}><{$_arg.0|default}><{$_prefix.1|default}>" title="<{$_arg.1|default}>"><{$_arg.1|default}></a>
<{/if}>