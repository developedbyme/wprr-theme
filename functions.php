<?php
	function wprr_theme_after_setup_theme() {
	
		// Automatic feed
		add_theme_support( 'automatic-feed-links' );
	
		// Set content-width
		global $content_width;
		if ( ! isset( $content_width ) ) $content_width = 620;
	
		// Post thumbnails
		add_theme_support( 'post-thumbnails' );
	
		// Title tag
		add_theme_support( 'title-tag' );
	
	}
	add_action( 'after_setup_theme', 'wprr_theme_after_setup_theme' );
	
	function wprr_theme_wp_head() {
		$image = null;
		$title = null;
		$description = null;
		$url = null;
		
		if(is_singular()) {
			if(has_post_thumbnail()) {
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
			}
			$title = get_the_title();
			$description = get_the_excerpt();
			$url = get_permalink();
		}
		else if(is_archive()) {
			
			$queried_object = get_queried_object();
			
			$title = $queried_object->name;
			$description = $queried_object->description;
		}
		
		if(!empty($url)) {
			?>
				<meta property="og:url" content="<?php echo($url); ?>" />
			<?php
		}
		if(!empty($image)) {
			?>
				<meta property="og:image" content="<?php echo($image); ?>" />
			<?php
		}
		if(!empty($title)) {
			?>
				<meta property="og:title" content="<?php echo(esc_attr($title)); ?>" />
			<?php
		}
		if(!empty($description)) {
			?>
				<meta property="og:description" content="<?php echo(esc_attr($description)); ?>" />
				<meta name="description" content="<?php echo(esc_attr($description)); ?>" />
			<?php
		}
		?>
			<meta property="og:type" content="website" />

			<meta name="author" content="<?php bloginfo( 'name' ); ?>" />
			<meta name="viewport" content="initial-scale=1,user-scalable=yes" />
			<meta name="HandheldFriendly" content="true" />
			<meta name="viewport" content="width=device-width, minimal-ui" />
		<?php
	}
	add_action( 'wp_head', 'wprr_theme_wp_head' );
?>