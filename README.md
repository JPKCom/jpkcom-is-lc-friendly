# JPKCom Theme is LiveCanvas friendly

**Plugin Name:** JPKCom Theme is LiveCanvas friendly  
**Plugin URI:** https://github.com/JPKCom/jpkcom-is-lc-friendly  
**Description:** Enables lc_theme_is_livecanvas_friendly().  
**Version:** 1.0.2  
**Author:** Jean Pierre Kolb <jpk@jpkc.com>  
**Author URI:** https://www.jpkc.com  
**Contributors:** JPKCom  
**Tags:** LiveCanvas, Bootstrap, Theme  
**Requires Plugins:** livecanvas  
**Requires at least:** 6.7  
**Tested up to:** 6.8  
**Requires PHP:** 8.3  
**Stable tag:** 1.0.2  
**License:** GPL-2.0+  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.txt

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

### 1.0.2
* Updated README.md

### 1.0.1
* Updated README.md

### 1.0.0
* Initial Release
