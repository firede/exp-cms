<tr>
<th><{$_formel.label|default}></th>
<td>
	<input type="file" class="input-text" value="<{$_formel.value|default}>" name="<{$_formel.name|default}>">
	<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
	<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
	<{if $_formel.value|default}><img src="<{$_formel.value}>" alt="<{$_formel.label}>" /><{/if}>
</td>
</tr>