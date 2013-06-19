<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * IsotopeFilterMember
 *
 * @copyright  Kirsten Roschanski 2013 <http://kirsten-roschanski.de>
 * @author     Kirsten Roschanski <kirsten.roschanski@kirsten-roschanski.de>
 * @package    IsotopeFilterMember
 * @license    LGPL 
 * @link       https://github.com/katgirl/isotope_filter-member
 * @filesource
 */

/**
 * Add a global operation to tl_member
 */
#$GLOBALS['TL_DCA']['tl_member']['list']['operations']['member_orders'] = array
#(
#	'label'         => &$GLOBALS['TL_LANG']['tl_member']['member_orders'],
#	'href'          => 'do=tl_iso_orders',
#	'icon'          => 'system/modules/isotope_filter-member/html/shopping-basket.png',
#);


/**
 * List
 */
$GLOBALS['TL_DCA']['tl_member']['list']['global_operations']['filter_member_by_last_order'] = array
(
	'label'				  => &$GLOBALS['TL_LANG']['tl_member']['filter_member_by_last_order'],
	'href'				  => 'do=member&key=filter_member_by_last_order',
	'class'				  => 'filter_member_by_last_order header_filter_all',
	'attributes'		=> 'onclick="Backend.getScrollOffset();"',
);
