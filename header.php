<!DOCTYPE html>
<html <?php language_attributes( ) ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( ); ?>>
    <?php wp_body_open( ); ?>

    <header>
        <div class="logo">
            <img src="<?= get_template_directory_uri(); ?>/assets/logo.png" alt="Logo du crédit agricole">
        </div>
            <div class="titles">
                <h1><?php the_title(); ?></h1>
                <h2><?php the_field('sub_title'); ?></h2>
            </div>
    </header>
