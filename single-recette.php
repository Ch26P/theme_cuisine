<?php get_header() ?>
<h1>single recette</h1>
   <a> Bonjour:<?php wp_title();?></a> <!--wp_title()  Affiche ou récupère le titre de la page   -->
   <?php wp_title_rss();?>  <!--wp_title_rss()  Affiche ou récupère le titre du site   -->

<?php if(have_posts()): ?>
    <?php while(have_posts()):the_post();?>     <!--boucle pour regarder dans les article-->
<div class="card" >
        <?php the_post_thumbnail('post-thumbnail',[ 'class '=>'card-img-top', 'alt'=>''])?>   <!--afficher la vignettes de l'article-->
        <img src="<?php the_post_thumbnail_url();?>"alt=""style="">   <!-- deuxieme methode pour recuperer url de la vignettes de l'article-->
        <div class="card-body">
        
            <h5 class="card-title"><?php the_title();?></h5>   <!--Affiche ou récupère le titre de l'article en cours avec un balisage optionnel.-->
         
            <h6 class=""><?php the_category();?></h6>   
            <p class="card-text">
                <?php the_content('En voir plus');?>   <!--  Affiche le contenu de l'article. -->
                <?php the_excerpt();?>          <!--  Affiche l'extrait de l'article.  -->
            </p>
            <a href="<?php the_permalink();?>" class="btn btn-primary">Voir plus</a>  <!--Affiche le permalien de l'article en cours.-->
        </div>
    </div>

    <?php endwhile ?>   

<?php else: ?>
    <h1>Pas d'articles</h1>
<?php endif; ?>
    




<?php get_footer() ?>