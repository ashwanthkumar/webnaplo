<?php

	$user = get_user();
	
	$db = $GLOBALS['db'];
	
	content_for('body');
?>
<div class="grid_12">
	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">News And Updates</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<div class="field noline">
			<ol>
			<marquee direction="up" scrollamount="2" height="445">
		<?php
			$db = $GLOBALS['db'];
			
			// Get only the latest 10 news items from the datastore
			$news = $db->run("select * from news order by date desc limit 0,10");
			
			foreach($news as $n) {
		?>
			<li style="text-align: justify;" class="field line"><?php echo $n['news']; ?> - <?php echo date("H", time() - strtotime($n['date'])); ?> hours ago
		<?php
			}
		?>
			</marquee>
			</ol>
		</div>
	</div>
	<!-- Box Content: End -->
</div>

<div class="grid_12">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Quick Stats</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<tr>
				<td>Courses</td>
				<?php
					$l = $db->run("select count(*) As count from course");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
			<tr>
				<td>Departments</td>
				<?php
					$l = $db->run("select count(*) As count from dept");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
			<tr>
				<td>Programme</td>
				<?php
					$l = $db->run("select count(*) As count from programme");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
			<tr>
				<td>Sections</td>
				<?php
					$l = $db->run("select count(*) As count from class");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
			<tr>
				<td>Staff</td>
				<?php
					$l = $db->run("select count(*) As count from staff");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
			<tr>
				<td>Student</td>
				<?php
					$l = $db->run("select count(*) As count from student");
				?>
				<td><?php echo $l[0]['count']; ?></td>
			</tr>
		</table>
	</div>
	<!-- Box Content: End -->
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

<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Change Password</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="POST" action="<?php echo url_for('/dataentry/changepass'); ?>">
			<div class="field">
				<label for="password" class="nowidth">New Password</label>
				<input type="password" name="newPass" id="newPass" />
			</div>
			<button type="submit">Update Password</button>
		</form>
	</div>
	<!-- Box Content: End -->
		
</div>

<?php
	end_content_for();
