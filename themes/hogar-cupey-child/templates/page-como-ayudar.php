```php
<?php
/**
 * Template Name: Cómo Ayudar
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
            
            <div class="formas-ayudar mt-3">
                
                <div class="ayudar-card">
                    <h3>💰 Donaciones Monetarias</h3>
                    <p>Con una módica cantidad mensual o anual puedes convertirte en amigo de nuestra organización.</p>
                    <a href="<?php echo esc_url( get_field( 'url_donacion', 'option' ) ); ?>" 
                       class="btn btn-primary" target="_blank">Donar Ahora</a>
                </div>
                
                <div class="ayudar-card">
                    <h3>🤝 Voluntariado</h3>
                    <p>Puedes ser voluntario ayudando en distintas tareas y labores grandes y pequeñas.</p>
                    <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" 
                       class="btn btn-secondary">Contactar</a>
                </div>
                
                <div class="ayudar-card">
                    <h3>🎉 Patrocinar Eventos</h3>
                    <p>Patrocina las actividades de recaudación de fondos que hacemos regularmente.</p>
                    <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" 
                       class="btn btn-secondary">Más Información</a>
                </div>
                
            </div>
        </div>
        
        <?php endwhile; ?>
        
    </div>
</main>

<style>
.formas-ayudar {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.ayudar-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.ayudar-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.ayudar-card .btn {
    margin-top: 1rem;
}
</style>

<?php get_footer(); ?>
```

---

