<?php
/**
 * Initialise WPLMS Buy Batches
 *
 * @class       Wplms_Buy_Batch_Filters
 * @author      H.K. Latiyan
 * @category    Admin
 * @package     WPLMS-Buy-Batch/admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wplms_Buy_Batch_Filters{

	public static $instance;
	public static function init(){

	    if ( is_null( self::$instance ) )
	        self::$instance = new Wplms_Buy_Batch_Filters();
	    return self::$instance;
	}

	private function __construct(){

	} // END public function __construct

} // End of class Wplms_Buy_Batch_Filters