<{if $USER_IS_LOGIN|default}>
<div class="userinfo">
	已经登录
</div>
<{else}>
<div class="userinfo" id="userLogin">
	<div>
		<label>帐号：</label>
		<input type="text" name="username" />
		<a href="<{$BASE_URL}>auth/register">注册用户</a>
	</div>
	<div>
		<label>密码：</label>
		<input type="password" name="password" />
		<input type="button" value="登录" />
	</div>
</div>
<{/if}>