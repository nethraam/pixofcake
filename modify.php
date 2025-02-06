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

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */

// Get url
    $sql = 'SELECT `url` FROM `'.TABLE_PREFIX.'mod_pixofcake` WHERE `section_id`='.(int)$section_id;
    if (($url = $database->get_one($sql)) ) {
        $url = OutputFilterApi('ReplaceSysvar', $url);
        $url = \htmlspecialchars($url);
    } else {
        $url = '';
    }
	
	
	$query = "SELECT * FROM `".TABLE_PREFIX."mod_pixofcake` WHERE `page_id` = '$page_id'";
	$get_content = $database->query($query);
	$content = $get_content->fetchAssoc();
	$crop_images = ($content['crop_images'] ?? ''); 
	$show_filenames = ($content['show_filenames'] ?? ''); 


?>

<form class="pixofcake-backend-form" id="pixofcake<?php echo $section_id; ?>" action="<?php echo WB_URL; ?>/modules/pixofcake/save.php" method="post">
	<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
    <?php echo $admin->getFTAN(); ?>
	<p>
	link to the folder where the photo's are located:<br>
    <input class="w3-border w3-padding w3-padding w3-mobile " type="text" name="url" id="url" value="<?php echo $url; ?>" style="width:60%;" />
	</p>
	<p>
	Crop the thumbnail images so they all have the same format of 150px x 150px:<br>
	<input type="checkbox" id="crop_images" name="crop_images" value="checked" <?php echo $crop_images ?> />
    <label for="pixofcake_crop_images">crop thumbnail images</label>
	</p>
	<p>
	Show filenames below the thumbnal images:<br>
	<input type="checkbox" id="show_filenames" name="show_filenames" value="checked" <?php echo $show_filenames ?> />
    <label for="pixofcake_crop_images">show filenames</label>
	</p>
	<p>
	Large images will be automatically resized so that the maximum width or length (depending on the orientation of the photo) will be 1500px.
	</p>
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

