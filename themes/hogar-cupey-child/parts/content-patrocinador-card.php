```php
<?php
/**
 * Template part for displaying Patrocinador Card
 */

$logo = get_field( 'logo_patrocinador' );
$url = get_field( 'url_sitio' );
?>

<div class="patrocinador-card">
    
    <?php if ( $url ) : ?>
        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
    <?php endif; ?>
    
    <?php if ( $logo ) : ?>
        <img src="<?php echo esc_url( $logo['sizes']['patrocinador-thumb'] ); ?>" 
             alt="<?php echo esc_attr( get_the_title() ); ?>" 
             class="patrocinador-logo" />
    <?php endif; ?>
    
    <h3 class="patrocinador-nombre"><?php the_title(); ?></h3>
    
    <?php if ( $url ) : ?>
        </a>
    <?php endif; ?>
    
</div>
```

---
