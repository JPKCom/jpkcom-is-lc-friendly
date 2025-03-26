<?php
/*
Plugin Name: JPKCom Theme is LiveCanvas friendly
Plugin URI: https://github.com/JPKCom/jpkcom-is-lc-friendly
Description: Enables lc_theme_is_livecanvas_friendly().
Version: 1.0.1
Author: Jean Pierre Kolb <jpk@jpkc.com>
Author URI: https://www.jpkc.com
Contributors: JPKCom
Tags: LiveCanvas, Bootstrap, Theme
Requires Plugins: livecanvas
Requires at least: 6.7
Tested up to: 6.8
Requires PHP: 8.3
Stable tag: 1.0.1
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
GitHub Plugin URI: JPKCom/jpkcom-is-lc-friendly
Primary Branch: main
*/

if ( ! defined( constant_name: 'WPINC' ) ) {
  die;
}

	
function lc_theme_is_livecanvas_friendly(): void {
  // That's all ;-)
}

function lc_theme_bootstrap_version(): float {

  return 5.3;

}