<?php

namespace Codemanas\OmniSearch;

class Bootstrap {
	private static ?Bootstrap $instance = null;

	public static function get_instance(): ?Bootstrap {
		return is_null( self::$instance ) ? self::$instance = new self() : self::$instance;
	}

	protected function __construct() {
		add_action( 'plugin_loaded', [ $this, 'init_modules' ] );

	}

	public function init_modules() {
		add_filter( 'cm_typesense_schema', [ $this, 'unified_schema' ], 20 );
		add_action( 'wp_footer', [ $this, 'load_template' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_filter( 'cm_typesense_data_before_entry', [ $this, 'format_data' ], 10, 4 );
		add_filter( 'cm_typesense_search_facet_title', [ $this, 'post_type_title' ], 10, 2 );
		add_filter( 'cm_typesense_search_facet_label', [ $this, 'post_type_label' ], 10, 2 );
	}


	public function unified_schema( $schema ) {
		$schema['name'] = 'unified_data';

		//taken from default TypesenseAPI.php schema
		$schema['fields'] = [
			[ 'name' => 'post_content', 'type' => 'string' ],
			[ 'name' => 'post_title', 'type' => 'string' ],
			[ 'name' => 'post_type', 'type' => 'string', 'optional' => true, 'facet' => true ],
			[ 'name' => 'post_author', 'type' => 'string' ],
			[ 'name' => 'sort_by_date', 'type' => 'int64' ],
			[ 'name' => 'post_id', 'type' => 'string' ],
			[ 'name' => 'post_modified', 'type' => 'string' ],
			[ 'name' => 'id', 'type' => 'string' ],
			[ 'name' => 'permalink', 'type' => 'string' ],
			[ 'name' => 'post_thumbnail_html', 'type' => 'string', 'optional' => true, 'index' => false ],

			/*
			 * Add And modify as necessary
			//handled by default format document before entry
			[ 'name' => 'category', 'type' => 'string[]', 'optional' => true, 'facet' => true ],
			[ 'name' => 'cat_link', 'type' => 'string[]', 'optional' => true, 'index' => false ],
			//Book post type specific options
			[ 'name' => 'genre', 'type' => 'string[]', 'facet' => true, 'optional' => true ],
			[ 'name' => 'price', 'type' => 'float', 'facet' => true, 'optional' => true ],
			[ 'name' => 'author', 'type' => 'string', 'facet' => true, 'optional' => true ],
			*/
		];

		$schema['default_sorting_field'] = 'sort_by_date';

		return $schema;
	}

	public function load_template() {
		require_once CM_UNIFIED_SEARCH_DIR_PATH . '/templates/hit-template.php';
	}

	public function enqueue_scripts() {
		wp_register_style( 'cmswt-unified-search', CM_UNIFIED_SEARCH_ASSETS_URL . 'css/style.css', '', CM_UNIFIED_SEARCH_VERSION );
		wp_enqueue_style( 'cmswt-unified-search' );
	}

	public function format_data( $formatted_data, $raw_data, $object_id, $schema_name ) {
		if ( $raw_data instanceof \WP_Post ) {
			$post_type_slug              = get_post_type( $raw_data );
			$post_type                   = get_post_type_object( $post_type_slug );
			$formatted_data['post_type'] = $post_type->label;
		}

		return $formatted_data;
	}

	public function post_type_title( $label, $filter ) {
		if ( $filter === 'post_type' ) {
			$label = __( "Post Type", 'omni-search' );
		}

		return $label;
	}

	public function post_type_label( $label, $filter ) {
		if ( $filter == 'post_type' ) {
			$label = __( "Post Type", 'omni-search' );
		}

		return $label;
	}

}

Bootstrap::get_instance();