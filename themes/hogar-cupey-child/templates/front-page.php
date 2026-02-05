<?php
/**
 * Template Name: Página de Inicio
 * Description: Template para la página principal
 * 
 * @package Hogar_Cupey_Child
 */

get_header(); ?>

<main id="main-content" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h2>Con más de 70 años</h2>
            <h1>Al servicio de los niños y niñas en desventaja social y económica</h1>
            <p>A través de servicios integrales en apoyo a la familia y a la comunidad. Servimos como facilidad residencial para niñas y un programa educativo complementario, buscando siempre el mayor interés y bienestar de cada niño y niña participante.</p>
            <a href="<?php echo esc_url( get_field( 'url_donacion', 'option' ) ?: '#' ); ?>" class="hero-cta">Dona Hoy</a>
        </div>
    </section>

    <!-- Contenido Principal -->
    <div class="content-section">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <div class="entry-content">
                    
                    <!-- Sección: 70 años de historia -->
                    <section class="historia-preview mt-3">
                        <h2 class="section-title">70 años de historia y ahora ofreciendo nuevos servicios</h2>
                        
                        <div class="historia-content">
                            <h3>Por más de 70 años hemos ayudado a miles de niños y niñas en desventaja social y económica.</h3>
                            
                            <p>Comenzamos como un Hogar de niños brindándoles un albergue seguro, alimentación y vestimenta. Luego servimos exclusivamente de Hogar a niñas víctimas de maltrato u abandono por parte de sus familiares y encargados ofreciendo servicios especializados y de apoyo en las áreas de salud física, mental y espiritual.</p>
                            
                            <h3>Desde agosto de 2021 abrimos un nuevo centro educativo para niños y niñas y que ofrece servicios a la familia y la comunidad.</h3>
                            
                            <p>También servimos como Facilidad Residencial para niñas.</p>
                            
                            <h4>¿Por qué los nuevos servicios?</h4>
                            
                            <p>Numerosos eventos han impactado la vida de las familias puertorriqueñas a lo largo de los últimos cinco años. Huracanes, terremotos y la pandemia del COVID 19, han dejado un saldo de precariedad en los sectores más necesitados y han colocado a nuestros niños en posiciones de mayor vulnerabilidad. La experiencia de la educación a distancia a causa del confinamiento pandémico ha colocado a miles de niños en situaciones de rezago académico y en distintas situaciones de riesgo que van a dificultar su desempeño y su desarrollo en el futuro.</p>
                            
                            <h4>Nuestra Misión</h4>
                            <p>Es proveer servicios integrales de excelencia a niños y jóvenes en desventaja social y económica, buscando el mejor interés y bienestar de los menores fundamentados en valores cristianos.</p>
                            
                            <h4>Nuestra Visión</h4>
                            <p>Es contribuir a la formación de niños capaces de transformar sus vidas e impactar su entorno familiar.</p>
                        </div>
                    </section>
                    
                    <!-- Sección: ¿Cómo puedes ayudar? -->
                    <section class="ayudar-preview mt-3">
                        <h3>¿Cómo puedes ayudar?</h3>
                        <p>Con una módica cantidad mensual o anual puedes convertirte en amigo de nuestra organización. También, puedes ser voluntario ayudando en distintas tareas y labores grandes y pequeñas. En cualquier momento puedes donar y patrocinar las actividades de recaudación de fondos que hacemos regularmente. Toda ayuda es buena y nos permite continuar nuestra misión de amor.</p>
                        
                        <div class="text-center mt-2">
                            <a href="<?php echo esc_url( home_url( '/como-ayudar/' ) ); ?>" class="btn btn-primary">¿Cómo puedo ayudar?</a>
                        </div>
                    </section>
                    
                    <!-- Eventos Recientes -->
                    <?php
                    $eventos_args = array(
                        'post_type'      => 'hdc_eventos',
                        'posts_per_page' => 3,
                        'meta_key'       => 'fecha_evento',
                        'orderby'        => 'meta_value',
                        'order'          => 'DESC',
                    );
                    
                    $eventos_query = new WP_Query( $eventos_args );
                    
                    if ( $eventos_query->have_posts() ) :
                    ?>
                    <section class="eventos-recientes mt-3">
                        <h2 class="section-title">Noticias y Eventos Recientes</h2>
                        
                        <div class="eventos-grid">
                            <?php
                            while ( $eventos_query->have_posts() ) :
                                $eventos_query->the_post();
                                get_template_part( 'parts/content', 'evento-card' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                        
                        <div class="text-center mt-2">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'hdc_eventos' ) ); ?>" class="btn btn-secondary">Ver Todos los Eventos</a>
                        </div>
                    </section>
                    <?php endif; ?>
                    
                    <?php the_content(); ?>
                    
                </div><!-- .entry-content -->
                
            </article>
            
            <?php
        endwhile; // End of the loop.
        ?>
    </div>
    
</main><!-- #main -->

<?php
get_footer();
