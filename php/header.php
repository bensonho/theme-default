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
	<title><?php bloginfo( 'name' ) ?><?php wp_title() ?></title>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta name="viewport" content="maximum-scale=1,width=device-width">
	<?php wp_meta() ?>
	<?php wp_head() ?>
	<?php require_once( 'partials/favicons.php' ) ?>
</head>
<body>
<header>
	<div class="container">
		<div class="logo">
			<a class="logo__link" href="<?php url() ?>">
				<h1 class="logo__title"><?php bloginfo( 'name' ) ?></h1>
				<h2 class="logo__tagline"><?php bloginfo( 'description' ) ?></h2>
			</a>
		</div>
		<nav class="navigation">
			<?php navigation( 'header' ) ?>
		</nav>
	</div>
</header>
