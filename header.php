<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php wp_head() ?> <!--  +wp_footer= insersion nav barr wp -->
</head>

<body>

  <header class="site_header">

    <?php $my_home_url = home_url(); //variable pour url page d acceuil  
    ?>

    <nav>
      <div class="container_navbar">
        <div id="logo">
          <?php
          $custom_logo_id = get_theme_mod('custom_logo');
          $custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'complet'); ?>
          <a href="<?php echo (home_url()); ?>"><?php echo '<img src="' . esc_url($custom_logo_url) . '" alt="logo" class="img_logo">'; ?></a>
        </div>
        <div id="container_line_menu">

          <!-- <button class="line_menu"> -->
          <span id="line_1" class="line"></span>
          <span id="line_2" class="line"></span>
          <span id="line_3" class="line"></span>
          <!--    </button>  -->
        </div>
        <div id="filtre_general">

          <form class="" action="" method="get">
            <button class="" type="submit" title="rechercher"><img src="<?php echo get_template_directory_uri() . '/assets/images/magnifying-glass-solid.svg' ?>" class="Icon Icon_fullscreen" alt=""></button>
            <label class="" for="">Je cherche</label>
            <input name="" id="" type="search" class="" placeholder="une recette, un ingrédient, de l'aide..." data-placeholder="une recette, un ingrédient, de l'aide..." data-alternative-placeholder="Je cherche...">
            <button class="" type="submit" title="rechercher"><img src="<?php echo get_template_directory_uri() . '/assets/images/magnifying-glass-solid.svg' ?>" class="Icon Icon_fullscreen" alt=""></button>


          </form>


        </div>



        <div id="connect">
          <?php if (is_user_logged_in()) : ?> <!--rajout securité -->
            <?php $current_user = wp_get_current_user(); ?>
            <div class="connect_in">

            <p>  <?php echo 'bonjour ' . $current_user->user_login;
              /*  echo 'User email: ' . $current_user->user_email  ;
          echo 'User first name: ' . $current_user->user_firstname ;
          echo 'User last name: ' . $current_user->user_lastname ;
          echo 'User display name: ' . $current_user->display_name ;
          echo 'User ID: ' . $current_user->ID ;*/ ?></br>
              <?php wp_loginout(); ?></p>
            </div>
          <?php else : ?>
            <!-- echo 'pas connecter';-->
            <div class="connect_out">
              <p>Connexion</p>
            </div>
          <?php endif; ?>


        </div><!--affiche la connexion/deconnexion-->





      </div>
      <div class="burger_menu">

        <?php
        wp_nav_menu(['theme_location' => 'header', 'container' => false]) //affichage menu
        ?>

      </div>

      <div id="bloc_login">
        <?php wp_login_form(); ?>
        <a href=" <?php echo  bloginfo('url'); ?>/wp-login.php?action=register"> s'inscrire</a> </br> <!-- lien vers inscription-->
        <!--     formulaire inscription

            <form name="registerform" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post">
              <fieldset>
                <label>Identifiant</label>
                <input type="text" name="user_login" value="" />
                <label>E-mail</label>
                <input type="text" name="user_email" value="" />
                <input type="hidden" name="redirect_to" value="<?php echo get_permalink('208'); ?>" />
                <input type="submit" name="wp-submit" />
              </fieldset>
            </form>    -->
      </div>

    </nav>
  </header>



  <div class="container">