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


/** 投稿記事一覧にアイキャッチ画像を表示. */
function customize_admin_manage_posts_columns($columns) {
	$columns['thumbnail'] = __('Thumbnail');
	return $columns;
}
function customize_admin_add_column($column_name, $post_id) {
	if ( 'thumbnail' == $column_name) {
		//テーマで設定されているサムネイルを利用する場合
		//$thum = get_the_post_thumbnail($post_id, 'thumb100', array( 'style'=>'width:100px;height:auto;' ));
		//Wordpressで設定されているサムネイル（小）を利用する場合
		$thum = get_the_post_thumbnail($post_id, 'small', array( 'style'=>'width:100px;height:auto;' ));
	}
	if ( isset($thum) && $thum ) {
		echo $thum;
	}
}
/** アイキャッチ画像の列の幅をCSSで調整. */
function customize_admin_css_list() {
	echo '<style TYPE="text/css">.column-thumbnail{width:120px;}</style>';
}
/** カラムの挿入. */
add_filter( 'manage_posts_columns', 'customize_admin_manage_posts_columns' );
/** サムネイルの挿入. */
add_action( 'manage_posts_custom_column', 'customize_admin_add_column', 10, 2 );
/** 投稿一覧のカラムの幅のスタイル調整. */
add_action('admin_print_styles', 'customize_admin_css_list', 21);
