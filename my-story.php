<?php
/**
 * Plugin Name: My Story
 * Description: Create your own custom Instagram style stories. Show them on any part of your site using a custom widget in the Elementor page builder by adding custom images, videos, text and links.
 * Version:     1.1.2
 * Author:      Saeed Piri
 * Author URI:  https://isaeedam.ir/
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: my-story
 * Domain Path: /languages
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register oEmbed Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.1.2
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function my_story_register_oembed_widget( $my_story_widgets_manager ) {

	require_once( __DIR__ . '/widget/my-story-widget.php' );

	$my_story_widgets_manager->register( new \My_Story_Widget() );

}
add_action( 'elementor/widgets/register', 'my_story_register_oembed_widget' );

function my_story_widget_categories( $my_story_elements_manager ) {

    $my_story_elements_manager->add_category(
        'my-story',
        [
            'title' => __('My Story', 'my-story'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'my_story_widget_categories' );

add_action( 'wp_enqueue_scripts', 'my_story_scripts' );
function my_story_scripts(){

    wp_register_script('zuck', plugin_dir_url(__FILE__) . 'js/zuck.min.js', array(), time(), array( 'strategy' => 'defer', 'in_footer' => true ) );
    wp_register_script( 'my-story', plugin_dir_url(__FILE__) . 'js/my-story.js', array( 'zuck' ), time(), array( 'strategy' => 'defer', 'in_footer' => true ) );
    wp_register_style('zuck-styles', plugin_dir_url(__FILE__) . 'css/zuck.min.css', array(), time(), 'all');
    wp_register_style('snapgram', plugin_dir_url(__FILE__) . 'css/snapgram.min.css', array(), time(), 'all');

    $my_story_js_strings = [
        'unmute' => __('Touch to unmute', 'my-story'),
        'keyboardTip' => __('Press space to see next', 'my-story'),
        'visitLink' => __('Visit link', 'my-story'),
        'time' => [
            'ago' => __('ago', 'my-story'),
            'hour' => __('hour', 'my-story'),
            'hours' => __('hours', 'my-story'),
            'minute' => __('minute', 'my-story'),
            'minutes' => __('minutes', 'my-story'),
            'fromnow' => __('from now', 'my-story'),
            'seconds' => __('seconds', 'my-story'),
            'yesterday' => __('yesterday', 'my-story'),
            'tomorrow' => __('tomorrow', 'my-story'),
            'days' => __('days', 'my-story'),
        ]
    ];
    wp_localize_script('my-story', 'zuckTranslations', $my_story_js_strings);

}

add_action( 'elementor/preview/enqueue_scripts', 'my_story_preview_scripts' );
function my_story_preview_scripts() {
    wp_enqueue_script( 'my-story-preview', plugin_dir_url(__FILE__) . 'js/my-story-preview.js', array( 'jquery', 'zuck' ), time(), array( 'strategy' => 'defer', 'in_footer' => true ) );
}