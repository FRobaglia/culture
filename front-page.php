<?php get_header(); 

include_once 'utils/format_date.php';

?>


<main> 
  <div class="container"> 
    <h1> Derniers ajouts </h1>
    <div class="cards"> 
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <?php $pods_fields = get_post_meta(get_post()->ID); ?>

      <a href="<?= get_permalink($post) ?>" class="card card-movie">
      <div class="card-content">
        <?= get_the_post_thumbnail($post, 'medium_large', ["class" => "card-thumbnail"]) ?>
        <div class="card-title"> <?= get_the_title($post) ?> <span><?= $pods_fields['release_date'][0] ?> </span> </div>
        <div class="card-creators"> De <?= $pods_fields['creator'][0] ?> </div>
        <p class="card-excerpt"> <?= get_the_excerpt($post) ?> </p>
      </div>
      <div class="card-footer">
        <span class="card-date"> <?= $watched_word ?> le <?= format_date($pods_fields['watched_date'][0]) ?> </span>
      </div>
    </a>

      <?php endwhile; else : ?>
        <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>