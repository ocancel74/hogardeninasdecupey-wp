<?php
/**
 * ACF Fields Registration
 * 
 * @package Hogar_Cupey_Child
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register ACF Field Groups Programmatically
 * Note: You can also export these from ACF and save as JSON in acf-json folder
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

/**
 * Field Group: Director Info
 */
acf_add_local_field_group( array(
    'key' => 'group_director_info',
    'title' => 'Información del Director',
    'fields' => array(
        array(
            'key' => 'field_foto_director',
            'label' => 'Foto del Director',
            'name' => 'foto_director',
            'type' => 'image',
            'instructions' => 'Sube una foto del director (recomendado: 400x400px)',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_nombre_completo',
            'label' => 'Nombre Completo',
            'name' => 'nombre_completo',
            'type' => 'text',
            'instructions' => 'El nombre completo del director se toma del título del post',
            'required' => 0,
            'default_value' => '',
            'placeholder' => 'Ej: María González López',
        ),
        array(
            'key' => 'field_cargo',
            'label' => 'Cargo',
            'name' => 'cargo',
            'type' => 'text',
            'instructions' => 'Cargo en la junta directiva',
            'required' => 1,
            'default_value' => '',
            'placeholder' => 'Ej: Presidenta, Tesorero, Vocal',
        ),
        array(
            'key' => 'field_descripcion',
            'label' => 'Descripción',
            'name' => 'descripcion',
            'type' => 'textarea',
            'instructions' => 'Breve biografía o descripción (opcional)',
            'required' => 0,
            'rows' => 4,
        ),
        array(
            'key' => 'field_orden_director',
            'label' => 'Orden',
            'name' => 'orden',
            'type' => 'number',
            'instructions' => 'Número para ordenar (menor número aparece primero)',
            'required' => 0,
            'default_value' => 10,
            'min' => 1,
            'step' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hdc_directores',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
));

/**
 * Field Group: Patrocinador Info
 */
acf_add_local_field_group( array(
    'key' => 'group_patrocinador_info',
    'title' => 'Información del Patrocinador',
    'fields' => array(
        array(
            'key' => 'field_logo_patrocinador',
            'label' => 'Logo del Patrocinador',
            'name' => 'logo_patrocinador',
            'type' => 'image',
            'instructions' => 'Sube el logo (recomendado: 300x200px, fondo transparente)',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_nombre_patrocinador',
            'label' => 'Nombre del Patrocinador',
            'name' => 'nombre_patrocinador',
            'type' => 'text',
            'instructions' => 'El nombre se toma del título del post',
            'required' => 0,
            'placeholder' => 'Nombre de la empresa/organización',
        ),
        array(
            'key' => 'field_url_sitio',
            'label' => 'Sitio Web',
            'name' => 'url_sitio',
            'type' => 'url',
            'instructions' => 'URL del sitio web del patrocinador (opcional)',
            'required' => 0,
            'placeholder' => 'https://www.ejemplo.com',
        ),
        array(
            'key' => 'field_orden_patrocinador',
            'label' => 'Orden',
            'name' => 'orden',
            'type' => 'number',
            'instructions' => 'Número para ordenar',
            'required' => 0,
            'default_value' => 10,
            'min' => 1,
            'step' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hdc_patrocinadores',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
));

/**
 * Field Group: Evento Info
 */
acf_add_local_field_group( array(
    'key' => 'group_evento_info',
    'title' => 'Información del Evento',
    'fields' => array(
        array(
            'key' => 'field_fecha_evento',
            'label' => 'Fecha del Evento',
            'name' => 'fecha_evento',
            'type' => 'date_picker',
            'instructions' => 'Selecciona la fecha del evento',
            'required' => 1,
            'display_format' => 'd/m/Y',
            'return_format' => 'Ymd',
            'first_day' => 0,
        ),
        array(
            'key' => 'field_descripcion_corta',
            'label' => 'Descripción Corta',
            'name' => 'descripcion_corta',
            'type' => 'textarea',
            'instructions' => 'Breve descripción para mostrar en la tarjeta (máx 200 caracteres)',
            'required' => 0,
            'maxlength' => 200,
            'rows' => 3,
        ),
        array(
            'key' => 'field_galeria_evento',
            'label' => 'Galería de Fotos',
            'name' => 'galeria_evento',
            'type' => 'gallery',
            'instructions' => 'Sube múltiples fotos del evento',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min' => 0,
            'max' => 20,
        ),
        array(
            'key' => 'field_contenido_completo',
            'label' => 'Contenido Completo',
            'name' => 'contenido_completo',
            'type' => 'wysiwyg',
            'instructions' => 'Contenido detallado del evento (opcional, usa el editor principal si prefieres)',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hdc_eventos',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
));

/**
 * Field Group: Opciones Globales
 */
acf_add_local_field_group( array(
    'key' => 'group_opciones_globales',
    'title' => 'Opciones Globales del Sitio',
    'fields' => array(
        // Redes Sociales
        array(
            'key' => 'field_tab_redes',
            'label' => 'Redes Sociales',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_facebook_url',
            'label' => 'URL de Facebook',
            'name' => 'facebook_url',
            'type' => 'url',
            'instructions' => 'URL completa de la página de Facebook',
            'placeholder' => 'https://www.facebook.com/hogardeninasdecupey',
        ),
        array(
            'key' => 'field_instagram_url',
            'label' => 'URL de Instagram',
            'name' => 'instagram_url',
            'type' => 'url',
            'instructions' => 'URL completa del perfil de Instagram',
            'placeholder' => 'https://www.instagram.com/hogardeninasdecupey',
        ),
        
        // Contacto
        array(
            'key' => 'field_tab_contacto',
            'label' => 'Información de Contacto',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_telefono',
            'label' => 'Teléfono',
            'name' => 'telefono',
            'type' => 'text',
            'placeholder' => '(787) 123-4567',
        ),
        array(
            'key' => 'field_email',
            'label' => 'Email',
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'info@hogardeninasdecupey.org',
        ),
        array(
            'key' => 'field_direccion',
            'label' => 'Dirección',
            'name' => 'direccion',
            'type' => 'textarea',
            'rows' => 3,
            'placeholder' => 'Calle Principal #123, Cupey, San Juan, PR 00926',
        ),
        array(
            'key' => 'field_mapa_embed',
            'label' => 'Código Embed de Google Maps',
            'name' => 'mapa_embed',
            'type' => 'textarea',
            'instructions' => 'Pega aquí el código iframe de Google Maps',
            'rows' => 4,
            'placeholder' => '<iframe src="..." width="600" height="450"></iframe>',
        ),
        
        // Donaciones
        array(
            'key' => 'field_tab_donaciones',
            'label' => 'Donaciones',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_texto_boton_dona',
            'label' => 'Texto del Botón Flotante',
            'name' => 'texto_boton_dona',
            'type' => 'text',
            'default_value' => 'Dona Hoy',
            'placeholder' => 'Dona Hoy',
        ),
        array(
            'key' => 'field_url_donacion',
            'label' => 'URL de Donación',
            'name' => 'url_donacion',
            'type' => 'url',
            'instructions' => 'URL donde se redirige al hacer click en "Dona Hoy"',
            'default_value' => 'https://www.paypal.com/fundraiser/charity/1596853',
            'placeholder' => 'https://www.paypal.com/fundraiser/charity/1596853',
        ),
        
        // Galerías de Páginas
        array(
            'key' => 'field_tab_galerias',
            'label' => 'Galerías',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_galeria_historia',
            'label' => 'Galería Historia',
            'name' => 'galeria_historia',
            'type' => 'gallery',
            'instructions' => 'Fotos para la página de Historia',
            'return_format' => 'array',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'opciones-globales',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
));

/**
 * Field Group: Page Historia
 */
acf_add_local_field_group( array(
    'key' => 'group_page_historia',
    'title' => 'Contenido de Historia',
    'fields' => array(
        array(
            'key' => 'field_galeria_historia_page',
            'label' => 'Galería de Fotos',
            'name' => 'galeria_historia_page',
            'type' => 'gallery',
            'instructions' => 'Fotos históricas del hogar',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/page-historia.php',
            ),
        ),
    ),
));

/**
 * Field Group: Page Servicios
 */
acf_add_local_field_group( array(
    'key' => 'group_page_servicios',
    'title' => 'Servicios del Hogar',
    'fields' => array(
        array(
            'key' => 'field_servicios_repeater',
            'label' => 'Lista de Servicios',
            'name' => 'servicios_repeater',
            'type' => 'repeater',
            'instructions' => 'Añade cada servicio que ofrece el hogar',
            'layout' => 'block',
            'button_label' => 'Añadir Servicio',
            'sub_fields' => array(
                array(
                    'key' => 'field_servicio_titulo',
                    'label' => 'Título del Servicio',
                    'name' => 'titulo',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_servicio_descripcion',
                    'label' => 'Descripción',
                    'name' => 'descripcion',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_servicio_icono',
                    'label' => 'Icono/Imagen',
                    'name' => 'icono',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/page-servicios.php',
            ),
        ),
    ),
));

endif; // function_exists check
