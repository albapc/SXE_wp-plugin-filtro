<?php
/**
* Plugin Name: miNombradorWP
* Plugin URI:  http://link to your plugin homepage
* Description: Plugin para filtrar palabras
* Version:     1.0
* Author:      Alba Perez
* Author URI:  http://link to your website
* License:     GPL2 etc
* License URI: http://link to your plugin license
*/

/** 
* Copyright 2020 ALBA PEREZ (email : aperezcesar@danielcastelao.org)
* miNombradorWP is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
* 
* miNombradorWP is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with miNombradorWP. If not, see (http://link to your plugin license).
*/

function renym_wordpress_typo_fix( $text ) {
	global $wpdb;
	$registros = $wpdb->get_results( "SELECT name FROM wp52_palabrasProhibidas" );

	$array = array();
	foreach ($registros as $res){
    	$array[] = $res->name;
	}
	
	return str_replace( $array, '*******', $text );
}
add_filter( 'the_content', 'renym_wordpress_typo_fix' );


function create_table_init() {
    global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'palabrasProhibidas';

// creamos la sentencia sql

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
name tinytext NOT NULL,
PRIMARY KEY (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

function add_data() {
    global $wpdb;
	
	$table_name = $wpdb->prefix . 'palabrasProhibidas';
	
	$wpdb->insert( $table_name, array('name' => 'subnormal'));
	$wpdb->insert( $table_name, array('name' => 'tonto'));
	$wpdb->insert( $table_name, array('name' => 'gilipollas'));
	$wpdb->insert( $table_name, array('name' => 'hijo de puta'));
	$wpdb->insert( $table_name, array('name' => 'retrasado'));
	$wpdb->insert( $table_name, array('name' => 'tonto'));
	
}



register_activation_hook( __FILE__, 'add_data' );
add_action('init', 'create_table_init');
?>