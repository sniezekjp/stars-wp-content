<?php
$list_type = 'marked';
$title = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($list_type == 'font' and !empty($title)) {
	$content = str_replace('<ul>', '<ul class="stm-list-icon">', $content);
	$content = str_replace('<li>', '<li><i class="'.$title.'"></i>', $content);
}
?>


<?php echo wpb_js_remove_wpautop($content, false); ?>