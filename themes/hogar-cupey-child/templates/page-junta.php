```php
<?php
/**
 * Template Name: Junta de Directores
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <header class="page-header">
            <h1 class="section-title">Junta de Directores</h1>
        </header>
        
        <div class="page-content">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
        
        <?php
        // Query de Directores
        $args = array(
            'post_type'      => 'hdc_directores',
            'posts_per_page' => -1,
            'meta_key'       => 'orden',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        );
        
        $directores_query = new WP_Query( $args );
        
        if ( $directores_query->have_posts() ) :
        ?>
        
        <section class="directores-section mt-3">
            <div class="directores-grid">
                <?php
                while ( $directores_query->have_posts() ) :
                    $directores_query->the_post();
                    
                    $foto = get_field( 'foto_director' );
                    $cargo = get_field( 'cargo' );
                    $descripcion = get_field( 'descripcion' );
                ?>
                
                <div class="director-card">
                    <?php if ( $foto ) : ?>
                        <img src="<?php echo esc_url( $foto['sizes']['director-thumb'] ); ?>" 
                             alt="<?php echo esc_attr( get_the_title() ); ?>" 
                             class="director-foto" />
                    <?php endif; ?>
                    
                    <h3 class="director-nombre"><?php the_title(); ?></h3>
                    
                    <?php if ( $cargo ) : ?>
                        <p class="director-cargo"><?php echo esc_html( $cargo ); ?></p>
                    <?php endif; ?>
                    
                    <?php if ( $descripcion ) : ?>
                        <p class="director-descripcion"><?php echo esc_html( $descripcion ); ?></p>
                    <?php endif; ?>
                </div>
                
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </section>
        
        <?php else : ?>
            <p>No hay miembros de la junta para mostrar.</p>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
```

---
