<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="MaterialMardown App on Freedom Framework">
		<meta name="version" content="<?php echo $app->getVersion(); ?>">

		<title><?php echo Scope::$domain->site_name; ?></title>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<link href="http://code.band-x.media/SASS-Material-Design-for-Bootstrap/assets/css/material-bootstrap.min.css" rel="stylesheet">

		<?php if(!empty($app->assets['css'])) { ?>
		<style>

			<?php foreach($app->assets['css'] as $css) echo $css; ?>

		</style>
		<?php } ?>

	</head>
