<?php
 
class VikiSpotStreamWidget extends VikiSpotWidget
{
	
	function VikiSpotStreamWidget(){
		$widget_ops = array('classname' => 'vikispot-stream', 'description' => __( "Stream Widget by VikiSpot") );
		$control_ops = array('width' => 200, 'height' => 300);
		$this->WP_Widget('vikispot-stream', __('VikiSpot (Stream)'), $widget_ops, $control_ops);
	}
	

	
	
	function echoWidget($args, $instance){
		
		extract($args);
		extract($instance);
		
		$title = apply_filters('widget_title', $instance['title']);

		$news = $this->checked($instance['news']);
		$video = $this->checked($instance['video']);
		$image = $this->checked($instance['image']);
		$blog = $this->checked($instance['blog']);
		$compact = $this->checked($instance['compact']);
	
		if($label == ''){
			$label = $title;
		}

		$label = str_replace('ytchannel:', '', $label);

		echo $before_widget;
		
		echo $before_title . '<span class="vs-name">'.$label.'</span>'. $after_title;

		$topPost = VikiSpotTopPost();

		$name = VikiSpotPickName($title, $topPost);
		$title = VikiSpotPickTopic($title, $topPost);
		
		
		
		$link = get_permalink();
		
		/*
		echo '<noscript>JavaScript disabled. Continue to <a href="http://www.vikispot.com" title="VikiSpot" target="_blank">' . $title . '</a>.</noscript>';
		*/
		
		
		$this->echoHead('vs-stream');
		
		$this->echoParam("name", $name);
		$this->echoParam("topic", $title);
		$this->echoParam("news", $news);
		$this->echoParam("video", $video);
		$this->echoParam("blog", $blog);
		$this->echoParam("compact", $compact);
		$this->echoParam("link", $link);
		$this->echoParam("line", $line);
		$this->echoParam("css", $css);
		$this->echoParam("font", $font);
		$this->echoParam("lang", $lang);
		$this->echoParam("imgw", $imgw);
		$this->echoParam("desc", $desc);
		$this->echoParam("grid", $grid);
		$this->echoParam("count", $count);
		$this->echoParam("vsize", $vsize);
		
		if(!VikiSpotSubmit()){
			$this->echoParam("submit", "false");
		}
		
		$this->echoTail();
		
		echo $after_widget;
	}
	


	function defaultParams(){
		return array('count'=>'8', 'line'=>'4', 'name'=>'', 'news'=>'', 'video'=>'', 'image'=>'', 'blog'=>'', 'selected'=>'news', 
		'compact'=>'', 'css'=>'simple', 'font'=>'', 'label'=>'', 'lang'=>'en', 'imgw'=>'80', 'desc'=>'4', 'grid'=>'1', 'vsize'=>'');
	}
	
	function echoForm($instance){
		
		extract($instance);
		
		$title = htmlspecialchars($instance['title']);
		
		$tip = '(The header above the widget. If not specified, the topic will be shown instead.)';
		$this->makeTextField('label', 'Label', $label, $tip);
		
		$tip = '(Leave blank to use post-specific topic. To specifiy a post topic, add a custom field with the name "vikispot" when editing post.)';		
		$this->makeTextField('title', 'Topic', $title, $tip);		
		
		
		$this->makeCheckField('news', 'News', $news);
		$this->makeCheckField('video', 'Video', $video);
		
		/*
		$this->makeCheckField('image', 'Image', $image);
		*/
		
		$this->makeCheckField('blog', 'Blog', $blog);
		
		$this->makeLanguageBox($lang);
		
		$values = array('', '12', '13', '14', '15', '16', '17', '18');
		$displays = array('Default', '12px', '13px', '14px', '15px', '16px', '17px', '18px');
		$this->makeComboField('font', 'Font', $values, $displays, $font, '');
		
		$values = array('0', '80', '120');
		$displays = array('None', '80px', '120px');
		$this->makeComboField('imgw', 'Thumbnail', $values, $displays, $imgw, '');
		
		
		$values = array('1', '2', '3', '4');
		$displays = array('None', '2 items', '3 items', '4 items');
		$this->makeComboField('grid', 'Column', $values, $displays, $grid, '');
		
		
		$values = array('1', '2', '3', '4', '5', '6', '7', '8');
		$displays = array('1 item', '2 items', '3 items', '4 items', '5 items', '6 items', '7 items', '8 items');
		$this->makeComboField('line', 'Display Count', $values, $displays, $line, '');
		
		$values = array('1', '2', '3', '4', '5', '6', '7', '8');
		$displays = array('1 item', '2 items', '3 items', '4 items', '5 items', '6 items', '7 items', '8 items');
		$this->makeComboField('count', 'Items Count', $values, $displays, $count, '');
		
		$this->makeVideoBox();		
		

		$values = array('1', '2', '3', '4', '5', '6', '7', '0');
		$displays = array('1 line', '2 lines', '3 lines', '4 lines', '5 lines', '6 lines', '7 lines', 'Flexible');
		$this->makeComboField('desc', 'Summary Height', $values, $displays, $desc, '');
		
		
		$this->makeCheckField('compact', 'Compact', $compact);
		
		/*
		$values = array('', 'simple', 'hot-sneaks', 'ui-lightness', 'smoothness', 'start', 'redmond', 'sunny', 'overcast', 'flick', 'pepper-grinder', 'eggplant', 'dark-hive', 'cupertino', 'south-street', 'blitzer', 'humanity', 'excite-bike', 'black-tie' );
		$displays = array('Parent Page', 'Parent Simple', 'Hot Sneaks', 'Lightness', 'Smoothness', 'Start', 'Redmond', 'Sunny', 'Overcast', 'Flick', 'Pepper Grinder', 'Eggplant', 'Dark Hive', 'Cupertino', 'South Street', 'Blitzer', 'Humanity', 'Excite Bike', 'Black Tie' );		
		$this->makeComboField('css', 'Style', $values, $displays, $css, '');
		*/
		
		
		$this->makeHelpBox();
		
	}
	
}
	



?>