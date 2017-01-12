<?php

class WPLMS_Buy_Batch_Class{

	public static $instance;
	public static function instance_buy_batch_class(){
	    if ( is_null( self::$instance ) )
	        self::$instance = new WPLMS_Buy_Batch_Class();
	    return self::$instance;
	}

	private function __construct(){
		add_shortcode('wplms_buy_batch', array($this,'wplms_buy_batch_shortcode'));
		add_action('wp_ajax_buy_wplms_batch',array($this,'buy_wplms_batch'));

	} // END public function __construct

	public function activate(){

	}

	public function deactivate(){
		
	}

	function wplms_buy_batch_shortcode($atts,$content = null){

		$defaults = array(
			'name'=>__('name','wplms-bb'),
			'courses'=>array(),
			'seats'=>0,
			);

		/* merge atts and defaults */
		$atts = wp_parse_args($atts,$defaults);

		/* create buy batch form */
		?>
		<div class="wplms_buy_batch_form">
			<form method="post">
				<label><?php _e('Name: ','wplms-bb'); ?></label><span><input type="text" name="batch_name" class="batch_name" placeholder="<?php _e('Batch Name','wplms-bb'); ?>"></span></br>

				<label><?php _e('Select Courses: ','wplms-bb'); ?></label><span>
					<select name="batch_course[]" class="batch_courses form_field chosen" multiple>
						<option value=""><?php _e('None','wplms-bb'); ?></option>
	                    <?php
	                        $args= array(
	                        'post_type'=> 'course',
	                        'posts_per_page'=> -1
	                        );
	                        $args = apply_filters('wplms_frontend_cpt_query',$args);
	                        
	                        $kposts = get_posts($args);

	                        foreach ( $kposts as $kpost ){
	                            echo '<option value="' . $kpost->ID . '"> '.$kpost->post_title . '</option>';
	                        }
	                    ?>
					</select>
				</span></br>

				<label><?php _e('Select Batch Seats: ','wplms-bb'); ?></label><span><input type="number" name="batch_seats" class="batch_seats" placeholder="<?php _e('Batch seats','wplms-bb'); ?>"></span></br>

				<?php echo '<a class="button-primary button" id="wplms_buy_batch">'.__('Buy Batch','wplms-bb').'</a>'; ?>
			</form>
		</div>
		<?php

	}

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

}
