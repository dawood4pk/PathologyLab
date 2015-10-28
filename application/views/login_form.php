<?php if(!$this->session->userdata('logged_in')) { ?>
	<div class="login form">
		<div class="header">
			<h2>Admin/Operator Login</h2>
		</div>

		<div id="errorDiv"></div>

		<form id="loginForm" name="loginForm" method="post">
			<input type="hidden" name="baseURL" value="<?php echo base_url();?>">
			<input type="text" id="username" name="username" placeholder="Username" />
			<input type="password" id="Password" name="Password" placeholder="Password" />
			<input id="loginBtn" type="Submit" value="Login" />
			<hr>
		</form>
	</div>
<?php }?>