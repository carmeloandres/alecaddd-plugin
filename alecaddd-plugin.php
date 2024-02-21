<?php

/**
* Fuente: https://www.youtube.com/watch?v=0l7JTie_6jM
*/

/* --- Part-9-Settings link and Admin Pages --- */ 

/**
 * @package AlecaddPlugin
 */

 /*
Plugin Name: Alecaddd Plugin
Plugin URI:  https://alecaddd.com/plugin
Description: This is may first attempt on writing a custom plugin for this amazing tutorial series.
Version:     1.0.0
Author:      Alessandro "Alecaddd" castellani
Author URI:  https://alecaddd.com
License: GPLv2 or later
Text Domain: alecaddd-plugin
Domain Path: /Languages
 */

/** 
 *  Uso de composer:
 *      - inicio del proyecto, creación del fichero "composer.json"
 *          entramos en el directorio del plugin y tecleamos "composer init"
 *              aceptamos el nombre propuesto, o lo cambiamos
 *              damos una pequeña descripción
 *              validamos el correo electonico
 *              en minimun Stabilitty: " dev"
 *              en tipo de paquete decimos que es un "project"
 *              Lincencia: "GPL"
 *              en esta caso no necesitamos dependencias : "no"
 *              definir dependencia interactivamente : "no"
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {die;} ; // to prevent direct access

// Añadimos el autoload de composer

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

use Inc\Activate;  //

class AlecadddPlugin {

    // propiedad para almacenar el nombre base del plugin
    public $plugin;

    function __construct(){

        // obtiene el nombre base del plugin y lo almacena en la propiedad
        // creada a tal efecto
        $this->plugin = plugin_basename(__FILE__);
    }


    function register() {
        add_action('admin_enqueue_scripts',array($this,'enqueue'));

        // añadimos la acción para incluir un menu en la administración 
        add_action('admin_menu', array($this, 'add_admin_pages'));


        add_filter('plugin_action_links_'.$this->plugin,array($this,'settings_link'));
    }

    // función de filtro para añadir un enlace a la lista de enlaces en la opcion de plugins 
    // de la administración
    function settings_link($links){
        // add custom settings link
        $settings_link = '<a href="admin.php?page=alecaddd_plugin">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    function add_admin_pages(){

        // creamos el menu en la administración con la función add_menu_page
        //add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
        add_menu_page ('Alecaddd PLugin', 'Alecaddd', 'manage_options','alecaddd_plugin', array($this,'admin_index'),'dashicons-store',110);

    }

    function admin_index(){
        // funcion para renderizar el contenido de la administración
        // requiere template
        require_once plugin_dir_path(__FILE__).'templates/admin.php';

    }

    function custom_post_type(){
        register_post_type( 'book',['public' => true,
                                    'label' => 'Books']); 
    }

    static function enqueue(){
        // enqueue all our scripts
        wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css',__FILE__));
        wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js',__FILE__));

    }

    function activate(){
        Activate::activate();
    }
}

if (! class_exists ('AlecaddPlugin')){

    // el metodo register es estatico solo tenemos que llamarlo de la siguiente manera:
 
    $alecaddPlugin = new AlecadddPlugin();
    $alecaddPlugin->register();
}

 // activación
 
 
 //require_once plugin_dir_path(__FILE__).'inc/alecaddd-plugin-activate.php';
 register_activation_hook(__FILE__,array('AlecadddPlugin','activate'));
 //register_activation_hook(__FILE__,array($alecaddPlugin,'activate'));


 // desactivación 
 
 require_once plugin_dir_path(__FILE__).'inc/alecaddd-plugin-deactivate.php';
 register_activation_hook(__FILE__,array('AlecadddPluginDeactivate','deactivate'));

 //register_deactivation_hook(__FILE__,array($alecaddPlugin,'deactivate'));
 
 // desinstalación 


error_log('El plugin ha sido activado');