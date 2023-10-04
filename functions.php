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
function cuisine_init(){
    register_taxonomy('type_plats','recette',[
        'labels'=> [
            'name'=> 'type de plat',
            'edit_items'=>'tous les type de plat',
           'add_new_item'=>'Ajouter type de plat',
        ],
        'show_in_rest' => true,
        'hierarchical' => true,
    ]);



    register_taxonomy('type_aliment','ingredient',[
        'labels'=> [
            'name'=> 'type aliment',
            'edit_items'=>'tous les type aliment',
           'add_new_item'=>'Ajouter type aliment',
        ],
        'show_in_rest' => true,
        'hierarchical' => true ,
    ]);

    register_taxonomy('parfum','recette',[
        'labels'=> [
            'name'=> 'Parfum',
            'edit_items'=>'tous les type parfum',
           'add_new_item'=>'Ajouter type parfum',
        ],
        'show_in_rest' => true,
        'hierarchical' => true ,
    ]);

    register_taxonomy('specialite','recette',[
        'labels'=> [
            'name'=> 'specialité',
            'edit_items'=>'tous les type specialité',
           'add_new_item'=>'Ajouter un pays ou une region',
        ],
        'show_in_rest' => true,
        'hierarchical' => true ,
    ]);

    register_post_type('recette',[
        'label' => 'Recettes',
        'public'=>true,
        'menu_position'=> 2,
        'menu_icon'=>'dashicons-welcome-write-blog',
        'supports'=>['title','editor','thumbnail'],
       'show_in_rest' => true,

    ]);
    register_post_type('ingredient',[
        'label' => 'Ingredients',
        'public'=>true,
        'menu_position'=> 2,
    'menu_icon'=>'dashicons-cart',
    'supports'=>['title','editor','thumbnail'],
    'show_in_rest' => true,
    ]);


}

function cuisine_add_custum_box(){

}

add_action('init','cuisine_init');
add_action('after_setup_theme','theme_cuisine');
add_action('wp_enqueue_scripts','theme_cuisine_assets');
add_action('add_meta_boxes','cuisine_add_custum_box');

