<?php
	
	// Get the current application's User
	$user = get_user();
	
	$db = $GLOBALS['db'];
	
	date_default_timezone_set("Asia/Calcutta");

	content_for('body');
?>
<div class="grid_12">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames"><?php echo get_text('NEWS_UPDATES'); ?></h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<div class="field noline">
			<ol>
			<marquee direction="up" scrollamount="2" height="305">
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
		<h1 class="icon frames"><?php echo get_text('CAMPUS_STATUS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
	<table>
		<tr>
			<td><span class="icon pages"></span> <?php echo get_text('DEPARTMENT'); ?></td>
			<?php
				$dept = $db->run("select count(*) as count from dept");
			?>
			<td class="right_end"><?php echo $dept[0]['count']; ?></td>
		</tr>

		<tr>
			<td><span class="icon pages"></span> <?php echo get_text('PROGRAMME'); ?></td>
			<?php
				$pgms = $db->run("select count(*) as count from programme;");
			?>
			<td class="right_end"><?php echo $pgms[0]['count']; ?></td>
		</tr>

		<tr>
			<td><span class="icon users"></span> <?php echo get_text('STAFF'); ?></td>
			<?php
				$pgms = $db->run("select count(*) as count from staff;");
			?>
			<td class="right_end"><?php echo $pgms[0]['count']; ?></td>
		</tr>

		<tr>
			<td><span class="icon users"></span><?php echo get_text('STUDENT'); ?></td>
			<?php
				$pgms = $db->run("select count(*) as count from student;");
			?>
			<td class="right_end"><?php echo $pgms[0]['count']; ?></td>
		</tr>
		</table>
	</div>
	<!-- Box Content: End -->
	
	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('SYSTEM_STATUS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content">
	<table>
		<tr>
			<td><?php echo get_text('VERSION'); ?></td>
			<td class="right_end"><?php echo System::$version; ?></td>
		</tr>
		<tr>
			<td><?php echo get_text('RELEASE'); ?></td>
			<td class="right_end"><?php echo System::$code_name; ?></td>
		</tr>
		<tr>
			<td><?php echo get_text('BUILD_DATE'); ?></td>
			<td class="right_end"><?php echo date('r', System::$build); ?></td>
		</tr>
	</table>
	</div>
	<!-- Box Content: End -->

</div>

<?php
	end_content_for();
	