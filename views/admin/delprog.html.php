<?php
	
	content_for('body');
?>
<!-- InstanceBeginEditable name="EditRegion1" -->
<!-- 100% Box Grid Container: Start -->
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
		<h1 class="icon frames"><?php echo get_text('DELETE_PROGRAMME'); ?></h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="POST" action="<?php echo url_for('/admin/programme/delete'); ?>">
		<div class="field">
			<label class="left">Programme Name</label>
			<label class="nobold left nowidth">
		<?php
			$db = $GLOBALS['db'];
			$pgms = $db->select("programme");
		?>
				<select name="Programme_FK" id="select">
				<?php
					foreach($pgms as $p) {
				?>
					<option value="<?php echo $p['idprogramme']; ?>"><?php echo $p['name']; ?></option>
				<?php
					}
				?>
				</select>
			</label>
		</div>
		
		<div class="field noline">
			<button type="submit">Delete </button>
			<button type="reset"> Reset </button>
		</div>
		
		</form>

	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();
