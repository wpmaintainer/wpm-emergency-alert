<?php
/*
Plugin Name: Emergency Alert
Description: Add an emergency alert banner in your site header or footer; or enable an emergency alert popup. Set how/where it displays.
Author: WP Maintainer
Author URI: https://wpmaintainer.com
Version: 1.3.0
*/
\define( 'WPM_EA_BASENAME', \plugin_basename( __FILE__ ) );

foreach ( \glob( __DIR__ . '/lib/*.php' ) as $file ) include $file;