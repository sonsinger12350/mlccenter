<?php

// Widgets: [path => class]
$custom_widgets = [
	'/widgets/header-icon.php'          => 'Astra_Child_Custom_Widget_Header_Icon',
	'/widgets/footer-introduction.php'  => 'Astra_Child_Custom_Widget_Footer_Introduction',
	'/widgets/footer-contact-info.php'  => 'Astra_Child_Custom_Widget_Footer_Contact_Info',
	'/widgets/footer-course.php'        => 'Astra_Child_Custom_Widget_Footer_Course',
	'/widgets/footer-facebook.php'      => 'Astra_Child_Custom_Widget_Footer_Facebook',
];

// Require widget file
foreach ($custom_widgets as $path => $class) {
	require_once get_stylesheet_directory() . $path;
}

// Register widget
add_action('widgets_init', function() use ($custom_widgets) {
	foreach ($custom_widgets as $class) {
		if (class_exists($class)) {
			register_widget($class);
		}
	}
});

// function custom_enqueue_editor_styles() {
// 	// Css for Elementor editor in admin
// 	wp_enqueue_style(
// 		'astra-child-custom-widget-css-editor',
// 		get_stylesheet_directory_uri() . '/css/custom-widget.css',
// 		array(),
// 		filemtime( get_stylesheet_directory() . '/css/custom-widget.css' )
// 	);
// }
// add_action( 'elementor/editor/after_enqueue_styles', 'custom_enqueue_editor_styles' );

function custom_enqueue_styles() {
    wp_enqueue_script('jquery');

    wp_enqueue_style(
        'custom-style',
        get_stylesheet_directory_uri() . '/css/custom.css',
        array(),
        filemtime( get_stylesheet_directory() . '/css/custom.css' )
    );

    wp_enqueue_script(
        'custom-script',
        get_stylesheet_directory_uri() . '/js/custom.js',
        array(),
        filemtime( get_stylesheet_directory() . '/js/custom.js' ),
        true
    );

    wp_enqueue_style(
        'astra-child-custom-widget-css',
        get_stylesheet_directory_uri() . '/css/custom-widget.css',
        array(),
        filemtime( get_stylesheet_directory() . '/css/custom-widget.css' )
    );

    wp_enqueue_style('font-awesome');

    wp_enqueue_style(
        'owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        array(),
        '2.3.4'
    );

    wp_enqueue_script(
        'owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        array(),
        '2.3.4',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_styles' );

// Đăng ký nhóm widget mới cho Elementor
add_action('elementor/elements/categories_registered', function($elements_manager) {
	$elements_manager->add_category(
		'widget-custom',
		[
			'title' => __('Custom', 'astra-child'),
			'icon' => 'fa fa-plug',
		]
	);
});

// Đăng ký custom Elementor widget
add_action('elementor/widgets/register', function($widgets_manager) {
    if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
        require_once get_stylesheet_directory() . '/widgets/home/events.php';
        \Elementor\Plugin::instance()->widgets_manager->register( new \Custom_Elementor_Widget_Events() );
    }
});

add_action('wp_head', function () {
    $currentLang = function_exists('pll_current_language') ? pll_current_language() : 'vi';

    if ($currentLang !== 'en') {
        echo '<style>.lang-en { display: none !important; }</style>';
    }

    if ($currentLang !== 'vi') {
        echo '<style>.lang-vi { display: none !important; }</style>';
    }
});

if (function_exists('pll_register_string')) {
    $translated_strings = [
        'footer_course' => 'Khóa học',
        'footer_course_item' => 'Khóa học giao tiếp tiếng anh',
        'footer_contact_info' => 'Thông tin liên hệ',
    ];

    add_action('init', function() use ($translated_strings) {
        foreach ($translated_strings as $key => $value) {
            pll_register_string($key, $value, 'Astra Child');
        }
    });
}

?>
