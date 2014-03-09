<?php
/**
 * @package Marketizator
 * @version 1.0
 */
/*
Plugin Name: Marketizator
Plugin URI: http://wordpress.org/extend/plugins/marketizator/
Description: <a href="http://www.marketizator.com">Marketizator</a> is the simplest way to convert your visitors into prospective customers or buyers. It helps increase your conversion or subscription rate. To get started: 1) Click the "Activate" link to the left of this description, 2) Sign up for an <a href="http://www.marketizator.com">Marketizator account</a>, and 3) Go to the <a href="admin.php?page=marketizator-config">settings page</a>, and enter your tracking code.
Author: Dragoi Ciprian
Version: 1.0
Author URI: http://www.marketizator.com/
License: GPL2
*/

/*  Copyright 2013 Dragoi Ciprian (email: ciprian@marketizator.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if (is_admin()) { require_once dirname( __FILE__ ) . '/admin.php'; }

// add script tag
add_action('wp_head', 'add_marketizator_script', -1000);

function add_marketizator_script() {
	if(empty($mktz_code)) {
		$mktz_code = get_option('mktz_code');
		$mktz_code = html_entity_decode($mktz_code);
		if(!empty($mktz_code)) { echo $mktz_code; }
	}
}
?>