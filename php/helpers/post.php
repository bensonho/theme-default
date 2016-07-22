<?php

/**
 * Post related helpers
 * @package helpers/post
 */

/**
 * Find a page by its slug
 *
 * @param $slug slug to search against
 * @param $postType post type to search against
 */
function get_post_by_slug($slug, $postType = "page") {
    $args = array("name" => $slug, "post_type" => $postType, "posts_per_page" => 1);

    $posts = get_posts($args);

    return empty($posts) ? null : $posts[0];
}

function get_post_content_by_slug($slug, $postType = "page") {
    $post = get_post_by_slug($slug, $postType);

    return isset($post) ? $post->post_content : "";
}

function post_content_by_slug($slug, $postType = "page") {
    echo get_post_content_by_slug($slug, $postType);
}

/**
 * Get all the children of a page
 *
 * @param $parent_id parent id to search against
 * @param $postType post type to search against
 */
function get_post_children($parent_id, $postType = "page") {
    $args = array(
        "post_parent"    => $parent_id,
        "post_type"      => $postType,
        "posts_per_page" => -1,
        "orderby"        => "menu_order",
        "order"          => "asc");

    $posts = get_posts($args);

    return empty($posts) ? null : $posts;
}

/**
 * Return the categories of a post id
 *
 * @param $post_id Post id to search against
 */
function get_categories_by_post_id($post_id) {
    $values = array();
    $categories = wp_get_post_categories($post_id);

    foreach ($categories as $category) {
        $category = get_category($category);
    }
    return $values;
}

/**
 * Return a page's or post's content
 *
 * @param object $content The post content of a page or post
 */
function get_content($content = null) {
    global $post;

    $page = isset($page) ? $page : $post;
    $content = isset($content) ? $content : $page->post_content;

    return do_shortcode($content);
}

/**
 * Return a page's or post's content
 *
 * @param object $content The post content of a page or post
 */
function content($content = null) {
    echo get_content($content);
}

/**
 * Return the HTML template of a page's or post's content
 *
 * @param page $page The page. If a page is not provided, the global post will be attempted to be found.
 */
function get_the_page($page = null) {
    global $post;

    $page = isset($page) ? $page : $post;
    $title = $page->post_title;
    $text = "";
    $breadcrumb = get_breadcrumb($page);
    $slug = $page->post_name;

    if (function_exists("get_field")) {
        $content = get_field("content", $page->ID);
        $text = get_acf_page($content);
    }
    else {
        $text = get_content($page->post_content);
    }

    // $text = get_content($page->post_content);

    $output = "
    $text
  ";

    return strip($output);
}

/**
 * Output the HTML template of a page's or post's content.
 *
 * @param page $page The page. If a page is not provided, the global post will be attempted to be found.
 */
function page($page = null) {
    echo get_the_page($page);
}


/**
 *
 */
function featured_image($size = "", $block_name = "") {
    echo get_the_thumbnail(null, $size, $block_name);
}


/**
 *
 */
function the_thumbnail($size = "", $block_name = "") {
    echo get_the_thumbnail(null, $size, $block_name);
}


/**
 *
 */
function get_the_thumbnail($post_id, $size = "", $block_name = "") {
    $output = "";
    $image_url = get_the_thumbnail_url($post_id, $size);

    if (!empty($image_url)) {
        $class_name.= $size == "" ? "" : " image__{$size}";
        $class_name.= $block_name == "" ? "" : " {$block_name}__image";

        $output = "<img src='$image_url' class='image $class_name'>";
    }

    return $output;
}


/**
 *
 */
function get_the_thumbnail_url($post_id, $size = "", $block_name = "") {
    $post_id = null === $post_id ? get_the_ID() : $post_id;
    $thumbnail_id = get_post_thumbnail_id($post_id);
    $return = "";

    if ($thumbnail_id) {
        $image = wp_get_attachment_image_src($thumbnail_id, $size);
        $return = $image[0];
    }

    return $return;
}


/**
 *
 */
function thumbnail_url($post_id, $size = "") {
    echo get_the_thumbnail_url($post_id, $size = "");
}

