<?php
	// Get the user of the application
	$user = get_user();

	// Getting the PDO Handler
	$db = $GLOBALS['db'];
	
	$stud = $db->select("student", "idstudent = :sid", array(":sid" => $user->userid));
	$stud = $stud[0];
	
	content_for('body');
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		<div class="field noline">
			<h1>Profile</h1>
		</div>
		<h1 class="icon frames">&nbsp;</h1>
		
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
	<form method="POST" action="<?php echo url_for('/student/profile/update'); ?>">
		<div class="field noline">
			<label class="left">Register No</label>
			<label class="nobold left nowidth"><?php echo $stud['idstudent']; ?></label>
		</div>
		
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><?php echo $stud['name']; ?></label>
		</div>

		<div class="field noline">
				<label class="left">Email Id</label>
				<label class="nobold left nowidth"><input type="text" name="email" id="email"  value="<?php echo $stud['email']; ?>" class="big validate required email tip-form" title="EMail ID of the student"/></label>
		</div>

		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="mobile" id="mobile"  value="<?php echo $stud['mobile']; ?>" class="big validate required digits tip-form" title="Mobile number of the Student" /></label>
		</div>
		
		<?php
			$dept = $db->run("select d.name as dname, d.iddept as iddept, p.name as pname, p.idprogramme as idprogramme, c.idclass as idclass, c.name as cname from student s, dept d, class c, programme p where s.idstudent = :reg and s.class_id = c.idclass and d.iddept = p.dept_id and c.programme_id = p.idprogramme", array(":reg" => $stud['idstudent']));
			
			$dept = $dept[0];
		?>
		<div class="field noline">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth"><?php echo $dept['dname']; ?></label>
			<input type="hidden" name="iddept" value="<?php echo $dept['iddept']; ?>" />
		</div>

		<div class="field noline">
			<label class="left">Programme Name</label>
			<label class="nobold left nowidth"><?php echo $dept['pname']; ?></label>
			<input type="hidden" name="idprogramme" value="<?php echo $dept['idprogramme']; ?>" />
		</div>

		<div class="field noline">
			<label class="left">Section Name</label>
			<label class="nobold left nowidth"><?php echo $dept['cname']; ?></label>
			<input type="hidden" name="class_id" value="<?php echo $dept['idclass']; ?>" />
		</div>
		
		<div class="field noline">
			<label class="left">Year</label>
			<label class="nobold left nowidth"><?php echo $stud['year']; ?></label>
		</div>

		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth"></label>
			 <textarea cols="4" style="width: 291px; height: 115px;" class="tip-form validate" title="Address of the Student"><?php echo $stud['address']; ?></textarea>
		</div>
		
		<div class="field noline">
			<button type="submit">Update</button>
			<button type="reset"> Reset </button>
		</div>
		</form>
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();