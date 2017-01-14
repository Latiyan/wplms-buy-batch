<?php
/**
 * Initialise WPLMS Buy Batches
 *
 * @class       WPLMS_Buy_Batch_Class
 * @author      H.K. Latiyan
 * @category    Admin
 * @package     WPLMS-Buy-Batch/admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPLMS_Buy_Batch_Class{

	public static $instance;
	public static function instance_buy_batch_class(){
	    if ( is_null( self::$instance ) )
	        self::$instance = new WPLMS_Buy_Batch_Class();
	    return self::$instance;
	}

	private function __construct(){
		add_shortcode('wplms_buy_batch', array($this,'wplms_buy_batch_shortcode'));

	} // END public function __construct

	public function activate(){

	}

	public function deactivate(){
		
	}

	function wplms_buy_batch_shortcode($atts,$content = null){

		$defaults = array(
			'status'=>'private',
			'courses'=>array(),
			'seats'=>0,
			'buy_batch'=>1,
		);

		/* merge atts and defaults */
		$atts = wp_parse_args($atts,$defaults);

		/* create buy batch form */
		?>
		<div class="wplms_buy_batch_form">
			<form method="post">
			<!-- Batch Name -->
				<li><label><?php _e('Name: ','wplms-bb'); ?></label><span><input type="text" name="batch_name" class="batch_name" placeholder="<?php _e('Batch Name','wplms-bb'); ?>"></span></li></br>

			<!-- Batch Courses -->
				<?php
				if(empty($atts['courses'])){
					?>
					<li><label class="course_label"><?php _e('Select Courses: ','wplms-bb'); ?></label>
					<span>
						<select name="batch_course[]" class="batch_courses form_field chosen" multiple>
							<option value=""><?php _e('None','wplms-bb'); ?></option>
		                    <?php
		                        global $wpdb;
								$courses = $wpdb->get_results("SELECT m.post_id as id,p.post_title as title,m.meta_value as seat_price FROM {$wpdb->postmeta} as m LEFT JOIN {$wpdb->posts} as p ON p.id = m.post_id WHERE m.meta_key = 'wplms_price_per_batch_seat'");

								if(!empty($courses)){
								  foreach ($courses as $course){
								  	echo '<option class="price" data-id="'.$course->seat_price.'" value="' . $course->id . '"> '.$course->title . '</option>';
								  }
								}
		                    ?>
						</select>
					</span></li></br>
					<?php
				}else{
					?>
					<li><label class="course_label"><?php _e('Courses: ','wplms-bb'); ?></label>

					<span>
						<select name="batch_course[]" class="batch_courses form_field chosen" multiple>
							<option value=""><?php _e('None','wplms-bb'); ?></option>
		                    <?php
			                    if(!is_array($atts['courses'])){
			                    	$atts['courses'] = explode(',',$atts['courses']);
			                    }
		                    	foreach ($atts['courses'] as $course){
									$price = get_post_meta($course,'wplms_price_per_batch_seat',true);
									if(!empty($price)){
										echo '<option class="price" data-id="'.$price.'" value="' . $course . '"> '.get_the_title($course) . '</option>';
									}
								}
		                    ?>
						</select>
					</span></li></br>
					<?php
				}
				?>
				
			<!-- Batch Seats -->	
				<?php
				if($atts['seats'] == 0){
					?>
					<li><label><?php _e('Select Batch Seats: ','wplms-bb'); ?></label><span><input type="number" name="batch_seats" class="batch_seats" placeholder="<?php _e('Batch seats','wplms-bb'); ?>"></span></li></br>
					<?php
				}else{
					?>
					<li><label><?php _e('Batch Seats: ','wplms-bb'); ?></label><span  class="batch_seats" data-seats="<?php echo $atts['seats']; ?>"><?php echo $atts['seats']; ?></span></li></br>
					<?php
				}
				?>

			<!-- Check Woocommerce Currency Symbol -->
				<?php
				global  $woocommerce;
   				$currency_symbol = get_woocommerce_currency_symbol();
   				echo '<div class="currency_symbol" style="display:none;">'.$currency_symbol.'</div>';
				?>
				
			<!-- Buy Batch Button -->
				<?php echo '<a class="button-primary button" id="wplms_buy_batch">'.__('Buy Batch','wplms-bb').'</a>'; ?>

				<input type="hidden" class="batch_status" data-status="<?php echo $atts['status']; ?>">
				<input type="hidden" class="buy_batch" data-batch="<?php echo $atts['buy_batch']; ?>">
			</form> <!-- End of Buy Batch Form -->
		</div>
		<?php
	}

} // End of class WPLMS_Buy_Batch_Class
