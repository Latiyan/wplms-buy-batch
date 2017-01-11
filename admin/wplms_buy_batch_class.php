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
	} // END public function __construct

	public function activate(){

	}

	public function deactivate(){
		
	}

	function wplms_buy_batch_shortcode(){
		
	}

}