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

class IsotopeFilterMember extends Backend
{
    public function __construct()
    {
      parent::__construct();
      $this->import('Database');
    }
  
    public function filter_member_by_last_order()
    {
      
      
      return '
        <div id="tl_buttons">
        <a href="'.ampersand(str_replace('&key=filter_member_by_last_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
        </div>

        <h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_member']['filter_member_by_last_order'][0].'</h2>
        <form action="'.ampersand(str_replace('&key=filter_member_by_last_order', '', $this->Environment->request)).'&key=filter_member"  id="tl_member" class="tl_form" method="post">
        <input type="hidden" name="FORM_SUBMIT" value="filter_member">
        <input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">
        <div class="tl_formbody_edit">
          <div class="tl_tbox block">
             <div class="w50 wizard">
              <h3><label for="ctrl_start">'.$GLOBALS['TL_LANG']['MSC']['labelFrom'][0].'</label></h3>
              <input type="text" name="start" id="ctrl_start" class="tl_text" value="" onfocus="Backend.getScrollOffset()"> <img src="plugins/datepicker/icon.gif" width="20" height="20" alt="" id="toggle_start" style="vertical-align:-6px">
              <script>
              window.addEvent("domready", function() {
                new Picker.Date($$("#ctrl_start"), {
                  draggable:false,
                  toggle:$$("#toggle_start"),
                  format:"%d.%m.%Y",
                  positionOffset:{x:-197,y:-182},
                  pickerClass:"datepicker_dashboard",
                  useFadeInOut:!Browser.ie,
                  startDay:1,
                  titleFormat:"%d. %B %Y"
                });
              });
              </script>
              <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['labelFrom'][1].'</p>
            </div>
            <div class="w50 wizard">
              <h3><label for="ctrl_stop">'.$GLOBALS['TL_LANG']['MSC']['labelTo'][0].'</label></h3>
              <input type="text" name="stop" id="ctrl_stop" class="tl_text" value="" onfocus="Backend.getScrollOffset()"> <img src="plugins/datepicker/icon.gif" width="20" height="20" alt="" id="toggle_stop" style="vertical-align:-6px">
              <script>
              window.addEvent("domready", function() {
                new Picker.Date($$("#ctrl_stop"), {
                  draggable:false,
                  toggle:$$("#toggle_stop"),
                  format:"%d.%m.%Y",
                  positionOffset:{x:-197,y:-182},
                  pickerClass:"datepicker_dashboard",
                  useFadeInOut:!Browser.ie,
                  startDay:1,
                  titleFormat:"%d. %B %Y"
                });
              });
              </script>
              <p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['MSC']['labelTo'][1].'</p>
            </div>
          </div>
        </div>
        <div style="clear:both"></div>
        <div class="tl_formbody_submit" style="text-align:right">
          <div class="tl_submit_container">
            <input type="submit" name="show_member" id="ctrl_show_member" value="'.$GLOBALS['TL_LANG']['MSC']['labelSubmit'].'">
          </div>
        </div>
        </form>
        </div>';
      
    }
    
    public function filter_member()
    {
      $arrIDs = array();
      
      if ($this->Input->post('start') || $this->Input->get('start'))
      {
        $start = strtotime( $this->Input->post('start') ? $this->Input->post('start') : $this->Input->get('start') );
      }
      else
      {
        $start = 0;  
      } 
      if ($this->Input->post('stop') || $this->Input->get('stop'))
      {
        $stop = strtotime( $this->Input->post('stop') ? $this->Input->post('stop') : $this->Input->get('stop') );
      }
      else
      {
        $stop = time();  
      }  
      $strMessage = "<form action=\"contao/main.php?do=member&amp;act=select\" id=\"tl_select\" class=\"tl_form\" method=\"post\">
                      <div class=\"tl_formbody\">
                        <input type=\"hidden\" name=\"FORM_SUBMIT\" value=\"tl_select\">
                        <input type=\"hidden\" name=\"REQUEST_TOKEN\" value=\"" . REQUEST_TOKEN . "\">";

      $strMessage .=  '<div id="tl_buttons">';
      $strMessage .=  '  <a href="'.ampersand(str_replace('&key=filter_member', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>';
      $strMessage .=  '</div>'; 
      
      $strMessage .=  '<h2 class="sub_headline">'. 
                          sprintf
                          ( 
                            $GLOBALS['TL_LANG']['MSC']['listOfMember'],
                            $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $start), 
                            $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $stop) 
                          ) . '</h2>';
        
      $strMessage .=  '<div class="tl_listing_container list_view">
                        <div class="tl_select_trigger">
                          <label for="tl_select_trigger" class="tl_select_label">Alle auswählen</label> 
                          <input type="checkbox" id="tl_select_trigger" onclick="Backend.toggleCheckboxes(this)" class="tl_tree_checkbox">
                        </div>
                        <table class="tl_listing showColumns">
                          <tbody>
                            <tr>
                              <th class="tl_folder_tlist col_icon"></th>
                              <th class="tl_folder_tlist col_firstname">Vorname</th>
                              <th class="tl_folder_tlist col_lastname">Nachname</th>
                              <th class="tl_folder_tlist col_username">Benutzername</th>
                              <th class="tl_folder_tlist col_date">Letzte Bestellung am</th>
                              <th class="tl_folder_tlist tl_right_nowrap">&nbsp;</th>
                            </tr>';
        
    
			$arrOrders = $this->Database->execute("SELECT pid, date FROM tl_iso_orders WHERE date>=$start AND date<=$stop ORDER BY date")->fetchAllAssoc();
      
      // No PIDs -> No Member order in this time
      if( count($arrOrders) == 0 )
      {
        return '<div id="tl_buttons">
                  <a href="' . $this->Environment->request . '_by_last_order" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
                </div>
                <div class="tl_gerror">' . 
                  sprintf( 
                    $GLOBALS['TL_LANG']['MSC']['noOrderInSpan'],
                    $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $start), 
                    $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $stop) ) . 
                '</div>';
      }
      
      foreach ($arrOrders as $arrOrder){
        $arrIDs[] = $arrOrder['pid'];
        $arrOrders[$arrOrder['pid']] = $arrOrder;
      }       
      
      $arrMembers = $this->Database->execute("SELECT id, lastname, firstname, username FROM tl_member WHERE id IN (" . implode(",", $arrIDs) . ")")->fetchAllAssoc();
      
      
      foreach ($arrMembers as $arrMember){
        $i++;
        $strMessage .= "
                            <tr class=\"". ( $i % 2 ? 'even' : 'odd' ) ."\" onmouseover=\"Theme.hoverRow(this,1)\" onmouseout=\"Theme.hoverRow(this,0)\">
                              <td colspan=\"1\" class=\"tl_file_list col_icon\" style=\"\"><div class=\"list_icon_new\" style=\"background-image:url('system/themes/default/images/member.gif')\">&nbsp;</div></td>
                              <td colspan=\"1\" class=\"tl_file_list col_firstname\" style=\"\">".$arrMember['firstname']."</td>
                              <td colspan=\"1\" class=\"tl_file_list col_lastname\" style=\"\">".$arrMember['lastname']."</td>
                              <td colspan=\"1\" class=\"tl_file_list col_username\" style=\"\">".$arrMember['username']."</td>
                              <td colspan=\"1\" class=\"tl_file_list col_dateOrder\" style=\"\">".date($GLOBALS['TL_CONFIG']['dateFormat'], $arrOrders[$arrMember['id']]['date'])."</td>
                              <td class=\"tl_file_list tl_right_nowrap\" style=\"\"><input type=\"checkbox\" name=\"IDS[]\" id=\"ids_".$arrMember['id']."\" class=\"tl_tree_checkbox\" value=\"".$arrMember['id']."\"></td>
                            </tr>"; 
      }  
      
      $strMessage .= "    
                          </tbody>
                        </table>
                      </div>";
      
      $strMessage .= "
                      <div class=\"tl_formbody_submit\" style=\"text-align:right\">
                        <div class=\"tl_submit_container\" style=\"left: 695px;\">
                          <input type=\"submit\" name=\"delete\" id=\"delete\" class=\"tl_submit\" accesskey=\"d\" onclick=\"return confirm('".$GLOBALS['TL_LANG']['MSC']['delAllConfirm']."')\" value=\"".$GLOBALS['TL_LANG']['MSC']['deleteSelected']."\">
                          <input type=\"submit\" name=\"edit\" id=\"edit\" class=\"tl_submit\" accesskey=\"s\" value=\"".$GLOBALS['TL_LANG']['MSC']['editSelected']."\"> 
                        </div>
                      </div>";
      return $strMessage . "</div></form>";
    }
}  
