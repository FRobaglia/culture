<?php get_header(); ?>

<?php include_once 'utils/display_posts_by_season.php'; 
$category = get_category(get_query_var('cat')); 
?>

<main> 
  <div class="container"> 
    <?php display_posts_by_seasons($category->slug) ?>
  </div>
</main>

<?php get_footer(); ?>