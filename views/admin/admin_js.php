<?php

	$user = get_user();
?>
	// Table to be used for staffs
	$('#student_list').dataTable( {
		"bProcessing": true,
		"sAjaxSource": '<?php echo url_for('/admin/json/students'); ?>'
	} );
