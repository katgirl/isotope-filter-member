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
 * BACK END MODULES
 */
$GLOBALS['BE_MOD']['accounts']['member']['filter_member_by_last_order'] = array('IsotopeFilterMember', 'filter_member_by_last_order');
$GLOBALS['BE_MOD']['accounts']['member']['filter_member'] = array('IsotopeFilterMember', 'filter_member');

