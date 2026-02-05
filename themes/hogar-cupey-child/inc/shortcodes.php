<?php
/**
 * Custom Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [hdc_directores]
 * Muestra la grilla de directores
 */
function hdc_shortcode_directores( $atts ) {
    $atts = shortcode_atts( array(
        'limit' => -1,
    ), $atts, 'hdc_directores' );
    
    ob_start();
    
    $args = array(
        'post_type'      => 'hdc_directores',
        'posts_per_page' => intval( $atts['limit'] ),
        'meta_key'       => 'orden',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        echo '<div class="directores-grid">';
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'parts/content', 'director-card' );
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    else :
        echo '<p>No hay directores para mostrar.</p>';
    endif;
    
    return ob_get_clean();
}
add_shortcode( 'hdc_directores', 'hdc_shortcode_directores' );

/**
 * Shortcode: [hdc_patrocinadores]
 */
function hdc_shortcode_patrocinadores( $atts ) {
    $atts = shortcode_atts( array(
        'limit' => -1,
    ), $atts, 'hdc_patrocinadores' );
    
    ob_start();
    
    $args = array(
        'post_type'      => 'hdc_patrocinadores',
        'posts_per_page' => intval( $atts['limit'] ),
        'meta_key'       => 'orden',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        echo '<div class="patrocinadores-grid">';
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'parts/content', 'patrocinador-card' );
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    else :
        echo '<p>No hay patrocinadores para mostrar.</p>';
    endif;
    
    return ob_get_clean();
}
add_shortcode( 'hdc_patrocinadores', 'hdc_shortcode_patrocinadores' );

/**
 * Shortcode: [hdc_eventos recent="3"]
 */
function hdc_shortcode_eventos( $atts ) {
    $atts = shortcode_atts( array(
        'recent' => 3,
    ), $atts, 'hdc_eventos' );
    
    ob_start();
    
    $args = array(
        'post_type'      => 'hdc_eventos',
        'posts_per_page' => intval( $atts['recent'] ),
        'meta_key'       => 'fecha_evento',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        echo '<div class="eventos-grid">';
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'parts/content', 'evento-card' );
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    endif;
    
    return ob_get_clean();
}
add_shortcode( 'hdc_eventos', 'hdc_shortcode_eventos' );
