<?php

	// Get the user from the application
	$user = get_user();

	// Get the global variable
	$db = $GLOBALS['db'];
	
	// Advanced View Page
	content_for('body');
	
	// Get the list of news 
	$newsList = News::search($db);
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

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames"><?php echo get_text('NEWS_LIST'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content <?php if(count($newsList) < 1) echo "padding"; ?>">
	<?php
		if(count($newsList) > 0) {
	?>
	<form method="POST" action="<?php echo url_for('/admin/news/batch/delete'); ?>">
		<table class="sorting">
			<thead>
				<th class="checkers"><input type="checkbox" class="checkall" /></th>
				<th>SNO </th>
				<th>Title </th>
				<th>Date </th>
				<th>Type </th>
				<th>Tools </th>
			</thead>
			
			<tbody>
			<?php
				$i = 1;
				foreach($newsList as $news) {
			?>
				<tr>
					<th class="checkers"><input type="checkbox" name="news[<?php echo $news['idNews']; ?>]"/></th>
					<td><?php echo $i++; ?></td>
					<td><?php echo $news['title']; ?></td>
					<td><?php echo date('d-m-Y', strtotime($news['date'])); ?></td>
					<td><?php echo News::getType($news['type']); ?></td>
					<td>
						<a href="<?php echo url_for("/admin/news/" . $news['idNews'] . "/delete"); ?>" class="delete tip" title="delete">delete</a>					</td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>

		<div class="table_actions">
			<input type="checkbox" class="checkall" />

			<button class="left">Delete Selected</button>
			<button type="button" class="left" onclick="window.location='<?php echo url_for('/admin/news/add'); ?>';return false;">Add New</button>
		</div>
	</form>
	<?php
		} else {
	?>
		<div class="field noline">
			<h6 class="noline">There are no News in the system. Please <a  href="<?php echo url_for('/admin/news/add'); ?>">Add </a> them. </h6>
		</div>
	<?php
		}
	?>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- Right Panel : End -->
<?
	end_content_for();
