<?php

/* Set PHP locale to french */

setlocale(LC_TIME, 'fr', 'fr_FR.UTF-8');

/* Enable Featured images */

add_theme_support( 'post-thumbnails' );

/* Menu */

function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' )
    )
  );
}

add_action( 'init', 'register_my_menus' );
?>