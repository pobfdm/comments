<?php
session_start();
session_destroy();
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
<body><div class="container mt-5" style="max-width: 500px">
	<div class="alert alert-secondary mt-5 text-center" role="alert" style="max-width: 500px;"><h1>Logout successful</h1>	
		<a class="btn btn-primary" href="index.php?filter=<?php echo $_GET['filter'].'&url='.$_GET['url'] ?>" >log in again</a>
	</div>	
</div></body>
</html>	
