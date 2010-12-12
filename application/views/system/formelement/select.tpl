<tr>
<th><{$_formel.label|default}></th>
<td>
	<select name="<{$_formel.name|default}>">
		<{foreach from=$_formel.value item=_formel_item key=_formel_key}>
		<option value="<{$_formel_key}>"><{$_formel_item}></option>
		<{/foreach}>
	</select>
	<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
	<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
</td>
</tr>