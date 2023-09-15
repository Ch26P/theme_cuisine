<?php get_header() ?>


<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?> <!--boucle pour regarder dans les article-->

       
        <img src="<?php the_post_thumbnail_url();?>"alt=""style="">
        <h1><?php the_title() ?></h1>
        <?php the_content();?> 


    <?php endwhile ?>

<?php else : ?>
    <h1>Pas d'articles</h1>
<?php endif; ?>





<?php get_footer() ?>