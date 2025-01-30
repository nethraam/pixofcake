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

if (!\defined('SYSTEM_RUN')) {require( (\dirname(\dirname((__DIR__)))).'/config.php');}
$aErrorMessage = [];
// suppress to print the header, so no new FTAN will be set
$admin_header = false;
// Tells script to update when this page was last updated
$update_when_modified = true;
// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

$bBackAfterSave = \intval(isset($aRequestVars['pagetree']));
$OverviewUrl = ADMIN_URL.'/pages/modify.php?page_id='.$page_id;
if (!$admin->checkFTAN())
{
    $admin->print_header();
    $sInfo = \strtoupper(\basename(__DIR__).'_'.\basename(__FILE__, ''.PAGE_EXTENSION).'::');
    $sDEBUG=(\defined('DEBUG') && DEBUG ? $sInfo : '');
    $admin->print_error($sDEBUG.$MESSAGE['GENERIC_SECURITY_ACCESS'], $OverviewUrl);
}
$admin->print_header();
// Update the mod_wysiwygs table with the contents

if (isset($_POST['url'])) {
//    $content = (\str_replace($notAllowedTags, '', $_POST['content']));
    $url = $oRequest->getParam('url');
    $sqlSet = '`'.TABLE_PREFIX.'mod_folder_album` SET '
            . '`section_id`='.$section_id.', '
            . '`page_id`='.$page_id.', '
            . '`url` = \''.$database->escapeString($url).'\' ';
    // search for instance of this module in section
    $sql = 'SELECT COUNT(*) FROM `'.TABLE_PREFIX.'mod_folder_album` '
         . 'WHERE `section_id`='.$section_id;
    if ($database->get_one($sql)) {
    // if matching record already exists run UPDATE
        $sql  = 'UPDATE '.$sqlSet
              .'WHERE `section_id`='.$section_id;
    } else {
    // if no matching record exists INSERT new record
        $sql = 'INSERT INTO '.$sqlSet;
    }
    if (!$database->query($sql)){
        $aErrorMessage[] = ($database->is_error() ? $database->get_error():'');
    }
}
// Check if there is a database error, otherwise say successful
if (\sizeof($aErrorMessage)) {
    $admin->print_error(\implode('<br />', $aErrorMessage), $OverviewUrl);
} else {
    $sIndexUrl = ADMIN_URL.'/pages/index.php';
    $OverviewUrl = (@$bBackAfterSave ? $sIndexUrl : $OverviewUrl);
    $admin->print_success($MESSAGE['PAGES_SAVED'], $OverviewUrl);
}

// Print admin footer
$admin->print_footer();
