```php
<?php
/**
 * Template Name: Contacto
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="content-section">
        
        <header class="page-header">
            <h1 class="section-title">Contáctanos</h1>
        </header>
        
        <?php
        $telefono = get_field( 'telefono', 'option' );
        $email = get_field( 'email', 'option' );
        $direccion = get_field( 'direccion', 'option' );
        $mapa = get_field( 'mapa_embed', 'option' );
        ?>
        
        <div class="contacto-wrapper">
            
            <div class="contacto-info">
                <h2>Información de Contacto</h2>
                
                <?php if ( $telefono ) : ?>
                <div class="contacto-item">
                    <div class="contacto-icon">📞</div>
                    <div>
                        <strong>Teléfono:</strong><br>
                        <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '-', '(', ')' ), '', $telefono ) ); ?>">
                            <?php echo esc_html( $telefono ); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ( $email ) : ?>
                <div class="contacto-item">
                    <div class="contacto-icon">✉️</div>
                    <div>
                        <strong>Email:</strong><br>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ( $direccion ) : ?>
                <div class="contacto-item">
                    <div class="contacto-icon">📍</div>
                    <div>
                        <strong>Dirección:</strong><br>
                        <?php echo nl2br( esc_html( $direccion ) ); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php
                $facebook = get_field( 'facebook_url', 'option' );
                $instagram = get_field( 'instagram_url', 'option' );
                
                if ( $facebook || $instagram ) :
                ?>
                <div class="contacto-item">
                    <div class="contacto-icon">🌐</div>
                    <div>
                        <strong>Redes Sociales:</strong><br>
                        <?php if ( $facebook ) : ?>
                            <a href="<?php echo esc_url( $facebook ); ?>" target="_blank">Facebook</a>
                        <?php endif; ?>
                        <?php if ( $facebook && $instagram ) : ?>|<?php endif; ?>
                        <?php if ( $instagram ) : ?>
                            <a href="<?php echo esc_url( $instagram ); ?>" target="_blank">Instagram</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="contacto-form">
                <h2>Envíanos un Mensaje</h2>
                
                <?php
                // Usar WPForms shortcode aquí
                // Reemplazar "123" con el ID real del formulario
                echo do_shortcode( '[wpforms id="123"]' );
                ?>
                
                <p class="form-note">
                    <small>* Todos los campos marcados con asterisco son obligatorios</small>
                </p>
            </div>
            
        </div>
        
        <?php if ( $mapa ) : ?>
        <div class="mapa-contacto mt-3">
            <h2 class="text-center">Nuestra Ubicación</h2>
            <?php echo $mapa; // Ya viene como HTML iframe ?>
        </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
```

---
