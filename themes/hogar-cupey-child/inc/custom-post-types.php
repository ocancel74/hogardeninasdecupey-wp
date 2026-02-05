<?php
/**
 * Custom Post Types Registration
 * 
 * @package Hogar_Cupey_Child
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Custom Post Type: Directores
 */
function hdc_register_directores_cpt() {
    $labels = array(
        'name'                  => 'Directores',
        'singular_name'         => 'Director',
        'menu_name'             => 'Directores',
        'name_admin_bar'        => 'Director',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Director',
        'new_item'              => 'Nuevo Director',
        'edit_item'             => 'Editar Director',
        'view_item'             => 'Ver Director',
        'all_items'             => 'Todos los Directores',
        'search_items'          => 'Buscar Directores',
        'not_found'             => 'No se encontraron directores',
        'not_found_in_trash'    => 'No hay directores en la papelera',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'director' ),
        'capability_type'       => 'post',
        'has_archive'           => false,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'supports'              => array( 'title', 'thumbnail' ),
        'show_in_rest'          => true,
    );
    
    register_post_type( 'hdc_directores', $args );
}
add_action( 'init', 'hdc_register_directores_cpt' );

/**
 * Register Custom Post Type: Patrocinadores
 */
function hdc_register_patrocinadores_cpt() {
    $labels = array(
        'name'                  => 'Patrocinadores',
        'singular_name'         => 'Patrocinador',
        'menu_name'             => 'Patrocinadores',
        'name_admin_bar'        => 'Patrocinador',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Patrocinador',
        'new_item'              => 'Nuevo Patrocinador',
        'edit_item'             => 'Editar Patrocinador',
        'view_item'             => 'Ver Patrocinador',
        'all_items'             => 'Todos los Patrocinadores',
        'search_items'          => 'Buscar Patrocinadores',
        'not_found'             => 'No se encontraron patrocinadores',
        'not_found_in_trash'    => 'No hay patrocinadores en la papelera',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'patrocinador' ),
        'capability_type'       => 'post',
        'has_archive'           => false,
        'hierarchical'          => false,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-awards',
        'supports'              => array( 'title', 'thumbnail' ),
        'show_in_rest'          => true,
    );
    
    register_post_type( 'hdc_patrocinadores', $args );
}
add_action( 'init', 'hdc_register_patrocinadores_cpt' );

/**
 * Register Custom Post Type: Eventos/Noticias
 */
function hdc_register_eventos_cpt() {
    $labels = array(
        'name'                  => 'Eventos',
        'singular_name'         => 'Evento',
        'menu_name'             => 'Eventos/Noticias',
        'name_admin_bar'        => 'Evento',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Evento',
        'new_item'              => 'Nuevo Evento',
        'edit_item'             => 'Editar Evento',
        'view_item'             => 'Ver Evento',
        'all_items'             => 'Todos los Eventos',
        'search_items'          => 'Buscar Eventos',
        'parent_item_colon'     => 'Evento Padre:',
        'not_found'             => 'No se encontraron eventos',
        'not_found_in_trash'    => 'No hay eventos en la papelera',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'eventos' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-calendar-alt',
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'          => true,
    );
    
    register_post_type( 'hdc_eventos', $args );
}
add_action( 'init', 'hdc_register_eventos_cpt' );

/**
 * Flush Rewrite Rules on Theme Activation
 * Important: Run only once after theme activation
 */
function hdc_flush_rewrite_rules() {
    // Register CPTs
    hdc_register_directores_cpt();
    hdc_register_patrocinadores_cpt();
    hdc_register_eventos_cpt();
    
    // Flush
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hdc_flush_rewrite_rules' );

/**
 * Add Custom Columns to Directores Admin List
 */
function hdc_directores_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = 'Foto';
    $new_columns['title'] = $columns['title'];
    $new_columns['cargo'] = 'Cargo';
    $new_columns['orden'] = 'Orden';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter( 'manage_hdc_directores_posts_columns', 'hdc_directores_columns' );

/**
 * Populate Custom Columns for Directores
 */
function hdc_directores_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            $foto = get_field( 'foto_director', $post_id );
            if ( $foto ) {
                echo '<img src="' . esc_url( $foto['sizes']['thumbnail'] ) . '" style="width:50px;height:50px;border-radius:50%;object-fit:cover;" />';
            } else {
                echo '—';
            }
            break;
            
        case 'cargo':
            $cargo = get_field( 'cargo', $post_id );
            echo $cargo ? esc_html( $cargo ) : '—';
            break;
            
        case 'orden':
            $orden = get_field( 'orden', $post_id );
            echo $orden ? intval( $orden ) : '—';
            break;
    }
}
add_action( 'manage_hdc_directores_posts_custom_column', 'hdc_directores_custom_column', 10, 2 );

/**
 * Make Directores Columns Sortable
 */
function hdc_directores_sortable_columns( $columns ) {
    $columns['orden'] = 'orden';
    $columns['cargo'] = 'cargo';
    return $columns;
}
add_filter( 'manage_edit-hdc_directores_sortable_columns', 'hdc_directores_sortable_columns' );

/**
 * Add Custom Columns to Patrocinadores Admin List
 */
function hdc_patrocinadores_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['logo'] = 'Logo';
    $new_columns['title'] = $columns['title'];
    $new_columns['url'] = 'Sitio Web';
    $new_columns['orden'] = 'Orden';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter( 'manage_hdc_patrocinadores_posts_columns', 'hdc_patrocinadores_columns' );

/**
 * Populate Custom Columns for Patrocinadores
 */
function hdc_patrocinadores_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'logo':
            $logo = get_field( 'logo_patrocinador', $post_id );
            if ( $logo ) {
                echo '<img src="' . esc_url( $logo['sizes']['thumbnail'] ) . '" style="max-width:80px;height:auto;" />';
            } else {
                echo '—';
            }
            break;
            
        case 'url':
            $url = get_field( 'url_sitio', $post_id );
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank">Ver sitio</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'orden':
            $orden = get_field( 'orden', $post_id );
            echo $orden ? intval( $orden ) : '—';
            break;
    }
}
add_action( 'manage_hdc_patrocinadores_posts_custom_column', 'hdc_patrocinadores_custom_column', 10, 2 );

/**
 * Add Custom Columns to Eventos Admin List
 */
function hdc_eventos_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = 'Imagen';
    $new_columns['title'] = $columns['title'];
    $new_columns['fecha'] = 'Fecha del Evento';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter( 'manage_hdc_eventos_posts_columns', 'hdc_eventos_columns' );

/**
 * Populate Custom Columns for Eventos
 */
function hdc_eventos_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 60, 60 ) );
            } else {
                echo '—';
            }
            break;
            
        case 'fecha':
            $fecha = get_field( 'fecha_evento', $post_id );
            if ( $fecha ) {
                $date = DateTime::createFromFormat( 'Ymd', $fecha );
                echo $date ? $date->format( 'd/m/Y' ) : $fecha;
            } else {
                echo '—';
            }
            break;
    }
}
add_action( 'manage_hdc_eventos_posts_custom_column', 'hdc_eventos_custom_column', 10, 2 );

/**
 * Make Eventos Sortable by Date
 */
function hdc_eventos_sortable_columns( $columns ) {
    $columns['fecha'] = 'fecha_evento';
    return $columns;
}
add_filter( 'manage_edit-hdc_eventos_sortable_columns', 'hdc_eventos_sortable_columns' );

/**
 * Orderby for Eventos Query
 */
function hdc_eventos_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    
    if ( 'fecha_evento' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', 'fecha_evento' );
        $query->set( 'orderby', 'meta_value' );
    }
}
add_action( 'pre_get_posts', 'hdc_eventos_orderby' );

/**
 * Custom Archive Query for Eventos (Show by Date DESC)
 */
function hdc_eventos_archive_order( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'hdc_eventos' ) ) {
        $query->set( 'meta_key', 'fecha_evento' );
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'DESC' );
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'hdc_eventos_archive_order' );
