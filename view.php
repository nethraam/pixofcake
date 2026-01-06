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

declare(strict_types = 1);
//declare(encoding = 'UTF-8');

namespace dispatch;

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!\defined('SYSTEM_RUN')) {\header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); echo '404 Not Found'; \flush(); exit;}
/* -------------------------------------------------------- */
// Get content



?>
<link rel="stylesheet" href="<?php echo WB_URL ?>/modules/pixofcake/fancybox/jquery.fancybox.css" media="screen" />
<script src="<?php echo WB_URL ?>/modules/pixofcake/fancybox/jquery.fancybox.js"></script>
<?php

// $folder = "/media/robot";

$page_id = $_SESSION['PAGE_ID'];

$query = "SELECT `url` FROM `".TABLE_PREFIX."mod_pixofcake` WHERE `page_id` = '$page_id'";
$get_content = $database->query($query);
$content = $get_content->fetchAssoc();
$folder = "/".($content['url'] ?? '');  // \htmlspecialchars

// Get url
    // $sql = 'SELECT `url` FROM `'.TABLE_PREFIX.'mod_pixofcake` WHERE `section_id`='.(int)$section_id;
    // if (($url = $database->get_one($sql)) ) {
        // $url = OutputFilterApi('ReplaceSysvar', $url);
        // $url = \htmlspecialchars($url);
    // } else {
        // $url = '';
    // }

	$query = "SELECT * FROM `".TABLE_PREFIX."mod_pixofcake` WHERE `page_id` = '$page_id'";
	$get_settings = $database->query($query);
	$settings = $get_settings->fetchAssoc();
	$crop_images = ($settings['crop_images'] ?? ''); 
	$show_filenames = ($settings['show_filenames'] ?? ''); 	


$current_url = explode("?", $_SERVER['REQUEST_URI']);

$previous_url = $current_url[0];

if(array_key_exists(1,$current_url)){
	if(str_contains($current_url[1], '/'))
		$previous_url = dirname($_SERVER['REQUEST_URI']);
}


echo "<div class='total_container'>\n";
	if(isset($_GET['subfolder'])){
		$folder = "$folder/".$_GET['subfolder'];
				echo "<div class='back_icon'> <a href='$previous_url'> <img src='".WB_URL."/modules/pixofcake/img/back.png' alt='' /> </a> </div>\n";
		}

	find_subfolders($folder);
	find_photos($folder, $show_filenames, $crop_images);

echo "</div>";


function find_photos($folder, $show_filenames, $crop_images){
	
	$files = scandir(WB_PATH.$folder);

	foreach ($files as $photo){
		 if (substr($photo, -4)=='.jpg'|| substr($photo, -5)=='.jpeg' || substr($photo, -4)=='.JPG' || substr($photo, -5)=='.JPEG'){
			
			$image_url = WB_PATH."$folder/$photo";
			
			list($width, $height) = getimagesize(str_replace(" ", "%20", WB_URL."$folder/$photo"));
			
			$scale_width_height = 1500;
			if (($width > $scale_width_height) || ($height > $scale_width_height))	
				scale_image($image_url, $scale_width_height);
			
			// echo WB_URL."$folder/$photo"."<br><br>";
			// echo $width.'-'.$height;
			
				if ($width >= $height)
					$orientation = 'horizontal';
				if ($width <= $height)
					$orientation = 'vertical';
				if ($width <= $height)
					$orientation = 'square';
				
				
				

					if($crop_images == 'checked'){
						echo "<div class='thumb_container'>\n";
						if (file_exists ( WB_PATH."$folder/thumbs/$photo" ))
							echo "<div class='thumb $orientation'> <a data-fancybox='gallery'  href='".WB_URL."$folder/$photo'> <img src='".WB_URL."$folder/thumbs/$photo' alt='$photo' /> </a> </div>\n";
						else{	
							echo "<div class='thumb $orientation'> <a data-fancybox='gallery'  href='".WB_URL."$folder/$photo'><img src='".WB_URL."$folder/$photo' alt='$photo' /> </a> </div>\n";				
							create_thumb($image_url);
						}
					}	
					else{
						echo "<div class='thumb_container_nocrop'>\n";
						if (file_exists ( WB_PATH."$folder/thumbs/$photo" ))
							echo "<div class='thumb_nocrop'> <a data-fancybox='gallery'  href='".WB_URL."$folder/$photo'> <img src='".WB_URL."$folder/thumbs/$photo' alt='$photo' /> </a> </div>\n";
						else{	
							echo "<div class='thumb_nocrop'> <a data-fancybox='gallery'  href='".WB_URL."$folder/$photo'><img src='".WB_URL."$folder/$photo' alt='$photo' /> </a> </div>\n";				
							create_thumb($image_url);
						}
					}
				
				if($show_filenames == 'checked'){	
					echo "<div class='thumb_text_container'>";
						echo reset(explode('.', $photo));
					echo "</div>";	
				}
					
				echo "</div>";				
			}
			
		 }	
}

function find_subfolders($folder){
	
	$subfolders = glob(WB_PATH."$folder/*" , GLOB_ONLYDIR);

	
	foreach ($subfolders as $subfolder) {
		
		
		$subfolder_name = end(explode('/', $subfolder));
		
		if($subfolder_name != 'thumbs'){
			if(isset($_GET['subfolder']))
				$subfolder_url =$_GET['subfolder']."/".end(explode('/', $subfolder));
			else
				$subfolder_url = end(explode('/', $subfolder));
		
			$firstFile = scandir($subfolder)[2];
			$secondfile = scandir($subfolder)[3];
			$thirdfile = scandir($subfolder)[4];
			
			echo "<div class='folder_container'>\n";
			
			// if($firstFile != '' && $secondfile != '' && $thirdfile != ''){

				if (file_is_image($firstFile)){					
					list($width, $height) = getimagesize(str_replace(" ", "%20", WB_URL."$folder/$subfolder_name/$firstFile"));
						if ($width >= $height)
							$orientation1 = 'horizontal';
						else
							$orientation1 = 'vertical';
					
					echo WB_URL."$folder/$subfolder_name/thumbs/$firstFile";					
					if (file_exists ( "$subfolder_name/thumbs/$firstFile" ))
						echo "<div class='thumb_folder $orientation'> <a href='$current_url'subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/thumbs/$firstFile' alt='' /> </a> </div>\n";
					else	
						echo "<div class='thumb_folder $orientation1'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/$firstFile' alt='' /> </a> </div>\n";
								
				}
					
				if (file_is_image($secondfile)){		
					list($width, $height) = getimagesize(str_replace(" ", "%20", WB_URL."$folder/$subfolder_name/$secondfile"));
						if ($width >= $height)
							$orientation2 = 'horizontal';
						else
							$orientation2 = 'vertical';
						
						echo WB_URL."$folder/$subfolder_name/thumbs/$secondfile";
						if (file_exists ( "$subfolder_name/thumbs/$secondfile" ))
							echo "<div class='thumb_folder thumb_folder2 $orientation2'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/thumbs/$secondfile' alt='' /> </a> </div>\n";
						else
							echo "<div class='thumb_folder thumb_folder2 $orientation2'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/$secondfile' alt='' /> </a> </div>\n";
								
				}			
				
				if (file_is_image($thirdfile)){			
					list($width, $height) = getimagesize(str_replace(" ", "%20", WB_URL."$folder/$subfolder_name/$thirdfile"));
						if ($width >= $height)
							$orientation3 = 'horizontal';
						else
							$orientation3 = 'vertical';
						
					echo WB_URL."$folder/$subfolder_name/thumbs/$thirdfile";
					if (file_exists ( "$subfolder_name/thumbs/$thirdfile" ))
						echo "<div class='thumb_folder thumb_folder3 $orientation3'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/thumbs/$thirdfile' alt='' /> </a> </div>\n";
					else
						echo "<div class='thumb_folder thumb_folder3 $orientation3'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."$folder/$subfolder_name/$thirdfile' alt='' /> </a> </div>\n";
								
				}			
							
					echo "<div class='folder_icon folder_icon_front'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."/modules/pixofcake/img/folder_front.png' alt='' /> </a> </div>\n";
					echo "<div class='folder_icon folder_icon_back'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."/modules/pixofcake/img/folder_back.png' alt='' /> </a> </div>\n";
					echo "<div class='folder_icon_text'> <a href='$current_url?subfolder=$subfolder_url'>$subfolder_name</a></div>\n";
							
					echo "</div>\n";
				
				// else{
					// echo "<div class='folder_container'>";	
								// echo "<div class='folder_icon folder_icon_front'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."/modules/pixofcake/img/folder_front.png' alt='' /> </a> </div>\n";
								// echo "<div class='folder_icon folder_icon_back'> <a href='$current_url?subfolder=$subfolder_url'> <img src='".WB_URL."/modules/pixofcake/img/folder_back.png' alt='' /> </a> </div>\n";
								// echo "<div class='folder_icon_text'> <a href='$current_url?subfolder=$subfolder_url'>$subfolder_name</a></div>\n";
					// echo "</div>\n";			
				// }
			// }
			
		}	
	}
}

function create_thumb($image){
	
	$directory = dirname($image);
	
	$directoryName = 'thumbs';

	/* Check if the directory already exists. */
	if(!is_dir($directory.'/'.$directoryName)){
		/* Directory does not exist, so lets create it. */
		mkdir($directory.'/'.$directoryName, 0755);
	}
	
	
	$im_php = imagecreatefromjpeg($image);
	$im_php = imagescale($im_php, 300);
	$new_height = imagesy($im_php);
	$new_name = basename($image); 
	imagejpeg($im_php, $directory.'/thumbs/'.$new_name);
}


function scale_image($image, $scale_width_height){
	//echo 'scale';
	
	$directory = dirname($image);
	
	list($width, $height) = getimagesize($image);
	
	$ratio = $width / $height;
	$calculated_width = intval($ratio*$scale_width_height);
	
	$im_php = imagecreatefromjpeg($image);
	
	if ($width >= $height)
		$im_php = imagescale($im_php, $scale_width_height); //horizontaal
	else
		$im_php = imagescale($im_php, $calculated_width); //verticaal
	$new_height = imagesy($im_php);
	
	$new_name = basename($image); 
	imagejpeg($im_php, $directory.'/'.$new_name);
}

function file_is_image($file_to_check){
	
	if(is_string($file_to_check)){
		if(substr($file_to_check, -4)=='.jpg'|| substr($file_to_check, -5)=='.jpeg' || substr($file_to_check, -4)=='.JPG' || substr($file_to_check, -4)=='.JEPG' || substr($file_to_check, -4)=='.png'|| substr($file_to_check, -4)=='.PNG')
			return true;
		else
			return false;
	}	
	else{
		return false;
	}	
}
























