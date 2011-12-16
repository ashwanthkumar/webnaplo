<?php
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
			<marquee direction="up" scrollamount="2">
		<?php
			$db = $GLOBALS['db'];
			
			// Get only the latest 10 news items from the datastore
			$news = $db->run("select * from news where type = 4 or type = 1  order by date desc limit 0,10");
			
			foreach($news as $n) {
		?>
			<li style="text-align: justify;" class="field line"><?php echo $n['news']; ?> - <?php echo date("d-M", strtotime($n['date'])); ?> 
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
	<div class="box_content padding">
		<div class="field noline">
			<p>Some useful content will come here.</p>
		</div>
	</div>
	<!-- Box Content: End -->
	
</div>

<?php
	end_content_for();
