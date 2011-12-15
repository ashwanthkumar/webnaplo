<?php

	// Get the user from the application
	$user = get_user();

	// Get the global variable
	$db = $GLOBALS['db'];

	$max_file_size = ini_get('upload_max_filesize');
	
	// Advanced View Page
	content_for('body');
?>
<div class="grid_24">
<?php
	if(isset($flash['success'])) {
?>
	<!-- Success Notice: Start -->
	<div class="notice success">
		<p><?php echo $flash['success']; ?></p>
	</div>
	<!-- Success Notice: End -->
<?php
	}

	if(isset($flash['error'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice error">
		<?php  $errors = $flash['error']; 
			
			if(count($errors) > 0) {
		?>
		<p>
		<?php
			while($e = current($errors)) {
		?>
		<?php echo key($errors) . ", "; ?>
		<?php
				next($errors);
			}
			
			if(count($errors) > 1)  echo "were"; else echo "was";
		?> not imported. 
		</p>
		<?php
			}
		?>
	</div>
	<!-- Error Notice: End -->

<?php
	}
	
	if(isset($flash['warning'])) {
?>
	<!-- Error Notice: Start -->
	<div class="notice warning">
		<p><?php echo $flash['warning']; ?></p>
	</div>
	<!-- Error Notice: End -->

<?php
		}
?>

</div>

<!-- Left Menu : Start -->
<div class="grid_6">
	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon pages">Sample Files</h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		<table>
			<tr><td><span class="icon buildings"></span><a href="#">Department List </a></td></tr>
			<tr><td><span class="icon book"></span><a href="#">Course List </a></td></tr>
			<tr><td><span class="icon book"></span><a href="#">Programme List </a></td></tr>
			<tr><td><span class="icon users"></span><a href="#">Staff List </a></td></tr>
			<tr><td><span class="icon users"></span><a href="#">Student List </a></td></tr>
		</table>
	</div>
</div>
<!-- Left Menu : End -->

<!-- Right Content : End -->
<div class="grid_18">
	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon frames">Import </h1>
		
		<!-- Tab Select: Start -->
		<ul class="sorting">
			<li><a href="#depttab" class="active"><?php echo get_text('DEPARTMENT'); ?> </a></li>
			<li><a href="#programmetab"><?php echo get_text('PROGRAMME'); ?> </a></li>
			<li><a href="#coursetab"><?php echo get_text('COURSE'); ?> </a></li>
			<li><a href="#stafftab"><?php echo get_text('STAFF'); ?> </a></li>
			<li><a href="#studenttab"><?php echo get_text('STUDENT'); ?> </a></li>
		</ul>
		<!-- Tab Select: End -->
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content padding">
		<div class="tabs">

			<div id="depttab">
				<form enctype="multipart/form-data" method="POST" action="<?php echo url_for('/admin/advanced/import/upload/dept'); ?>">
					<div class="field ">
						<label for="deptlist">Choose the Department Import list </label>
							<input type="file" name="deptlist" id="deptlist" class="big validate tip required" title="Upload the Department list" />
					</div>
					
					<div class="field noline">
						<h3 class="field noline">File Specification</h3>
							<ol>
								<li>Upload file must be of <em>xls/xlsx/csv </em> </li>
								<li>Upload file must be of size less than <em><?php echo $max_file_size; ?> </em> </li>
								<li>Student file format must of the following column headers 
									<br />
									<ul>
										<li>name</li>
									</ul>
								</li>
							</ol>
						<button type="submit">Upload Department List</button>
					</div>
				</form>
			</div>
			<!-- Start of Student Tab List -->
			<div id="studenttab">
				<form enctype="multipart/form-data" method="POST" action="<?php echo url_for('/admin/advanced/import/upload/student'); ?>">
					<div class="field ">
						<label for="studentlist">Choose the Student Import list </label>
						<input type="file" name="studentlist" id="studentlist" class="big validate tip" title="Upload the Student list" />

						<label for="classid">
							Class
							<select name="classid" id="classid">
							<?php
								$classList = Section::search($db);
								
								foreach($classList as $class) {
							?>
								<option value="<?php echo $class['idclass']; ?>"><?php echo $class['name']; ?> </option>
							<?php
								}
							?>
							</select>
						</label>
					</div>
					
					<div class="field noline">
						<h3 class="field noline">File Specification</h3>
							<ol>
								<li>Upload file must be of <em>xls/xlsx/csv </em> </li>
								<li>Student file format must of the following column headers 
									<br />
									<ul>
										<li>registernumber</li>
										<li>name</li>
										<li>year</li>
										<li>semester</li>
										<li>mobile</li>
										<li>address</li>
										<li>email</li>
									</ul>
								</li>
							</ol>
						<button type="submit">Upload Student List</button>
					</div>
				</form>
			</div>
			<!-- End of Student List -->
			
			<!-- Staff Tab List -->
			<div id="stafftab">
				<form enctype="multipart/form-data" method="POST" action="<?php echo url_for('/admin/advanced/import/upload/staff'); ?>">
					<div class="field ">
						<label for="stafflist">Choose the Staff Import list </label>
						<input type="file" name="stafflist" id="stafflist" class="big validate tip" title="Upload the Staff list" />

						<label for="deptid">Choose the Department 
							<select name="deptid" id="deptid">
							<?php
								$deptList = Department::search($db);
								
								foreach($deptList as $dept) {
							?>
								<option value="<?php echo $dept['iddept']; ?>"><?php echo $dept['name']; ?> </option>
							<?php
								}
							?>
							</select>
						</label>
					</div>
					
					<div class="field noline">
						<h3 class="noline">File Specifications</h3>
						<ol>
							<li>Upload file must be of <em>xls/xlsx/csv </em> </li>
							<li>Staff file format must of the following column headers 
								<br />
								<ul>
									<li>staffid</li>
									<li>name</li>
									<li>address</li>
									<li>designation</li>
									<li>mobile</li>
									<li>email</li>
								</ul>
							</li>
						</ol>
						
						<button type="submit">Upload Staff List</button>
					</div>
				</form>
			</div>
			<!-- End of Staff List -->

			<!-- Programme Tab List -->
			<div id="programmetab">
				<form enctype="multipart/form-data" method="POST" action="<?php echo url_for('/admin/advanced/import/upload/programme'); ?>">
					<div class="field ">
						<label for="stafflist">Choose the Programme Import list </label>
						<input type="file" name="programmelist" id="programmelist" class="big validate tip" title="Upload the Programme list" />

						<label for="deptid">Choose the Department 
							<select name="deptid" id="deptid">
							<?php
								$deptList = Department::search($db);
								
								foreach($deptList as $dept) {
							?>
								<option value="<?php echo $dept['iddept']; ?>"><?php echo $dept['name']; ?> </option>
							<?php
								}
							?>
							</select>
						</label>
					</div>
					
					<div class="field noline">
						<h3 class="noline">File Specifications</h3>
						<ol>
							<li>Upload file must be of <em>xls/xlsx/csv </em> </li>
							<li>Programme file format must of the following column headers 
								<br />
								<ul>
									<li>name</li>
								</ul>
							</li>
						</ol>
						
						<button type="submit">Upload Programme List</button>
					</div>
				</form>
			</div>
			<!-- End of Programme List -->

			<!-- Course Tab List -->
			<div id="coursetab">
				<form enctype="multipart/form-data" method="POST" action="<?php echo url_for('/admin/advanced/import/upload/course'); ?>">
					<div class="field ">
						<label for="stafflist">Choose the Course Import list </label>
						<input type="file" name="courselist" id="courselist" class="big validate tip" title="Upload the Course list" />

						<label for="deptid">Choose the Programme 
							<select name="pgmid" id="pgmid">
							<?php
								$pgmList = Programme::search($db);
								
								foreach($pgmList as $pgm) {
							?>
								<option value="<?php echo $pgm['idprogramme']; ?>"><?php echo $pgm['name']; ?> </option>
							<?php
								}
							?>
							</select>
						</label>
					</div>
					
					<div class="field noline">
						<h3 class="noline">File Specifications</h3>
						<ol>
							<li>Upload file must be of <em>xls/xlsx/csv </em> </li>
							<li>Programme file format must of the following column headers 
								<br />
								<ul>
									<li>code - Course Code</li>
									<li>name - Course Name</li>
									<li>credits - Course Credits</li>
								</ul>
							</li>
						</ol>
						
						<button type="submit">Upload Programme List</button>
					</div>
				</form>
			</div>
			<!-- End of Programme List -->
		</div>
	</div>

	
	<!-- Box Content: End -->
	
</div>
<!-- Right Content : End -->

<?
	end_content_for();
