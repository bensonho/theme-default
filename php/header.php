<!DOCTYPE html>
<!--[if lte IE 7]>
<html class="ie ie7" <?php language_attributes() ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes() ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes() ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />
	<title><?php bloginfo( 'name' ) ?><?php wp_title() ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--[if lt IE 9]>
	<script charset="utf-8" type="text/javascript" src="<?php base() ?>ie.js"></script>
	<![endif]-->

	<?php wp_meta() ?>
	<?php wp_head() ?>

	<?php require_once( 'partials/favicons.php' ) ?>
</head>
<body>
<header>
	<div class="container">
		<div class="logo">
			<a href="/">
				<h1><?php bloginfo( 'name' ) ?></h1>
				<h2><?php bloginfo( 'description' ) ?></h2>
			</a>
		</div>
		<nav>
			<?php navigation() ?>
		</nav>
	</div>
</header>
<div class="container">
