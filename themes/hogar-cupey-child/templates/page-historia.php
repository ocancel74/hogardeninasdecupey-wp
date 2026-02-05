```php
<?php
/**
 * Template Name: Historia
 * Description: Página de Historia del Hogar
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        <?php
        while ( have_posts() ) : the_post();
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <h1 class="section-title"><?php the_title(); ?></h1>
            </header>
            
            <div class="entry-content">
                <?php the_content(); ?>
                
                <?php
                // Galería de fotos
                $galeria = get_field( 'galeria_historia_page' );
                
                if ( $galeria ) :
                ?>
                <section class="galeria-section mt-3">
                    <h2>Galería de Fotos Históricas</h2>
                    <div class="galeria-fotos">
                        <?php foreach ( $galeria as $imagen ) : ?>
                            <div class="galeria-item">
                                <img src="<?php echo esc_url( $imagen['sizes']['galeria-thumb'] ); ?>" 
                                     alt="<?php echo esc_attr( $imagen['alt'] ); ?>"
                                     loading="lazy" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>
            
        </article>
        
        <?php
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
```

---
