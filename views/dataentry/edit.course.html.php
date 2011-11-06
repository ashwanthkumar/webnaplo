<?php
	
	$db = $GLOBALS['db'];
	
	content_for('body');
	
	$cid = params(0);
	
	$course = $db->select("course", "idcourse = :cid", array(":cid" => $cid));
	
	// Re-direct the course list 
	if(count($course) < 1) {
		redirect('/dataentry/course/list');
	}
	
	$course = $course[0];
?>
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
		
		<h1 class="icon frames">&nbsp;</h1>
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<form method="POST" action="<?php echo url_for("/dataentry/course/$cid/edit"); ?>">
		<div class="field noline">
			<h1>EDIT COURSE </h1>
		</div>

		<div class="field noline">
			<label class="left"> Old Course Code</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="oldcoursecode" id="oldcoursecode" value="<?php echo $course['course_code']; ?>" disabled="disabled" /></label>
		</div>
		
		<input name="idcourse" id="idcourse" type="hidden" value="<?php echo $course['idcourse']; ?>" />
		
		<div class="field noline">
			<label class="left"> Course Code</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="coursecode" id="coursecode" value="<?php echo $course['course_code']; ?>" /></label>
		</div>

		<div class="field noline">
			<label class="left">Course Name</label>
			<label class="nobold left nowidth"><input type="text" name="coursename"  class="big validate required" id="coursename" value="<?php echo $course['course_name']; ?>" /></label>
		</div>

		<div class="field noline">
			<label class="left">Credits</label>
			<label class="nobold left nowidth"><input type="text" name="credits" id="credits"  class="big validate required number" value="<?php echo $course['credits']; ?>" /></label>
		</div>

		<div class="field">
			<label class="left">Programe Name</label>
			<?php
				$pgms = $db->select("programme");
			?>
			<label class="nobold left nowidth">
				<select name="pgm_id" id="select">
				<?php
					foreach($pgms as $p) {
				?>
					<option value="<?php echo $p['idprogramme']; ?>" <?php if($p['idprogramme'] === $course['programme_idprogramme']) echo "selected='selected'"; ?>><?php echo $p['name']; ?></option>
				<?php
					}
				?>
				</select>
			</label>
		</div>
		
		<div class="field noline">
			<button type="submit"> Submit</button>
			<button type="reset"> Reset </button>
		</div>
	</form>
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php

	end_content_for();
