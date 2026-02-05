
```php
<?php
/**
 * Template part for displaying Evento Card
 */

$fecha = get_field( 'fecha_evento' );
$descripcion = get_field( 'descripcion_corta' );
?>

<div class="evento-card">
    
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'evento-featured', array( 'class' => 'evento-imagen' ) ); ?>
        </a>
    <?php endif; ?>
    
    <div class="evento-content">
        
        <?php if ( $fecha ) : 
            $date = DateTime::createFromFormat( 'Ymd', $fecha );
        ?>
            <span class="evento-fecha">
                <?php echo $date->format( 'd/m/Y' ); ?>
            </span>
        <?php endif; ?>
        
        <h3 class="evento-titulo">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <?php if ( $descripcion ) : ?>
            <p class="evento-descripcion"><?php echo esc_html( $descripcion ); ?></p>
        <?php else : ?>
            <p class="evento-descripcion"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
        <?php endif; ?>
        
        <a href="<?php the_permalink(); ?>" class="evento-leer-mas">Leer más</a>
        
    </div>
    
</div>
```

---

