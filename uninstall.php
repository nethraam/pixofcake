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

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_pixofcake`");