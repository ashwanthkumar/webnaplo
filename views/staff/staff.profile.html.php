<?php

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
			<h1>STAFF PROFILE</h1>
		</div>
<div class="field noline">
			<label class="left">Designation</label>
			
			<label class="nobold left nowidth big">
				<select name="Programme_FK" id="select">
					<option name="AP-I">Assistant Professor - I</option>
					<option name="AP-II">Assistant Professor - II</option>
					<option name="AP-III">Assistant Professor - III</option>
					<option name="Professor">Professor</option>
				</select>
			</label>
		</div>
		<div class="field">
			<label class="left">Department Name</label>
			<label class="nobold left nowidth">
				<select name="dept_FK" id="select">
					<option name="CSE">CSE</option>
					<option name="IT">IT</option>
					<option name="ECE">ECE</option>
					<option name="EEE">EEE</option>
					<option name="PHYSICS">PHYSICS</option>
				</select>
			</label>
		</div>
		<div class="field noline">
			<label class="left">Staff Id</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="name" id="staffid" /></label>
		</div>
		<div class="field noline">
			<label class="left">Name</label>
			<label class="nobold left nowidth"><input type="text" class="required big validate" name="Coursecode" id="name" /></label>
		</div>

		
			<div class="field noline">
				<label class="left">Email Id</label>
				<label class="nobold left nowidth"><input type="text" name="Credits" id="email"  class="big validate required" /></label>
		</div>
		<div class="field noline">
			<label class="left">Mobile No</label>
			<label class="nobold left nowidth"><input type="text" name="Credits" id="mobile"  class="big validate required" /></label>
		</div>
		

		<!-- Textarea: Start -->	
		<div class="field">
			<label class="left">Address</label>
			<label class="nobold left nowidth"></label>
			 <textarea cols="4" style="width: 291px; height: 115px;"></textarea>
		</div>
		<!-- Textarea: End -->
		
		<div class="field noline">
			<button type="submit"> Add </button>
			<button type="reset"> Reset </button>
		</div>
	</div>
	<!-- Box Content: End -->
		
</div>
<!-- 100% Box Grid Container: End -->

<?php
	end_content_for();
