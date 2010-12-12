<tr>
<th><{$_formel.label|default}></th>
<td>
	<textarea cols="40" rows="4" name="<{$_formel.name}>"><{$_formel.value|default}></textarea>
	<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
	<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
</td>
</tr>