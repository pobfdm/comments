<?php
$ROOT=dirname(__FILE__); 
$fileDB=$ROOT.'/db/db.sqlite';
$DSN='sqlite:'.$fileDB ;
$WEBROOT='http://192.168.1.4:8080/'; // ex: http://www.yoursite.com/comments/
$REFER='http://192.168.1.4:8080/testpage.php'; // ex: http://www.yoursite.com/yourpage.php
$maxDBFileSize=52428800; //50mb

//Admin 
$adminEmail="pobfdm@gmail.com";
$siteEmail="noreply@freemedialab.org";

//Labels
$TITLE='Pob Comments';
$TITLE_PAGE='Pob Comments';
$UNDER_TITLE='Post your comment here.'; 

//Messages
$commentSent='<h3>Comment sent</h3><p>Your comment requires administrator approval. It will be published shortly.</p>';
$wrongResult='<h3>Wrong Result</h3><p>The result of the captcha is wrong</p>';
$wrongEmail='Wrong E-Mail address!';
$wrongUsername='Wrong Username';
$wrongText='Enter a comment, please!';
$labelButtonSend='Send';

//Place holder
$userNamePlaceHolder='Username';
$emailPlaceHolder='E-mail';
$textPlaceHolder='Your comment...';
$captchaPlaceHolder='Answer';

?>
