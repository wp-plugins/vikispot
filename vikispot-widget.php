<?php
/*
 * Plugin Name: VikiSpot
 * Version: 2.0.2
 * Plugin URI: http://wpdemo.vikispot.com/embedding-dynamic-content-in-your-blog
 * Description: Content Widgets by VikiSpot.
 * Author: VikiSpot
 * Author URI: http://www.vikispot.com
 */
 
include 'abstract-widget.php';
include 'content-widget.php';
include 'stream-widget.php';	
	
function VikiSpotTopPost(){

	global $posts;
	global $post;
	

	if($posts != null && count($posts) > 0){
		$result = $posts[0];
	}else{
		$result = $post;
	}
	
	
	return $result;
}	

function VikiSpotPost(){

	global $posts;
	global $post;
	
	if($posts != null && count($posts) >= 2){
		$result = null;
	}else{
		$result = $post;
	}
	
	
	return $result;
}
	
	
function VikiSpotPickTopic($topic, $post){

	//$post = VikiSpotTopPost();

	if($topic != ''){
		return $topic;
	}
	
	$custom_fields = get_post_custom($post->ID);
  	$topics = $custom_fields['vikispot'];
  	
  	if($topics){  	
	  	foreach ( $topics as $value ){		
	  		return $value;
	  	}
  	}
	
	/*
	
	//Disabled tags and cats for now
	$posttags = get_the_tags();
	
	if ($posttags) {
		foreach($posttags as $tag) {
			//echo $tag->name . ' '; 
			return $tag->name;
		}
	}

	
	$cats = get_the_category();
	
	if($cats){
		foreach($cats as $category) { 
		    //echo $category->cat_name . ' '; 
		    if($category->cat_name != 'Uncategorized'){
		    	return $category->cat_name;
		    }
		} 
	
	}
	*/

	
	
	return $post->post_title;
	
	
}	
	
	
function VikiSpotPickTb(){

	if(!function_exists('get_post_thumbnail_id')){
		return null;
	}


	$post = VikiSpotPost();

	if($post == null){
		return null;
	}

	$post_thumbnail_id = get_post_thumbnail_id($post->ID);
	$tb_array = wp_get_attachment_image_src($post_thumbnail_id, 0);
	$tb;
	
	if($tb_array != null){
		$tb = $tb_array[0];	
	}	
	
	return $tb;
}	


function VikiSpotPickDesc(){

	$post = VikiSpotPost();
	
	if($post == null){
		return null;
	}
	
	return $post->post_excerpt;

}
	
function VikiSpotInit() {
	register_widget('VikiSpotContentWidget');
	register_widget('VikiSpotStreamWidget');
}	

add_action('widgets_init', 'VikiSpotInit');


function VikiSpotScriptsInit(){

	if(!is_admin()){	 
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('jsapi', 'http://www.google.com/jsapi');
		
		$debug = $_GET['vsdebug'];
		
		if('true' == $debug){
			wp_enqueue_script('contentv2.js', 'http://vikispottest.dyndns-ip.com/p/widgetjs', '', '2.0.2', true);
		}else{
			wp_enqueue_script('contentv2.js', 'http://api.vikispot.com/widget/contentv2.js', '', '2.0.2', true);
		}
		
		
	}
	

}

add_action('wp_print_scripts', 'VikiSpotScriptsInit');

function VikiSpotHeadInit(){
	$tb = VikiSpotPickTb();
	if($tb != null){
		echo '<meta property="og:image" content="' . $tb . '"/>';
	}
	$desc = VikiSpotPickDesc();
	if($desc != null){
		$desc = strip_tags($desc);
		echo '<meta property="og:description" content="' . $desc . '"/>';
	}
	
}


add_action('wp_head', 'VikiSpotHeadInit');


function VikiSpotTopic($text){
	
	global $post;
	$topic = VikiSpotPickTopic('', $post);
	$link = get_permalink();
	
	if($topic){
		$tag1 = '<div class="vs-topic" topic="'.$topic.'" link="' . $link . '">';
		$tag2 = '</div>';
		return $tag1 . $text . $tag2;
	}
	
	return $text;
}

add_filter('the_content', 'VikiSpotTopic');





?>