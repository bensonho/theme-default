<?php
/**
 * Helpers that generate HTML tags
 * @package helpers/tag
 */


/**
 * Outputs a html link
 *
 * @param string $text The text for the link
 * @param string $url The url of the link
 * @param array $options An associative array of options to configure the link
 *
 */
function link_to($text, $url, $options = null) {
	global $translations;

	$class  = isset($options["class"]) ? "class={$options['class']}" : "";
	$target = isset($options["target"]) ? "target={$options['target']}" : "";

	echo "<a href='$url' $class $target>$text</a>";
}


/**
 * Return a url relative to the website
 *
 * @param string $url The url of the website
 * @param string $language_code the language code of the website
 *
 */
function get_url($url = "") {
	return get_site_url() . $url;
}


/**
 * Outputs a url relative to the website
 *
 * @param string $url The url of the website
 * @param string $language_code the language code of the website
 *
 */
function url($url = "") {
	echo get_url($url);
}


/**
 * Returns the base URL
 */
function get_base($url = "") {
	return get_template_directory_uri() . $url;
}


/**
 * Outputs the base path of the website
 */
function base($url = "") {
	echo get_base($url);
}


/**
 * Output a HTML image tag
 *
 * @param array $images An array of acf images
 * @param array $options An associative array of options to configure the image tag
 *
 * @todo Reevaluate this function
 */
function img_tag($image, $options = null) {
	echo get_img_tag($image, $options);
}


/**
 * Return a HTML image tag
 *
 * @param array $image An array of acf images
 * @param array $options An associative array of options to configure the image tag
 *
 * @todo Reevaluate this function
 */
function get_img_tag($image, $options = null) {
	$image_size  = isset($options["image_size"]) ? $options["image_size"] : "large";
	$render_div  = isset($options["render_div"]) && $options["render_div"] == true;

	$url = get_img_url($image, $image_size);

	if ($render_div) {
		return "<div class='image' style='background-image: url($url)'></div>";
	}
	else {
		return "<img src='$url' class='img'>";
	}
}


/**
 * Return the absolute url of an image
 *
 * @param array $images An array of acf images
 * @param array $size size of the image
 *
 * @todo Reevaluate this function
 */
function get_img_url($images, $size) {
	if (empty($images)) {
		return;
	}
	else {
		return $images;
	}
}


/**
 * Outputs the contents of an SVG file
 *
 * @param string $url the url of the svg
 */
function svg($url) {
	echo get_svg($url);
}


/**
 * Returns the contents of an SVG file. In the case of ie8, output the png equivalent in the same directory
 *
 * @param string $url the url of the svg
 */
function get_svg($url, $dimensions = null) {

	$theme_dir = get_base();

	$png = str_replace(".svg", ".png", $url);

	$width  = isset($dimensions) ? $dimensions[0] : "";
	$height = isset($dimensions) ? $dimensions[1] : "";

	$return  = "<!--[if gte IE 9]><!-->";
	$return .= file_get_contents("$theme_dir/$url", true);
	$return .= "<![endif]-->";
	$return .= "<!--[if lte IE 8]><img width='$width' height='$height' src='$theme_dir/$png' class='svg_png'><![endif]-->";

	return $return;
}


/**
 *
 */
function get_background_img($url = null) {
	$return = "";

	if (empty($url)) {
		$url = get_the_thumbnail_url($post->ID);
	}

	if (!empty($url)) {
		$return = " style='background-image: url($url)'";
	}

	return $return;
}



/**
 *
 */
function background_img($url = null) {
	// TODO: have it so that if there are no arguments, grab the image from the current post
	echo get_background_img($url);
}

