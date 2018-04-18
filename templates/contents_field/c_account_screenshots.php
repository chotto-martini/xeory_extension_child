<?php
/**
 * 「口座スクリーンショット」コンテンツのテンプレートファイル.
 */

if($images) {
	$html = '';
	foreach($images as $image) {
		$image_src = wp_get_attachment_image_src($image["id"] , "full");
		$url = $image_src[0];
?>

<p>
	<a href="<?php echo $url; ?>">
		<img class="alignnone wp-image-45 size-full" src="<?php echo $url; ?>" />
	</a>
</p>

<?php
	}
	echo $html;
}
?>