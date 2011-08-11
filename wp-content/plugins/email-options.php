<?php
/*
Plugin Name: Change Email Address and Sender
Plugin URI: http://blog.sowink.com
Description: Changes the Email From address and the Sender name.
Version: 0.5
Author: Marius Craciunoiu
Author URI: http://sowink.com
*/

class emailFrom{
	public function __construct(){
		add_filter('wp_mail_from', array(&$this, 'doEmailFilter'),10, 1);
		add_filter('wp_mail_from_name', array(&$this, 'doEmailNameFilter'), 10, 1);
	}

	public function doEmailFilter($data){
		return 'info@sowink.com';
	}
	public function doEmailNameFilter($data){
		return 'SoWink Blog';
	}
}
$_ef = new emailFrom();

?>