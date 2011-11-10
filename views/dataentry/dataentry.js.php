<?php

$user = get_user();

$db = $GLOBALS['db'];

?>
<script type="text/javascript">
$(document).ready(function() {

	$('#department').change(function() {
		// alert("Department changed");
		$.getJSON("<?php echo "http://" . $_SERVER['SERVER_NAME'] . url_for('/dataentry/student/add/proxy'); ?>", {"dept": $(this).val() }, function(data) {
			// alert(data);
			$("#programme").find("option").remove();
			
			if(data.data.length > 0) $("#programme").removeAttr("disabled");
			if(data.data.length < 1) $("#programme").attr("disabled","disabled");
			
			$.each(data.data, function(id, pgm) {
				$('#programme')
				.append($('<option />', { value : pgm.idprogramme, text: pgm.name })); 
				$("#programme").change();
			});
		});
	});

	$('#programme').change(function() {
		// alert("Department changed");
		$.getJSON("<?php echo "http://" . $_SERVER['SERVER_NAME'] . url_for('/dataentry/student/add/proxy'); ?>", {"pgm": $(this).val() }, function(data) {
			$("#class").find("option").remove();

			if(data.data.length > 0) $("#class").removeAttr("disabled");
			if(data.data.length < 1) $("#class").attr("disabled","disabled");
			

			$.each(data.data, function(id, c) {
				$('#class')
				.append($('<option />', { value : c.idclass, text: c.name })); 
			});
		});
	});
});
</script>