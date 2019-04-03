<?php
	include_once('../lib/utils.php');
	include('../lib/sauth.php');
	
	$id=$_POST['id'];
	$show=$_POST['show'];
	$cod=$_POST['cod'];
	$user=$_POST['user'];
	$email=$_POST['email'];
	$text=$_POST['text'];
	$url=$_POST['url'];
	$year=$_POST['year'];
	$month=$_POST['month'];
	$day=$_POST['day'];
	$hour=$_POST['hour'];
	$minute=$_POST['minute'];
	$second=$_POST['second'];
	
	if (isset($_POST['show'])){
		$show='1';
	}else{
		$show='0';
	}
	
	try{
		editCommentAdmin($id,$show,$user,$email,$text,$url,$cod,$year,$month,$day,$hour,$minute,$second) ;
		notifyToAll($url);
		echo '<div class="alert alert-success text-center" role="alert">Saved.</div>';
	
	} catch (Exception $e) {
			echo '<div class="alert alert-danger text-center" role="alert">'.$e->getMessage().'</div>';
	}
	

?>
