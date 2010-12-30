<{if $_formel.readonly|default}>
<{else}>
<tr>
<th><{$_formel.label|default}></th>
<td>
	<input type="password" class="input-text" value="<{$_formel.value|default}>" name="<{$_formel.name|default}>">
	<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
	<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
</td>
</tr>
<{/if}>