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
	} // END public function __construct

	function buy_wplms_batch(){
		if(isset($_POST['batch_name']) && isset($_POST['batch_seats']) && isset($_POST['batch_courses'])){

			$batch_name = $_POST['batch_name'];
			$courses = $_POST['batch_courses'];
			$batch_seats = $_POST['batch_seats'];
			$user_id = get_current_user_id();

			$group_settings = array(
	            'creator_id' => $user_id,
	            'name' => $batch_name,
	            'status' => 'private',
	            'date_created' => current_time('mysql')
	        );

	        /* Create group/batch */
	        $group_id = groups_create_group( $group_settings);

	        if(is_numeric($group_id)){

	        	/* Add batch settings */
	        	groups_update_groupmeta( $group_id, 'total_member_count', 1 );
            	groups_update_groupmeta( $group_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );
            	groups_update_groupmeta( $group_id, 'course_batch',1);
            	foreach ($courses as $course_id) {
            		groups_add_groupmeta($group_id,'batch_course',$course_id);
            	}
            	groups_update_groupmeta( $group_id, 'enable_seats', 1 );
            	groups_update_groupmeta( $group_id, 'batch_seats',$batch_seats);
            	groups_update_groupmeta( $group_id, 'batch_exclusivity', 1 );
	        }
		}
	}

} // End of class Wplms_Buy_Batches_Actions
