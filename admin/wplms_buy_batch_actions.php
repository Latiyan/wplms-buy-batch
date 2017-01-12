<?php
/**
 * Initialise WPLMS Buy Batches
 *
 * @class       Wplms_Buy_Batch_Actions
 * @author      H.K. Latiyan
 * @category    Admin
 * @package     WPLMS-Buy-Batch/admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wplms_Buy_Batch_Actions{

	public static $instance;
	public static function init(){

	    if ( is_null( self::$instance ) )
	        self::$instance = new Wplms_Buy_Batch_Actions();
	    return self::$instance;
	}

	private function __construct(){

		add_action('wp_ajax_buy_wplms_batch',array($this,'buy_wplms_batch'));
		add_action('woocommerce_order_status_completed',array($this,'create_batch_on_order_completion'));

	} // END public function __construct

	function buy_wplms_batch(){
		if(isset($_POST['batch_name']) && isset($_POST['batch_seats']) && isset($_POST['batch_courses'])){

			$batch_name = $_POST['batch_name'];
			$courses = $_POST['batch_courses'];
			$batch_seats = $_POST['batch_seats'];

            /* Creat product */
            $post_args = array('post_type' => 'product','post_status'=>'publish','post_title'=>$batch_name);
	        $product_id = wp_insert_post($post_args);

	        /* Product Price */
	        $product_price = 0;
        	foreach ($courses as $course_id) {
        		$price_per_seat = get_post_meta($course_id,'wplms_price_per_batch_seat',true);
        		if(!empty($price_per_seat)){
        			$price = $price_per_seat*$batch_seats;
        			$product_price += $price;
        		}
        	}
	        update_post_meta($product_id,'_price', $product_price);

	        /* Product Settings */
	        wp_set_object_terms($product_id, 'simple', 'product_type');
	        update_post_meta($product_id,'_visibility','hidden');
	        update_post_meta($product_id,'_virtual','yes');
	        update_post_meta($product_id,'_downloadable','yes');
	        update_post_meta($product_id,'_sold_individually','yes');
	        update_post_meta($product_id,'_stock_status','instock');

	        /* Add Batch information in product meta */
	        $batch_info = array(
	        		'batch_name' => $batch_name,
	        		'batch_courses' => $courses,
	        		'batch_seats' => $batch_seats
	        	);
	        update_post_meta($product_id,'wplms_buy_batch_information',$batch_info);

	        /* Redirect user to cart page on ajax success */
	        global $woocommerce;
	        $cart_url = $woocommerce->cart->get_cart_url();
	        $cart_url = $cart_url.'?add-to-cart='.$product_id;

	        echo $cart_url;
		}
	}

	function create_batch_on_order_completion($order_id){
		
	}

} // End of class Wplms_Buy_Batches_Actions
