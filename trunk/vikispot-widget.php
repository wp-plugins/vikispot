<?php
/*
 * Plugin Name: VikiSpot
 * Version: 1.0.8
 * Plugin URI: http://about.vikispot.com/wordpress/dynamic-content/
 * Description: Content widget by VikiSpot.
 * Author: VikiSpot
 * Author URI: http://www.vikispot.com
 */
 

 
class VikiSpotContentWidget extends WP_Widget
{
	
	function VikiSpotContentWidget(){
		$widget_ops = array('classname' => 'vikispot', 'description' => __( "Related Content Widget by VikiSpot") );
		$control_ops = array('width' => 200, 'height' => 300);
		$this->WP_Widget('vikispot', __('VikiSpot'), $widget_ops, $control_ops);
	}
	
	
	function widget($args, $instance){
		
		
		
		if($this->checkDisabled()){
			echo $before_widget;
			echo $before_title;
			echo $after_title;
			echo $after_widget;
		}else{
			$this->echoWidget($args, $instance);
		}
	
		
	}
	
	
	function echoWidget($args, $instance){
		extract($args);
		
		$instance = $this->setDefault($instance);
		
		
		$title = apply_filters('widget_title', $instance['title']);
		
		$label = $instance['label'];
		
		$count = $instance['count'];
		$line = $instance['line'];
		
		
		$news = $this->checked($instance['news']);
		$video = $this->checked($instance['video']);
		$image = $this->checked($instance['image']);
		$blog = $this->checked($instance['blog']);
		
		$selected = $instance['selected'];
		
		
		$compact = $this->checked($instance['compact']);
		
		$css = $instance['css'];
		$font = $instance['font'];
		
		if($label == ''){
			$label = $title;
		}

		echo $before_widget;
		
		echo $before_title . '<span class="vs-name">'.$label.'</span>'. $after_title;

		$title = VikiSpotPickTopic($title);
	
		echo '<div class="vs-content" name="' . $title .'" news="'.$news.'" video="'.$video.'" image="'.$image .'" blog="'. $blog . 
		'" compact="' . $compact .
		'" selected="'.$selected.'" count="'.$count.'" line="'.$line.'" css="'.$css.'" font="'.$font.'"></div>';
		
		echo $after_widget;
	}
	
	

	

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['label'] = strip_tags(stripslashes($new_instance['label']));
		$instance['count'] = $new_instance['count'];
		$instance['line'] = $new_instance['line'];
		$instance['news'] = $new_instance['news'];
		$instance['video'] = $new_instance['video'];
		$instance['image'] = $new_instance['image'];
		$instance['blog'] = $new_instance['blog'];
		$instance['selected'] = $new_instance['selected'];
		$instance['compact'] = $new_instance['compact'];
		$instance['css'] = $new_instance['css'];
		$instance['font'] = $new_instance['font'];
		return $instance;
	}
	
	
	function checkDisabled(){
	
		$custom_fields = get_post_custom();
	  	$disable = $custom_fields['vs-disabled'];
	  	
	  	if($disable){  	
			return true;
	  	}
	  	
	  	return false;
	}
	
	
	function makeTextField($var, $label, $value, $desc){
		
		echo '<p>';
		echo '<label for="' . $this->get_field_name($var) . '">'.__($label).'</label>';
		echo ' <input style="width: 100%" id="' . $this->get_field_id($var) . '" name="' . $this->get_field_name($var) . '" type="text" value="' . $value . '" />';
		echo $desc;
		echo '</p>';		
	}
	
	function makeComboField($var, $label, $values, $displays, $default){
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id($var) . '">'.__($label).'</label>';
		echo '<select style="width:100%;" id="' . $this->get_field_id($var) . '" name="' . $this->get_field_name($var) . '">';
			
		
		for($i = 0; $i < sizeof($values); $i=$i+1){
			$sel = '';
			if($values[$i] == $default){
				$sel = ' selected="selected"';
			}
			echo '<option value="' . $values[$i] . '"'.$sel.'>'. $displays[$i].'</option>';
		}  
			
		echo '</select>';
		echo '</p>';	
	}

	function makeCheckField($var, $label, $value){
	
		$checked = '';
		if($value == 'on'){
			$checked = ' checked="checked"';
		}
		
		echo '<p>';
		
		echo ' <input id="' . $this->get_field_id($var) . '" name="' . $this->get_field_name($var) . '" type="checkbox"'.$checked.'/>';
		echo '<label style="margin-left:5px;" for="' . $this->get_field_id($var) . '">';
		echo  __($label) . '</label></p>';		
	}
	
	function makeHelpBox(){
	
		echo '<p>Help: <a href="http://www.vikispot.com" target="_blank">WidgetMaker</a>, <a href="http://getsatisfaction.com/vikispot" target="_blank">Support</a></p>';
		echo '<p>Plugin News: <a href="http://twitter.com/vikispot" target="_blank">Twitter</a>, <a href="http://www.facebook.com/apps/application.php?id=261143120269&v=wall" target="_blank">Facebook</a></p>';
	
	}
	
	
	function checked($checked){
		if($checked == 'on') return 'true';
		else return 'false';
	}
	
	function setDefault($instance){
		$instance = wp_parse_args( (array) $instance, array('count'=>'8', 'line'=>'4', 'name'=>'', 'news'=>'', 'video'=>'on', 'image'=>'', 'blog'=>'', 'selected'=>'video', 
		'compact'=>'', 'css'=>'simple', 'font'=>'', 'label'=>'') );
		return $instance;
	}

	
	function form($instance){
		
		$instance = $this->setDefault($instance);
		
		$title = htmlspecialchars($instance['title']);
		$count = $instance['count'];
		$line = $instance['line'];
		
		$news = $instance['news'];
		$video = $instance['video'];
		$image = $instance['image'];
		$blog = $instance['blog'];
		$selected = $instance['selected'];
		$compact = $instance['compact'];
		$css = $instance['css'];
		$font = $instance['font'];
		
		
		$label = $instance['label'];
		$desc = '(The header above the widget. If not specified, the topic will be shown instead.)';
		$this->makeTextField('label', 'Label', $label, $desc);
		

		$desc = '(Leave blank to use post-specific topic. To specifiy a post topic, add a custom field with the name "vikispot" when editing post.)';		
		$this->makeTextField('title', 'Topic', $title, $desc);		
		
		
		$this->makeCheckField('news', 'News', $news);
		$this->makeCheckField('video', 'Video', $video);
		$this->makeCheckField('image', 'Image', $image);
		$this->makeCheckField('blog', 'Blog', $blog);
		
		$values = array('news', 'video', 'image', 'blog');
		$displays = array('News', 'Video', 'Image', 'Blog');
		$this->makeComboField('selected', 'Selected', $values, $displays, $selected);
		
		$values = array('1', '2', '3', '4', '5', '6', '7', '8');
		$displays = $values;
		$this->makeComboField('count', 'Items Count', $values, $displays, $count);
		
		$values = array('1', '2', '3', '4', '5', '6', '7', '8');
		$displays = $values;
		$this->makeComboField('line', 'Display Count', $values, $displays, $line);
		
		
		$this->makeCheckField('compact', 'Compact', $compact);
		
		$values = array('', 'simple', 'hot-sneaks', 'ui-lightness', 'smoothness', 'start', 'redmond', 'sunny', 'overcast', 'flick', 'pepper-grinder', 'eggplant', 'dark-hive', 'cupertino', 'south-street', 'blitzer', 'humanity', 'excite-bike', 'black-tie' );
		$displays = array('Parent Page', 'Parent Simple', 'Hot Sneaks', 'Lightness', 'Smoothness', 'Start', 'Redmond', 'Sunny', 'Overcast', 'Flick', 'Pepper Grinder', 'Eggplant', 'Dark Hive', 'Cupertino', 'South Street', 'Blitzer', 'Humanity', 'Excite Bike', 'Black Tie' );		
		$this->makeComboField('css', 'Style', $values, $displays, $css);
		
		
		$values = array('', '12', '13', '14', '15', '16', '17', '18');
		$displays = array('Default', '12px', '13px', '14px', '15px', '16px', '17px', '18px');
		$this->makeComboField('font', 'Font', $values, $displays, $font);
		
		$this->makeHelpBox();
		
	}
	
}
	
function VikiSpotPickTopic($topic){

	global $post;

	
	if($topic != ''){
		return $topic;
	}
	
	$custom_fields = get_post_custom();
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
	
	
function VikiSpotInit() {
	register_widget('VikiSpotContentWidget');
}	
add_action('widgets_init', 'VikiSpotInit');

function VikiSpotScriptsInit(){

	//if(is_active_widget(false, false, 'vikispot') && !is_admin()){	 

	if(!is_admin()){	 
		wp_enqueue_script('content.js', 'http://cdn.vikispot.com/widget/content.js', '', '', true);
	}

}



add_action('wp_print_scripts', 'VikiSpotScriptsInit');

function VikiSpotTopic($text){
	
	$topic = VikiSpotPickTopic('');
	if($topic){
		$tag1 = '<div class="vs-topic" topic="'.$topic.'">';
		$tag2 = '</div>';
		return $tag1 . $text . $tag2;
	}
	
	return $text;
}

add_filter('the_content', 'VikiSpotTopic');





?>