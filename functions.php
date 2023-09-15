<?php 
 function theme_cuisine(){
add_theme_support('title-tag');
add_theme_support( 'post-thumbnails', array( 'post' ) );  /** ajout des image de mise en avantdans les post */
 }

function theme_cuisine_assets(){
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css',
    array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
 }
/*
function theme_cuisine_titre ($title){
    $title="salut bienvenue sur ce site de :";     peut s'écrire 
   return  $title ;    return 'salut' . $title 
}
add_filter('wp_title','theme_cuisine_titre');
function test_variable($valeur) {       tester une variable
    var_dump($valeur);die();
}
add_filter('la fonction ou la houk s insere','test_variable');
*/

add_action('after_setup_theme','theme_cuisine');
add_action('wp_enqueue_scripts','theme_cuisine_assets');

