```php
<?php
/**
 * Template Name: Patrocinadores
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <header class="page-header">
            <h1 class="section-title">Nuestros Patrocinadores</h1>
        </header>
        
        <div class="page-content">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
        
        <?php
        // Query de Patrocinadores
        $args = array(
            'post_type'      => 'hdc_patrocinadores',
            'posts_per_page' => -1,
            'meta_key'       => 'orden',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        );
        
        $patrocinadores_query = new WP_Query( $args );
        
        if ( $patrocinadores_query->have_posts() ) :
        ?>
        
        <section class="patrocinadores-section mt-3">
            <div class="patrocinadores-grid">
                <?php
                while ( $patrocinadores_query->have_posts() ) :
                    $patrocinadores_query->the_post();
                    
                    $logo = get_field( 'logo_patrocinador' );
                    $url = get_field( 'url_sitio' );
                ?>
                
                <div class="patrocinador-card">
                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php endif; ?>
                    
                    <?php if ( $logo ) : ?>
                        <img src="<?php echo esc_url( $logo['sizes']['patrocinador-thumb'] ); ?>" 
                             alt="<?php echo esc_attr( get_the_title() ); ?>" 
                             class="patrocinador-logo" />
                    <?php endif; ?>
                    
                    <h3 class="patrocinador-nombre"><?php the_title(); ?></h3>
                    
                    <?php if ( $url ) : ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
        
        <?php else : ?>
            <p>No hay patrocinadores para mostrar.</p>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
```

---
