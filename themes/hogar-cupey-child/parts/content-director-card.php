```php
<?php
/**
 * Template part for displaying Director Card
 */

$foto = get_field( 'foto_director' );
$cargo = get_field( 'cargo' );
$descripcion = get_field( 'descripcion' );
?>

<div class="director-card">
    
    <?php if ( $foto ) : ?>
        <img src="<?php echo esc_url( $foto['sizes']['director-thumb'] ); ?>" 
             alt="<?php echo esc_attr( get_the_title() ); ?>" 
             class="director-foto" />
    <?php endif; ?>
    
    <h3 class="director-nombre"><?php the_title(); ?></h3>
    
    <?php if ( $cargo ) : ?>
        <p class="director-cargo"><?php echo esc_html( $cargo ); ?></p>
    <?php endif; ?>
    
    <?php if ( $descripcion ) : ?>
        <p class="director-descripcion"><?php echo esc_html( $descripcion ); ?></p>
    <?php endif; ?>
    
</div>
```

---
