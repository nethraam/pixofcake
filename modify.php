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

// Get url
    $sql = 'SELECT `url` FROM `'.TABLE_PREFIX.'mod_folder_album` WHERE `section_id`='.(int)$section_id;
    if (($url = $database->get_one($sql)) ) {
        $url = OutputFilterApi('ReplaceSysvar', $url);
        $url = \htmlspecialchars($url);
    } else {
        $url = '';
    }

?>

<form id="folder_album<?php echo $section_id; ?>" action="<?php echo WB_URL; ?>/modules/folder_album/save.php" method="post">
	<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
    <?php echo $admin->getFTAN(); ?>
	<br>
	link to the folder where the photo's are located;<br>
    <input class="w3-border w3-padding w3-padding w3-mobile " type="text" name="url" id="url" value="<?php echo $url; ?>" style="width:60%;" />
	<br>
	<br>
	<table style="padding-bottom: 10px; width: 100%;">
        <tr>
            <td style="margin-left: 1em;">
                <input class="w3-btn w3-blue-wb w3-hover-green w3--medium w3-btn-min-width" name="modify" type="submit" value="<?php echo $TEXT['SAVE']; ?>"  />
                <input class="w3-btn w3-blue-wb w3-hover-green w3--medium w3-btn-min-width" name="pagetree" type="submit" value="<?php echo $TEXT['SAVE'].' &amp; '.$TEXT['BACK']; ?>"  />
            </td>
            <td style="text-align: right;margin-right: 1em;">
                <input class="w3-btn w3-blue-wb w3-hover-red w3--medium w3-btn-min-width" name="cancel" type="button" value="<?php echo $TEXT['CLOSE']; ?>" onclick="window.location = 'index.php';"  />
            </td>
        </tr>
    </table>
</form>

<?php
// end of file

