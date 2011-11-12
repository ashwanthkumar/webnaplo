<!DOCTYPE HTML>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo get_text('WEBNAPLO'); ?> - <?php echo get_text('LOGIN_PAGE'); ?> </title>
	
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
	
	<!-- IE Canvas Fix for Visualize Charts - Added in 1.1 -->
	<!--[if IE]><script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/excanvas.js"></script><![endif]-->
	
	<!-- jQuery thats loaded before document ready to prevent flickering - Rest are found at the bottom -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.i18n.properties-min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.styleswitcher.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.visualize.js"></script>
	
</head>

<body>

<!-- Start: Page Wrap -->
<div id="wrap" class="container_24">


<!-- Grid Container: Start (centers) -->
	<div class="login2">

		<!-- 100% Box Grid Container: Start -->
		<div class="grid_12">
		
			<!-- Box Header: Start -->
			<div class="box_top">
				<h1 class="icon key"><?php echo get_text('LOGIN_PAGE'); ?></h1>
			</div>
			<!-- Box Header: End -->
			
			<!-- Box Content: Start -->
			<div class="box_content padding">
				
				<!-- Tabs: Start -->
				<div class="tabs">
					
					<!-- Login Tab: Start -->
					<div id="login">
						<p class="note small"><?php echo get_text('WELCOME_TO_WEBNAPLO'); ?></p>
						<?php
							if(isset($flash['error'])) {
						?>
						<p class="error small"><?php echo $flash['error']; ?></p>
						<?php
							}
						?>
						
						<form action="<?php echo url_for('/user/login'); ?>" method="post" id="loginForm">
						
							<div class="field noline nopadding">
								<label class="left" for="username"><?php echo get_text('USERNAME'); ?></label>
								<input type="text" class="validate tip-stay right required" title="<?php echo get_text('ENTER_USERNAME'); ?>" message="<?php echo get_text('ENTER_USERNAME'); ?>" name="username" id="username">
							</div>
							
							<div class="field">
								<label class="left" for="password"><?php echo get_text('PASSWORD'); ?></label>
								<input type="password" class="validate tip-stay right required" title="<?php echo get_text('ENTER_PASSWORD'); ?>" message="<?php echo get_text('ENTER_PASSWORD'); ?>" name="password" id="password">
							</div>
							
							<div class="right">
								<button type="submit"><?php echo get_text('LOGIN'); ?></button>
							</div>
						</form>
						
					</div>
					<!-- Login Tab: End -->
					
				</div>
				<!-- Tabs: End -->
		
			</div>
			<!-- Box Content: End -->
			
		</div>
		<!-- 100% Box Grid Container: End -->
		
		<div class="grid_12">
			<div class="box_content padding">
			<p class="left">
				&copy; 2011 <a href="<?php echo url_for('/credits'); ?>"> WebNaplo</a> (Beta)
			</p>
		<p class="right">
			View in <a href="<?php echo url_for('user/locale/en'); ?>">English</a> | <a href="<?php echo url_for('user/locale/ta'); ?>"><?php echo get_text('TAMIL', 'ta'); ?></a>
		</p>
	</div>
		</div>
		
	</div>
	<!-- Grid Container: End (centers) -->


</div>
<!-- End: Page Wrap -->

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
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shCore.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushXml.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushJScript.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushCss.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushPhp.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/fileTree/jqueryFileTree.js"></script> <!-- Added in 1.2 -->
	
	<!-- jQuery Customization -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo url_for('/user/js/i18n'); ?>"></script>

</body>

</html>