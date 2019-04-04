<?php
include_once('../lib/utils.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
	($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'  && 
	(strpos($REFER,$_SERVER['SERVER_NAME']) !== false) &&
	validateUrl($_POST['url'])) ) 	{
    
    if (filesize ($fileDB)>$maxDBFileSize)
    {
		echo '<div class="alert alert-danger text-center" role="alert">Maximum database size reached</div>';
		$message = "Maximum database size reached at $fileDB in $WEBROOT";
		mail($adminEmail, 'Maximum database size reached', $message);
		die();
	}
    
    if(verifyCAPTCHA($_POST['question_code'],$_POST['answer']))
    {
		
		if (! validateEmail($_POST['email']))
		{
			echo '<div class="alert alert-danger text-center" role="alert">'.$wrongEmail.'</div>';
			echo '<script>$("#email").addClass("inputError")</script>';
			die();
		}
		
		if (empty($_POST['user']))
		{
			echo '<div class="alert alert-danger text-center" role="alert">'.$wrongUsername.'</div>';
			echo '<script>$("#user").addClass("inputError")</script>';
			die();
		}
		
		if (empty($_POST['text']))
		{
			echo '<div class="alert alert-danger text-center" role="alert">'.$wrongText.'</div>';
			echo '<script>$("#text").addClass("inputError")</script>';
			die();
		}
		
		
		try{
			registerComment($_POST['user'],$_POST['email'],$_POST['text'],$_POST['url']);
			notifyNewCommentToAdmin($_POST['url']);
			echo '<div class="alert alert-success text-center" role="alert">'.$commentSent.'</div>';
			echo '<script>
			$("#stargateJS").load("'.$WEBROOT.'/pages/captcha-reload.php")
			$("#usersComments").html(spinner).load("'.$WEBROOT.'/pages/show_comments.php?url="+window.location.href);
			</script>';
		} catch (Exception $e) {
			echo '<div class="alert alert-danger text-center" role="alert">'.$e->getMessage().'</div>';
		}	
		
		
	}else{
		echo '<div class="alert alert-danger text-center" role="alert">'.$wrongResult.'</div>';
		echo '<script>$("#answer").addClass("inputError")</script>';
		die();
	}

}else{
	echo '<div class="alert alert-danger text-center" role="alert">Are you trying to be smart?</div>';
	die();
}// end check ajax request
?>
