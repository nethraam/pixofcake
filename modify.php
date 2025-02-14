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

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(WB_PATH .'/modules/pixofcake/languages/' .LANGUAGE.'.php')) {
	// no module language file exists for the language set by the user, include default module language file EN.php
	require_once(WB_PATH .'/modules/pixofcake/languages/EN.php');
} else {
	// a module language file exists for the language defined by the user, load it
		require_once(WB_PATH .'/modules/pixofcake/languages/' .LANGUAGE.'.php');
}

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
	<?php echo $MOD_PIXOFCAKE['Folder of the image gallery']; ?><br>
    <!--<input class="w3-border w3-padding w3-padding w3-mobile " type="text" name="url" id="url" value="<?php echo $url; ?>" style="width:60%;" />-->
		<?php $aMediaFolderList = MediaDirectoryList(WB_PATH.MEDIA_DIRECTORY); ?>
		<select name="url" style="width: 300px; padding:4px;">
			<option value="media">media</option>
			<?php
			foreach ($aMediaFolderList as $aFolder){
				echo '<option value="'.$aFolder.'" ';
				if ($aFolder == $url){echo ' selected = "selected"';}
				echo ' > '.$aFolder.'</option>';
			}
			?>     
		</select>
	</p>
	<p>
	<?php echo $MOD_PIXOFCAKE['Crop thumbnail images']; ?><br>
	<input type="checkbox" id="crop_images" name="crop_images" value="checked" <?php echo $crop_images ?> />
    <label for="pixofcake_crop_images">crop thumbnail images</label>
	</p>
	<p>
	<?php echo $MOD_PIXOFCAKE['Show filenames']; ?> <br>
	<input type="checkbox" id="show_filenames" name="show_filenames" value="checked" <?php echo $show_filenames ?> />
    <label for="pixofcake_crop_images">show filenames</label>
	</p>
	<p>
	<?php echo $MOD_PIXOFCAKE['Large images will be automatically resized']; ?>
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
function MediaDirectoryList($directory, $show_hidden = false){
    $aMediaFolderList = [];
    if (\is_dir($directory))
    {
        $dir = array_values(array_diff(\scandir($directory),['.','..'])); //Open directory
        foreach ($dir as $key => $entry) {
            if(($entry[0] === '.') && ($show_hidden == false)) { continue; } // Skip hidden files
            $sItem = str_replace('//', '/',$directory.'/'.$entry.(\is_dir($directory.'/'.$entry) ? '' : ''));
            if (\is_dir($sItem)) { // Add dir and contents to list
                // $aMediaFolderList = \array_merge($aMediaFolderList, MediaDirectoryList($sItem));
                $aMediaFolderList[] = str_replace(WB_PATH."/",'',$sItem);
            }
        }
    }
    if (\natcasesort($aMediaFolderList)) {
        // new indexing
        $aMediaFolderList = \array_merge($aMediaFolderList);
    }
    return $aMediaFolderList; // Now return the list
}


// end of file
?>

