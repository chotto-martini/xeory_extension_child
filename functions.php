<?php
/**
 * テーマ共通処理.
 */

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
}

/** コンテンツブロック要素に関する関数. */
require_once('functions/function-blocks.php');

/** the_contentをフックしてコンテンツブロックを表示する. */
add_action('the_content', function ($content) {
	$content = $content . get_content_blocks($post->ID);
	return $content;
});
