<?php
/* For licensing terms, see /dokeos_license.txt */

/**
* 	User Profile ajax
*	This script allow to modify user field position
*	@package dokeos.admin
*/

require_once('../../inc/global.inc.php');

if (isset($_GET['action']) && $_GET['action'] == 'change_field_position') {
 $field_id = Security::remove_XSS($_GET['field_id']);
 $new_order = Security::remove_XSS($_GET['new_order']);
 change_lp_position($field_id, $new_order);
}

/**
 * Change the user field position
 * @param integer Field id
 * @param integer New position for ordering it
 * @return string
 */
function change_lp_position ($field_id, $new_position) {
  $new_position = intval($new_position);
  $field_id = intval($field_id);
  $tbl_user_field = Database::get_course_table(TABLE_MAIN_USER_FIELD);  
  $rs = Database::query('SELECT field_order FROM ' . $tbl_user_field . ' WHERE id=' . $field_id);
  if (($old_position = Database::result($rs, 0)) !== false) {
	update_empty_values();
	$old_position = intval($old_position);	
	if ($new_position > $old_position) {
		Database::query('UPDATE ' . $tbl_user_field . ' SET field_order = field_order - 1 WHERE field_order > ' . $old_position . ' AND field_order <= ' . $new_position);
	} else {
		Database::query('UPDATE ' . $tbl_user_field . ' SET field_order = field_order + 1 WHERE field_order < ' . $old_position . ' AND field_order >= ' . $new_position);
	}
   	$rs = Database::query('UPDATE ' . $tbl_user_field . ' SET field_order = ' . $new_position . ' WHERE id=' . $field_id);
	// Ajax response
	if ($new_position !== false && ($new_position != $old_position)) {
		echo 'true';
	} else {
		echo 'false';
	}
  }
}

/*
* Update empty values 
* @return   void  
*/
function update_empty_values() {
    $tbl_user_field = Database::get_course_table(TABLE_MAIN_USER_FIELD);
    $rs = Database::query("SELECT id, field_order FROM $tbl_user_field WHERE field_order is null");
    if (Database::num_rows($rs) > 0) {
	while ($row = Database::fetch_object($rs)) {
	  Database::query("UPDATE $tbl_user_field SET field_order = {$row->id} WHERE id = {$row->id}");
	}
    }
}
