<tr>
<th><{$_formel.label|default}></th>
<td>
	<{if $_formel.readonly|default}>
		<span><{$_formel.value|default|escape:'html'}></span>
		<input type="hidden" value="<{$_formel.value|default}>" name="<{$_formel.name|default}>">
	<{else}>
		<textarea cols="46" rows="4" name="<{$_formel.name}>"><{$_formel.value|default}></textarea>
	<{/if}>
	<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
	<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
</td>
</tr>