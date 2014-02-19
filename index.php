<?php
//Manual Tracker by Penian4
//index.php
/*this displays the form and updates the tracker image, and auto tweets*/
require_once 'twitteroauth.php';
//CHANGE THE VARIABLES BELOW
$password = 'Choose a Password';
$mascotname = 'Mascot Name';
$foundmessage = $mascotname.' has been found at the '.$_POST['room'];
$movedmessage = $mascotname.' has moved to the '.$_POST['room'];
$leftmessage = $mascotname.' has left the server.';
$trackingmessage = $mascotname.' tracking has begun!';

//CREATE A TWITTER APPLICATION (dev.twitter.com) AND FILL IN THE KEYS BELOW
$apikey = 'API key';
$apisecret = 'API key secret';
$accesstoken = 'Access Token';
$accesstokensecret = 'Access Token Secret';

function tweetThis($message,$apikey,$apisecret,$accesstoken,$accesstokensecret){
	$connection = new TwitterOAuth($apikey,$apisecret,$accesstoken,$accesstokensecret);
	$connection->post('statuses/update',array('status'=>utf8_encode($message).' ['.rand(0,99).']'));
}
$txt = file_get_contents('tracker.txt'); 
list($oldstatus,$oldserver,$oldroom) = explode('|',$txt);
if ($_POST) {
	if ($_POST['password'] == $password) {
	
		if ($oldstatus=='offline' && $_POST['status']=='found') $message=$foundmessage;
		if ($oldstatus=='tracking' && $_POST['status']=='found') $message=$foundmessage;
		if ($oldstatus=='tracking' && $_POST['status']=='offline') $message=$trackingmessage;
		if ($oldstatus=='found' && $_POST['status']=='found') $message=$movedmessage;
		if ($oldstatus=='found' && $_POST['status']=='tracking') $message=$leftmessage;
		if ($oldstatus=='found' && $_POST['status']=='offline') $message=$leftmessage;
		if ($oldstatus=='offline' && $_POST['status']=='tracking') $message=$trackingmessage;
		
		$contents = $_POST['status'].'|'.$_POST['server'].'|'.$_POST['room'];
		file_put_contents('tracker.txt',$contents);
		tweetThis($message,$apikey,$apisecret,$accesstoken,$accesstokensecret);
		$text = '<font color="darkgreen">Tracker Updated!</font>';
	} else $text = '<font color="darkred">Incorrect Password</font>';
}
?>
<div class="box">
<div class="form">
<form action="index.php" method="post">
<div class="radiogroup">
<input type="radio" name="status" value="found" <?php echo $oldstatus=='found'?'checked':''; ?>> Found
<input type="radio" name="status" value="tracking" <?php echo $oldstatus=='tracking'?'checked':''; ?>> Tracking
<input type="radio" name="status" value="offline" <?php echo $oldstatus=='offline'?'checked':''; ?>> Offline<br>
</div>
<input type="text" name="server" value="<?php echo $oldstatus=='found'?$oldserver:''; ?>" placeholder="Server"/><br>
<input type="text" name="room" value="<?php echo $oldstatus=='found'?$oldroom:''; ?>" placeholder="Room"/><br>
<input type="password" placeholder="Password" name="password"/>
<input type="submit" value="Update"/>
</form>
</div>
<p style="margin-left: 50px; font-weight: bold; position: absolute;"><?php echo $text; ?></p>
<img class="trackerimg" src="tracker.php"/>
</div>

<style>
body,
html {
margin:0;
font-family:arial;
background-image:url(http://cpcheats.co/images/bgs.png);
}
.form {
background-color: lightblue;
border-radius: 15px;
border: 3px solid #014D8D;
padding: 10px;
font-family: calibri;
width: 250px;
padding-bottom: 0px;
}
input[type=text] {
border-radius: 7px;
border: 1px solid black;
padding: 5px;
-webkit-box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
}
input[type=password] {
margin-top: 10px;
border-radius: 7px;
border: 2px solid black;
padding: 5px;
-webkit-box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
width: 100px;
margin-left: 1px;
}
.radiogroup {
border-radius: 8px;
border: 1px solid black;
padding: 5px;
-webkit-box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
box-shadow:inset 0 0 5px 2px rgba(0,0,0,0.2);
background-color: white;
margin-left: 2px;
margin-bottom: 2px;
}
.trackerimg {
margin-left: 300px;
margin-top: -200px;
}
.box {
position: absolute;
left: 50%;
top: 50%;
width: 800px;
margin-left: -400px;
height: 200px;
margin-top: -100px;
background-color: #E5E5E5;
border-radius: 20px;
padding: 50px;
}
input[type=submit] {
border-radius: 8px;
color: white;
cursor: hand;
border: 2px solid #d37000;
padding: 7px;
background: #ffa84c; /* Old browsers */
background: -moz-linear-gradient(top,  #ffa84c 0%, #ff7b0d 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffa84c), color-stop(100%,#ff7b0d)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffa84c 0%,#ff7b0d 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffa84c 0%,#ff7b0d 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffa84c 0%,#ff7b0d 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffa84c 0%,#ff7b0d 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffa84c', endColorstr='#ff7b0d',GradientType=0 ); /* IE6-9 */
}
input[type=submit]:hover {
background: #ffa84c; /* Old browsers */
background: -moz-linear-gradient(top,  #ffa84c 61%, #ff7b0d 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(61%,#ffa84c), color-stop(100%,#ff7b0d)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffa84c 61%,#ff7b0d 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffa84c 61%,#ff7b0d 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffa84c 61%,#ff7b0d 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffa84c 61%,#ff7b0d 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffa84c', endColorstr='#ff7b0d',GradientType=0 ); /* IE6-9 */
}
</style>