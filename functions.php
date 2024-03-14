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
		
		if(!defined( 'WPSEO_VERSION' )) {
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
				<meta name="author" content="<?php bloginfo( 'name' ); ?>" />
				<meta property="og:type" content="website" />
			<?php
		}
		
		?>
			

			
			<meta name="viewport" content="initial-scale=1,user-scalable=yes" />
			<meta name="HandheldFriendly" content="true" />
			<meta name="viewport" content="width=device-width, minimal-ui" />
		<?php
		
		if(is_singular()) {
			$has_dbm_content_translations = apply_filters('wprr_theme/has_dbm_translations', false);
		
			if($has_dbm_content_translations) {
				$current_id = get_the_id();
				$local_post = wprr_get_data_api()->wordpress()->get_post($current_id);
				
				$translated_posts = $local_post->object_relation_query('out:in:group/translations-group,in:in:*');
				foreach($translated_posts as $translated_post) {
					
					$language = $translated_post->get_meta('language');
					if($language) {
						echo("<link rel=\"alternate\" hreflang=\"".esc_attr($language)."\" href=\"".(site_url($translated_post->get_link()))."\" />");
					}
				}
			}
		}
	}
	add_action( 'wp_head', 'wprr_theme_wp_head' );
	
	function wprr_theme_output_lang_attribute() {
		
		if(is_singular()) {
			$has_dbm_content_translations = apply_filters('wprr_theme/has_dbm_translations', false);
		
			if($has_dbm_content_translations) {
				$language = get_post_meta(get_the_id(), 'language', true);
				if($language) {
					echo("lang=\"".esc_attr($language)."\"");
					return;
				}
			}
		}
		
		language_attributes();
	}
	
	function wprr_theme_filter_post_locale($locale) {
		
		if(is_singular()) {
			$has_dbm_content_translations = apply_filters('wprr_theme/has_dbm_translations', false);
	
			if($has_dbm_content_translations) {
				$language = get_post_meta(get_the_id(), 'language', true);
				if($language) {
					return $language;
				}
			}
		}
	
		return $locale;
	}
	add_filter('wpseo_og_locale', 'wprr_theme_filter_post_locale', 1);
	add_filter('wpseo_schema_piece_language', 'wprr_theme_filter_post_locale', 1);
?>