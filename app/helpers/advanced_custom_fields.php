<?php
/**
 * Advance Custom Fields related helpers
 * @package helpers/acf
 */



/**
 *
 */
function get_acf($field_name, $post_name = null) {

  if (!empty($post)) {
    $post = get_post_by_slug($post_name);

    if (!empty($post)) {
      return get_field($field_name, $post->ID);
    }
  }

  return get_field($field_name);
}


/**
 *
 */
function field($field_name, $post_name = null) {
  echo get_acf($field_name, $post_name);
}


/**
 *
 */
function acf_option($field_name) {
  echo get_acf_option($field_name);
}


/**
 *
 */
function get_acf_option($field_name) {
  return get_field($field_name, "option");
}


/**
 *
 */
function get_acf_img() {
  # TODO: write this function ...


}


/**
 * Return an acf page
 *
 * @param acf_object $content The acf content object which contains a page's content
 */
function get_acf_page($content) {
  global $post;

  $return = "";

  if (empty($content)) {
    return "";
  }

  foreach ($content as $section) {
    if (!empty($section["heading"])) {
      $section_id = slugify($section['heading']);
      $section_id = "id='section-{$section_id}'";
    }
    else {
      $section_id = "";
    }

    $return  .= "<section class='section' $section_id>";

    switch ($section["acf_fc_layout"]) {
      case "heading":
        $return .= get_acf_heading($section);
        break;

      case "slides":
        $return .= get_acf_slides($section);
        break;

      case "full-width":
        $return .= get_acf_full_width($section);
        break;

      case "two-columns":
        $return .= get_acf_two_columns($section);
        break;

      case "three-columns":
        $return .= get_acf_three_columns($section);
        break;

      default: break;
    }

    $return .= "</section>";
  }

  return strip($return);
}


function get_acf_slides($section) {
  $slides_output = "";

  foreach ($section["slides"] as $index => $slide) {
    $subheading     = !empty($slide["subheading"]) ? "<h2 class='slide__subheading'>{$slide["subheading"]}</h2>" : "";;
    $heading        = !empty($slide["heading"]) ? "<h1 class='slide__heading'>{$slide["heading"]}</h1>" : "";
    $content        = $slide["content"];
    $background_url = !empty($slide["background_image"]) ? get_background_img($slide["background_image"]["url"]): "";

    $slides_output .= "
    <div class='slide'>
      <div class='slide__container'>
        <div class='background slide__background' $background_url></div>
        <div class='content slide__content'>
          $subheading
          $heading
          $content
        </div>
      </div>
    </div>";

  }

  if ($section["display_down_arrow"]) {

    $slide_arrow = get_svg('images/slide-arrow.svg');
    $slide_arrow_background = get_svg('images/slide-arrow-background.svg');
    $slides_arrow_output = "<div class='slides__arrow'>
      <div class='slides__arrow-background'>
        $slide_arrow_background
      </div>
      <a href='#' id='slides__arrow' class='slides__arrow-link'>
        $slide_arrow
      </a>
    </div>
    ";
  }
  else {
    $slides_arrow_output = "";
  }

  $return = "
  <div class='slides'>
    $slides_output
  </div>
  $slides_arrow_output
  ";

  // return trim($return);
  return strip($return);
}


function get_acf_full_width($section) {
  $heading = !empty($section["heading"]) ? "<h1 class='section__heading'>{$section["heading"]}</h1>" : "";
  $col1    = $section["column-1"];
  $arrow   = $section["display_down_arrow"] ? "<div class='section__arrow'>" . get_svg("images/slide-arrow.svg") . "</div>" : "";

  $return = "
  <div class='container content'>
    <h1>$heading</h1>
    <div class='row'>
      <div class='col-12'>$col1</div>
    </div>
    $arrow
  </div>";

  return $return;
}

function get_acf_two_columns($section) {
  $heading = !empty($section["heading"]) ? "<h1 class='section__heading'>{$section["heading"]}</h1>" : "";
  $col1    = $section["column-1"];
  $col2    = $section["column-2"];
  $arrow   = $section["display_down_arrow"] ? "<div class='section__arrow'>" . get_svg("images/slide-arrow.svg") . "</div>" : "";

  if ($section["proportions"] == "left") {
    $col1_size = "col-8";
    $col2_size = "col-4";
  }
  if ($section["proportions"] == "even") {
    $col1_size = "col-6";
    $col2_size = "col-6";
  }
  else if ($section["proportions"] == "right") {
    $col1_size = "col-4";
    $col2_size = "col-8";
  }

  $return = "
  <div class='container content'>
    <h1>$heading</h1>
    <div class='row'>
      <div class='$col1_size'>$col1</div>
      <div class='$col2_size'>$col2</div>
    </div>
    $arrow
  </div>";

  return $return;
}


function get_acf_three_columns($section) {
  $heading = !empty($section["heading"]) ? "<h1 class='section__heading'>{$section["heading"]}</h1>" : "";
  $col1    = $section["column-1"];
  $col2    = $section["column-2"];
  $col3    = $section["column-3"];
  $arrow   = $section["display_down_arrow"] ? "<div class='section__arrow'>" . get_svg("images/slide-arrow.svg") . "</div>" : "";

  $return = "
  <div class='container content'>
    <h1>$heading</h1>
    <div class='row'>
      <div class='col-4'>$col1</div>
      <div class='col-4'>$col2</div>
      <div class='col-4'>$col3</div>
    </div>
    $arrow
  </div>";

  return $return;
}


function get_acf_heading($section) {
  $subheading     = !empty($section["subheading"]) ? "<h2 class='heading__subheading'>{$section["subheading"]}</h2>" : "";;
  $heading        = !empty($section["heading"]) ? "<h1 class='heading__heading'>{$section["heading"]}</h1>" : "";
  $background_url = !empty($section["background_image"]) ? get_background_img($section["background_image"]["url"]): "";

  $return = "
  <div class='heading'>
    <div class='background heading__background' $background_url></div>
    <div class='content heading__content'>
      $subheading
      $heading
    </div>
  </div>";

  return $return;
}


/**
 * Returns the HTML template for an image gallery
 *
 * @param array $images An array of acf images
 * @param array $options An associative array of options to configure the gallery
 *
 * @todo Update to reflect new JQuery plugin
 * @todo Adapt WooCommerce to use new jQuery plugin markup
 * @todo Set the options properly
 *
 */
function get_acf_gallery($images, $options = null) {
  $name = $options["name"];

  $links_output  = "";
  $images_output = "";

  $img_url   = get_img_url($images[0], "large");
  $blank_url = get_base() . "/images/blank.gif";

  for ($i=0; $i < sizeof($images); $i++) {
    $thumbnail_url = get_img_url($images[$i], "thumbnail");
    $fullsize_url  = get_img_url($images[$i], "large");

    $links_output .= "
    <a data-rel='prettyPhoto[product-gallery-$name]' href='$fullsize_url' class='col-sm-2'>
      <img data-src='$thumbnail_url' src='$blank_url'>
    </a>";
  }

  $output = "
    <div class='gallery row'>
      <div class='images'>
        <a itemprop='image' data-rel='prettyPhoto[product-gallery-$name]' href='$fullsize_url'>
          <img data-src='$img_url' src='$blank_url'>
        </a>
      </div>
      <div class='thumbnails row'>
        $links_output
      </div>
    </div>
  ";

  return $output;
}


/**
 * Returns the HTML template for an image gallery
 *
 * @param array $images an array of acf images
 * @param array $options an associative array of options to configure the gallery
 *
 * @todo Set the options properly
 *
 */
function get_acf_carousel($images, $options = null) {
  $links_output  = "";
  $images_output = "";

  for ($i=0; $i < sizeof($images); $i++) {
    $links_output   .= "<li data-target='#album' data-slide-to='$i'></li>";
    $img_tag = get_img_tag($images[0]);

    $active = ($i == 0) ? "active" : "";

    $images_output .= "
      <div class='item $active'>
        $img_tag
      </div>
    ";
  }

  $output = "
    <div class='carousel slide' data-ride='carousel'>
      <ol class='carousel-indicators'>$links_output</ol>
      <div class='carousel-inner' role='listbox'>$images_output</div>
    </div>
  ";

  return $output;
}


function get_acf_excerpt($text, $length = 100) {
  if (empty($text)) {
    return "";
  }

  return substr(strip_tags($text), 0, $length) . " ...";
}


