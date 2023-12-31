<?php

namespace Codemanas\OmniSearch;

class Bootstrap {
	private static ?Bootstrap $instance = null;

	public static function get_instance(): ?Bootstrap {
		return is_null( self::$instance ) ? self::$instance = new self() : self::$instance;
	}

	protected function __construct() {
		add_action( 'plugin_loaded', [ $this, 'init_modules' ] );
		add_action( 'wp_footer', [ $this, 'load_template' ] );
	}

	public function init_modules() {
		add_filter( 'cm_typesense_schema', [ $this, 'unified_schema' ], 20 );
	}

	public function unified_schema( $schema ) {
		$schema['name'] = 'unified_data';

		//taken from default TypesenseAPI.php schema
		$schema['fields'] = [
			[ 'name' => 'post_content', 'type' => 'string' ],
			[ 'name' => 'post_title', 'type' => 'string' ],
			[ 'name' => 'post_type', 'type' => 'string' ],
			[ 'name' => 'post_author', 'type' => 'string' ],
			[ 'name' => 'comment_count', 'type' => 'int64' ],
			[ 'name' => 'is_sticky', 'type' => 'int32' ],
			[ 'name' => 'post_excerpt', 'type' => 'string' ],
			[ 'name' => 'post_date', 'type' => 'string' ],
			[ 'name' => 'sort_by_date', 'type' => 'int64' ],
			[ 'name' => 'post_id', 'type' => 'string' ],
			[ 'name' => 'post_modified', 'type' => 'string' ],
			[ 'name' => 'id', 'type' => 'string' ],
			[ 'name' => 'permalink', 'type' => 'string' ],
			[ 'name' => 'post_thumbnail', 'type' => 'string', 'optional' => true, 'index' => false ],
			[ 'name' => 'post_thumbnail_html', 'type' => 'string', 'optional' => true, 'index' => false ],
			//handled by default format document before entry
			[ 'name' => 'category', 'type' => 'string[]', 'optional' => true, 'facet' => true ],
			[ 'name' => 'cat_link', 'type' => 'string[]', 'optional' => true, 'index' => false ],
			//Book post type specific options
			[ 'name' => 'genre', 'type' => 'string[]', 'facet' => true, 'optional' => true ],
			[ 'name' => 'price', 'type' => 'float', 'facet' => true, 'optional' => true ],
			[ 'name' => 'author', 'type' => 'string', 'facet' => true, 'optional' => true ],
		];

		$schema['default_sorting_field'] = 'sort_by_date';

		return $schema;
	}

	public function load_template() {
		require_once CM_UNIFIED_SEARCH_DIR_PATH . '/templates/hit-template.php';
	}

}

Bootstrap::get_instance();