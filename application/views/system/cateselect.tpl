<select>
<{foreach from=$ds item=cate1}>
	<option value=""><{$cate1.name}></option>
	<{foreach from=$cate1.child item=cate2}>
		<option value="">-> <{$cate2.name}></option>
		<{foreach from=$cate2.child item=cate3}>
			<option value="">-> -> <{$cate3.name}></option>
		<{/foreach}>
	<{/foreach}>
<{/foreach}>
</select>