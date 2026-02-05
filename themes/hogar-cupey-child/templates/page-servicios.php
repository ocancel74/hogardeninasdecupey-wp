```php
<?php
/**
 * Template Name: Servicios
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <?php while ( have_posts() ) : the_post(); ?>
        
        <header class="page-header">
            <h1 class="section-title"><?php the_title(); ?></h1>
        </header>
        
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        
        <?php
        // Mostrar servicios desde ACF Repeater
        if ( have_rows( 'servicios_repeater' ) ) :
        ?>
        
        <section class="servicios-grid mt-3">
            <?php while ( have_rows( 'servicios_repeater' ) ) : the_row(); 
                $titulo = get_sub_field( 'titulo' );
                $descripcion = get_sub_field( 'descripcion' );
                $icono = get_sub_field( 'icono' );
            ?>
            
            <div class="servicio-card">
                <?php if ( $icono ) : ?>
                    <div class="servicio-icono">
                        <img src="<?php echo esc_url( $icono['sizes']['thumbnail'] ); ?>" 
                             alt="<?php echo esc_attr( $titulo ); ?>" />
                    </div>
                <?php endif; ?>
                
                <h3><?php echo esc_html( $titulo ); ?></h3>
                <p><?php echo esc_html( $descripcion ); ?></p>
            </div>
            
            <?php endwhile; ?>
        </section>
        
        <?php endif; ?>
        
        <?php endwhile; ?>
        
    </div>
</main>

<style>
.servicios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.servicio-card {
    background: #ffffff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    transition: all 0.3s ease;
}

.servicio-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.servicio-icono {
    margin-bottom: 1rem;
}

.servicio-icono img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}
</style>

<?php get_footer(); ?>
```

---

