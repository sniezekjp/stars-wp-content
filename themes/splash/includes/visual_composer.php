<?php

add_action( 'vc_before_init', 'splash_vc_set_as_theme' );

function splash_vc_set_as_theme() {
	vc_set_as_theme( true );
}

if( function_exists( 'vc_set_default_editor_post_types' ) ){
	vc_set_default_editor_post_types( array( 'page', 'post', 'donation', 'vc_sidebar', 'product', 'sp_calendar', 'sp_event', 'sp_player', 'sp_team', 'sp_list' ) );
}

add_action( 'init', 'splash_update_existing_shortcodes' );

function splash_update_existing_shortcodes(){
	if( function_exists( 'vc_remove_param' ) ){
		vc_remove_param( 'vc_cta_button2', 'h2' );
		vc_remove_param( 'vc_cta_button2', 'content' );
		vc_remove_param( 'vc_cta_button2', 'btn_style' );
		vc_remove_param( 'vc_cta_button2', 'color' );
		vc_remove_param( 'vc_cta_button2', 'size' );
		vc_remove_param( 'vc_cta_button2', 'css_animation' );

		//Accordion
		vc_remove_param( 'vc_tta_accordion', 'color' );
		vc_remove_param( 'vc_tta_accordion', 'shape' );
		vc_remove_param( 'vc_tta_accordion', 'style' );
		vc_remove_param( 'vc_tta_accordion', 'spacing' );
		vc_remove_param( 'vc_tta_accordion', 'c_align' );
		vc_remove_param( 'vc_tta_accordion', 'c_position' );
		vc_remove_param( 'vc_tta_accordion', 'gap' );
		vc_remove_param( 'vc_tta_accordion', 'c_icon' );

		//Tabs
		vc_remove_param( 'vc_tta_tabs', 'title' );
		vc_remove_param( 'vc_tta_tabs', 'style' );
		vc_remove_param( 'vc_tta_tabs', 'shape' );
		vc_remove_param( 'vc_tta_tabs', 'color' );
		vc_remove_param( 'vc_tta_tabs', 'spacing' );
		vc_remove_param( 'vc_tta_tabs', 'gap' );
		vc_remove_param( 'vc_tta_tabs', 'alignment' );
		vc_remove_param( 'vc_tta_tabs', 'pagination_style' );
		vc_remove_param( 'vc_tta_tabs', 'pagination_color' );

		//Toggle
		vc_remove_param( 'vc_toggle', 'style' );
		vc_remove_param( 'vc_toggle', 'color' );
		vc_remove_param( 'vc_toggle', 'size' );
	}

	if( function_exists( 'vc_remove_element' ) ){
		vc_remove_element( "vc_gallery" );
		//vc_remove_element( "vc_images_carousel" );
		vc_remove_element( "vc_tta_tour" );
		//vc_remove_element( "vc_btn" );
		vc_remove_element( "vc_cta" );
		vc_remove_element( "vc_tta_pageable" );
		vc_remove_element( "vc_cta_button" );
		vc_remove_element( "vc_posts_slider" );
		vc_remove_element( "vc_icon" );
		vc_remove_element( "vc_pinterest" );
		vc_remove_element( "vc_googleplus" );
		vc_remove_element( "vc_facebook" );
		vc_remove_element( "vc_tweetmeme" );
	}

}


if ( function_exists( 'vc_map' ) ) {
	add_action( 'init', 'splash_vc_elements' );
}

function splash_vc_elements() {
	$order_by_values = array(
		'',
		esc_html__( 'Date', 'splash' )          => 'date',
		esc_html__( 'ID', 'splash' )            => 'ID',
		esc_html__( 'Author', 'splash' )        => 'author',
		esc_html__( 'Title', 'splash' )         => 'title',
		esc_html__( 'Modified', 'splash' )      => 'modified',
		esc_html__( 'Random', 'splash' )        => 'rand',
		esc_html__( 'Comment count', 'splash' ) => 'comment_count',
		esc_html__( 'Menu order', 'splash' )    => 'menu_order',
	);

	$order_way_values = array(
		'',
		esc_html__( 'Descending', 'splash' ) => 'DESC',
		esc_html__( 'Ascending', 'splash' )  => 'ASC',
	);

	/*Teams*/
	$teams = get_posts(array('post_type' => 'sp_team', 'posts_per_page' => 9999));
	$teams_array = array( esc_html__( 'All', 'splash' ) => 0 );
	if($teams){
		foreach($teams as $team){
			$teams_array[$team->post_title] = $team->ID;
		}
	}

	/*Players list*/
	$player_lists = get_posts(array('post_type' => 'sp_list', 'posts_per_page' => 9999));
	$lists_array = array();
	if($player_lists){
		foreach($player_lists as $list){
			$lists_array[$list->post_title] = $list->ID;
		}
	}

	/*Players*/
	$players = get_posts(array('post_type' => 'sp_player', 'posts_per_page' => 9999));
	$players_array = array();
	if($players){
		foreach($players as $player){
			$players_array[] = array( 'label' => $player->post_title, 'value' => $player->ID );
		}
	}

	/*Tables*/
	$tables = get_posts(array('posts_per_page' => 9999, 'post_type' => 'sp_table'));
	$tables_array = array('0' => esc_html__('Empty', 'splash'));
	if($tables){
		$tables_array = array();
		foreach($tables as $table){
			$tables_array[$table->post_title] = $table->ID;
		}
	}

	/*Performance player*/
	$statistics = get_posts(array('post_type' => 'sp_statistic', 'posts_per_page' => 9999));
	$statistics_array = array();
	if($statistics){
		foreach($statistics as $statistic){
			$statistics_array[] = array( 'label' => $statistic->post_title, 'value' => $statistic->ID );
		}
	}

	$posts_categories = get_terms( 'category' );
	$post_categories_arr = array();

	foreach( $posts_categories as $posts_category ) {
		$post_categories_arr[] = array( 'label' => $posts_category->name, 'value' => $posts_category->slug );
	}

	/*Product categories*/
	$product_categories = get_terms( 'product_cat' );
	$product_categories_arr = array();

	if(!empty($product_categories) and !is_wp_error($product_categories)) {
		foreach ( $product_categories as $product_category ) {
			$product_categories_arr[] = array( 'label' => $product_category->name, 'value' => $product_category->slug );
		}
	}

	/*Leagues categories*/
	$leagues = get_terms( 'sp_league' );
	$leagues_array = array();

	if(!empty($leagues) and !is_wp_error($leagues)) {
		foreach ( $leagues as $league ) {
			$leagues_array[] = array( 'label' => $league->name, 'value' => $league->term_id );
		}
	}

	/*Season categories*/
	$seasons = get_terms( 'sp_season' );
	$seasons_array = array();

	if(!empty($seasons) and !is_wp_error($seasons)) {
		foreach ( $seasons as $season ) {
			$seasons_array[] = array( 'label' => $season->name, 'value' => $season->term_id );
		}
	}

	vc_map( array(
		'name'     => esc_html__( 'Icon list', 'splash' ),
		'base'     => 'stm_icon_list',
		'icon'     => 'stm_icon_list',
		'category' => esc_html__( 'STM', 'splash' ),
		'params'   => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'List type', 'splash' ),
				'param_name' => 'list_type',
				'value'    => array(
					esc_html__( 'Marked', 'splash' ) => 'marked',
					esc_html__( 'Numeric', 'splash' ) => 'numeric',
					esc_html__( 'Font icon', 'splash' ) => 'font',
				),
				'holder' => 'div'
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'splash' ),
				'param_name' => 'title',
				'dependency' => array('element' => 'list_type', 'value' => 'font'),
			),
			array(
				'type' => 'textarea_html',
				'heading' => esc_html__( 'Text', 'splash' ),
				'param_name' => 'content'
			),
		)
	) );

	vc_map( array(
		'name'     => esc_html__( 'Button', 'splash' ),
		'base'     => 'stm_button',
		'icon'     => 'stm_button',
		'category' => esc_html__( 'STM', 'splash' ),
		'params'   => array(
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'splash' ),
				'param_name' => 'link'
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button type', 'splash' ),
				'param_name' => 'button_type',
				'value'    => array(
					esc_html__( 'Primary', 'splash' ) => 'primary',
					esc_html__( 'Secondary', 'splash' ) => 'secondary',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button size', 'splash' ),
				'param_name' => 'button_size',
				'value'    => array(
					esc_html__( 'Normal', 'splash' ) => 'btn-sm',
					esc_html__( 'Medium', 'splash' ) => 'btn-md',
					esc_html__( 'Large', 'splash' ) => 'btn-lg',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button color style', 'splash' ),
				'param_name' => 'button_color_style',
				'value'    => array(
					esc_html__( 'Style 1', 'splash' ) => 'style-1',
					esc_html__( 'Style 2', 'splash' ) => 'style-2',
					esc_html__( 'Style 3', 'splash' ) => 'style-3',
					esc_html__( 'Style 4', 'splash' ) => 'style-4',
				),
			)
		)
	) );

	vc_map( array(
		'name'     => esc_html__( 'Call to action', 'splash' ),
		'base'     => 'stm_call_to_action',
		'icon'     => 'stm_call_to_action',
		'category' => esc_html__( 'STM', 'splash' ),
		'params'   => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Call to action Text', 'splash' ),
				'param_name' => 'call_to_action_label',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text color', 'splash' ),
				'param_name' => 'text_color',
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'splash' ),
				'param_name' => 'link'
			),
			/*Button style*/
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button type', 'splash' ),
				'param_name' => 'button_type',
				'value'    => array(
					esc_html__( 'Primary', 'splash' ) => 'primary',
					esc_html__( 'Secondary', 'splash' ) => 'secondary',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button size', 'splash' ),
				'param_name' => 'button_size',
				'value'    => array(
					esc_html__( 'Normal', 'splash' ) => 'btn-sm',
					esc_html__( 'Medium', 'splash' ) => 'btn-md',
					esc_html__( 'Large', 'splash' ) => 'btn-lg',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button color style', 'splash' ),
				'param_name' => 'button_color_style',
				'value'    => array(
					esc_html__( 'Style 1', 'splash' ) => 'style-1',
					esc_html__( 'Style 2', 'splash' ) => 'style-2',
					esc_html__( 'Style 3', 'splash' ) => 'style-3',
					esc_html__( 'Style 4', 'splash' ) => 'style-4',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			)
		)
	) );

	vc_map(array(
		"name" => esc_html__("Next Matches", 'splash'),
		"base" => "stm_next_match",
		"class" => "stm_next_match",
		"controls" => "full",
		'category' => esc_html__( 'STM', 'splash' ),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Next Match", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background image', 'splash' ),
				'param_name' => 'images'
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Show", 'splash'),
				"description" => esc_html__("Fixtures by only this team will be displayed", 'splash'),
				"param_name" => "show_games",
				"value" => array(
					esc_html__( 'Certain number', 'splash' ) => 'number',
					esc_html__( 'All games', 'splash' ) => 'all'
				)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Count", 'splash'),
				"param_name" => "count",
				"value" => 3,
				"min" => 1,
				"dependency" => array(
					"element" => "show_games",
					"value" => array( "number" ),
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Pick a team", 'splash'),
				"description" => esc_html__("Fixtures by only this team will be displayed", 'splash'),
				"param_name" => "pick_team",
				"value" => $teams_array
			),
		)
	));

	vc_map(array(
		"name" => esc_html__("Latest Results", 'splash'),
		"base" => "stm_latest_results",
		"class" => "stm_latest_results",
		"controls" => "full",
		'category' => esc_html__( 'STM', 'splash' ),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Latest Results", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Show", 'splash'),
				"description" => esc_html__("Fixtures by only this team will be displayed", 'splash'),
				"param_name" => "show_games",
				"value" => array(
					esc_html__( 'Certain number', 'splash' ) => 'number',
					esc_html__( 'All games', 'splash' ) => 'all'
				)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Fixture Link", 'splash'),
				"param_name" => "link_bind",
				"value" => array(
					esc_html__( 'Link teams', 'splash' ) => 'teams',
					esc_html__( 'Link event', 'splash' ) => 'event'
				)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Count", 'splash'),
				"param_name" => "count",
				"value" => 3,
				"min" => 1,
				"dependency" => array(
					"element" => "show_games",
					"value" => array( "number" ),
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Pick a team", 'splash'),
				"description" => esc_html__("Fixtures by only this team will be displayed", 'splash'),
				"param_name" => "pick_team",
				"value" => $teams_array
			),
		)
	));

	vc_map( array(
		"name"              => esc_html__( "Players Carousel", 'splash' ),
		"base"              => "stm_players_carousel",
		"class"             => "stm_players_carousel",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Players", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"heading" => esc_html__("Player per row", 'splash'),
				"param_name" => "per_row",
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"heading" => esc_html__("Image Size", 'splash'),
				"param_name" => "player_image_size",
				"description" => esc_html__("Default 270x370.", 'splash')
			),
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__( "Player Lists", 'splash' ),
				"param_name"  => "player_list",
				"value"       => $lists_array,
				"admin_label" => true
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Enable carousel", 'splash'),
				"param_name" => "enable_carousel",
				"value" => array(
					esc_html__( 'Yes', 'splash' ) => 'yes',
					esc_html__( 'No', 'splash' ) => 'no'
				)
			)
		)
	) );

	vc_map( array(
		"name"              => esc_html__( "Reviews Carousel", 'splash' ),
		"base"              => "stm_reviews_carousel",
		"class"             => "stm_reviews_carousel",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Reviews", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Number of review to display", 'splash'),
				"param_name" => "number",
				"value" => esc_html__("3", 'splash'),
			),
		)
	) );

	vc_map( array(
		"name"              => esc_html__( "Media tabs", 'splash' ),
		"base"              => "stm_media_tabs",
		"class"             => "stm_media_tabs",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Media", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'disable_masonry',
				'value'      => array(
					esc_html__( 'Disable masonry mode', 'splash' ) => 'disable'
				)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Number of medias to display (each tab)", 'splash'),
				"param_name" => "number",
				"value" => esc_html__("6", 'splash'),
			),
		)
	) );

	vc_map( array(
		"name"              => esc_html__( "News tabs", 'splash' ),
		"base"              => "stm_news_tabs",
		"class"             => "stm_news_tabs",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("News", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Include Category', 'splash' ),
				'param_name' => 'post_categories',
				'description' => esc_html__( 'Add Category. If not added show all category', 'splash' ),
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'min_length' => 1,
					'no_hide' => true,
					'unique_values' => true,
					'display_inline' => true,
					'values' => $post_categories_arr
				)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Number of news to display (each tab)", 'splash'),
				"param_name" => "number",
				"value" => esc_html__("3", 'splash'),
			),
		)
	) );

	vc_map( array(
		"name"              => esc_html__( "Products carousel", 'splash' ),
		"base"              => "stm_products_carousel",
		"class"             => "stm_products_carousel",
		"description"       => esc_html__('Carousel of recent products', 'splash'),
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Official Store", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Include Category', 'splash' ),
				'param_name' => 'post_categories',
				'description' => esc_html__( 'Add Category. If not added show all category', 'splash' ),
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'min_length' => 1,
					'no_hide' => true,
					'unique_values' => true,
					'display_inline' => true,
					'values' => $product_categories_arr
				)
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Number of products to display", 'splash'),
				"param_name" => "number",
				"value" => esc_html__("6", 'splash'),
			),
		)
	) );

	vc_map( array(
		"name"              => esc_html__( "Player statistics", 'splash' ),
		"base"              => "stm_player_statistic",
		"class"             => "stm_player_statistic",
		"description"       => esc_html__('Carousel of players', 'splash'),
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Preseason Stats", 'splash'),
				"description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", 'splash')
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Sub Title", 'splash'),
				"param_name" => "sub_title",
				"value" => esc_html__("Preseason Leaders", 'splash'),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background image', 'splash' ),
				'param_name' => 'images'
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Choose League", 'splash'),
				"param_name" => "league",
				"value" => $leagues_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Choose Season", 'splash'),
				"param_name" => "season",
				"value" => $seasons_array
			),
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Items', 'splash' ),
				'param_name' => 'items',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Choose Statistic', 'splash' ),
						'value' => '',
					),
					array(
						'label' => esc_html__( 'Statistic Title', 'splash' ),
						'value' => '',
					),
					array(
						'label' => esc_html__( 'Choose Players', 'splash' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Choose statistic to show", 'splash'),
						"param_name" => "statistic",
						"value" => $statistics_array,
						"holder" => 'div'
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__("Statistic title", 'splash'),
						"param_name" => "statistic_title",
						"description" => esc_html__("Enter text which will be used as widget title. Leave blank, title will be generated from statistic title", 'splash')
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Players', 'splash' ),
						'param_name' => 'players',
						'description' => esc_html__( 'Choose players to show', 'splash' ),
						'settings' => array(
							'multiple' => true,
							'min_length' => 1,
							'no_hide' => true,
							'values' => $players_array,
						)
					),
				),
			),
		)
	) );

	vc_map(array(
		"name" => esc_html__("League Tables", 'splash'),
		"description" => esc_html__("Place League Table", 'splash'),
		"base" => "stm_league_table",
		"class" => "stm_league_table",
		"controls" => "full",
		"icon" => 'stm_league_table',
		"category" => esc_html__('STM', 'splash'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Select Table", 'splash'),
				"param_name" => "id",
				"value" => $tables_array
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Table title", 'splash'),
				"param_name" => "title",
				"value" => esc_html__("Points Table", 'splash'),
				"min" => 1
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Count", 'splash'),
				"param_name" => "count",
				"value" => 7,
				"min" => 1
			)
		)
	));

	vc_map( array(
		'name'        => esc_html__( 'Trophies', 'splash' ),
		'base'        => 'stm_trophies',
		'as_parent' => array('only' => 'stm_trophy'),
		'icon'        => 'stm_image_links',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'splash' ),
				'param_name' => 'title',
				'value' => esc_html__('Awards', 'splash')
			),
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'Css', 'splash' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design options', 'splash' )
			)
		),
		'js_view' => 'VcColumnView'
	) );

	vc_map( array(
		'name'        => esc_html__( 'STM Trophy', 'splash' ),
		'base'        => 'stm_trophy',
		'as_child'    => array('only' => 'stm_trophies'),
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'splash' ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'splash' ),
				'param_name' => 'image_size',
				'value' => '170x259',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'splash' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Year', 'splash' ),
				'param_name' => 'year',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Trophy title', 'splash' ),
				'param_name' => 'title',
			),
		),
	) );

	vc_map( array(
		'name'        => esc_html__( 'Carousel', 'splash' ),
		'base'        => 'stm_carousel',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'splash' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'splash' ),
				'param_name' => 'images'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'splash' ),
				'param_name' => 'image_size',
				'value' => '160x60',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'splash' ),
			),
		),
	) );

	vc_map( array(
		'name'        => esc_html__( 'Slider', 'splash' ),
		'base'        => 'stm_slider',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'splash' ),
				'param_name' => 'images'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'splash' ),
				'param_name' => 'image_size',
				'value' => '1170x650',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'splash' ),
			),
		),
	) );

	vc_map( array(
		'name'        => esc_html__( 'Images Grid', 'splash' ),
		'base'        => 'stm_images_grid',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'splash' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'splash' ),
				'param_name' => 'images'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'splash' ),
				'param_name' => 'image_size',
				'value' => '270x250',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'splash' ),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Columns", 'splash'),
				"param_name" => "columns",
				"value" => array(
					'6' => '6',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				),
				'std' => '4'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Load by', 'splash' ),
				'param_name' => 'load_by',
				'value' => '12',
				'description' => esc_html__( 'Images to show by. Default: 12', 'splash' ),
			),
			/*Button style*/
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button type', 'splash' ),
				'param_name' => 'button_type',
				'value'    => array(
					esc_html__( 'Primary', 'splash' ) => 'primary',
					esc_html__( 'Secondary', 'splash' ) => 'secondary',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button size', 'splash' ),
				'param_name' => 'button_size',
				'value'    => array(
					esc_html__( 'Normal', 'splash' ) => 'btn-sm',
					esc_html__( 'Medium', 'splash' ) => 'btn-md',
					esc_html__( 'Large', 'splash' ) => 'btn-lg',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button color style', 'splash' ),
				'param_name' => 'button_color_style',
				'value'    => array(
					esc_html__( 'Style 1', 'splash' ) => 'style-1',
					esc_html__( 'Style 2', 'splash' ) => 'style-2',
					esc_html__( 'Style 3', 'splash' ) => 'style-3',
					esc_html__( 'Style 4', 'splash' ) => 'style-4',
				),
				'group'      => esc_html__( 'Button style', 'splash' )
			)
		),
	) );

	vc_map( array(
		"name"              => esc_html__( "Price plan", 'splash' ),
		"base"              => "stm_price_plan",
		"class"             => "stm_price_plan",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Plan title", 'splash'),
				"param_name" => "title",
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Plan badge", 'splash'),
				"param_name" => "badge",
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Plan price", 'splash'),
				"param_name" => "price",
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Plan price label", 'splash'),
				"param_name" => "price_label",
			),
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Features', 'splash' ),
				'param_name' => 'feature',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Feature', 'splash' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__("Feature", 'splash'),
						"param_name" => "feature_item",
					),
				),
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Link', 'splash' ),
				'param_name' => 'link'
			),
		)
	) );

	vc_map( array(
		'name'        => esc_html__( 'Contact Info', 'splash' ),
		'base'        => 'stm_contact_info',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Image', 'splash' ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'splash' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle', 'splash' ),
				'param_name' => 'subtitle',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Phone', 'splash' ),
				'param_name' => 'phone',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Fax', 'splash' ),
				'param_name' => 'fax',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Email', 'splash' ),
				'param_name' => 'email',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'URL', 'splash' ),
				'param_name' => 'url',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'splash' ),
				'param_name' => 'image_size',
				'value' => '370x150',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'splash' ),
			),
		),
	) );

	//GMAP
	vc_map( array(
		'name'     => esc_html__( 'Google Map', 'splash' ),
		'base'     => 'stm_gmap',
		'icon'     => 'stm_gmap',
		'category' => esc_html__( 'STM', 'splash' ),
		'params'   => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Marker', 'splash' ),
				'param_name' => 'image'
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Map Width', 'splash' ),
				'param_name'  => 'map_width',
				'value'       => '100%',
				'description' => esc_html__( 'Enter map width in px or %', 'splash' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Map Height', 'splash' ),
				'param_name'  => 'map_height',
				'value'       => '460px',
				'description' => esc_html__( 'Enter map height in px', 'splash' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Latitude', 'splash' ),
				'param_name'  => 'lat',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Longitude', 'splash' ),
				'param_name'  => 'lng',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Map Zoom', 'splash' ),
				'param_name' => 'map_zoom',
				'value'      => 18
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'InfoWindow text', 'splash' ),
				'param_name' => 'infowindow_text',
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'disable_mouse_whell',
				'value'      => array(
					esc_html__( 'Disable map zoom on mouse wheel scroll', 'splash' ) => 'disable'
				)
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Extra class name', 'splash' ),
				'param_name'  => 'el_class',
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'splash' )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'Css', 'splash' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design options', 'splash' )
			)
		)
	) );

	vc_map( array(
		'name'        => esc_html__( 'Team History', 'splash' ),
		'base'        => 'stm_team_history',
		'category'    => esc_html__( 'STM', 'splash' ),
		'params'      => array(
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Year description', 'splash' ),
				'param_name' => 'feature',
				'value' => urlencode( json_encode( array(
					array(
						'label' => esc_html__( 'Year', 'splash' ),
						'value' => '',
					),
					array(
						'label' => esc_html__( 'Title', 'splash' ),
						'value' => '',
					),
					array(
						'label' => esc_html__( 'Content', 'splash' ),
						'value' => '',
					),
				) ) ),
				'params' => array(
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__("Year", 'splash'),
						"param_name" => "year",
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__("Title", 'splash'),
						"param_name" => "title",
					),
					array(
						"type" => "textarea",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__("Content", 'splash'),
						"param_name" => "content",
					),
				),
			),
		),
	) );

	vc_map( array(
		"name"              => esc_html__( "Media Archive", 'splash' ),
		"base"              => "stm_media_archive",
		"class"             => "stm_media_archive",
		"controls"          => "full",
		"category"          => esc_html__( 'STM', 'splash' ),
		"params"            => array(
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'Css', 'splash' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design options', 'splash' )
			)
		)
	) );
}



if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Stm_Trophies extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Stm_Icon_List extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Button extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Call_To_Action extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Next_Match extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Latest_Results extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Players_Carousel extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Reviews_Carousel extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Media_Tabs extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_News_Tabs extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Products_Carousel extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Player_Statistic extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_League_Table extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Trophy extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Carousel extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Slider extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Images_Grid extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Price_Plan extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_STM_Contact_Info extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Gmap extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Team_History extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Media_Archive extends WPBakeryShortCode {
	}
}