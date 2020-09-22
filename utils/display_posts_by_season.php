<?php

include_once 'format_date.php';

function get_season($date) {
  // Spring
  $spring_start_date = '1970-03-20';
  $spring_end_date = '1970-06-20';
  
  // Summer
  $summer_start_date = '1970-06-21';
  $summer_end_date = '1970-09-21';
  
  // Autumn
  $autumn_start_date = '1970-09-22';
  $autumn_end_date = '1970-12-20';
  
  // Winter
  $winter_start_date = '1970-12-21';
  $winter_end_date = '1970-03-19';
  
  $real_date_year = get_date_year($date);

  $fake_year = '1970';
  $date = $fake_year.substr($date, 4);

  $season = 'Saison inconnue ';
  
  if (date_in_range($spring_start_date, $spring_end_date, $date)) {
    $season = 'Printemps ';
  } else if (date_in_range($summer_start_date, $summer_end_date, $date)) {
    $season = 'Été ';
  } else if (date_in_range($autumn_start_date, $autumn_end_date, $date)) {
    $season = 'Automne ';
  } else if (date_in_range($winter_start_date, $winter_end_date, $date)) {
    $season = 'Hiver ';
  }

  $season .= $real_date_year;

  return $season;
}

function display_posts_by_seasons($category = 'films') {

  $args = [
    'category_name' => $category,
    'posts_per_page' => -1
  ];
  
  if ($category === 'films') {
    $art_word = 'film';
    $art_word_plural = 'films';
    $watched_word = 'visionné';
    $watched_word_plural = 'visionnés';
    $feminin = false;
  } else if ($category === 'livres') {
    $art_word = 'livre';
    $art_word_plural = 'livres';
    $watched_word = 'lu';
    $watched_word_plural = 'lus';
    $feminin = false;
  } else if ($category === 'series') {
    $art_word = 'série';
    $art_word_plural = 'séries';
    $watched_word = 'visionnée';
    $watched_word_plural = 'visionnées';
    $feminin = true;
  } else if ($category === 'culture-generale') {
    $art_word = 'fait de culture générale';
    $art_word_plural = 'faits de culture générale';
    $watched_word = 'appris';
    $watched_word_plural = 'appris';
    $feminin = false;
  }
  
  $posts = get_posts($args);

  $today_date = date('Y-m-d');

  function sort_date_descending($a, $b) {
    return strtotime(get_post_meta($b->ID)['watched_date'][0]) - strtotime(get_post_meta($a->ID)['watched_date'][0]);
  }

  usort($posts, "sort_date_descending");

  $current_season = get_season($today_date);
  $current_season_has_at_least_one_post = false;
  ?>

  <section>
    <h1> <?php echo $current_season ?> </h1>
    <div class="cards">

  <?php

  if (count($posts) === 0) : ?>
  <a class="big-text" href="<?= admin_url( 'post-new.php'); ?>"> Ajouter un<?php echo ($feminin ? 'e' : '') ?> premi<?php echo ($feminin ? 'ère' : 'er') ?> <?= $art_word ?> pour voir vos <?= $art_word ?>s <?= $watched_word_plural ?></a>
  <?php endif;

  foreach ($posts as $post) {
    $pods_fields = get_post_meta($post->ID);
    $post_season = get_season($pods_fields['watched_date'][0]);

    if ($post_season !== $current_season) {
      if ($current_season === get_season($today_date)) {
        $encore = 'encore';
      } else {
        $encore = '';
      }
      $current_season = $post_season;
      if (!$current_season_has_at_least_one_post) {
        $current_season_has_at_least_one_post = false; ?>
        <p class="grey-text"> Pas <?= $encore ?> de <?= $art_word . ' ' . $watched_word ?>s en <?= $current_season ?>  </p>
      <?php } ?>
      </div>
    </section>
    <section>
      <h1> <?= $current_season ?> </h1>
      <div class="cards">
    <?php } else {
      $current_season_has_at_least_one_post = true;
    } ?>

    <!-- Start card HTML -->

    <a href="<?= get_permalink($post) ?>" class="card card-movie">
      <?= get_the_post_thumbnail($post, 'medium_large', ["class" => "card-thumbnail"]) ?>
      <div class="card-title"> <?= get_the_title($post) ?> <span><?= $pods_fields['release_date'][0] ?> </span> </div>
      <div class="card-creators"> De <?= $pods_fields['creator'][0] ?> </div>
      <p class="card-excerpt"> <?= get_the_excerpt($post) ?> </p>
      <span class="card-date"> <?= $watched_word ?> le <?= format_date($pods_fields['watched_date'][0]) ?> </span>
    </a>

    <!-- End card HTML -->

    <?php 
  }
}