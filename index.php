<?php 
	get_header();
	
	if(function_exists('wprr_output_module')) {
		$render_path = $_SERVER["REQUEST_URI"];
		wprr_output_module_with_seo_content('index', $render_path);
	}
	
	get_footer();
?>