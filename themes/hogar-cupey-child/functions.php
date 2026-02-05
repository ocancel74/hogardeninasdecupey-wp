<?php
/**
 * Hogar de Niñas de Cupey - Child Theme Functions
 * 
 * @package Hogar_Cupey_Child
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Constants
 */
define( 'HDC_THEME_VERSION', '1.0.0' );
define( 'HDC_THEME_DIR', get_stylesheet_directory() );
define( 'HDC_THEME_URI', get_stylesheet_directory_uri() );

/**
 * Enqueue Parent and Child Theme Styles
 */
function hdc_enqueue_styles() {
    // Parent theme style
    wp_enqueue_style( 
        'astra-parent-style', 
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->parent()->get('Version')
    );
    
    // Child theme style
    wp_enqueue_style( 
        'hogar-cupey-child-style', 
        get_stylesheet_uri(),
        array( 'astra-parent-style' ),
        HDC_THEME_VERSION
    );
    
    // Custom CSS
    wp_enqueue_style(
        'hdc-custom-style',
        HDC_THEME_URI . '/assets/css/custom.css',
        array( 'hogar-cupey-child-style' ),
        HDC_THEME_VERSION
    );
    
    // Custom JS
    wp_enqueue_script(
        'hdc-custom-script',
        HDC_THEME_URI . '/assets/js/custom.js',
        array( 'jquery' ),
        HDC_THEME_VERSION,
        true
    );
    
    // Pass PHP data to JS
    wp_localize_script( 'hdc-custom-script', 'hdcData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'donateUrl' => get_field( 'url_donacion', 'option' ) ?: 'https://www.paypal.com/fundraiser/charity/1596853',
    ));
}
add_action( 'wp_enqueue_scripts', 'hdc_enqueue_styles' );

/**
 * Include Custom Files
 */
require_once HDC_THEME_DIR . '/inc/custom-post-types.php';
require_once HDC_THEME_DIR . '/inc/acf-fields.php';
require_once HDC_THEME_DIR . '/inc/enqueue-scripts.php';
require_once HDC_THEME_DIR . '/inc/shortcodes.php';

/**
 * Theme Setup
 */
function hdc_theme_setup() {
    // Add theme support
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', array(
        'height'      => 70,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'hogar-cupey-child' ),
        'footer'  => __( 'Menú Footer', 'hogar-cupey-child' ),
    ));
    
    // Set content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}
add_action( 'after_setup_theme', 'hdc_theme_setup' );

/**
 * Register Widget Areas
 */
function hdc_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar Principal', 'hogar-cupey-child' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Sidebar para páginas con barra lateral', 'hogar-cupey-child' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar( array(
        'name'          => __( 'Footer 1', 'hogar-cupey-child' ),
        'id'            => 'footer-1',
        'description'   => __( 'Primera columna del footer', 'hogar-cupey-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar( array(
        'name'          => __( 'Footer 2', 'hogar-cupey-child' ),
        'id'            => 'footer-2',
        'description'   => __( 'Segunda columna del footer', 'hogar-cupey-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar( array(
        'name'          => __( 'Footer 3', 'hogar-cupey-child' ),
        'id'            => 'footer-3',
        'description'   => __( 'Tercera columna del footer', 'hogar-cupey-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action( 'widgets_init', 'hdc_widgets_init' );

/**
 * Add Floating Donate Button
 */
function hdc_floating_donate_button() {
    $donate_text = get_field( 'texto_boton_dona', 'option' ) ?: 'Dona Hoy';
    $donate_url = get_field( 'url_donacion', 'option' ) ?: 'https://www.paypal.com/fundraiser/charity/1596853';
    
    ?>
    <div id="hdc-floating-donate" class="hdc-floating-donate">
        <a href="<?php echo esc_url( $donate_url ); ?>" 
           target="_blank" 
           rel="noopener noreferrer"
           class="floating-donate-link">
            <span class="donate-icon">❤</span>
            <span class="donate-text"><?php echo esc_html( $donate_text ); ?></span>
        </a>
    </div>
    
    <style>
    .hdc-floating-donate {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        animation: pulse 2s infinite;
    }
    
    .floating-donate-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #ff6600 0%, #ff8800 100%);
        color: #ffffff !important;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(255, 102, 0, 0.4);
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .floating-donate-link:hover {
        transform: scale(1.1) translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 102, 0, 0.6);
        color: #ffffff !important;
    }
    
    .donate-icon {
        font-size: 1.25rem;
        animation: heartbeat 1.5s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        25%, 75% { transform: scale(1.1); }
        50% { transform: scale(1.2); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hdc-floating-donate {
            bottom: 20px;
            right: 20px;
        }
        
        .floating-donate-link {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
        
        .donate-text {
            display: none;
        }
        
        .donate-icon {
            font-size: 1.5rem;
        }
    }
    </style>
    <?php
}
add_action( 'wp_footer', 'hdc_floating_donate_button' );

/**
 * Add Social Media Links to Header
 */
function hdc_header_social_links() {
    $facebook = get_field( 'facebook_url', 'option' );
    $instagram = get_field( 'instagram_url', 'option' );
    
    if ( $facebook || $instagram ) :
    ?>
    <div class="header-social-links">
        <?php if ( $facebook ) : ?>
            <a href="<?php echo esc_url( $facebook ); ?>" 
               target="_blank" 
               rel="noopener noreferrer"
               class="social-link facebook"
               aria-label="Facebook">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
        <?php endif; ?>
        
        <?php if ( $instagram ) : ?>
            <a href="<?php echo esc_url( $instagram ); ?>" 
               target="_blank" 
               rel="noopener noreferrer"
               class="social-link instagram"
               aria-label="Instagram">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
    
    <style>
    .header-social-links {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .header-social-links .social-link {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .header-social-links .facebook {
        background: #1877f2;
        color: #ffffff;
    }
    
    .header-social-links .facebook:hover {
        background: #145dbf;
        transform: scale(1.1);
    }
    
    .header-social-links .instagram {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: #ffffff;
    }
    
    .header-social-links .instagram:hover {
        transform: scale(1.1);
    }
    </style>
    <?php
    endif;
}
add_action( 'astra_header_markup_after', 'hdc_header_social_links' );

/**
 * Customize Excerpt Length
 */
function hdc_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'hdc_custom_excerpt_length' );

/**
 * Customize Excerpt More
 */
function hdc_custom_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'hdc_custom_excerpt_more' );

/**
 * Add Image Sizes
 */
function hdc_custom_image_sizes() {
    add_image_size( 'director-thumb', 300, 300, true );
    add_image_size( 'patrocinador-thumb', 300, 200, true );
    add_image_size( 'evento-featured', 800, 500, true );
    add_image_size( 'galeria-thumb', 400, 300, true );
}
add_action( 'after_setup_theme', 'hdc_custom_image_sizes' );

/**
 * Enable SVG Upload (with security)
 */
function hdc_enable_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'hdc_enable_svg_upload' );

/**
 * Sanitize SVG on Upload
 */
function hdc_sanitize_svg( $file ) {
    if ( $file['type'] === 'image/svg+xml' ) {
        // Basic SVG sanitization - consider using library for production
        $svg_content = file_get_contents( $file['tmp_name'] );
        
        // Remove scripts
        $svg_content = preg_replace( '/<script\b[^>]*>(.*?)<\/script>/is', '', $svg_content );
        
        // Save cleaned content
        file_put_contents( $file['tmp_name'], $svg_content );
    }
    
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'hdc_sanitize_svg' );

/**
 * Add ACF Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' => 'Opciones Globales',
        'menu_title' => 'Opciones Globales',
        'menu_slug'  => 'opciones-globales',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-settings',
        'position'   => 2,
        'redirect'   => false,
    ));
}

/**
 * Disable Comments on Pages (optional)
 */
function hdc_disable_comments_on_pages() {
    remove_post_type_support( 'page', 'comments' );
    remove_post_type_support( 'page', 'trackbacks' );
}
add_action( 'init', 'hdc_disable_comments_on_pages' );

/**
 * Add Schema.org Markup for Nonprofit
 */
function hdc_add_organization_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'NGO',
        'name' => 'Hogar de Niñas de Cupey',
        'url' => home_url(),
        'logo' => get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : '',
        'description' => get_bloginfo( 'description' ),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'San Juan',
            'addressRegion' => 'PR',
            'addressCountry' => 'PR',
        ),
        'sameAs' => array(
            get_field( 'facebook_url', 'option' ),
            get_field( 'instagram_url', 'option' ),
        ),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
add_action( 'wp_head', 'hdc_add_organization_schema' );

/**
 * Security: Remove WordPress Version
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Security: Disable XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Performance: Defer JavaScript
 */
function hdc_defer_scripts( $tag, $handle, $src ) {
    $defer_scripts = array( 'hdc-custom-script' );
    
    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'hdc_defer_scripts', 10, 3 );

/**
 * Accessibility: Skip to Content Link
 */
function hdc_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#main-content">'. __( 'Saltar al contenido', 'hogar-cupey-child' ) . '</a>';
}
add_action( 'wp_body_open', 'hdc_skip_link' );

/**
 * Admin: Custom Admin Footer Text
 */
function hdc_custom_admin_footer() {
    echo 'Desarrollado para <strong>Hogar de Niñas de Cupey</strong> | WordPress ' . get_bloginfo( 'version' );
}
add_filter( 'admin_footer_text', 'hdc_custom_admin_footer' );

/**
 * Debug: Log Function (for development)
 */
if ( ! function_exists( 'hdc_log' ) ) {
    function hdc_log( $message ) {
        if ( WP_DEBUG === true ) {
            if ( is_array( $message ) || is_object( $message ) ) {
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}
