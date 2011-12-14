<!DOCTYPE HTML>


<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	
	<!-- Imports General CSS and jQuery CSS -->
	<link href="<?php echo option('base_path'); ?>/public/css/screen.css" rel="stylesheet" media="screen" type="text/css" />
	
	<!-- CSS for Fluid and Fixed Widths - Double to prevent flickering on change -->
	<link href="<?php echo option('base_path'); ?>/public/css/fixed.css" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo option('base_path'); ?>/public/css/fixed.css" rel="stylesheet" media="screen" type="text/css" class="width" />
	
	<!-- IE Stylesheet ie7 - Added in 1.2 -->
	<!--[if lt IE 8]> <html lang="en" class="ie7"> <![endif]-->
	
	<!-- IE Stylesheet ie8 - Added in 1.1 -->
	<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
	
	<!-- CSS for Theme Styles - Double to prevent flickering on change -->
	<link href="<?php echo option('base_path'); ?>/public/css/theme/blue.css" rel="stylesheet" media="screen" type="text/css" />
	<link href="<?php echo option('base_path'); ?>/public/css/theme/blue.css" rel="stylesheet" media="screen" type="text/css" class="theme" />
	<?php 
		if(isset($tt_active)) {
	?>
	<link href="<?php echo option('base_path'); ?>/public/timetable/style.css" rel="stylesheet" media="screen" type="text/css"/>
	<?php
		}
	?>
	
	<!-- IE Canvas Fix for Visualize Charts - Added in 1.1 -->
	<!--[if IE]><script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/excanvas.js"></script><![endif]-->
	
	<!-- jQuery thats loaded before document ready to prevent flickering - Rest are found at the bottom -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.styleswitcher.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.visualize.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.poshytip.min.js"></script>

	<script type="text/javascript">
		// Tip for Forms
		$('.tip-form').poshytip({
			className: 'tip-theme',
			showOn:'focus',
			showTimeout: 1,
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			allowTipHover: true,
			fade: false,
			slide: true
		});

		$("form").validate({
			   errorElement: "div",
			   errorClass: "validate_error",
			   validClass: "validate_success",
			   ignoreTitle: true,
			   unhighlight: function(element,eclass, vclass) {
				 $(element).poshytip('disable');
				 $(element).removeClass(eclass);
				 $(element).addClass(vclass);
			   },
			   errorPlacement: function(error, element) {
					element.poshytip('enable');
					element.poshytip('update', $(error).html());
			   }
		});
	</script>
	
</head>

<body>	
<!-- Start: Page Wrap -->
<div id="wrap" class="container_24">

<?php if(isset($body)) echo $body; ?>

</div>
<?php
	if(isset($show_footer)) :
?>
<!-- Footer Grid: Start -->
<div class="grid_24">

	<!-- Footer: Start -->
	<div id="footer">
		
		<p class="left">
			Copyright &#169; 2011 <a href="#">Team WebNaplo</a>. Currently in Beta.
		</p>
		<p class="right">
			View in <a href="<?php echo url_for('user/locale/en'); ?>">English</a> | <a href="<?php echo url_for('user/locale/ta'); ?>"><?php echo get_text('TAMIL', 'ta'); ?></a>
		</p>
		
	</div>
	<!-- Footer: End -->
	
</div>
<!-- Footer Grid: End -->
<?php
	endif;
?>
	
	<!-- jQuery libs - Rest are found in the head section (at top) -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.visualize-tooltip.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery-animate-css-rotate-scale.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery-ui-1.8.13.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.poshytip.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.quicksand.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.facebox.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shCore.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushXml.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushJScript.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushCss.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushPhp.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/fileTree/jqueryFileTree.js"></script> <!-- Added in 1.2 -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.blockUI.js"></script>
	
	<!-- jQuery Customization -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/custom.js"></script>

</body>

</html>