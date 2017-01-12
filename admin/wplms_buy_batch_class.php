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

		
	}

}
