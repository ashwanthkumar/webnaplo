<?php

	// Get the user from the application
	$user = get_user();

	// Get the global variable
	$db = $GLOBALS['db'];
	
	// Advanced View Page
	content_for('body');
?>

<!-- Right Panel : Start -->
<div class="grid_12">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Reset Password</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<div class="field ">
			<label for="resetUserId">Enter User Id for Reset Password </label>
			<input type="text" name="resetUserId" class="medium validate">	
			<button type="Reset">Reset </button>
		</div>
		<div class="field noline">
			<button>Reset All Staff Password</button>
			<button>Reset All Student Password</button>
		</div>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- Right Panel : End -->

<!-- Right Panel : Start -->
<div class="grid_12">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Semester Configuration</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
	<table>
		<tr>
			<td class="align_left">Admin Username</td>
			<td><?php echo Configuration::get(Configuration::$CONFIG_ADMIN_USER, $db, true); ?></td>
		</tr>
		<tr>
			<td class="align_left">Admin Password</td>
			<td><input type="password" name="adminPassword" id="adminPassword"/></td>
		</tr>
		<tr>
			<td class="align_left">Dataentry Username</td>
			<td><?php echo Configuration::get(Configuration::$CONFIG_DATAENTRY_USER, $db, true); ?></td>
		</tr>
		<tr>
			<td class="align_left">Dataentry Password</td>
			<td><input type="password" name="dataentryPassword" id="dataentryPassword" /></td>
		</tr>
	</table>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- Right Panel : End -->
<?
	end_content_for();

