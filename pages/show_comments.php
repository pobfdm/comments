<?php
include_once('../lib/utils.php');
global $DSN;
try {
	
	$url= $_GET['url'];
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	$mydb->connect();
	if ( !$mydb->execute("select * from comments where url = '$url' and show=1")) echo "problemi nella query<br>";
	$nrows=$mydb->nrows();
	for ($i=1; $i<= $mydb->nrows(); $i++)
	{
		echo '<div class="card">
			  <div class="card-body">
				<h5 class="card-title">'.$mydb->read($i, "user").'</h5>
				<small>'.$mydb->read($i, "year").'/'.$mydb->read($i, "month").'/'.$mydb->read($i, "day").' - '.$mydb->read($i, "hour").':'.$mydb->read($i, "minute").'</small>
				<p class="card-text">'.$mydb->read($i, "text").'</p>
			  </div>
			</div>';
	}
	
	$mydb->disconnect();
} catch (Exception $e) {
	echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>' ;
}

?>
