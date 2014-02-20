<?php
//Manual Trackers by Penian4
//tracker.php
/* This will get info from the txt file and show the image */
header('Content-type: image/png');

$txt = file_get_contents('tracker.txt'); //get the contents of the txt file
list($status,$server,$room) = explode('|',$txt); //get the status server and room as variables

if ($status=='tracking') list($status,$server,$room) = array('Online','Tracking...','Tracking...');
if ($status=='offline') list($status,$server,$room) = array('Offline','N/A','N/A');
if ($status=='found') $status='Online';

putenv('GDFONTPATH=' . realpath('.'));
$im = imagecreatefrompng('tracker.png'); //create the image
$white = imagecolorallocate($im, 255, 255, 255);
$font = 'includes/font.ttf';

imagettftext($im, 16, 0, 230, 110, $white, $font, $status);
imagettftext($im, 16, 0, 230, 140, $white, $font, $server);
imagettftext($im, 16, 0, 230, 170, $white, $font, $room);

imagepng($im); //output as a png image
imagedestroy($im); //destroys the image
?>