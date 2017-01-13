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
				<label><?php _e('Name: ','wplms-bb'); ?></label><span><input type="text" name="batch_name" class="batch_name" placeholder="<?php _e('Batch Name','wplms-bb'); ?>"></span></br>

				<?php
				if(empty($atts['courses'])){
					?>
					<label class="course_label"><?php _e('Select Courses: ','wplms-bb'); ?></label>
					<span>
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
					<?php
				}else{
					?>
					<label class="course_label"><?php _e('Courses: ','wplms-bb'); ?></label>
					<span>
						<?php
						$courses = implode(',', $atts['courses']);
						echo '<input type="hidden" class="batch_courses" data-ids="'.$courses.'">';
						foreach ($atts['courses'] as $course){
							echo get_the_title($course);
						}
						?>
					</span>
					<?php
				}
				?>
				
				<?php
				if($atts['seats'] == 0){
					?>
					<label><?php _e('Select Batch Seats: ','wplms-bb'); ?></label><span><input type="number" name="batch_seats" class="batch_seats" placeholder="<?php _e('Batch seats','wplms-bb'); ?>"></span></br>
					<?php
				}else{
					?>
					<label><?php _e('Batch Seats: ','wplms-bb'); ?></label><span  class="batch_seats" data-seats="<?php echo $atts['seats']; ?>"><?php echo $atts['seats']; ?></span>
					<?php
				}
				?>

				<?php echo '<a class="button-primary button" id="wplms_buy_batch">'.__('Buy Batch','wplms-bb').'</a>'; ?>

				<input type="hidden" class="batch_status" data-status="<?php echo $atts['status']; ?>">
				<input type="hidden" class="buy_batch" data-batch="<?php echo $atts['buy_batch']; ?>">
			</form>
		</div>
		<?php
	}

} // End of class WPLMS_Buy_Batch_Class
