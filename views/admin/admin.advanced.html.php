<?php

	// Get the user from the application
	$user = get_user();

	// Get the global variable
	$db = $GLOBALS['db'];
	
	// Advanced View Page
	content_for('body');
?>
<div class="grid_24">
<?php
	if(isset($flash['success'])) {
?>
	<!-- Success Notice: Start -->
	<div class="notice success">
		<p><?php echo $flash['success']; ?>.</p>
	</div>
	<!-- Success Notice: End -->
<?php
	}

	if(isset($flash['error'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice error">
		<p><?php echo $flash['error']; ?>.</p>
	</div>
	<!-- Error Notice: End -->

<?php
	}
	
	if(isset($flash['warning'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice warning">
		<p><?php echo $flash['warning']; ?>.</p>
	</div>
	<!-- Error Notice: End -->

<?php
		}
?>

</div>
<div class="grid_12">
	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Reset Password</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<form method="POST" action="<?php echo url_for('/admin/user/reset/'); ?>">
		<div class="field ">
			<label for="username">Enter User Id to Reset Password </label>
			<input type="text" name="username" class="medium validate validateMultiForm tip-form" title="User ID for whom you want to reset the password" message="User ID for whom you want to reset the password">	
			<button type="submit">Reset </button>
		</div>
	</form>
		<div class="field noline">
		<form method="POST" action="<?php echo url_for('/admin/user/reset/staff/all'); ?>">
			<button type="submit">Reset All Staff Password</button>
		</form>
		<form method="POST" action="<?php echo url_for('/admin/user/reset/student/all'); ?>">
			<button type="submit">Reset All Student Password</button>
		</form>
		</div>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- Right Panel : End -->

<!-- Right Panel : Start -->
<div class="grid_12">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Admin User Settings</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
	<form method="POST" action="<?php echo url_for('/admin/user/admin/update/password'); ?>">
	<table>
		<tr>
			<td class="align_left">Admin Username</td>
			<td><?php echo Configuration::get(Configuration::$CONFIG_ADMIN_USER, $db, true); ?></td>
		</tr>
		<tr>
			<td class="align_left">Admin Password</td>
			<td><input type="password" name="adminpassword" id="adminpassword"/></td>
		</tr>
		<tr>
			<td colspan="2" class="center"><button>Update Settings</button></td>
		</tr>
	</table>
	</form>
	</div>

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Data Entry User Settings</h1>
	</div>
	<!-- Box Header: End -->
	
	<div class="box_content">
	<form method="POST" action="<?php echo url_for('/admin/user/dataentry/update/password'); ?>">
	<table>
		<tr>
			<td class="align_left">Dataentry Username</td>
			<td><?php echo Configuration::get(Configuration::$CONFIG_DATAENTRY_USER, $db, true); ?></td>
		</tr>
		<tr>
			<td class="align_left">Dataentry Password</td>
			<td><input type="password" name="dataentryPassword" id="dataentryPassword" /></td>
		</tr>
		<tr>
			<td colspan="2" class="center"><button>Update Settings</button></td>
		</tr>
	</table>
	</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- Right Panel : End -->
<?
	end_content_for();

