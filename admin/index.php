<?php
	include_once('../lib/utils.php');
	include('../lib/sauth.php');
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
	<script>
		function getUrlVars() {
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
			});
			return vars;
		}
		
	$(document).ready(function(){
		$('tr[data-href]').on("click", function() {
			document.location = $(this).data('href');
		});
		$('tr').css( 'cursor', 'pointer' );
		
		$('#cmbPosted').on('change', function() {
			if (this.value==1)
			{
				window.location.href='<?php echo $WEBROOT?>admin/index.php?filter=posted&url='+getUrlVars()["url"];
			}else{
				window.location.href='<?php echo $WEBROOT?>admin/index.php?filter=notposted&url='+getUrlVars()["url"];
			}
		
		});
		
	}); //ready
</script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="">
  <a class="navbar-brand" href="#"><?php echo $TITLE?></a>
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
<div style="margin-top: 100px; margin-bottom:10px">
	<label for="txtUrl">Url</label>
	<input type="text" class="form-control mb-3" id="txtUrl" value="<?php echo $_GET['url']?>" readonly>
	<a class="btn btn-success btn-sm" href="<?php echo $WEBROOT.'admin?url='.$_GET['url'].'&filter='.$_GET['filter'] ?>" role="button">Show all</a>
  
  <select  id="cmbPosted">
	  <option value="0" selected>Filter</option>
	<option value="0" >Not posted</option>
    <option value="1">Posted</option>
  </select>
</div>	
<table class="table table-hover" >
  <thead>
    <tr>
      <th scope="col">Posted</th>
      <th scope="col">Date</th>
      <th scope="col">User</th>
    </tr>
  </thead>
  <tbody>
<?php
global $DSN;
$url=$_GET['url'];
if (isset($_GET['date']))
{
	$date=explode("-", $_GET['date']);
	$year=$date[0];
	$month=$date[1];
	$day=$date[2];
}
if(isset($_GET['cod'])) $cod=$_GET['cod'];

try {
	
	switch ($_GET['filter']) {
    case "notposted":
		$sql="select * from comments where show=0 and url='$url'";
        break;
    case "posted":
		$sql="select * from comments where show=1 and url='$url'";
        break;
     case "cod":
		$sql="select * from comments where cod='$cod' and url='$url'";
        break;          
    case "date":
		$sql="select * from comments where year=$year and month=$month and day=$day and url='$url'";
        break;
    default:
      $sql="select * from comments where url='$url' ORDER BY id DESC LIMIT 300";
}
	
	
	$url= $_GET['url'];
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	$mydb->connect();
	if ( !$mydb->execute($sql)) echo "problemi nella query<br>";
	$nrows=$mydb->nrows();
	for ($i=1; $i<= $mydb->nrows(); $i++)
	{
		if ($mydb->read($i,'show')==1)
		{
				$show='yes';
		}else{ $show='no';}
		echo '<tr data-href="'.$WEBROOT.'admin/edit.php?url='.$_GET['url'].'&filter='.$_GET['filter'].'&id='.$mydb->read($i, "id").'">
			  <th scope="row">'.$show.'</th>
			  <td>'.$mydb->read($i, "year").'/'.$mydb->read($i, "month").'/'.$mydb->read($i, "day").' - '.$mydb->read($i, "hour").':'.$mydb->read($i, "minute").'</td>
			  <td>'.$mydb->read($i,"user").'</td>
			</tr>';
	}
	
	$mydb->disconnect();
} catch (Exception $e) {
	echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>' ;
}
?>
</tbody>
</table>

</div>

</body>
</html>
