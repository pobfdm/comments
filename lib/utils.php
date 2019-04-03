<?php
include('../conf.php');
include_once('../lib/spdo.php');

function getQuestionCode()
{
	global $DSN;
	try {
		
		$mydb = new sPDO();
		$mydb->DSN=$DSN;
		
		$mydb->connect();
		if ( !$mydb->execute("select * from CAPTCHA ")) echo "problemi nella query<br>";
		(int)$nrows=$mydb->nrows();
		$rand= rand(1,$nrows);
		$res=$mydb->read($rand,'question_code');
		
		$mydb->disconnect();
		return $res;
	} catch (Exception $e) {
		return $e->getMessage();
	}
}

function getQuestionTextFromCode($code)
{
	global $DSN;
	try {
		
		$mydb = new sPDO();
		$mydb->DSN=$DSN;
		
		$mydb->connect();
		if ( !$mydb->execute("select * from CAPTCHA where question_code='".$code."'")) echo "problemi nella query<br>";
		$res=$mydb->read(1,'question_text');
		$mydb->disconnect();
		return $res;
	} catch (Exception $e) {
		return $e->getMessage();
	}
}

function verifyCAPTCHA($code,$answer)
{
	global $DSN;
	try {
		
		$mydb = new sPDO();
		$mydb->DSN=$DSN;
		
		$mydb->connect();
		if ( !$mydb->execute("select * from CAPTCHA where question_code='".$code."' and answer='".$answer."'")) echo "problemi nella query<br>";
		if ($mydb->nrows()>0)
		{
			return TRUE;
		}else{
			return FALSE;
		}
		$mydb->disconnect();
		return $res;
	} catch (Exception $e) {
		return $e->getMessage();
	}
}

function validateEmail($email) {
      return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}
function validateUrl($url) {
	global $REFER;
	if (!contains($REFER,$url)) return false;
    return filter_var($url, FILTER_VALIDATE_URL);
}
function registerComment($user,$email,$text,$url) 
{
	global $DSN;
		
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	//Strip '
	$user=$mydb->addslashes($user);
	$email=$mydb->addslashes($email);
	$text=$mydb->addslashes($text);
	$url=$mydb->addslashes($url);
	
	//Strip tags
	$user= strip_tags($user);
	$email=strip_tags($email);
	$text=strip_tags($text, '<p><a>');
	$url=strip_tags($url);
	
	
	
	$year=date('Y');
	$month=date('m');
	$day=date('d');
	
	$hour=date('H');
	$minute=date('i');
	$second=date('s');
	
	$cod=random_str(40);
	
	$mydb->connect();
	$sql="INSERT INTO  `comments` ( `show` ,`cod` , `user`,`email`,`text`,`url` ,`year`,`month`, `day`, `hour`, `minute`, `second` ) VALUES ( 0,'$cod','$user' , '$email' , '$text', '$url', $year, $month, $day, $hour, $minute, $second);" ;
	if ( !$mydb->execute($sql)) echo "problemi nella query<br>";
	$mydb->disconnect();
		

}

function editCommentAdmin($id,$show,$user,$email,$text,$url,$cod,$year,$month,$day,$hour,$minute,$second) 
{
	global $DSN;
		
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	//Strip '
	$user=$mydb->addslashes($user);
	$email=$mydb->addslashes($email);
	$text=$mydb->addslashes($text);
	$url=$mydb->addslashes($url);
	
	//Strip tags
	$user= strip_tags($user);
	$email=strip_tags($email);
	$text=strip_tags($text, '<p><a>');
	$url=strip_tags($url);
	
	$mydb->connect();
	$sql="UPDATE comments
			SET user = '$user', 
			show= '$show',
			email= '$email',
			url= '$url',
			text= '$text',
			cod= '$cod',
			year= '$year',
			month= '$month',
			day= '$day',
			hour= '$hour',
			minute= '$minute',
			second= '$second'
			 WHERE id = $id" ;
	if ( !$mydb->execute($sql)) echo "problemi nella query<br>";
	$mydb->disconnect();
		

}

function deleteCommentAdmin($id) 
{
	global $DSN;
		
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	$mydb->connect();
	$sql="delete from comments where id=$id " ;
	if ( !$mydb->execute($sql)) echo "problemi nella query<br>";
	$mydb->disconnect();
		

}


function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}


function notifyToAll($url) 
{
	global $DSN;
	global $adminEmail;
	global $WEBROOT;
	global $siteEmail;
		
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	$sql="select * from comments where url='$url' and show=1";
	$mydb->connect();
	$mydb->execute($sql);
	$message='<p>Read the news:</p><p><a href="'.$url.'">'.$url.'</a></p>';
	$Cc='';
	for ($i=1; $i<= $mydb->nrows(); $i++)
	{
		$email=$mydb->read($i,'email');
		if ($i==$mydb->nrows())
		{
			$Cc.="$email";
		}else{
			$Cc.="$email, ";
		}
	
	}
	
	$mydb->disconnect();
	mailSender( $adminEmail,$Cc, $siteEmail, 'Comments', $siteEmail, "Your comment has been updated", $message, $url);
}


function mailSender( $mailto,$Cc, $from_mail, $from_name, $replyto, $subject, $message,$url) {
    
    //$headers .= 'Cc: somebody@domain.com' . "\r\n";
    global $adminEmail;
	global $WEBROOT;
	global $siteEmail;
	
	$mail_boundary = "=_NextPart_" . md5(uniqid(time()));
	 
	$to = $adminEmail;
	$subject = "New update for your comment";
	$sender = $siteEmail;
	 
	$headers = "From: $sender\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
	$headers .= "X-Mailer: PHP " . phpversion()."\r\n";
	
	$headers .= 'Bcc: '.$Cc . "\r\n";
	 
	$text_msg = "New update for your comment at $url";
	$html_msg = "<b>New update for your comment</b> at url: <p><a href='$url'>$url</a><br></p>";
	 
	$msg = "This is a multi-part message in MIME format.\n\n";
	$msg .= "--$mail_boundary\n";
	$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
	$msg .= "Content-Transfer-Encoding: 8bit\n\n";
	$msg .= "New update for your comment at url: $url \n\n ";  
	 
	$msg .= "\n--$mail_boundary\n";
	$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$msg .= "Content-Transfer-Encoding: 8bit\n\n";
	$msg .= "<b>New update for your comment</b> at url: <p><a href='$url'>$url</a><br></p>";

	 
	// Boundary  multipart/alternative
	$msg .= "\n--$mail_boundary--\n";
	 
	//Return-Path 
	ini_set("sendmail_from", $sender);
	 
	// "-f$sender" set Return-Path on Linux hosting 
	if (mail('You', $subject, $msg, $headers, "-f$sender")) { 
	} else { 
		
	}
}




function notifyNewCommentToAdmin($url)
{
	global $adminEmail;
	global $WEBROOT;
	global $siteEmail;
	
	$moderationPage=$WEBROOT."admin/index.php?filter=notposted&url=$url";
	
	$mail_boundary = "=_NextPart_" . md5(uniqid(time()));
	 
	$to = $adminEmail;
	$subject = "New comment from your site";
	$sender = $siteEmail;
	 
	$headers = "From: $sender\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
	$headers .= "X-Mailer: PHP " . phpversion();
	 
	$text_msg = "New comment at $url";
	$html_msg = "<b>New comment</b> at url: <p><a href='$url'>$url</a><br></p>";
	 
	$msg = "This is a multi-part message in MIME format.\n\n";
	$msg .= "--$mail_boundary\n";
	$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
	$msg .= "Content-Transfer-Encoding: 8bit\n\n";
	$msg .= "New comment at $url \n\n Moderate: $moderationPage";  
	 
	$msg .= "\n--$mail_boundary\n";
	$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$msg .= "Content-Transfer-Encoding: 8bit\n\n";
	$msg .= "<b>New comment</b> at url: <p><a href='$url'>$url</a><br></p><p><a href='$moderationPage'>Approve/deny</a></p>";

	 
	// Boundary  multipart/alternative
	$msg .= "\n--$mail_boundary--\n";
	 
	//Return-Path 
	ini_set("sendmail_from", $sender);
	 
	// "-f$sender" set Return-Path on Linux hosting 
	if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
	} else { 
		
	}
	


	
	

}

?>
