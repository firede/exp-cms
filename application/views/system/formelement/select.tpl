<tr>
<th><{$_formel.label|default}></th>
<td>
	<{if $_formel.readonly|default}>
		<{foreach from=$_formel.value.data item=_formel_item key=_formel_key}>
			<{if $_formel_key == $_formel.value.select}>
				<span><{$_formel_item|escape:'html'}></span>
			<{/if}>
		<{/foreach}>
	<{else}>
		<select name="<{$_formel.name|default}>">
			<{foreach from=$_formel.value.data item=_formel_item key=_formel_key}>
			<option value="<{$_formel_key}>"<{if $_formel_key == $_formel.value.select}> selected="selected"<{/if}>><{$_formel_item}></option>
			<{/foreach}>
		</select>
		<{if $_formel.desc|default}><span class="desc"><{$_formel.desc}></span><{/if}>
		<{if $_formel.message|default}><div class="message"><{$_formel.message}></div><{/if}>
	<{/if}>
</td>
</tr>