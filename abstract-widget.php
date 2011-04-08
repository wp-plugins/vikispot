<?php
 
class VikiSpotWidget extends WP_Widget
{
	
	/*
	
	There are 3 functions to be implemented. widget(), update(), form(). widget is implemented and echoWidget() is called.
	
	*/

	function widget($args, $instance){

		if($this->checkDisabled()){
			echo $before_widget;
			echo $before_title;
			echo $after_title;
			echo $after_widget;
		}else{
			$instance = $this->setDefault($instance);		
			$this->echoWidget($args, $instance);
		}
	
		
	}
	
	//abstract method
	function echoWidget($args, $instance){
	
	}
	
	
	function update($new_instance, $old_instance){
		/*
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
		*/
		return $new_instance;
	}



	function form($instance){
		
		$instance = $this->setDefault($instance);		
		$this->echoForm($instance);
		
	}
	
	function setDefault($instance){
	
		$instance = wp_parse_args( (array) $instance, $this->defaultParams());
		return $instance;
	}
	
	//abstract method
	function defaultParams(){
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
	
	
	function makeComboField($var, $label, $values, $displays, $default, $desc){
		
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
		echo $desc;
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
	
		
		$help = '<div>Tools &#38; Tips:</div><p>'
		. '<a title="Help/Feedback" target="_blank" href="http://www.vikispot.com/spot/826993/feedback">Help+Feedback</a>,'		
		. '<a href="http://market.android.com/details?id=com.pekca.vikispot.android" target="_blank">Android Reader</a>, '
		. '<a href="http://www.vikispot.com/widgetmaker" target="_blank">Widget Maker</a>, '
		. '<a title="Embedding Dynamic Content in your Blog" target="_blank" href="http://wpdemo.vikispot.com/embedding-dynamic-content-in-your-blog">WP Demo</a> '		
		. '</p>';
		echo $help;
	}
	
	function echoHead($cls){
		echo '<div class="'.$cls.'"';
	}
	
	function echoTail(){
		echo '></div>';
	}
	
	function echoParam($name, $value){
		echo ' ' . $name . '="' . $value . '"';
	}
	
	function checked($checked){
		if($checked == 'on') return 'true';
		else return 'false';
	}
	
	function makeLanguageBox($lang){
		$values = array('ar', 'bg', 'ca', 'zh-CN', 'zh-TW', 'hr', 'cs', 'nl', 'en', 'fi', 'fr', 'de', 'el', 'hu', 'id', 'it', 'ja', 'ko', 'lv', 'lt', 'no', 'pl', 'ro', 'ru', 'sr', 'sk', 'sl', 'es', 'sv', 'tr');
		$displays = array('Arabic', 'Bulgarian', 'Catalan', 'Chinese (Simplified)', 'Chinese (Traditional)', 'Croation', 'Czech', 'Dutch', 'English', 'Finnish', 'French', 'German', 'Greek', 'Hungarian', 'Indonesian', 'Italian', 'Japanese', 'Korean', 'Latvian', 'Lithuanian', 'Norwegian', 'Polish', 'Romanian', 'Russian', 'Serbian', 'Slovak', 'Slovenian', 'Spanish', 'Swedish', 'Turkish');		
		$this->makeComboField('lang', 'Language', $values, $displays, $lang, '');
	}
	
	function makeVideoBox(){
		$values = array('', '640', '853', '1280');
		$displays = array('None', '640', '853', '1280');
		$this->makeComboField('vsize', 'Popup Video Player Size', $values, $displays, $vsize, '(Video player will not popup if screen size is too small. Out dated browsers, such as IE6 or less, will always go directly to video source. This is a Beta feature.)');		
	}
		
	
}
	



?>