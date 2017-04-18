<?php
/**
 * The template for displaying 404 (not found) pages
 *
 * @package WordPress
 */

?>
<?php get_header() ?>

<div class="sections">
	<section class="section">
		<h1>Page not Found - 404</h1>
		<p>
			Sorry, the page you were looking for does not exist.<br>
			<br>
			<a href="<?php url() ?>">Back to Home</a>
		</p>
	</section>
</div>

<?php get_footer() ?>
