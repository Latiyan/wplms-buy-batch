<?php
/*
Plugin Name: WPLMS BUY BATCH
Plugin URI: http://www.Vibethemes.com
Description: A simple WordPress plugin to modify WPLMS template
Version: 1.0
Author: H.K. Latiyan
Author URI: http://www.vibethemes.com
Text Domain: wplms-bb
License: GPL2
*/
/*
Copyright 2014  VibeThemes  (email : vibethemes@gmail.com)

WPLMS BUY BATCH program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

WPLMS BUY BATCH program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with WPLMS BUY BATCH program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


include_once 'admin/wplms_buy_batch_class.php';

add_action('plugins_loaded','wplms_buy_batch_translations');
function wplms_buy_batch_translations(){

    $locale = apply_filters("plugin_locale", get_locale(), 'wplms-bb');
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'wplms-bb', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;

    if ( file_exists( $mofile_global ) ) {
        load_textdomain( 'wplms-bb', $mofile_global );
    } else {
        load_textdomain( 'wplms-bb', $mofile_local );
    }  
}

if(class_exists('WPLMS_Buy_Batch_Class')){

    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WPLMS_Buy_Batch_Class', 'activate'));
    register_deactivation_hook(__FILE__, array('WPLMS_Buy_Batch_Class', 'deactivate'));

    // instantiate the plugin class
 	$init = WPLMS_Buy_Batch_Class::instance_buy_batch_class();
}

add_action('wp_enqueue_scripts','wplms_buy_batch_custom_cssjs');
function wplms_buy_batch_custom_cssjs(){

    wp_enqueue_style( 'wplms-buy-batch-css', plugins_url( 'css/style.css' , __FILE__ ));
    wp_enqueue_script( 'wplms-buy-batch-js', plugins_url( 'js/custom.js' , __FILE__ ));
}


