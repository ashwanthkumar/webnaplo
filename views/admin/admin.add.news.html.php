<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];

	// Edit Mode for re-using the template? 
	$edit_mode = isset($edit_me) ? true : false;
	if($edit_mode) {
		$course_profile = $staff->getCourseProfile($edit_me, $db);
		
		// Leave the page in case of an error
		if(!$course_profile) {
			flash('error', "There seems to be an error in editing the Course Profile");
			return redirect("/staff/course_profile");
		}
	}

	// Render Page Starts
	content_for('body');
?>
<!-- Having a universal form for the entire page -->
<form method="post" action="<?php if(!$edit_mode) echo url_for('/admin/news/add'); else echo url_for('/admin/news/edit'); ?>">

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
		<h1 class="icon frames"><?php echo get_text('ADD_NEWS'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<form method="POST" action="<?php echo url_for('/admin/news/add'); ?>">
		<?php
			if($edit_mode) :
		?>
			<input type="hidden" name="idNews" value="<?php echo $edit_me; ?>" />
		<?php
			endif;
		?>
		
		<div class="field noline">
			<label class="left"> <?php echo get_text('TYPE'); ?></label>
			<label class="nobold left nowidth">
				<select name="type" id="type">
					<option value="1"><?php echo get_text('COMMON'); ?></option>
					<option value="2"><?php echo get_text('DATAENTRY'); ?></option>
					<option value="3"><?php echo get_text('STAFF'); ?></option>
					<option value="4"><?php echo get_text('STUDENT'); ?></option>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left"> <?php echo get_text('DATE'); ?></label>
			<label class="nobold left nowidth"><input type="text" readonly='true' class="date required big validate tip-form" title="What's today?" name="date" id="date" <?php if($edit_mode) echo "value='" . date('m/d/Y', strtotime($news->date)) . "'"; ?>/></label>
		</div>

		<div class="field noline">
			<label class="left"> <?php echo get_text('TITLE'); ?></label>
			<label class="nobold left nowidth"><input type="text" class="required big validate tip-form" title="Name of news item for your reference" name="title" id="title" <?php if($edit_mode) echo "value='" . $news->title . "'"; ?>/></label>
		</div>

		<div class="field noline">
			<label class="left"> <?php echo get_text('NEWS'); ?></label>
			<label class="nobold left nowidth"><textarea class="big wysiwyg validate tip-form" name="news" title="Type in the actual news content" id="news"> <?php if($edit_mode) echo $news->news; ?></textarea></label>
		</div>
		
		<div class="field noline">
			<button type="submit"> <?php echo ($edit_mode) ? "Update News Item" : "Add News Item" ; ?> </button>
			<button type="button" onclick="window.location = '<?php echo url_for('/admin/news'); ?>';"> Cancel </button>
		</div>
	</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<?php
	end_content_for();

