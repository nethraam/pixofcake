<?php
/*
 * @category        photoalbum modules
 * @package         pixofcake
 * @author          Maarten
 * @copyright       2025, Maarten
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.13.x
 * @requirements    PHP 8.0.0 and higher
*/

// Prevent this file from being accessed directly
if (!defined('WB_PATH')) {
    exit("Cannot access this file directly");
}

//Include config.php
require_once('../../config.php');

// Adds $field to $table if it doesn't already exist
function db_add_field($field, $table, $desc) {
	global $database;
	$table = TABLE_PREFIX . $table;
    
    // Does the field already exist?
	$query = $database->query("DESCRIBE $table '$field'");
	if(!$query || $query->numRows() == 0) {
        // No: Add field
        $cSQL = "ALTER TABLE $table ADD $field $desc";
        // echo "$cSQL<br />\n";
        
		$query = $database->query($cSQL);
		// echo (mysql_error()?mysql_error().'<br />':'');
        
		$query = $database->query("DESCRIBE $table '$field'");
		// echo (mysql_error()?mysql_error().'<br />':'');
    } else {
        // Yes: Just print a message
        // echo "Field '$field' already present in table '$table'<br />\n";
    }
}	
	
db_add_field("crop_images", "mod_pixofcake", "VARCHAR(10) DEFAULT '' ");
db_add_field("show_filenames", "mod_pixofcake", "VARCHAR(10) DEFAULT '' ");
	
?>