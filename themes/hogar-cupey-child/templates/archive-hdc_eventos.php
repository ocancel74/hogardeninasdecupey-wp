```php
<?php
/**
 * Archive Template for Eventos/Noticias
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <header class="page-header">
            <h1 class="section-title">Noticias y Eventos</h1>
            <p class="archive-description">Mantente al tanto de nuestras actividades y novedades</p>
        </header>
        
        <?php if ( have_posts() ) : ?>
        
        <div class="eventos-grid">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'parts/content', 'evento-card' );
            endwhile;
            ?>
        </div>
        
        <?php
        // Paginación
        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( '← Anterior', 'hogar-cupey-child' ),
            'next_text' => __( 'Siguiente →', 'hogar-cupey-child' ),
        ));
        
        else :
            echo '<p>No hay eventos para mostrar.</p>';
        endif;
        ?>
        
    </div>
</main>

<?php get_footer(); ?>
```

---
