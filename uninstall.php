<?php
/**
 *
 * @category        modules
 * @package         pixofcake
 * @author          Maarten
 * @copyright       2023, Maarten
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.13.x
 * @requirements    PHP 8.0.0 and higher
 *
*/

// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));

$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_pixofcake`");