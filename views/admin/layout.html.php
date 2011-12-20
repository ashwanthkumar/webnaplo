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
	<script type="text/javascript" src="<?php echo option('base_path'); ?>/public/js/jquery.validate.min.js"></script>
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
					<a href="#" class="top icon user"><?php echo get_text('ADMIN'); ?></a>
					
					<!-- User Dropdown Content: Start -->
					<ul class="subnav">  
						<li><a href="<?php echo url_for('admin/advanced/'); ?>" class="icon settings"><?php echo get_text('ADVANCED_SETTINGS'); ?></a></li>
						<li><a href="<?php echo url_for('admin/advanced/import'); ?>" class="icon settings2"><?php echo get_text('ADVANCED_IMPORT_SETTINGS'); ?></a></li>
						<li><a href="<?php echo url_for('admin/advanced/changedayorder'); ?>" class="icon settings2"><?php echo get_text('ADVANCED_CHANGE_DAY_ORDER'); ?></a></li>
			            <li><a href="<?php echo url_for('/user/logout/'); ?>" class="icon lock"><?php echo get_text('LOGOUT'); ?></a></li>  
			        </ul>  
			        <!-- User Dropdown Content: End -->
				</li>
			</ul>
			<!-- User: End -->
			<!-- Width Switcher: Start -->
			<ul id="width" class="dropdown right">
				<li class="topnav">
					<a href="http://www.sastra.edu/" class="top"><?php echo get_text('SASTRA_UNIVERSITY'); ?></a>
				</li>
			</ul>
			<!-- Width Switcher: End -->

		</div>
		<!-- User Panel: End -->
				<!-- Header: Start -->
		<div id="header">
		<!-- Navigation: Start -->
			<ul id="navigation" class="dropdown">
				<li><a class=" <?php if(isset($home_active)) echo "active"; ?>" href="<?php echo url_for('/admin/home'); ?>"> <?php echo get_text('HOME'); ?></a></li>
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<!--
				<li><a class=" <?php if(isset($marks_active)) echo "active"; ?>" href="<?php echo url_for('/admin/modify/'); ?>">Modify Marks</a></li>
				-->
				<!-- Navigation Dropdown Menu Item: End -->
				
				<!-- Navigation Dropdown Menu Item: Start -->
				<li>
					<a class=" <?php if(isset($news_active)) echo "active"; ?>" href="<?php echo url_for('admin/news/'); ?>"><?php echo get_text('NEWS'); ?></a>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->

				<!-- Navigation Dropdown Menu Item: Start -->
				<li>
					<a class=" <?php if(isset($block_active)) echo "active"; ?>" href="<?php echo url_for('admin/block_unblock/'); ?>"><?php echo get_text('BLOCK'); ?></a>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				<!-- Navigation Dropdown Menu Item: Start -->
				<li>
					<a class=" <?php if(isset($lock_active)) echo "active"; ?>" href="<?php echo url_for('admin/lock/'); ?>"><?php echo get_text('LOCK'); ?></a>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->

				<!--
					Edit can be accessed only from the listing
				-->
				<?php if(isset($edit_active)) {
				?>
				<li class="topnav">
					<a class="pages <?php if(isset($edit_active)) echo "active"; ?>" href="#"><?php echo get_text('EDIT'); ?></a>
				</li>
				<?php
					}
				?>
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages <?php if(isset($delete_active)) echo "active"; ?>" href="#"><?php echo get_text('DELETE'); ?></a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
			            <li><a href="<?php echo url_for('/admin/course/delete/'); ?>" class="icon pages"><?php echo get_text('COURSE'); ?></a></li> 
						<li><a href="<?php echo url_for('/admin/department/delete/'); ?>" class="icon laptop"><?php echo get_text('DEPARTMENT'); ?></a></li>  
			            <li><a href="<?php echo url_for('/admin/programme/delete/'); ?>" class="icon archive"><?php echo get_text('PROGRAMME'); ?></a></li>  
			            <li><a href="<?php echo url_for('/admin/staff/delete/'); ?>" class="icon graph"><?php echo get_text('STAFF'); ?></a></li>  
			            <li><a href="<?php echo url_for('/admin/student/delete/'); ?>" class="icon edit"><?php echo get_text('STUDENT'); ?></a></li>  
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
				<!-- Navigation Dropdown Menu Item: Start -->
				<li class="topnav">
					<a class="pages <?php if(isset($list_active)) echo "active"; ?>" href="#"><?php echo get_text('LIST'); ?></a>
					
					<!-- Navigation Dropdown Menu Item Content: Start -->
					<ul class="subnav">
						<li><a href="<?php echo url_for('/admin/staff/list/'); ?>" class="icon laptop"><?php echo get_text('STAFF_LIST'); ?></a></li>  
			            <li><a href="<?php echo url_for('/admin/programme/list/'); ?>" class="icon archive"><?php echo get_text('PROGRAMME_LIST'); ?></a></li>  
			            <li><a href="<?php echo url_for('/admin/course/list/'); ?>" class="icon pages"><?php echo get_text('COURSE_LIST'); ?></a></li> 
			            <!-- <li><a href="<?php echo url_for('/admin/section/list/'); ?>" class="icon edit">Section List</a></li>  -->			            
			       </ul>  
			        <!-- Navigation Dropdown Menu Item Content: End --> 
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->
			        
				</li>
				<!-- Navigation Dropdown Menu Item: End -->

				<!-- Navigation Dropdown Menu Item: Start -->
				<!-- Navigation Dropdown Menu Item: End -->				
			</ul>
			<!-- Navigation: End -->
			
		</div>
		<!-- Header: End -->
		
	</div>
	<!-- Header Grid Container: End -->

<?php
	if(isset($body)) echo $body;
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
	<!-- Custom Admin related JS -->
	<script type="text/javascript" src="<?php echo url_for('admin/js'); ?>"></script>

</body>
<!--[if lte IE 6]><script src="<?php echo url_for('/public/js/ie6/warning.js'); ?>"></script><script>window.onload=function(){e("<?php echo url_for('/public/js/ie6/'); ?>")}</script><![endif]-->
</html>
