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
	
	
	<!-- Header Grid Container: Start -->
	<div class="grid_24">
		
		<!-- User Panel: Start -->
		<div id="userpanel">
			
			<!-- User: Start -->
			<ul id="user" class="dropdown">
				<li class="topnav">
					<!-- User Name -->
					<?php
						$user = get_user();
					?>
					<a href="<?php echo url_for('/staff/home'); ?>" class="top icon user"><?php echo $user->name; ?></a>
					
					<!-- User Dropdown Content: Start -->
					<ul class="subnav">
			            <li><a href="<?php echo url_for('/user/logout'); ?>" class="icon lock">Log out</a></li>  
			        </ul>  
			        <!-- User Dropdown Content: End -->
				</li>
			</ul>
			<!-- User: End -->
			<!-- Width Switcher: Start -->
			<ul id="width" class="dropdown right">
				<li class="topnav">
					<a href="http://www.sastra.edu/" class="top">Sponsored by SASTRA</a>
				</li>
			</ul>
			<!-- Width Switcher: End -->

		</div>
		<!-- User Panel: End -->
		
		<!-- Header: Start -->
		<div id="header">
				
			
			<!-- Navigation: Start -->
			<ul id="navigation" class="dropdown">
				<li><a class="dashboard <?php if(isset($home_active)) echo "active"; ?>" href="<?php echo url_for('/staff/home'); ?>">Home</a></li>
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="">
					<a class="frames <?php if(isset($cp_active)) echo "active"; ?>" href="<?php echo url_for('/staff/course_profile/'); ?>">Course Profile</a>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="">
					<a class="pages <?php if(isset($at_active)) echo "active"; ?>" href="<?php echo url_for('/staff/attendance/'); ?>">Attendance</a>
					
					
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="">
					<a class="pages <?php if(isset($cia_active)) echo "active"; ?>" href="<?php echo url_for('/staff/cia'); ?>">CIA</a>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages" href="<?php echo url_for('/staff/profile'); ?>">View</a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
						<li><a href="<?php echo url_for('/staff/profile/view/'); ?>" class="icon laptop">Profile</a></li> 
						
			            <li><a href="<?php echo url_for('/staff/cumulative_report/view'); ?>" class="icon archive">Cumulative Report</a></li>  
			             
			            
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
			</ul>
			<!-- Navigation: End -->
			
		</div>
		<!-- Header: End -->
<?php 
	if(isset($dashboard)) echo $dashboard;
?>
	</div>
	<!-- Header Grid Container: End -->

<?php
	if(!isset($home_active)) :
?>
<!-- // Sidebar starts -->
<!-- 25% Box Grid Container: Start -->
<div class="grid_6">

	<!-- Box Header: Start -->
	<div class="box_top">
		<h1 class="icon coverflow">Staff </h1>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		
		<!-- Vertical Menu: Start -->
			<ul class="menu">
				<li><a href="#" class="tip" title="Edit your Profile"><span class="icon user"></span> Edit Profile </a>
				<li><a href="#" class="tip" title="Generate Integrated Report"><span class="icon graph"></span> Generate IR</a>
				<li><a href="#" class="tip" title="Generate Lack Report"><span class="icon pages"></span> Generate LR</a>
				<li><a class="tip" title="View Timetable" href="#" onclick="window.open('<?php echo url_for('/staff/timetable/popup'); ?>', 'timetable_popup','status=0,height=650,width=1000');"><span class="icon pages"></span>Timetable</a></li>
			</ul>
		<!-- Vertical Menu: End -->

	</div>
	<!-- Box Content: End -->

	<!-- Help Box Header: Start -->
	<div class="box_top">
		<h2 class="icon coverflow">Help Videos </h2>
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		
		<!-- Vertical Menu: Start -->
			<ul class="menu">
				<li><a href="#" class="tip" title="View Video Tutorial for 'How to Edit your Profile?'"><span class="icon user"></span> Edit Profile </a>
				<li><a href="#" class="tip" title="View Video Tutorial for 'How to Generate Integrated Report?'"><span class="icon graph"></span> Generate IR</a>
				<li><a href="#" class="tip" title="View Video Tutorial for 'How to Generate Lag Report?'"><span class="icon pages"></span> Generate LR</a>
			</ul>
		<!-- Vertical Menu: End -->

	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 25% Box Grid Container: End -->
<!-- // Sidebar Ends -->
<?php
	endif;
?>

<?php if(isset($body)) echo $body; ?>

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
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.tinysort.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shCore.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushXml.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushJScript.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushCss.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/syntaxHighlighter/shBrushPhp.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/fileTree/jqueryFileTree.js"></script> <!-- Added in 1.2 -->
	
	<!-- jQuery Customization -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/custom.js"></script>

</body>

</html>
