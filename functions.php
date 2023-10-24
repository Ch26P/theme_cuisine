<?php 
 function theme_cuisine(){
add_theme_support('title-tag');
add_theme_support( 'post-thumbnails', array( 'post' ) );  /** ajout des image de mise en avant dans les post */
add_theme_support( 'post-thumbnails', array( 'recette' ) );/** ajout des image de mise en avant dans recettes */
add_theme_support( 'post-thumbnails', array( 'ingredient' ) );/** ajout des image de mise en avant dans ingredient */
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


    register_post_type('recette',[
        'label' => 'Recettes',
        'public'=>true,
        'menu_position'=> 1,
       
        
        'menu_icon'=>'dashicons-welcome-write-blog',
        'supports'=>['thumbnail','title','editor','revisions','author','comments','excerpt','post-formats', 'page-attributes' ],
        
        /*   */ 
       'show_in_rest' => true,
       'has_archive'=>true,

    ]);
    register_post_type('ingredient',[
        'label' => 'Ingredients',
        'public'=>true,
        'menu_position'=> 2,
    'menu_icon'=>'dashicons-cart',
    'supports'=>['title','editor','thumbnail'],
    'show_in_rest' => true,
    ]);


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




}
/*metabox choix des ingredient*/
function cuisine_add_custum_box(){
add_meta_box('cuisine_ingredients_quantite','choisir les ingrédients et la quantité associé','cuisine_remplir_quantite_ingredients_box','recette','side');
}
function cuisine_remplir_quantite_ingredients_box(){
   if(have_posts()): 
     while(have_posts()):the_post();?>
   
   
    <input type='checkbox' value=''name='Ingredient'>
    <label for='ingredients'>Le nom de l'ingredients</label>
    
    <?php   endwhile ?>   

<?php else: ?>
    <p>Pas d'ingredients enregistré</p>
<?php endif; 
}


add_action('init','cuisine_init');
add_action('after_setup_theme','theme_cuisine');
add_action('wp_enqueue_scripts','theme_cuisine_assets');
add_action('add_meta_boxes','cuisine_add_custum_box');// Ajout metabox 



/*filtrer les nom des colonnes de "Recettes" */
add_filter('manage_recette_posts_columns',function($columns){
    return[
        'cb'=>$columns['cb'],
        'thumbnail'=>'Miniature',
        'title'=>$columns['title'],
    
    'author'=>$columns['author'],
    
    'taxonomy'=>'type_plats',
    'date'=>$columns['date'],
    ];
    });

    add_filter('manage_recette_posts_custom_column',function($column,$postId){
        if ($column ==='thumbnail'){
            the_post_thumbnail('thumbnail', $postId); }
    

       
           /* if ($column ==='type_plats'){
                echo 'bonjour'; }*/
            } , 10,2);
    