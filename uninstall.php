<?php

/**
 * Ejecuta este fichero en la desinstalación del plugin
 */

 /**
 * @package AlecaddPlugin
 */

 /**
  * Sentencia de protección para asegurarnos que se ejecuta a
  * petición de wordpress
  */

if(! defined('WP_UNINSTALL_PLUGIN')){die;}

/* --- limpiar la base de datos. 
        dos metodos- wordpress y SQL
---*/

// usando metodos de worpress //

// obtenemos un array con todos los posts de tipo book
$books = get_posts(array('post_type' => 'book', 'numberpost' => -1));

// recorremos el array de books y los borramos uno a uno.
foreach ($books as $book ){
    wp_delete_post($book->ID,true);
}

// usando metodos de SQL
/*
global $wpdb;
// borra los cpt en la tabla post_type
$wpsb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
// borra los metadata de los custom post type que no estarn en la tabla wp_posts
$wpdp->query("DELETE FROM wp_postmeta WHERE post_id NOT IN( SELECT if FROM wp_posts)");
// borra lss relaciones de los custom post type con taxonomias
$wpdp->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN( SELECT if FROM wp_posts)");
*/