<?php
/**
 * Unified Search
 *
 * @package           Codemanas/UnifiedSearch
 * @author            Your Name
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Unified Search for Search with Typesense
 * Plugin URI:        #
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            codemanas
 * Author URI:        https://www.codemanas.com
 * Text Domain:       unified-search
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


defined( 'CM_UNIFIED_SEARCH_FILE' ) || define( 'CM_UNIFIED_SEARCH_FILE', __FILE__ );
defined( 'CM_UNIFIED_SEARCH_DIR_PATH' ) || define( 'CM_UNIFIED_SEARCH_DIR_PATH', dirname( __FILE__ ) );

require CM_UNIFIED_SEARCH_DIR_PATH.'/includes/Bootstrap.php';