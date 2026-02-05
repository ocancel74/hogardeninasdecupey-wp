```php
<?php
/**
 * Single Template for Eventos
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <?php
        while ( have_posts() ) :
            the_post();
            
            $fecha = get_field( 'fecha_evento' );
            $galeria = get_field( 'galeria_evento' );
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'evento-single' ); ?>>
            
            <header class="entry-header">
                <?php if ( $fecha ) : 
                    $date = DateTime::createFromFormat( 'Ymd', $fecha );
                ?>
                    <p class="evento-fecha-single">
                        <?php echo $date->format( 'd \d\e F, Y' ); ?>
                    </p>
                <?php endif; ?>
                
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="evento-featured-image">
                <?php the_post_thumbnail( 'evento-featured' ); ?>
            </div>
            <?php endif; ?>
            
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            
            <?php if ( $galeria && is_array( $galeria ) ) : ?>
            <section class="evento-galeria mt-3">
                <h2>Galería de Fotos</h2>
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
            
            <footer class="entry-footer">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'hdc_eventos' ) ); ?>" class="btn btn-secondary">
                    ← Volver a Eventos
                </a>
            </footer>
            
        </article>
        
        <?php
        endwhile;
        ?>
        
    </div>
</main>

<style>
.evento-fecha-single {
    color: var(--hdc-primary);
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.evento-featured-image {
    margin: 2rem 0;
    border-radius: 10px;
    overflow: hidden;
}

.evento-featured-image img {
    width: 100%;
    height: auto;
}

.entry-footer {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid var(--hdc-light);
}
</style>

<?php get_footer(); ?>
```

---

