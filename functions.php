<?php
function theme_cuisine()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails', array('post', 'recette', 'ingredient'));



    add_theme_support('menus');

    register_nav_menu('header', 'En tete');
    register_nav_menu('footer', 'pied de page');

    if (function_exists('register_sidebar'))
        register_sidebar();



    /** ajout des image de mise en avant dans les post */
    /** add_theme_support( 'post-thumbnails', array( 'recette' ) );ajout des image de mise en avant dans recettes */
    /**add_theme_support( 'post-thumbnails', array( 'ingredient' ) ); ajout des image de mise en avant dans ingredient */
}/*verifier les fonctions a installé ex:htlm5 ?*/
// Passer les variables PHP au script JavaScript

// Dans functions.php ou dans le fichier où vous enregistrez vos scripts


function theme_cuisine_assets()
{
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_directory_uri() . '/sass/theme.css',
        array(),
        filemtime(get_stylesheet_directory() . '/sass/theme.css')
    );
    wp_enqueue_script('jquery', "//code.jquery.com/jquery-1.12.0.min.js");
    wp_enqueue_script('modal-login', get_stylesheet_directory_uri() . '/js/modal_login.js', [], 1.0, true);
    //////////////////////////////




    //wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);

    //**calendrier js */
    //  wp_enqueue_script('creat_calender', get_stylesheet_directory_uri() . '/js/calender.js', [], 1.0, true);
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
function cuisine_init()
{


    register_post_type('recette', [
        'label' => 'Recettes',
        'public' => true,
        'menu_position' => 2,


        'menu_icon' => 'dashicons-welcome-write-blog',
        'supports' => ['thumbnail', 'title',/*'editor',*/ 'revisions', 'author', 'comments', 'excerpt', 'post-formats', 'page-attributes'],

        /*   */
        'show_in_rest' => true,
        'has_archive' => true,

    ]);
}



add_action('init', 'cuisine_init');
add_action('after_setup_theme', 'theme_cuisine');
add_action('wp_enqueue_scripts', 'theme_cuisine_assets');
//add_action('add_meta_boxes', 'cuisine_add_custum_box'); // Ajout metabox 



//filtrer les nom des colonnes de "Recettes" 
/**/
add_filter('manage_recette_posts_columns', function ($columns) {
    //  var_dump($columns);die;
    return [
        'cb' => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title' => $columns['title'],


        //  'taxonomy-specialite' => 'specialité',
        //  'taxonomy-type_plats' =>  'type_plats',
        'author' => $columns['author'],
    ];
});
add_filter('manage_recette_posts_custom_column', function ($column, $postId) {

    if ($column === 'thumbnail') {
        the_post_thumbnail('thumbnail', $postId);
    }
}, 10, 2);



//////////////////////////////////hook connexion et deconexion//////////////////////////////////////////


function eloou_login($user_login, $user) {}

add_action('wp_login', 'eloou_login', 10, 2);




function eloou_logout()
{

    wp_redirect("http://localhost/cuisine/");  ////redirection vers la page d'accueil ///A MODIFIER
    exit();
}
add_action('wp_logout', 'eloou_logout');




/////////////////////////////////////////////////////////essai de redirection pour la page d inscription/////////////////////////////////////////////////////////////////////

/*function erreur_connection( $user, $error  ) {

} ;

add_action( 'wp_login_failed', 'erreur_connection',  );


*/







add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('admin_cuisine', get_template_directory_uri() . '/assets/admin.css');
});
///////////////////////////////////////////////////////* fonction pour *///////////////////////////////////////////
/*
function get_taxo_ingredient() {
    // Vérifier que l'utilisateur est connecté
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Utilisateur non autorisé.'));
        return;
    }

    // Récupérer les termes de la taxonomie 'taxo-ingredient'
    $terms = get_terms(array(
        'taxonomy' => 'taxo-ingredient',
        'hide_empty' => false,
    ));

    if (is_wp_error($terms)) {
        wp_send_json_error(array('message' => 'Erreur lors de la récupération des ingrédients de la taxonomie.'));
        return;
    }

    // Formatage des termes pour le retour
    $ingredient_list = array();
    foreach ($terms as $term) {
        $ingredient_list[] = array(
            'id' => $term->term_id,
            'name' => $term->name,
        );
    }

    wp_send_json_success($ingredient_list);
}
add_action('wp_ajax_get_taxo_ingredient', 'get_taxo_ingredient');
/////////////////////////////////////////////////////////////////////////

// Fonction pour récupérer les termes de la taxonomie 'taxo-unite-mesure'
function get_taxo_unite_mesure() {

     // Récupérer les termes de la taxonomie 'taxo-ingredient'
    $terms = get_terms(array(
        'taxonomy' => 'taxo-unite-mesure',
        'hide_empty' => false,
    ));

    if (is_wp_error($terms)) {
        wp_send_json_error(array('message' => 'Erreur lors de la récupération des ingrédients de la taxonomie.'));
        return;
    }

    // Formatage des termes pour le retour
    $mesure_list = array();
    foreach ($terms as $term) {
        $mesure_list[] = array(
            'id' => $term->term_id,
            'name' => $term->name,
        );
    }

    wp_send_json_success($mesure_list);
}

add_action('wp_ajax_get_taxo_unite_mesure', 'get_taxo_unite_mesure');
add_action('wp_ajax_nopriv_get_taxo_unite_mesure', 'get_taxo_unite_mesure');

*/


//////////////////////////////////////////////////calandrier/////////////////////////////////////////////////////////////////////




function enqueue_custom_scripts()
{
    wp_enqueue_script('display-toggle', get_template_directory_uri() . '/js/display-toggle.js', array('jquery'), null, true);
    // Enregistre le script JavaScript et le localise avec des variables PHP
    wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/calender.js', array('jquery'), null, true);


 // Déterminer si l'utilisateur est connecté
 //$user_id = is_user_logged_in() ? get_current_user_id() : 0;

    // Localise le script avec des variables PHP
    wp_localize_script('my-custom-script', 'pageData', array(
        'ajaxurl' => admin_url('admin-ajax.php'), // URL AJAX pour WordPress
        'pageTitle' => get_the_title(),
        'pageId' => get_the_ID(),
        'nonce' => wp_create_nonce('save_meals_nonce'), // Ajoute un nonce pour la sécurité
      //   'userId' => $user_id // Ajoute l'ID de l'utilisateur si connecté, sinon 0
        'userId' => get_current_user_id(), // Ajoute l'ID de l'utilisateur



       // 'originalCount' => isset($list_champs['recette_pour']) ? intval($list_champs['recette_pour']) : 1 // Ajoute le nombre d'origine

        
        
    ));
    

    wp_enqueue_script('shopping-list-script', get_template_directory_uri() . '/js/shopping-list.js', array('jquery'), null, true);
    wp_enqueue_script('updateQuantities-script', get_template_directory_uri() . '/js/updateQuantities.js', array('jquery'), null, true);



}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');




function save_meal()
{
    global $wpdb;
    check_ajax_referer('save_meals_nonce', 'nonce');

    // Vérifier si l'utilisateur est connecté
        if (! is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté pour ajouter un repas.');
        return;
    }

    // Récupérer les données du POST
    $user_id = intval($_POST['userId']);
    $page_id = intval($_POST['pageId']);
    $meal_date = sanitize_text_field($_POST['mealDate']);
    $meal_type = sanitize_text_field($_POST['mealType']);
    $meal_name = sanitize_text_field($_POST['mealName']);
    $number_of_people = intval($_POST['numberOfPeople']);

    // Préparer et exécuter la requête d'insertion
    $table = $wpdb->prefix . 'planned_meals';
    $wpdb->insert(
        $table,
        array(
            'user_id' => $user_id,
            'page_id' => $page_id,
            'meal_date' => $meal_date,
            'meal_type' => $meal_type,
            'meal_name' => $meal_name,
            'number_of_people' => $number_of_people,
        ),
        array(
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%d'
        )
    );

    if ($wpdb->insert_id) {
        wp_send_json_success('Repas enregistré avec succès.');
    } else {
        wp_send_json_error('Erreur lors de l\'enregistrement du repas2.');
    }
}
add_action('wp_ajax_save_meal', 'save_meal');


//////////////////////////////////////*ok jusqu ici*////////////////////////////// 



// Enregistrement de l'API REST pour récupérer les repas
function get_meals()
{
    global $wpdb;
    $table = $wpdb->prefix . 'planned_meals'; // Nom de la table avec préfixe

    // Vérification que l'utilisateur est connecté
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Utilisateur non autorisé.'));
        return;
    }

    // Récupérer l'ID de l'utilisateur actuel
    $user_id = get_current_user_id();




    // Préparez la requête SQL
    $query = "SELECT * FROM $table WHERE user_id = %d";
    $results = $wpdb->get_results(
        $wpdb->prepare($query, $user_id),
        ARRAY_A
    );
    // Log pour vérifier les résultats
    // error_log(print_r($results, true));

    // Préparer les repas pour la réponse JSON
    $meals = array();
    if (!empty($results)) {
        foreach ($results as $row) {
            // Ajouter les repas au tableau de résultats avec des clés spécifiques
            $meals[$row['meal_date']][$row['meal_type']][] = array(
                'name' => $row['meal_name'], // Correction du nom de la colonne pour correspondre à la base de données
                'page_id' => $row['page_id'], // ID de la page
                'pers' => $row['number_of_people'], // Nombre de personnes
                'id' => $row['id'],
            );
        }
    }

    wp_send_json_success($meals);
}
add_action('wp_ajax_get_meals', 'get_meals');


///////////////////////////////////////////*ok jusque la *////////////////////////////////////////////


// Fonction pour supprimer un repas
function delete_meal() {
    global $wpdb;
    check_ajax_referer('save_meals_nonce', 'nonce');

    // Vérifier si l'utilisateur est connecté
    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté pour supprimer un repas.');
        return;
    }

    // Récupérer l'ID du repas à supprimer
    $meal_id = intval($_POST['mealId']);

    // Préparer et exécuter la requête de suppression
    $table = $wpdb->prefix . 'planned_meals';
    $deleted = $wpdb->delete($table, array('id' => $meal_id), array('%d'));

    if ($deleted !== false) {
        wp_send_json_success('Repas supprimé avec succès.');
    } else {
        wp_send_json_error('Erreur lors de la suppression du repas.');
    }
}
add_action('wp_ajax_delete_meal', 'delete_meal');


////////////////////////////////////////////////////*ok jusque la  */////////////////////////////////////////////////////////
function get_ingredients() {
    global $wpdb;

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Utilisateur non autorisé.'));
        return;
    }

    $page_id = 1070; // ID de la page que nous voulons récupérer
    $fields = get_fields($page_id); // Récupérer les champs personnalisés

    if (!$fields) {
        wp_send_json_error(array('message' => 'Aucun champ trouvé.'));
        return;
    }

    $ingredients = [];

    // Récupérer le nombre de personnes
    if (isset($fields['recette_pour'])) {
        $ingredients['recette_pour'] = esc_html($fields['recette_pour']);
    }

    // Tableau pour stocker les ingrédients
    $ingredientsList = [];

    // Parcourir les étapes et les ingrédients
    if (isset($fields['nbresetapes'])) {
        foreach ($fields['nbresetapes'] as $step) {
            foreach ($step as $ingredientIndex => $ingredient) {
                if (preg_match('/etape_\d+_ingredient_\d+/', $ingredientIndex)) {
                    $term = get_term($ingredient['choix_de_lingredient'], "taxo-ingredient");
                    // Vérifier si le terme existe avant de l'ajouter
                    if ($term && !is_wp_error($term)) {
                        $currentIngredient = [
                            'name' =>  html_entity_decode(esc_html($term->name)),
                            'quantity' => $ingredient['quantite_1_group_1'],
                            'unit' => $ingredient['unite_mesure']
                        ];
                        $ingredientsList[] = $currentIngredient;
                    }
                }
            }
        }
    }

    // Ajouter la liste des ingrédients au tableau final
    $ingredients['ingredients'] = $ingredientsList;

    wp_send_json_success($ingredients);
}
add_action('wp_ajax_get_ingredients', 'get_ingredients');

function get_ingredients_for_recipes() {
    global $wpdb;

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Utilisateur non autorisé.'));
        return;
    }

    // Vérifier que nous avons des IDs de recettes
    $recipe_ids = isset($_POST['recipe_ids']) ? json_decode(stripslashes($_POST['recipe_ids']), true) : null;

    if (!$recipe_ids) {
        wp_send_json_error(array('message' => 'Aucun ID de recette trouvé.'));
        return;
    }

    $ingredients = [];

    // Parcourir chaque recette
    foreach ($recipe_ids as $recipe) {
        $page_id = intval($recipe['id']); // ID de la recette
        $number_of_people = intval($recipe['number_of_people']); // Nombre de personnes prévu

        // Récupérer les champs de la recette
        $fields = get_fields($page_id);

        if (!$fields) {
            continue; // Passer à la recette suivante si aucune donnée n'est trouvée
        }

        // Récupérer le nombre de personnes de la recette
        $recette_pour = isset($fields['recette_pour']) ? esc_html($fields['recette_pour']) : 1;

        // Tableau pour stocker les ingrédients
        $ingredientsList = [];

        // Parcourir les étapes et les ingrédients
        if (isset($fields['nbresetapes'])) {
            foreach ($fields['nbresetapes'] as $step) {
                foreach ($step as $ingredientIndex => $ingredient) {
                    if (preg_match('/etape_\d+_ingredient_\d+/', $ingredientIndex)) {
                        $term = get_term($ingredient['choix_de_lingredient'], "taxo-ingredient");
                        if ($term && !is_wp_error($term)) {
                            // Calculer la quantité ajustée
                            $originalQuantity = floatval($ingredient['quantite_1_group_1']);
                            $adjustedQuantity = $originalQuantity * ($number_of_people / $recette_pour); // Ajustement

                            $currentIngredient = [
                                'name' => html_entity_decode(esc_html($term->name)), // Ici, on applique la transformation
                                'quantity' => $adjustedQuantity,
                                'unit' => $ingredient['unite_mesure']
                            ];
                            $ingredientsList[] = $currentIngredient;
                        }
                    }
                }
            }
        }

        // Ajouter les ingrédients de la recette au tableau final
        $ingredients[] = [
            'recipe_id' => $page_id,
            'ingredients' => $ingredientsList,
            'original_servings' => $recette_pour,
            'requested_servings' => $number_of_people
        ];
    }

    wp_send_json_success($ingredients);
}
add_action('wp_ajax_get_ingredients_for_recipes', 'get_ingredients_for_recipes');



///////////////////////////////////////////////////////////////////*ok jusque la */////////////////////////////////////////////////////////
/*
// Enregistrer l'action AJAX
add_action('wp_ajax_get_taxo_ingredients', 'get_taxo_ingredients');
add_action('wp_ajax_nopriv_get_taxo_ingredients', 'get_taxo_ingredients'); // Pour les utilisateurs non connectés

function get_taxo_ingredients() {
    // Récupérer les termes de la taxonomie
    $terms = get_terms(array(
        'taxonomy' => 'taxo-ingredient',
        'hide_empty' => false, // Inclure les termes vides
    ));

    // Retourner les termes sous forme de JSON
    if (!is_wp_error($terms)) {
        wp_send_json_success($terms);
    } else {
        wp_send_json_error('Erreur lors de la récupération des termes.');
    }
}
    */


    function get_taxo_ingredients() {
        // Vérification de la requête AJAX pour des raisons de sécurité
        if (isset($_POST['action']) && $_POST['action'] === 'get_taxo_ingredients') {
            
            // Récupération des termes de la taxonomie 'taxo-ingredient'
            $terms = get_terms([
                'taxonomy' => 'taxo-ingredient',
                'hide_empty' => false, // Récupère tous les termes, même ceux sans contenu
            ]);
    
            if (!empty($terms) && !is_wp_error($terms)) {
                // Préparation des données avec parent et grand-parent
                $taxonomies = [];
    
                foreach ($terms as $term) {
                    $parent = null;
                    $grandparent = null;
    
                    // Récupérer le parent si disponible
                    if ($term->parent != 0) {
                        $parent_term = get_term($term->parent, 'taxo-ingredient');
                        $parent = $parent_term->name;
    
                        // Récupérer le grand-parent si disponible
                        if ($parent_term->parent != 0) {
                            $grandparent_term = get_term($parent_term->parent, 'taxo-ingredient');
                            $grandparent = $grandparent_term->name;
                        }
                    }
    
                    // Stocker les informations dans l'objet
                    $taxonomies[] = [
                        'term_id' => $term->term_id,
                        'name' => $term->name,
                        'parent' => $parent,
                        'grandparent' => $grandparent,
                    ];
                }
    
                // Retourner les données au format JSON pour AJAX
                wp_send_json_success($taxonomies);
            } else {
                wp_send_json_error('Aucun terme trouvé.');
            }
        }
        wp_die(); // Fin de l'exécution
    }
    add_action('wp_ajax_get_taxo_ingredients', 'get_taxo_ingredients');
    add_action('wp_ajax_nopriv_get_taxo_ingredients', 'get_taxo_ingredients');
    