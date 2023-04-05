<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title><?php echo $_ENV["APP_NAME"] ?></title>
	<meta name="author" content="<?php echo $_ENV["APP_AUTHOR"] ?>">
	<meta name="description" content="<?php echo $_ENV["APP_DESC"] ?>">

	<link rel="shortcut icon" href="<?php echo route['a'] ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo route['a'] ?>favicon.ico" type="image/x-icon">

	<?php include(root['s'] . 'styles.php'); ?>
	<?php include(root['s'] . 'libs.php'); ?>
</head>
<style>
	.body-login {
		background-image: url('<?php echo route['i'] . $css['body-bg'] ?>');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: cover;
	}
</style>
<body class="<?php echo $css['body'] ?? null ?>">