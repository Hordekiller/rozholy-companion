<?php
/**
 * Plugin Name:       Rozholy Companion
 * Plugin URI:        https://github.com/Hordekiller/rozholy-companion
 * Description:       Companion plugin for Rozholy theme — booking management with React admin UI and custom Gutenberg blocks styled with WPDS
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            ThemeFire
 * Author URI:        https://themefire.dev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rozholy-companion
 * Domain Path:       /languages
 */

define('ROZHOLY_COMPANION_VERSION', '1.0.0');
define('ROZHOLY_COMPANION_DIR', plugin_dir_path(__FILE__));
define('ROZHOLY_COMPANION_URI', plugin_dir_url(__FILE__));

require_once ROZHOLY_COMPANION_DIR . 'includes/post-types.php';
require_once ROZHOLY_COMPANION_DIR . 'includes/admin-page.php';
require_once ROZHOLY_COMPANION_DIR . 'includes/rest-api.php';
require_once ROZHOLY_COMPANION_DIR . 'includes/blocks.php';
require_once ROZHOLY_COMPANION_DIR . 'includes/frontend.php';

add_action('init', 'rozholy_companion_init');
function rozholy_companion_init() {
    load_plugin_textdomain('rozholy-companion', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
