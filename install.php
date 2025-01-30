<?php
/**
 *
 * @category        modules
 * @package         folder_album
 * @author          Maarten
 * @copyright       2023, Maarten
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @link            https://websitebaker.org/
 * @license         https://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.13.x
 * @requirements    PHP 8.0.0 and higher
 *
*/

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
  if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */


// create tables from sql dump file
        if (is_readable(__DIR__.'/install-struct.sql.php')) {
            $database->SqlImport(__DIR__.'/install-struct.sql.php', TABLE_PREFIX, __FILE__ );
        }

