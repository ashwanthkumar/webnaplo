// Initialize the jQuery i18n properties plugin
jQuery.i18n.properties({
	name:'errors', 
	path:'<?php echo url_for('/i18n'); ?>/', 
	mode:'both',
	language:'<?php echo option('locale'); ?>', 
	callback: function() {
		$.validator.setDefaults({
			errorClass: "validate_error",
			validClass: "validate_success",
			ignoreTitle: true,
			unhighlight: function(element,eclass, vclass) {
				// Changed from disable to update to give a better UX 
				$(element).poshytip('update', $(element).attr('message'));
				$(element).removeClass(eclass);
				$(element).addClass(vclass);
			},
			errorPlacement: function(error, element) {
				element.poshytip('update', $(error).html());
			},
		});
	}
});

// Login Form validation
$("#loginForm").validate({
	messages: {
		username: jQuery.i18n.prop('webnaplo.i18n.errors.required_field'),
		password: jQuery.i18n.prop('webnaplo.i18n.errors.required_field')
	}
});

