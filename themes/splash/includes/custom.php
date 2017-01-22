<?php

function stm_set_html_content_type() {
	return 'text/html';
}

// Add svg support
function splash_svg_mime( $mimes ) {
	$mimes['ico'] = 'image/icon';
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'splash_svg_mime' );

if ( ! function_exists( 'splash_pa' ) ) {
	function splash_pa( $array ) {
		echo '<pre>';
		print_r( $array );
		echo '</pre>';
	}
}

if ( ! function_exists( 'splash_socials' ) ) {
	function splash_socials( $socials_pos = 'top_bar_socials' ) {
		$socials_array = array();

		$header_socials_enable = explode( ',', get_theme_mod( $socials_pos ) );
		$socials        = get_theme_mod( 'socials_link' );
		$socials_values = array();
		if ( ! empty( $socials ) ) {
			parse_str( $socials, $socials_values );
		}

		if ( $header_socials_enable ) {
			foreach ( $header_socials_enable as $social ) {
				if ( ! empty( $socials_values[ $social ] ) ) {
					$socials_array[ $social ] = $socials_values[ $social ];
				}
			}
		}

		return $socials_array;
	}
}

if ( ! function_exists( 'splash_generate_inline_style' ) ) {
	function splash_generate_inline_style( $styles ) {
		$return = '';
		if ( ! empty( $styles ) ) {
			$return = 'style="';
			foreach ( $styles as $style_name => $style_value ) {
				if ( ! empty( $style_value ) ) {
					$return .= $style_name . ':' . $style_value . ' !important;';
				}
			}
			$return .= '"';
		}

		return $return;
	}
}

if ( ! function_exists( 'splash_top_bar_styles' ) ) {
	function splash_top_bar_styles() {
		$color      = get_theme_mod( 'top_bar_text_color' );
		$custom_css = '';
		if ( ! empty( $color ) ) {
			$custom_css = "#stm-top-bar .heading-font, #stm-top-bar a {
				color: {$color};
			}";
		};
		wp_add_inline_style( 'stm-theme-style', $custom_css );
	}

	add_action( 'wp_enqueue_scripts', 'splash_top_bar_styles' );
}

if ( ! function_exists( 'splash_hex2rgb' ) ) {
	function splash_hex2rgb( $colour ) {
		if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return $r . ',' . $g . ',' . $b;
	}
}

if ( ! function_exists( 'splash_body_class' ) ) {
	function splash_body_class( $classes ) {
		$macintosh = strpos( $_SERVER["HTTP_USER_AGENT"], 'Macintosh' ) ? true : false;
		if ( $macintosh ) {
			$classes[] = 'stm-macintosh';
		}

		global $wp_customize;

		if ( isset( $wp_customize ) ) {
			$classes[] = 'stm-customize-page';
		}


		$boxed    = get_theme_mod( 'site_boxed', false );
		$bg_image = get_theme_mod( 'bg_image', false );

		if ( $boxed ) {
			$classes[] = 'stm-boxed';
			if ( $bg_image ) {
				$classes[] = $bg_image;
			}
		}

		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			if ( strlen( strstr( $agent, 'Firefox' ) ) > 0 ) {
				$classes[] = 'stm-firefox';
			}
		}

		$shop_sidebar_id = get_theme_mod('shop_sidebar', 'primary_sidebar');
		if($shop_sidebar_id != 'no_sidebar') {
			$classes[] = 'stm-shop-sidebar';
		}

		return $classes;
	}
}

add_filter( 'body_class', 'splash_body_class' );

if ( ! function_exists( 'splash_get_thumbnail_url' ) ) {
	function splash_get_thumbnail_url( $post_id = 0, $image_id = 0, $image_size = "stm-85-105" ) {
		$return = '';
		if ( ! $image_id ) {
			$image = get_post_thumbnail_id( $post_id );
		} else {
			$image = $image_id;
		}
		if ( ! empty( $image ) ) {
			$image = wp_get_attachment_image_src( $image, $image_size );
			if ( ! empty( $image[0] ) ) {
				$return = $image[0];
			}
		}

		return $return;
	}

	;
}

if ( ! function_exists( 'splash_get_sportpress_points_system' ) ) {
	function splash_get_sportpress_points_system() {
		$points = 'points';
		$points = get_option( 'sportspress_primary_result' );

		return $points;
	}
}

//Declare wp-admin url
add_action( 'wp_head', 'splash_ajaxurl' );

function splash_ajaxurl() { ?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
		var stm_cf7_preloader = '<?php echo esc_url(get_template_directory_uri() . '/assets/images/map-pin.png') ?>';
	</script>
<?php }

if ( ! function_exists( 'splash_pagination' ) ) {
	function splash_pagination() {
		echo paginate_links( array(
			'type'      => 'list',
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
		) );
	}
}

if ( ! function_exists( 'splash_pages_pagination' ) ) {
	function splash_pages_pagination() {
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'splash' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'splash' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
	}
}

//Sidebar layout
if ( ! function_exists( 'splash_sidebar_layout_mode' ) ) {
	function splash_sidebar_layout_mode( $position = 'left', $sidebar_id = false ) {
		$content_before = $content_after = $sidebar_before = $sidebar_after = $show_title = $default_row = $default_col = '';

		if ( get_post_type() == 'post' ) {
			if ( ! empty( $_GET['show-title-box'] ) and $_GET['show-title-box'] == 'hide' ) {
				$blog_archive_id = get_option( 'page_for_posts' );
				if ( ! empty( $blog_archive_id ) ) {

					$get_the_title = get_the_title( $blog_archive_id );

					if ( ! empty( $get_the_title ) ) {
						$show_title = '<h2 class="stm-blog-main-title">' . $get_the_title . '</h2>';
					}
				}
			}
		}

		if ( ! $sidebar_id ) {
			$content_before .= '<div class="col-md-12">';

			$content_after .= '</div>';

			$default_row = 3;
			$default_col = 'col-md-4 col-sm-4 col-xs-12';
		} else {
			if ( $position == 'right' ) {
				$content_before .= '<div class="col-md-9 col-sm-12 col-xs-12"><div class="sidebar-margin-top clearfix"></div>';
				$sidebar_before .= '<div class="col-md-3 hidden-sm hidden-xs">';

				$sidebar_after .= '</div>';
				$content_after .= '</div>';
			} elseif ( $position == 'left' ) {
				$content_before .= '<div class="col-md-9 col-md-push-3 col-sm-12"><div class="sidebar-margin-top clearfix"></div>';
				$sidebar_before .= '<div class="col-md-3 col-md-pull-9 hidden-sm hidden-xs">';

				$sidebar_after .= '</div>';
				$content_after .= '</div>';
			}
			$default_row = 2;
			$default_col = 'col-md-6 col-sm-6 col-xs-12';
		}

		$return                   = array();
		$return['content_before'] = $content_before;
		$return['content_after']  = $content_after;
		$return['sidebar_before'] = $sidebar_before;
		$return['sidebar_after']  = $sidebar_after;
		$return['show_title']     = $show_title;
		$return['default_row']    = $default_row;
		$return['default_col']    = $default_col;

		return $return;
	}
}

if ( ! function_exists( 'splash_get_sidebar_settings' ) ) {
	function splash_get_sidebar_settings( $sidebar = 'sidebar', $sidebar_pos = 'sidebar_position', $sidebar_default = 'primary_sidebar', $sidebar_pos_default = 'left' ) {
		$sidebar_id       = get_theme_mod( $sidebar, $sidebar_default );
		$sidebar_position = get_theme_mod( $sidebar_pos, $sidebar_pos_default );

		$blog_sidebar = 0;

		if ( ! empty( $_GET['sidebar-position'] ) and $_GET['sidebar-position'] == 'left' ) {
			$sidebar_position = 'left';
		}

		if ( ! empty( $_GET['sidebar-position'] ) and $_GET['sidebar-position'] == 'right' ) {
			$sidebar_position = 'right';
		}

		if ( ! empty( $_GET['sidebar-position'] ) and $_GET['sidebar-position'] == 'none' ) {
			$sidebar_id = false;
		}

		if ( $sidebar_id == 'no_sidebar' ) {
			$sidebar_id = false;
		}

		$view_type = get_theme_mod( 'view_type', 'grid' );

		if ( ! empty( $_GET['view-type'] ) and $_GET['view-type'] == 'grid' ) {
			$view_type = 'grid';
		}

		if ( ! empty( $_GET['view-type'] ) and $_GET['view-type'] == 'list' ) {
			$view_type = 'list';
		}

		if ( ! empty( $sidebar_id ) ) {
			$blog_sidebar = get_post( $sidebar_id );
		}

		$response = array(
			'id'           => $sidebar_id,
			'position'     => $sidebar_position,
			'view_type'    => $view_type,
			'blog_sidebar' => $blog_sidebar
		);

		return $response;
	}
}

function splash_categories_empty_title( $title = '', $instance = '', $base = '' ) {
	if ( $base == 'categories' ) {
		if ( trim( $instance['title'] ) == '' ) {
			return '';
		}
	}

	return $title;
}

add_filter( 'widget_title', 'splash_categories_empty_title', 10, 3 );

if ( ! function_exists( 'splash_theme_comment' ) ) {
	function splash_theme_comment( $comment, $args, $depth ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo wp_kses_post($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>

		<div class="clearfix">

			<div class="comment-author-image">
				<?php if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				} ?>
			</div>

			<div class="comment-author vcard">
				<span
					class="comment-author heading-font"><?php echo wp_kses_post( get_comment_author_link() ); ?></span>
				<span class="comment-meta commentmetadata">
					<span class="date heading-font"><?php echo esc_attr( get_comment_date() ); ?></span>
				</span>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'splash' ); ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>

				<div class="reply">
					<i class="fa fa-mail-reply"></i>
					<?php comment_reply_link( array_merge( $args, array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					) ) ); ?>
				</div>
			</div>
		</div>


		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif; ?>
	<?php
	}
}

add_filter( 'comment_form_default_fields', 'splash_bootstrap3_comment_form_fields' );

if ( ! function_exists( 'splash_bootstrap3_comment_form_fields' ) ) {
	function splash_bootstrap3_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$fields    = array(
			'author' => '<div class="row stm-row-comments">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="form-group comment-form-author">
			            			<input placeholder="' . esc_html__( 'Name', 'splash' ) . ( $req ? ' *' : '' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
		                        </div>
		                    </div>',
			'email'  => '<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group comment-form-email">
								<input placeholder="' . esc_html__( 'E-mail', 'splash' ) . ( $req ? ' *' : '' ) . '" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
							</div>
						</div>',
			'url'    => '<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="form-group comment-form-url">
							<input placeholder="' . esc_html__( 'Website', 'splash' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
						</div>
					</div></div>'
		);

		return $fields;
	}
}

add_filter( 'comment_form_defaults', 'splash_bootstrap3_comment_form' );

if ( ! function_exists( 'splash_bootstrap3_comment_form' ) ) {
	function splash_bootstrap3_comment_form( $args ) {
		$args['comment_field'] = '<div class="form-group comment-form-comment">
			<textarea placeholder="' . _x( 'Message', 'noun', 'splash' ) . ' *" name="comment" rows="9" aria-required="true"></textarea>
	    </div>';

		return $args;
	}
}

if ( ! function_exists( 'splash_donors_text' ) ) {
	function splash_donors_text( $post_id, $getProcent = false ) {

		$raised = get_post_meta( $post_id, 'raised_money', true );
		$donors = get_post_meta( $post_id, 'donors', true );
		$goal   = get_post_meta( $post_id, 'goal', true );

		if ( ! $getProcent ) {

			if ( empty( $raised ) ) {
				$raised = '0';
			}

			if ( empty( $donors ) ) {
				$donors = '0';
			}

			if ( empty( $goal ) ) {
				$goal = '0';
			}

			$raised_label   = get_theme_mod( 'donation_raised', esc_html__( 'Raised', 'splash' ) );
			$donors_label   = get_theme_mod( 'donation_donors', esc_html__( 'Donors', 'splash' ) );
			$goal_label     = get_theme_mod( 'donation_goal', esc_html__( 'Goal', 'splash' ) );
			$currency_label = get_theme_mod( 'donation_currency', esc_html__( '$', 'splash' ) );

			$response = '';
			$response .= '<div class="heading-font">';
			$response .= '<span class="stm-red">' . $raised_label . '</span> ' . $currency_label . $raised;
			$response .= '</div>';
			$response .= '<div class="heading-font">';
			$response .= '<span class="stm-red">' . $donors_label . '</span> ' . $donors;
			$response .= '</div>';
			$response .= '<div class="heading-font">';
			$response .= '<span class="stm-red">' . $goal_label . '</span> ' . $currency_label . $goal;
			$response .= '</div>';

			echo wp_kses_post( $response );
		} else {
			$procent = 0;
			if ( ! empty( $raised ) and ! empty( $goal ) ) {
				$total   = ( $raised * 100 ) / $goal;
				$procent = round( $total, 1 );
			}

			return $procent;
		}
	}
}

// Event Sign up form
if ( ! function_exists( 'splash_donate_money' ) ) {
	function splash_donate_money() {
		// Get event details
		$json           = array();
		$json['errors'] = array();

		$_POST['donor']['id'] = filter_var( $_POST['donor']['id'], FILTER_VALIDATE_INT );

		if ( empty( $_POST['donor']['id'] ) ) {
			return false;
		}

		if ( ! filter_var( $_POST['donor']['name'], FILTER_SANITIZE_STRING ) ) {
			$json['errors']['name'] = true;
		}
		if ( ! is_email( $_POST['donor']['email'] ) ) {
			$json['errors']['email'] = true;
		}
		if ( ! is_numeric( $_POST['donor']['phone'] ) ) {
			$json['errors']['phone'] = true;
		}
		if ( ! filter_var( $_POST['donor']['message'], FILTER_SANITIZE_STRING ) ) {
			$json['errors']['message'] = true;
		}
		if ( ! filter_var( $_POST['donor']['amount'], FILTER_VALIDATE_INT ) ) {
			$json['errors']['amount'] = true;
		}

		if ( empty( $json['errors'] ) ) {

			$participant_data['post_title']   = $_POST['donor']['name'];
			$participant_data['post_type']    = 'donor';
			$participant_data['post_status']  = 'draft';
			$participant_data['post_excerpt'] = $_POST['donor']['message'];
			$participant_id                   = wp_insert_post( $participant_data );
			update_post_meta( $participant_id, 'donor_email', $_POST['donor']['email'] );
			update_post_meta( $participant_id, 'donor_phone', $_POST['donor']['phone'] );
			update_post_meta( $participant_id, 'donor_event', $_POST['donor']['id'] );
			update_post_meta( $participant_id, 'donor_amount', $_POST['donor']['amount'] );

			$items                = array();
			$items['item_name']   = get_the_title( $_POST['donor']['id'] );
			$items['item_number'] = $_POST['donor']['id'];
			$items['amount']      = $_POST['donor']['amount'];
			$items                = http_build_query( $items );

			$mode = get_theme_mod( 'paypal_mode', 'sandbox' );
			$url  = ( $mode == 'live' ) ? 'www.paypal.com' : 'www.sandbox.paypal.com';

			$redirect_url = '';

			$redirect_url .= 'https://' . $url;
			$redirect_url .= '/cgi-bin/webscr?cmd=_xclick&business=';
			$redirect_url .= get_theme_mod( 'paypal_email' );
			$redirect_url .= '&' . $items;
			$redirect_url .= '&no_shipping=1&no_note=1&currency_code=' . get_theme_mod( 'paypal_currency', 'USD' );
			$redirect_url .= '&bn=PP%2dBuyNowBF&charset=UTF%2d8&invoice=' . $participant_id;
			$redirect_url .= '&return=' . home_url('/') . '&rm=2&notify_url=' . home_url('/');

			add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

			$headers[] = 'From: ' . get_bloginfo( 'blogname' ) . ' <' . get_bloginfo( 'admin_email' ) . '>';

			wp_mail( get_bloginfo( 'admin_email' ), esc_html__( 'New donation', 'splash' ), esc_html__( 'New donation, please check it.', 'splash' ), $headers );

			remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

			$json['redirect_url'] = $redirect_url;

			$json['success'] = esc_html__( 'Redirecting to Paypal.', 'splash' );
		}

		echo json_encode( $json );
		exit;
	}
}

add_action( 'wp_ajax_splash_donate_money', 'splash_donate_money' );
add_action( 'wp_ajax_nopriv_splash_donate_money', 'splash_donate_money' );

if ( ! function_exists( 'splash_load_media' ) ) {
	function splash_load_media() {
		$json = array();

		$category = sanitize_text_field( $_GET['category'] );
		$page     = intval( $_GET['page'] );
		$load_by  = intval( $_GET['load'] );

		/*SIDEBAR SETTINGS*/
		$sidebar_settings = splash_get_sidebar_settings( 'media_sidebar', 'media_sidebar_position', 'no_sidebar', 'right' );
		$sidebar_id       = $sidebar_settings['id'];

		$sidebar_settings_position = 'none';

		if ( ! empty( $sidebar_id ) ) {
			$sidebar_settings_position = $sidebar_settings['position'];
		}

		$offset = $page * $load_by;

		$all_media_args = array(
			'post_type'      => 'media_gallery',
			'post_status'    => 'publish',
			'offset'         => $offset,
			'posts_per_page' => $load_by,
			'meta_key'       => '_thumbnail_id',
		);

		if ( $category != 'all' ) {
			$all_media_args['meta_query'] = array(
				array(
					'key'     => 'media_type',
					'value'   => $category,
					'compare' => '='
				)
			);
		}

		$all_medias = new WP_Query( $all_media_args );

		$html = '';

		if ( $all_medias->have_posts() ) {
			if ( $load_by == 7 ) {
				$post_position = 0;
			} else {
				$post_position = $offset;
			}
			$style = 'style_' . rand( 1, 3 );
			while ( $all_medias->have_posts() ) {
				$all_medias->the_post();
				$post_position ++;
				if ( $post_position % $load_by == 0 ) {
					$style = 'style_' . rand( 1, 3 );
				}
				ob_start();
				stm_single_media_output( get_the_ID(), $post_position, $style, $sidebar_settings_position );
				$html .= ob_get_clean();
			}


			$new_offset = $page + 1;
		}

		if ( $all_medias->found_posts < $offset + $load_by ) {
			$new_offset = 'none';
		}

		$json['offset'] = $new_offset;
		$json['html']   = $html;

		echo json_encode( $json );
		exit;
	}
}

add_action( 'wp_ajax_splash_load_media', 'splash_load_media' );
add_action( 'wp_ajax_nopriv_splash_load_media', 'splash_load_media' );

/*Show sportpress future events content for everyone*/
add_action( 'pre_get_posts', function ( $query ) {
	if ( ! is_admin() && $query->is_main_query() && in_array( $query->get( 'post_type' ), array( 'sp_event' ) ) ) {
		$query->set( 'post_status', array( 'publish', 'future' ) );
	}
} );

function splash_get_search_form( $form ) {
	$form = '<form method="get" action="' . home_url( '/' ) . '">';
	$form .= '<div class="search-wrapper">';
	$form .= '<input ';
	$form .= 'placeholder="' . esc_html__( 'Search', 'splash' ) . '" type="text"';
	$form .= ' class="search-input"';
	$form .= ' value="' . get_search_query() . '" name="s" />';
	$form .= '</div>';
	$form .= '<button type="submit" class="search-submit" ><i class="fa fa-search"></i></button>';
	$form .= '</form>';

	return $form;
}

add_action( 'get_search_form', 'splash_get_search_form' );

// STM Updater
if ( ! function_exists( 'splash_updater' ) ) {
	function splash_updater() {

		$envato_username = get_theme_mod( 'envato_username' );
		$envato_api_key  = get_theme_mod( 'envato_api' );

		if ( ! empty( $envato_username ) && ! empty( $envato_api_key ) ) {
			$envato_username = trim( $envato_username );
			$envato_api_key  = trim( $envato_api_key );
			if ( ! empty( $envato_username ) && ! empty( $envato_api_key ) ) {
				load_template( get_template_directory() . '/includes/updater/envato-theme-update.php' );

				if ( class_exists( 'Envato_Theme_Updater' ) ) {
					Envato_Theme_Updater::init( $envato_username, $envato_api_key, 'StylemixThemes' );
				}
			}
		}
	}

	add_action( 'after_setup_theme', 'splash_updater' );
}

function splash_import_widgets( $widget_data ) {
	$json_data = $widget_data;
	$json_data = json_decode( $json_data, true );

	$sidebar_data = $json_data[0];
	$widget_data  = $json_data[1];

	$menu_object = wp_get_nav_menu_object( 'Widget menu' );

	if(!empty($menu_object)
	   and !empty($menu_object->term_id)
	       and !empty($widget_data['nav_menu'])
	           and !empty($widget_data['nav_menu'][2])
	               and !empty($widget_data['nav_menu'][2]['nav_menu'])) {
		$widget_data['nav_menu'][2]['nav_menu'] = $menu_object->term_id;
	}

	foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
		$widgets[ $widget_data_title ] = '';
		foreach ( $widget_data_value as $widget_data_key => $widget_data_array ) {
			if ( is_int( $widget_data_key ) ) {
				$widgets[ $widget_data_title ][ $widget_data_key ] = 'on';
			}
		}
	}
	unset( $widgets[""] );

	foreach ( $sidebar_data as $title => $sidebar ) {
		$count = count( $sidebar );
		for ( $i = 0; $i < $count; $i ++ ) {
			$widget               = array();
			$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
			$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
			if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
				unset( $sidebar_data[ $title ][ $i ] );
			}
		}
		$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
	}

	foreach ( $widgets as $widget_title => $widget_value ) {
		foreach ( $widget_value as $widget_key => $widget_value ) {
			$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
		}
	}

	$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

	splash_widget_parse_import_data( $sidebar_data );
}

function splash_widget_parse_import_data( $import_array ) {
	global $wp_registered_sidebars;
	$sidebars_data    = $import_array[0];
	$widget_data      = $import_array[1];
	$current_sidebars = get_option( 'sidebars_widgets' );
	$new_widgets      = array();

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) :
				$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name     = splash_get_new_widget_name( $title, $index );
				$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
						$new_index ++;
					}
				}
				$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
					$multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
					unset( $new_widgets[ $title ]['_multiwidget'] );
					$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
					$current_multiwidget               = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : false;
					$new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
					$multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[ $title ]               = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;

	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content ) {
			update_option( 'widget_' . $title, $content );
		}

		return true;
	}

	return false;
}

function splash_get_new_widget_name( $widget_name, $widget_index ) {
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array();
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index ++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;

	return $new_widget_name;
}

if( ! function_exists( 'splash_skin_custom' ) ) {
	function splash_skin_custom() {
		$site_color = get_theme_mod( 'site_style', 'default' );

		if( $site_color == 'site_style_custom' ) {
			global $wp_filesystem;

			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$custom_style_css = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/styles.css' );
			$base_color = get_theme_mod( 'site_style_base_color', '#e21e22' );

			$colors_arr = array();
			$colors_arr[] = $base_color;
			$colors_differences = false;

			$custom_style_css = str_replace(
				array(
					'#e21e22',
					'226, 30, 34',
				),
				array(
					$base_color,
					splash_hex2rgb($base_color),
				),
				$custom_style_css
			);

			$upload_dir = wp_upload_dir();

			if( ! $wp_filesystem->is_dir( $upload_dir['basedir'] . '/stm_uploads' ) ) {
				$wp_filesystem->mkdir( $upload_dir['basedir'] . '/stm_uploads', FS_CHMOD_DIR );
			}

			if( $custom_style_css ) {
				$css_to_filter = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $custom_style_css );
				$css_to_filter = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css_to_filter );

				$custom_style_file = $upload_dir['basedir'] . '/stm_uploads/skin-custom.css';

				if( $custom_style_file ) {
					$custom_style_content = $wp_filesystem->get_contents( $custom_style_file );

					if( is_array( $colors_arr ) && !empty( $colors_arr ) ) {
						foreach( $colors_arr as $color ) {
							$color_find = strpos( $custom_style_content, $color );
							if( ! $color_find && ! $colors_differences ) {
								$colors_differences = true;
							}
						}
					}

					if( $colors_differences ) {
						$wp_filesystem->put_contents($custom_style_file, $css_to_filter, FS_CHMOD_FILE);
					}
				} else {
					$wp_filesystem->put_contents($custom_style_file, $css_to_filter, FS_CHMOD_FILE);
				}
			}
		}

		exit;
	}
}

add_action( 'customize_save_after', 'splash_skin_custom', 20 );

if ( ! function_exists( 'splash_print_styles' ) ) {
	function splash_print_styles() {
		$front_css = '';

		/*Boxed BG*/
		$site_boxed = get_theme_mod('site_boxed');
		if($site_boxed) {
			$bg_image = get_theme_mod('bg_image');
			$custom_bg_image = get_theme_mod('custom_bg_image');
			$custom_bg_pattern = get_theme_mod('custom_bg_pattern');

			if(empty($custom_bg_image) and empty($custom_bg_pattern)) {
				$front_css .= '
					body.stm-boxed {
						background-image: url( ' . get_template_directory_uri() .  '/assets/images/tmp/box_img_5.png );
					}
				';
			}

			if(!empty($bg_image)) {
				$box_images = array(
					'5' => 'box_img_5.png',
					'1' => 'box_img_1.jpg',
					'2' => 'box_img_2.jpg',
					'3' => 'box_img_3.jpg',
					'4' => 'box_img_4.jpg',
				);

				if(!empty($box_images[$bg_image])) {
					$front_css .= '
						body.stm-boxed {
							background-image: url( ' . get_template_directory_uri() . '/assets/images/tmp/' . $box_images[ $bg_image ] . ' );
							background-attachment: fixed;
						}
					';
				}
			}

			if(!empty($custom_bg_image)) {
				$front_css .= '
					body.stm-boxed {
						background-image: url( ' . esc_url($custom_bg_image) . ' );
						background-attachment: fixed;
						background-size:cover;
					}
				';
			} elseif(!empty($custom_bg_pattern)) {
				$front_css .= '
					body.stm-boxed {
						background-image: url( ' . esc_url($custom_bg_pattern) . ' );
						background-repeat: repeat;
					}
				';
			}

		}

		/*Remove page bottom padding after content*/
		$no_page_padding = get_post_meta(get_the_ID(), 'no_page_padding', true);
		$style_opts = array();
		if(!empty($no_page_padding) and $no_page_padding == 'on') {
			$front_css .= '
					#main {
						padding: 0 !important;
					}
				';
		}

		/*Custom CSS*/
		$custom_css = get_theme_mod( 'custom_css' );

		if( !empty( $custom_css ) ){
			$front_css .= preg_replace( '/\s+/', ' ', $custom_css );
		}

		wp_add_inline_style( 'stm-theme-default-styles', $front_css );
	}
}

add_action( 'wp_enqueue_scripts', 'splash_print_styles' );

// Remove [...] from excerpt
add_filter( 'excerpt_more', 'splash_excerpt_more' );
function splash_excerpt_more( $more ) {
	return '...';
}

//Add empty gravatar
function splash_default_avatar ($avatar_defaults) {
	$stm_avatar = get_template_directory_uri() . '/assets/images/gravataricon.png';
	$avatar_defaults[$stm_avatar] = esc_html__('Splash Default Avatar', 'splash');
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'splash_default_avatar' );

/* Display custom column */
function splash_display_posts_stickiness( $column, $post_id ) {
	if ($column == 'media_type'){
		$media_type = get_post_meta($post_id, 'media_type', true);
		if(empty($media_type)) {
			$media_type = 'image';
		}
		echo esc_attr($media_type);
	}
}
add_action( 'manage_media_gallery_posts_custom_column' , 'splash_display_posts_stickiness', 10, 2 );

/* Add custom column to post list */
function splash_add_sticky_column( $columns ) {
	return array_merge( $columns,
		array( 'media_type' => __( 'Media type', 'splash' ) ) );
}
add_filter( 'manage_media_gallery_posts_columns' , 'splash_add_sticky_column' );

// After import hook and add menu, home page. slider, blog page
if( ! function_exists( 'splash_importer_done_function' ) ){
	function splash_importer_done_function(){

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		/*Widgets*/
		$widgets_file = get_template_directory() . '/includes/demo/widget_data.json';
		if ( file_exists( $widgets_file ) ) {
			$encode_widgets_array = $wp_filesystem->get_contents( $widgets_file );
			splash_import_widgets( $encode_widgets_array );
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$menus = wp_get_nav_menus();

		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				if ( is_object( $menu ) ) {
					switch ($menu->name) {
						case 'Header menu':
							$locations['primary'] = $menu->term_id;
							break;
						case 'Widget menu':
							$locations['bottom_menu'] = $menu->term_id;
							break;
						case 'Sidebar menu':
							$locations['sidebar_menu'] = $menu->term_id;
							break;
					}
				}
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );

		update_option( 'show_on_front', 'page' );

		$front_page = get_page_by_title( 'Home page' );
		if ( isset( $front_page->ID ) ) {
			update_option( 'page_on_front', $front_page->ID );
		}

		$blog_page = get_page_by_title( 'News' );
		if ( isset( $blog_page->ID ) ) {
			update_option( 'page_for_posts', $blog_page->ID );
		}

		$shop_page = get_page_by_title( 'Shop' );
		if( isset( $shop_page->ID ) ) {
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
		}

		$checkout_page = get_page_by_title( 'Checkout' );
		if ( isset( $checkout_page->ID ) ) {
			update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}
		$cart_page = get_page_by_title( 'Cart' );
		if ( isset( $cart_page->ID ) ) {
			update_option( 'woocommerce_cart_page_id', $cart_page->ID );
		}
		$account_page = get_page_by_title( 'My Account' );
		if ( isset( $account_page->ID ) ) {
			update_option( 'woocommerce_myaccount_page_id', $account_page->ID );
		}

		if ( class_exists( 'RevSlider' ) ) {
			$main_slider = get_template_directory() . '/includes/demo/home_slider.zip';

			if ( file_exists( $main_slider ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $main_slider );
			}
		}
	}
}

add_action( 'splash_importer_done', 'splash_importer_done_function' );

if(!function_exists('splash_sportspress_side_posts')) {
	function splash_sportspress_side_posts() {
		$post_types_content = array(
			'sp_calendar' => array(
				'class' => 'stm-single-sp_calendar stm-calendar-page',
				'template' => 'calendar-content'
			),
			'sp_event' => array(
				'class' => 'stm-single-sp_event stm-event-page',
				'template' => 'event-content'
			),
			'sp_table' => array(
				'class' => 'stm-single-sp_table-league stm-table-league-page',
				'template' => 'event-content'
			),
			'sp_player' => array(
				'class' => 'stm-single-sp_player stm-player-page',
				'template' => 'player-content'
			),
			'sp_team' => array(
				'class' => 'stm-single-sp_team stm-team-page',
				'template' => 'team-content'
			),
			'sp_list' => array(
				'class' => 'stm-single-sp_list stm-list-page',
				'template' => 'team-content'
			)
		);
		return $post_types_content;
	}
}

if(!function_exists('splash_display_sidebar')) {
	function splash_display_sidebar($sidebar_id, $before, $after, $settings) {
		if(!empty($sidebar_id)):
			echo wp_kses_post($before);
			if(!empty($sidebar_id) and $sidebar_id !== 'primary_sidebar') {
				echo apply_filters( 'the_content' , $settings->post_content); ?>
				<style type="text/css">
					<?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ); ?>
				</style>
			<?php } elseif(!empty($sidebar_id) and $sidebar_id == 'primary_sidebar') {
				get_sidebar();
			}
			echo wp_kses_post($after);
		endif;
	}
}