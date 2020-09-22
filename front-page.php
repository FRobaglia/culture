<?php get_header(); 

include_once 'utils/format_date.php';

?>


<main> 
  <div class="container"> 
    <h1>  Accueil </h1>
    <div class="cards"> 
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <?php $pods_fields = get_post_meta(get_post()->ID); ?>

        <a href="<?php the_permalink() ?>" class="card card-movie">
          <?php the_post_thumbnail('medium_large', ["class" => "card-thumbnail"]) ?>
          <div class="card-title"> <?php the_title() ?> <span><?php echo $pods_fields['release_date'][0] ?> </span> </div>
          <div class="card-creators"> De <?php echo $pods_fields['creator'][0] ?> </div>
          <div class="card-excerpt"> <?php the_excerpt() ?> </div>
          <span class="card-date"> Le <?php echo format_date($pods_fields['watched_date'][0]) ?> </span>
        </a>

      <?php endwhile; else : ?>
        <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>