<?php
/**
 * コンテンツブロック要素に関する関数.
 */

/**
 * コンテンツブロックを表示する.
 *
 * @param unknown $post_id 投稿ID
 * @return string コンテンツブロックの文字列
 */
function get_content_blocks($post_id) {
	global $post;

	$blocks = array();
	$contents = _get_content_blocks($post_id);
	$count = count($contents);
	$page_no = get_query_var("page");

	if ($count > 1) {
		if ($page_no && is_numeric($page_no) && $count >= $page_no) {
			if ($page_no > 1) {
				$p = $page_no - 1;
			} else {
				$p = 0;
			}
		} else {
			$p = 0;
		}
		$blocks = $contents[$p];

	} else {
		$blocks = $contents[0];
	}

	$ret = '';
	if ($blocks) {
		foreach ($blocks as $block) {
			$ret .= $block;
		}
	}
	return $ret;
}

/**
 * 「article_content」として登録されたコンテンツブロックを取得する.
 *
 * @param unknown $post_id 投稿ID
 * @return string コンテンツブロックの文字列
 */
function _get_content_blocks($post_id) {

	if (have_rows('article_content')) {

		$i = 0;
		$block_no = 1;
		$contents[] = array();

		while ( have_rows('article_content') ) : the_row();

		$pagenate_flg = false;
		set_query_var("post_id", $post_id);

		// 「口座スクリーンショット」コンテンツを取得する。
		if (get_row_layout() == 'c_account_screenshots') {
			$images = get_sub_field('c_images');
			$option["thumbnail"] = get_sub_field('option_thumbnail');

			// テンプレート要素をセット。
			set_query_var("images", $images);
			set_query_var("option", $option);
		}

		if (!$pagenate_flg) {
			ob_start();
			get_template_part('templates/contents_field/'  . get_row_layout());
			$contents[$i][] = ob_get_clean();
		}
		$block_no++;
		endwhile;

		return $contents;
	}
}
