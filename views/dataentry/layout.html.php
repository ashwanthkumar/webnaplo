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
	
	<!-- IE Canvas Fix for Visualize Charts - Added in 1.1 -->
	<!--[if IE]><script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/excanvas.js"></script><![endif]-->
	
	<!-- jQuery thats loaded before document ready to prevent flickering - Rest are found at the bottom -->
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.styleswitcher.js"></script>
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.visualize.js"></script>
	
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
					<a href="#" class="top icon user">Data Entry User</a>
					
					<!-- User Dropdown Content: Start -->
					<ul class="subnav">  
			            
			            <li><a href="<?php echo url_for('/user/logout/'); ?>" class="icon lock">Log out</a></li>  
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
				<li><a class="dashboard <?php if(isset($home_active)) echo "active"; ?>" href="<?php echo url_for('/dataentry/home/'); ?>"> Home</a></li>
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="frames <?php if(isset($add_active)) echo "active"; ?>" href="#">Add</a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
					    <li><a href="<?php echo url_for('/dataentry/course/add/'); ?>" class="icon blocks">Course</a></li>  
						<li><a href="<?php echo url_for('/dataentry/department/add/'); ?>" class="icon typography">Department</a></li> 
						<li><a href="<?php echo url_for('/dataentry/programme/add/'); ?>" class="icon blocks">Programme</a></li>  
						<li><a href="<?php echo url_for('/dataentry/section/add/'); ?>" class="icon blocks">Section</a></li>  
						<li><a href="<?php echo url_for('/dataentry/staff/add/'); ?>" class="icon blocks">Staff</a></li>
						<li><a href="<?php echo url_for('/dataentry/student/add/'); ?>" class="icon blocks">Student</a></li>
					</ul> 
			        <!-- Navigation Dropdown Menu Item Content: End --> 
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages <?php if(isset($edit_active)) echo "active"; ?>" href="#">Edit</a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
			            <li><a href="<?php echo url_for('/dataentry/course/edit/'); ?>" class="icon pages">Course</a></li> 
						<li><a href="<?php echo url_for('/dataentry/department/edit/'); ?>" class="icon laptop">Department</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/programme/edit/'); ?>" class="icon archive">Programme</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/staff/edit/'); ?>" class="icon graph">Staff</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/student/edit/'); ?>" class="icon edit">Student</a></li>  
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages <?php if(isset($delete_active)) echo "active"; ?>" href="#">Delete</a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
			            <li><a href="<?php echo url_for('/dataentry/course/delete/'); ?>" class="icon pages">Course</a></li> 
						<li><a href="<?php echo url_for('/dataentry/department/delete/'); ?>" class="icon laptop">Department</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/programme/delete/'); ?>" class="icon archive">Programme</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/staff/delete/'); ?>" class="icon graph">Staff</a></li>  
			            <li><a href="<?php echo url_for('/dataentry/student/delete/'); ?>" class="icon edit">Student</a></li>  
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages <?php if(isset($list_active)) echo "active"; ?>" href="#">List</a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
						<li><a href="stafflist.html" class="icon laptop">Staff List</a></li>  
			            <li><a href="pgmlist.html" class="icon archive">Programme List</a></li>  
			            <li><a href="courselist.html" class="icon pages">Course List</a></li> 
			            <li><a href="section.html" class="icon edit">Section List</a></li>  
			            
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				
			</ul>
			<!-- Navigation: End -->
			
		</div>
		<!-- Header: End -->
		
		<!-- Breadcrumb Bar: Start -->
		<div id="breadcrumb">
			
			<!-- Breadcrumb: Start -->
			<ul class="left">
				<li class="icon dashboard"><a href="#">Data Entry User</a></li>
			</ul>
			<!-- Breadcrumb: End -->
			
			<!-- Breadcrumb Icon Links: Start -->
			<ul class="right">
				<li><a href="#" class="icon support tip" title="FAQ">FAQ</a></li>
				<li><a href="#" class="icon home tip" title="Home">Home</a></li>
			</ul>
			<!-- Breadcrumb Icon Links: End -->
			
		</div>
		<!-- Breadcrumb Bar: End -->
		
	</div>
	<!-- Header Grid Container: End -->
<!-- InstanceBeginEditable name="EditRegion1" -->
<?php

	// Render the layout template
	if(isset($body)) echo $body;
?>

<!-- Footer Grid: Start -->
<div class="grid_24">

	<!-- Footer: Start -->
	<div id="footer">
		
		<p class="left">
			Copyright &#169; 2011 <a href="#">Team WebNaplo</a>. 
			Powered by <a href="#">WN Framework</a>.
		</p>
		
		<!-- Footer Icon Navigation: Start -->
		<ul class="right">
			<li><a href="#" class="icon dashboard tip active" title="Dashboard">Dashboard</a></li>
			<li><a href="#" class="icon pages tip" title="Pages">Pages</a></li>
			<li><a href="#" class="icon users tip" title="Users">Users</a></li>
			<li><a href="#" class="icon settings tip" title="Settings">Settings</a></li>
			<li><a href="#" class="icon support tip" title="Support">Support</a></li>
			<li><a href="#" class="icon home tip" title="Home">Home</a></li>
		</ul>
		<!--Footer Icon Navigation: End -->
		
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