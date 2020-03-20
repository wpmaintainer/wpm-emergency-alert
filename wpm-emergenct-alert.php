<?php
/*
Plugin Name: Emergency Alert
Description: Add an emergency alert banner in your site header or footer; or enable an emergency alert popup. Set how/where it displays.
Author: WP Maintainer
Author URI: https://wpmaintainer.com
Version: 1.0.0
*/

foreach ( \glob( __DIR__ . '/lib/*.php' ) as $file ) include $file;