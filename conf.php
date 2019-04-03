<?php
$ROOT=dirname(__FILE__); 
$fileDB=$ROOT.'/db/db.sqlite';
$DSN='sqlite:'.$fileDB ;
$WEBROOT='http://192.168.1.4:8080/'; // ex: http://www.yoursite.com/comments/
$REFER='http://192.168.1.4:8080/testpage.php'; // ex: http://www.yoursite.com/yourpage.php
$maxDBFileSize=52428800;

//Admin 
$adminEmail="pobfdm@gmail.com";
$siteEmail="noreply@freemedialab.org";

//Labels
$TITLE='Pob Comments';
$TITLE_PAGE='Pob Comments';
$UNDER_TITLE='Post your comment here.'; 

//Messages
$commentSent='<h3>Comment sent</h3><p>Your comment requires administrator approval. It will be published shortly.</p>';
$labelButtonSend='Send';
?>
