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

		add_filter('wplms_course_metabox',array($this,'add_price_per_batch_seat_backend'));
		add_filter('wplms_course_creation_tabs',array($this,'add_price_per_batch_seat_frontend'));

	} // END public function __construct

	function add_price_per_batch_seat_backend($settings){
		$settings['wplms_price_per_batch_seat']=array( // Text Input
		      'label' => __('Price Per Batch Seats','wplms-bb'), // <label>
		      'desc'  => __('','wplms-bb' ), // description
		      'id'  => 'wplms_price_per_batch_seat', // field id and name
		      'type'  => 'number', // type of field
		      'std' => 0
		    );

		return $settings;
	}

	function add_price_per_batch_seat_frontend($settings){
		$fields = $settings['course_settings']['fields'];
		$arr = array(array(
				'label'=> __('Batch Seat Price','wplms-bb' ),
				'text'=>__('Price Per Batch Seats','wplms-bb' ),
				'type'=> 'number',
				'style'=>'',
				'id' => 'wplms_price_per_batch_seat',
				'from'=> 'meta',
				'default'=>0,
				'desc'=> __('','wplms-bb' )
			));
		array_splice($fields, (count($fields)-5), 0,$arr );
		$settings['course_settings']['fields'] = $fields;
	    return $settings;
	}

} // End of class Wplms_Buy_Batch_Filters

Wplms_Buy_Batch_Filters::init();
