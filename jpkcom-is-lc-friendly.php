<?php
/*
Plugin Name: JPKCom Theme is LiveCanvas friendly
Plugin URI: https://github.com/JPKCom/jpkcom-is-lc-friendly
Description: Enables lc_theme_is_livecanvas_friendly().
Version: 1.0.8
Author: Jean Pierre Kolb <jpk@jpkc.com>
Author URI: https://www.jpkc.com
Contributors: JPKCom
Tags: LiveCanvas, Bootstrap, Theme
Requires Plugins: livecanvas
Requires at least: 6.9
Tested up to: 7.1
Requires PHP: 8.3
Stable tag: 1.0.8
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

declare(strict_types=1);

if ( ! defined( constant_name: 'WPINC' ) ) {
  die;
}


/**
 * Plugin Constants
 *
 * @since 1.0.4
 */
if ( ! defined( 'JPKCOM_IS_LC_FRIENDLY_VERSION' ) ) {
    define( 'JPKCOM_IS_LC_FRIENDLY_VERSION', '1.0.8' );
}


/**
 * Initialize Plugin Updater
 *
 * Loads and initializes the GitHub-based plugin updater with SHA256 checksum verification.
 *
 * @since 1.0.4
 *
 * @return void
 */
add_action( 'init', static function (): void {
    $updater_file = plugin_dir_path( __FILE__ ) . 'includes/class-plugin-updater.php';

    if ( file_exists( $updater_file ) ) {
        require_once $updater_file;

        if ( class_exists( 'JPKComIsLcFriendlyGitUpdate\\JPKComGitPluginUpdater' ) ) {
            new \JPKComIsLcFriendlyGitUpdate\JPKComGitPluginUpdater(
                plugin_file: __FILE__,
                current_version: JPKCOM_IS_LC_FRIENDLY_VERSION,
                manifest_url: 'https://jpkcom.github.io/jpkcom-is-lc-friendly/plugin_jpkcom-is-lc-friendly.json'
            );
        }
    }
}, 5 );

if ( ! function_exists( function: 'lc_theme_is_livecanvas_friendly' ) ) {

  /**
   * Signal to LiveCanvas that the active theme is LiveCanvas-friendly.
   *
   * LiveCanvas detects the mere existence of this function; it intentionally
   * has no body.
   *
   * @since 1.0.0
   *
   * @return void
   */
  function lc_theme_is_livecanvas_friendly(): void {

    // That's all ;-)

  }

}

if ( ! function_exists( function: 'lc_theme_bootstrap_version' ) ) {

  /**
   * Tell LiveCanvas which Bootstrap version the theme targets.
   *
   * @since 1.0.0
   *
   * @return float Bootstrap version (e.g. 5.3 for the latest Bootstrap 5).
   */
  function lc_theme_bootstrap_version(): float {

    return 5.3;

  }

}
