```php
<?php
/**
 * Plugin Name: HDC Configuración
 * Plugin URI: https://github.com/TU-USUARIO/hogar-ninas-cupey-wp
 * Description: Plugin de configuración personalizada para Hogar de Niñas de Cupey
 * Version: 1.0.0
 * Author: Tu Nombre
 * License: GPL v2 or later
 * Text Domain: hdc-configuracion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HDC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HDC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load ACF JSON from plugin
 */
add_filter( 'acf/settings/save_json', 'hdc_acf_json_save_point' );
function hdc_acf_json_save_point( $path ) {
    $path = HDC_PLUGIN_DIR . 'acf-json';
    return $path;
}

add_filter( 'acf/settings/load_json', 'hdc_acf_json_load_point' );
function hdc_acf_json_load_point( $paths ) {
    unset( $paths[0] );
    $paths[] = HDC_PLUGIN_DIR . 'acf-json';
    return $paths;
}

/**
 * Custom functions for the plugin
 */

// Add more custom functions here as needed
```

---
