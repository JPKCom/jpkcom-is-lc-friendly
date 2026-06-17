# JPKCom Theme is LiveCanvas friendly

**Plugin Name:** JPKCom Theme is LiveCanvas friendly  
**Plugin URI:** https://github.com/JPKCom/jpkcom-is-lc-friendly  
**Description:** Enables lc_theme_is_livecanvas_friendly().  
**Version:** 1.0.4  
**Author:** Jean Pierre Kolb <jpk@jpkc.com>  
**Author URI:** https://www.jpkc.com  
**Contributors:** JPKCom  
**Tags:** LiveCanvas, Bootstrap, Theme  
**Requires Plugins:** livecanvas  
**Requires at least:** 6.9  
**Tested up to:** 7.0  
**Requires PHP:** 8.3  
**Stable tag:** 1.0.4  
**License:** GPL-2.0-or-later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html

Enables lc_theme_is_livecanvas_friendly().


## Description

Adds the following features:

```
function lc_theme_is_livecanvas_friendly(){}
```

```
function lc_theme_bootstrap_version() {
    return 5.3; //for latest Bootstrap, or
    //return 5; //for   Bootstrap 5.0 .. 5.2 , or
    //return 4;  //for   Bootstrap 4 
}
```

For more details visit: https://docs.livecanvas.com/which-themes-with-livecanvas/


### Documentation

**API Documentation:** Complete PHPDoc-generated API documentation is available at:
[https://jpkcom.github.io/jpkcom-is-lc-friendly/docs/](https://jpkcom.github.io/jpkcom-is-lc-friendly/docs/)


## Installation

1. In your admin panel, go to 'Plugins' > and click the 'Add New' button.
2. Click Upload Plugin and 'Choose File', then select the Plugin's .zip file. Click 'Install Now'.
3. Make sure 'LiveCanvas' plugin is activated.
4. Click 'Activate' to use the plugin right away.
5. Create a subdirectory called `page-templates` in your theme folder.
6. In this folder, create a file called `empty.php` with the following code:

```
<?php
/* Template Name: Empty */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
the_post();
the_content();
endwhile;

get_footer();

```


## Changelog

### 1.0.4
* Added secure self-hosted plugin updates via GitHub with SHA256 checksum verification
* Added an automated release workflow (builds the ZIP, generates the manifest and deploys to gh-pages on tag push)
* Raised the minimum WordPress version to 6.9 and "Tested up to" to WordPress 7.0
* Switched license metadata to the SPDX identifier `GPL-2.0-or-later` with the HTTPS license URI
* Added PHPDoc-generated API documentation, built and deployed to gh-pages on release
* Hardening: enabled `declare(strict_types=1)` and guarded the LiveCanvas helper functions with `function_exists()`

### 1.0.3
* Tested up to WP v6.8

### 1.0.2
* Updated README.md

### 1.0.1
* Updated README.md

### 1.0.0
* Initial Release
