<?php
/**
 * The template for displaying search forms in Boilerplate
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
<form action="<?php echo home_url( '/' ); ?>" role="search" method="get" id="searchform">
	<label for="search" class="visuallyhidden">Search</label>
	<input type="search" name="search" id="search" value="<?php the_search_query(); ?>" placeholder="search..." />
	<input type="submit" id="searchsubmit" value="Search" />
</form>