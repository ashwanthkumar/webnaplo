<?php

$user = get_user();

$db = $GLOBALS['db'];

	$courses = $db->select("course_profile", "staff_id = :id", array(":id" => $user->userid));

	content_for('body');
?>
<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h1 class="icon frames">&nbsp;</h1>
		
	</div>
	<!-- Box Header: End -->
	
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		
		<div class="field noline">
			<h1>TIMETABLE </h1>
		</div>
		
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->
<?php
	end_content_for();
