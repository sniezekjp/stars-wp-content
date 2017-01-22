(function ($) {
    "use strict";

    /*Ready DOM scripts*/
    $(document).ready(function () {
        stm_sticky_footer();

        stm_open_search();

        stmFullwidthRowJs();

        default_widgets_scripts();

        //Default plugins
        $("select:not(.disable-select2)").select2({
            width: '100%',
            minimumResultsForSearch: '1'
        });

        $('.stm-iframe').fancybox({
            type: 'iframe',
            padding: 0,
            maxWidth: '800px',
            width: '100%',
            fitToView: false,
            beforeLoad: function () {
                this.href = $(this.element).data('url');
            }
        });

        $('.stm-fancybox').fancybox({
            fitToView: false,
            padding: 0,
            autoSize: true,
            closeClick: false,
            maxWidth: '100%',
            maxHeight: '90%',
            beforeShow: function () {
                $('body').addClass('stm_locked');
                this.title = $(this.element).attr("data-caption");
            },
            beforeClose: function () {
                $('body').removeClass('stm_locked');
            },
            helpers: {
                title: {
                    type: 'inside'
                },
                overlay: {
                    locked: false
                }
            }
        });

        $('html').click(function () {
            $('.search-input').removeClass('active');
            $('.search-submit').removeClass('activated');
        });

        stm_sort_media();

        // Event form validation
        $('.donation-popup-form').on('submit', function (e) {
            e.preventDefault();
            var $this = $(this);
            $($this).removeClass('error');
            $($this).find('.loading').addClass('active');
            $(this).ajaxSubmit({
                url: ajaxurl,
                dataType: 'json',
                success: function (data) {
                    $($this).find('.loading').removeClass('active');
                    if (data['redirect_url']) {
                        top.location.href = data['redirect_url'];
                        $($this).replaceWith('<p class="alert alert-success heading-font">' + data['success'] + '</p>');
                    } else if( data['success'] ){
                        $($this).replaceWith('<p class="alert alert-success heading-font">' + data['success'] + '</p>');
                    } else {
                        for (var k in data['errors']) {
                            $($this).find('input[name="donor[' + k + ']"]').addClass('error');
                            $($this).find('textarea[name="donor[' + k + ']"]').addClass('error');
                        }
                    }
                }
            });
            $($this).find('.error').live('hover', function () {
                $(this).removeClass('error');
            });
            return false;
        });

        $('.stm-load-more-images-grid').click(function(e){
            e.preventDefault();
            $(this).closest('.stm-images-grid').find('.stm-waiting').addClass('animated fadeIn').removeClass('stm-waiting');
            $(this).remove();
        });

        $('.stm-media-load-more a').click(function(e){
            e.preventDefault();

            var page = $(this).attr('data-page');
            var category = $(this).attr('data-category');
            var loadBy = $(this).attr('data-load');
            var player_id = 'none';
            if(typeof stm_player_id !== 'undefined') {
                player_id = stm_player_id;
            }
            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                context: this,
                data: {
                    action: 'splash_load_media',
                    page: page,
                    load: loadBy,
                    category: category,
                    playerId: player_id
                },
                beforeSend: function(){
                    $(this).addClass('loading');
                },
                success: function (data) {
                    $(this).removeClass('loading');
                    if(data.offset !== 'none') {
                        $(this).attr('data-page', data.offset);
                    } else {
                        $(this).remove();
                    }

                    if(data.html) {
                        var $items = $(data.html);
                        $('#' + category + '_media .stm-medias-unit').append($items).isotope('appended', $items, false);
                        stm_sort_media();
                    }
                }
            });
        });

        $('.stm-single-product-content-right table.variations select').live("change", function() {
            $(this).parent().find('.select2-selection__rendered').text($(this).find('option[value="'+ $(this).val() +'"]').text());
        });

        $('.stm-menu-toggle').click(function(e){
            e.preventDefault();
            $(this).toggleClass('opened');
            $('.stm-mobile-menu-unit').slideToggle();
        });

        $(document).on("click", ".stm-mobile-menu-list li a", function() {
            if( $(this).parent("li").hasClass("menu-item-has-children") && ! $(this).parent("li").hasClass("active") ) {

                $(this).closest("li").siblings().find("ul").slideUp();
                $(this).closest("li").siblings().find("li").removeClass("active");

                $(this).next("ul").slideDown();
                $(this).parent("li").addClass("active").siblings().removeClass("active");

                return false;
            }
        });

    });

    /*Window load scripts*/

    $(window).load(function () {
        stm_sticky_footer();

        stmFullwidthRowJs();
    });

    /*Window resize scripts*/
    $(window).resize(function () {
        stm_sticky_footer();

        stmFullwidthRowJs();
    });


    /*CUSTOM FUNCTIONS*/
    /*Sticky footer*/
    function stm_sticky_footer() {
        var winH = $(window).outerHeight();
        var footerH = $('.stm-footer').outerHeight();
        var siteMinHeight = winH - footerH;

        $('#wrapper').css({
            'min-height': siteMinHeight + 'px'
        });

        $('body').css({
            'padding-bottom': footerH + 'px'
        });

    }

    function stm_open_search() {
        $('.stm-header-search').click(function (e) {
            e.stopPropagation();
        });

        $('.search-submit').click(function (e) {
            $(this).toggleClass('activated');
            var inputText = $(this).closest('form').find('input');
            if (!inputText.hasClass('active') || inputText.val() == '') {
                e.preventDefault();
                inputText.toggleClass('active');
            }
            inputText.focus();
        });
    }

    function stm_sort_media() {
        // init Isotope
        if ($('.stm-medias-unit').length) {
            if (typeof imagesLoaded == 'function') {
                $('.stm-medias-unit').imagesLoaded(function () {
                    $('.stm-medias-unit').isotope({
                        itemSelector: '.stm-media-single-unit',
                        layoutMode: 'masonry'
                    });
                });
            }
        }

        $('.stm-media-tabs-nav a').on('shown.bs.tab', function (e) {
            var tabId = $(this).attr('href');
            $(tabId + ' .stm-medias-unit').isotope('layout');
        })
    }

    function default_widgets_scripts() {
        var stm_menu_widget = $('.widget_nav_menu');
        var stm_categories_widget = $('.widget_categories');
        var stm_recent_entries = $('.widget_recent_entries');

        if(stm_menu_widget.length) {
            stm_menu_widget.each(function () {
                if($(this).closest('.footer-widgets-wrapper').length == 0) {
                    $(this).addClass('stm-widget-menu');
                    $(this).find('a').each(function(){
                        $(this).html('<span>' + $(this).text() + '</span>');
                    });
                }
            });
        }

        if(stm_categories_widget.length) {
            stm_categories_widget.each(function () {
                $(this).find('a').each(function(){
                    $(this).html('<span>' + $(this).text() + '</span>');
                });
            });
        }

        if(stm_recent_entries.length) {
            stm_recent_entries.each(function () {
                if( !$(this).find('.post-date').length ) {
                    $(this).addClass('no-date');
                }
            });
        }
    }

    function stmFullwidthRowJs() {
        var winW = $(window).outerWidth();
        var contW = $('.stm-fullwidth-row-js').find('.container').width();
        var contMargins = (winW - contW) / 2;
        $('.stm-fullwidth-row-js').css({
            'margin-left': -contMargins + 'px',
            'margin-right': -contMargins + 'px'
        })
    }

})(jQuery);