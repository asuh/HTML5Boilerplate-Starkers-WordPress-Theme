<form action="<?php echo home_url( '/' ); ?>" role="search" method="get" id="searchform">
    <fieldset>
        <label for="search">Search in <?php echo home_url( '/' ); ?></label>
        <input type="search" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="search..." />
        <input type="submit" id="searchsubmit" value="Search" />
    </fieldset>
</form>