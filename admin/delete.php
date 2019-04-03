<?php
	include_once('../lib/utils.php');
	include('../lib/sauth.php');
	
	$id=$_GET['id'];
	
	try{
		deleteCommentAdmin($id);
		$res= '<div class="alert alert-success text-center" role="alert">Deleted.
			<a href="'.$WEBROOT.'admin/index.php?filter='.$_GET['filter'] .'&url='.$_GET['url'].'" class="btn btn-success">Ok</a>
		</div>';
		
	} catch (Exception $e) {
			$res= '<div class="alert alert-danger text-center" role="alert">'.$e->getMessage().'
				<a href="'.$WEBROOT.'admin/index.php?filter='.$_GET['filter'] .'&url='.$_GET['url'].'" class="btn btn-secondary">Ok</a>
			</div>';
	}
	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
	<title><?php echo $TITLE_PAGE?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="../js/jquery.min.js"></script>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/local.css">
	<link rel="shortcut icon" type="image/png" href="../imgs/favicon.png"/>
	<script src="../js/bootstrap.bundle.min.js"></script>
	
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="">
  <a class="navbar-brand" href="<?php echo $WEBROOT ?>admin/index.php?filter=<?php echo $_GET['filter']?>&url=<?php echo $_GET['url']?>"><?php echo $TITLE?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="<?php echo $WEBROOT ?>admin/logout.php?filter=<?php echo $_GET['filter']?>&url=<?php echo $_GET['url']?>">Logout</a>
    </div>
  </div>
</nav>	
<div class="container">
	<div style="margin-top: 200px"><?php echo $res ?></div>
</div>


</body>
</html>
