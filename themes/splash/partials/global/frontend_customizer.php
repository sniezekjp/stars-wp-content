<?php
	$service = false; 
	if(is_page_template('home-service-layout.php')) {
		$service = true;
	}
?>

<div id="frontend_customizer" style="left: -276px;">
	<div class="customizer_wrapper">

		<h3><?php esc_html_e('Nav Mode', 'splash'); ?></h3>

		<div class="customizer_element">
			<div class="stm_switcher active" id="navigation_type">
				<div class="switcher_label disable"><?php esc_html_e('Static', 'splash'); ?></div>
				<div class="switcher_nav"></div>
				<div class="switcher_label enable"><?php esc_html_e('Sticky', 'splash'); ?></div>
			</div>
		</div>

		<h3><?php esc_html_e('Layout', 'splash'); ?></h3>

		<div class="customizer_element">
			<div class="stm_switcher active" id="layout_mode">
				<div class="switcher_label disable"><?php esc_html_e('Boxed', 'splash'); ?></div>
				<div class="switcher_nav"></div>
				<div class="switcher_label enable"><?php esc_html_e('Wide', 'splash'); ?></div>
			</div>
		</div>

		<div class="customizer_boxed_background">
			<h3><?php esc_html_e( 'Background Image', 'splash' ); ?></h3>

			<div class="customizer_element">
				<div class="customizer_colors" id="background_image">
					<span id="boxed_fifth_bg" class="active" data-image="box_img_5"></span>
					<span id="boxed_first_bg" data-image="box_img_1"></span>
					<span id="boxed_second_bg" data-image="box_img_2"></span>
					<span id="boxed_third_bg" data-image="box_img_3"></span>
					<span id="boxed_fourth_bg" data-image="box_img_4"></span>

				</div>
			</div>
		</div>

		<h3><?php esc_html_e( 'Color Skin', 'splash' ); ?></h3>

		<div class="customizer_element">
			<div class="customizer_colors" id="skin_color">
				<span id="site_style_default" class="active"></span>
				<span id="blue"></span>
				<span id="blue-violet"></span>
				<span id="choco"></span>
				<span id="gold"></span>
				<span id="green"></span>
				<span id="orange"></span>
				<span id="sky-blue"></span>
				<span id="turquose"></span>
				<span id="violet-red"></span>
			</div>
		</div>

	</div>
	<div id="frontend_customizer_button"><i class="fa fa-cog"></i></div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function ($) {
		"use strict";

		$(window).load(function () {
			$("#frontend_customizer").animate({left: -233}, 300);
		});

		$("#frontend_customizer_button").on('click', function () {
			if ($("#frontend_customizer").hasClass('open')) {
				$("#frontend_customizer").animate({left: -233}, 300);
				$("#frontend_customizer").removeClass('open');
			} else {
				$("#frontend_customizer").animate({left: 0}, 300);
				$("#frontend_customizer").addClass('open');
			}
		});

		$('body').on('click', function (kik) {
			if (!$(kik.target).is('#frontend_customizer, #frontend_customizer *') && $('#frontend_customizer').is(':visible')) {
				$("#frontend_customizer").animate({left: -233}, 300);
				$("#frontend_customizer").removeClass('open');
			}
		});

		var body_class = '';

		$("#skin_color span").on('click', function () {

			$('body').removeClass(body_class);

			var style_id = $(this).attr('id');
			body_class = 'skin-' + style_id;

			$('body').addClass(body_class);
			
			var logo_url = '<?php echo esc_url(get_template_directory_uri().'/assets/images/tmp/logo_'); ?>' + style_id + '.svg';
			
			$("#skin_color .active").removeClass("active");
			
			$(this).addClass("active");
			
			$("#custom_style").remove();
			
			if( style_id != 'site_style_default' ){
				$('#custom_style').remove();
				$("head").append('<link rel="stylesheet" id="custom_style" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/skins/skin-custom-'+style_id+'.css?v=' + Math.floor((Math.random() * 100) + 1) + '" type="text/css" media="all">');

				$('.stm-header .logo-main img, .stm-small-logo').attr('src', logo_url);
			} else {
				$('.stm-header .logo-main img, .stm-small-logo').attr('src', logo_url);
			}
		});


		$("#navigation_type").on("click", function () {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');

				$('.stm-header').removeClass('stm-header-fixed-mode stm-header-fixed stm-header-fixed-intermediate');
			} else {
				$(this).addClass('active');

				$('.stm-header').addClass('stm-header-fixed-mode');
			}
		});

		$("#layout_mode").on("click", function () {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');

				$('body').addClass('stm-boxed');
				$('.customizer_boxed_background').slideDown();
				
				$('body').addClass('stm-background-customizer-box_img_5');
			} else {
				$(this).addClass('active');

				$('body').removeClass('stm-boxed');
				$('.customizer_boxed_background').slideUp();
				
				$('body').addClass('stm-background-customizer-box_img_5');
			}
		});
		
		$('#background_image span').on('click', function(){
			$('#background_image span').removeClass('active');
			$(this).addClass('active');
			
			var img_src = $(this).data('image');
			
			$('body').removeClass('stm-background-customizer-box_img_1 stm-background-customizer-box_img_2 stm-background-customizer-box_img_3 stm-background-customizer-box_img_4 stm-background-customizer-box_img_5');
			
			$('body').addClass('stm-background-customizer-' + img_src);
		});

	});

</script>