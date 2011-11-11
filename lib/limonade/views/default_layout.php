<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo option('SYSTEM_NAME') . " v" . option('SYSTEM_VERSION'); ?></title>
		<link rel="stylesheet" href="<?php echo url_for('/_lim_css/screen.css');?>" type="text/css" media="screen">
</head>
<body>
  <div id="header">
    <h1>Webnaplo</h1>
  </div>
  
  <div id="content">
    <?php echo error_notices_render(); ?>
    <div id="main">
      <?php echo $content;?>
      <hr class="space">
    </div>
  </div>

</body>
</html>
