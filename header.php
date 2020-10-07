<!DOCTYPE html>
<html lang="fr">
<head>
  <?php wp_head(); ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="<?= get_template_directory_uri(); ?>/styles/main.css">
  <link rel="icon" type="image/png" href="<?= get_template_directory_uri(); ?>/assets/images/favicon.jpg">
  <link rel="shortcut icon" type="image/png" href="<?= get_template_directory_uri(); ?>/assets/images/favicon.jpg">
</head>

<body <?php body_class(); ?>>
  <header id="header">
    <nav class="menu"> 
      <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => 'ul', 'menu_class' => 'menu-items' ) ); ?>
    </nav>
  </header>
