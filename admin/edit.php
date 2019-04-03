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
		$("#frmEdit").submit(function(){ 
				$("#btnSend").prop("disabled",true);
				$("#btnSpinner").css("display","block");
                var querystring = $(this).serialize();
 
                 $.ajax({
                    url: '<?php echo $WEBROOT ?>admin/save.php',    
                    type: "POST",       
                    dataType: 'html', 
                    data: querystring, 
                    success: function(data) {
                                $('#stargate').html(data);
                                $("#btnSend").prop("disabled",false);
                                $("#btnSpinner").css("display","None");
                            },
                    error: function(data){
                                $('#stargate').html('Something went wrong!');
                                $("#btnSend").prop("disabled",false);
                                $("#btnSpinner").css("display","None");
                            },
                    statusCode: { 
                            404: function() {
                                    alert( "page not found" );
                                    $("#btnSend").prop("disabled",false);
                                    $("#btnSpinner").css("display","None");
                                }
                        }
                 });
 
				//prevent default
				return false;
          });//submit form
		
	}); //ready
</script>
</head>
<?php
try {	
	
	$id= $_GET['id'];
	$sql="select * from comments where id=$id";
	$mydb = new sPDO();
	$mydb->DSN=$DSN;
	
	$mydb->connect();
	$mydb->execute($sql);
	$show=$mydb->read(1,'show');
	$cod=$mydb->read(1,'cod');
	$user=$mydb->read(1,'user');
	$email=$mydb->read(1,'email');
	$text=$mydb->read(1,'text');
	$url=$mydb->read(1,'url');
	$year=$mydb->read(1,'year');
	$month=$mydb->read(1,'month');
	$day=$mydb->read(1,'day');
	$hour=$mydb->read(1,'hour');
	$minute=$mydb->read(1,'minute');
	$second=$mydb->read(1,'second');
	
	
	$mydb->disconnect();
} catch (Exception $e) {
	echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>' ;
}
?>
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
	<div id="stargate" style="margin-top: 100px; margin-bottom:10px"></div>
	<form id="frmEdit">
		<input id="id" name="id" type="hidden" value="<?php echo $id?>">
		<input id="cod" name="cod" type="hidden" value="<?php echo $cod?>">
		<input id="year" name="year" type="hidden" value="<?php echo $year?>">
		<input id="month" name="month" type="hidden" value="<?php echo $month?>">
		<input id="day" name="day" type="hidden" value="<?php echo $day?>">
		<input id="hour" name="hour" type="hidden" value="<?php echo $hour?>">
		<input id="minute" name="minute" type="hidden" value="<?php echo $minute?>">
		<input id="second" name="second" type="hidden" value="<?php echo $second?>">
		
		
		<div class="form-group">
		  <label for="show"><input id="show" name="show" type="checkbox" value="1" <?php if ($show=='1') echo 'checked' ?> > Published</label>
		</div>
		<div class="form-group">
			<label for="txtUrl">Url</label>
			<input type="text" class="form-control mb-3" id="url" name="url" value="<?php echo $url ?>" readonly>
		</div>	
		<div class="form-group">
			<label for="user">User:</label>
			<input class="form-control mb-3" id="user" name="user" type="text" value="<?php echo $user?>">
		</div>
		<div class="form-group">
			<label for="email">E-Mail:</label>
			<input class="form-control mb-3" id="email" name="email" type="email" value="<?php echo $email?>">
		</div>
		 <div class="form-group">
		  <label for="comment">Comment:</label>
		  <textarea class="form-control" rows="5" id="text" name="text"><?php echo $text ?></textarea>
		</div>
		<div align="right">
			 <div id="btnSpinner" class="spinner-border text-secondary" role="status" style="display: None"><span class="sr-only">Loading...</span></div>
			 <a class="btn btn-secondary mt-2" href="<?php echo $WEBROOT.'admin?url='.$_GET['url'].'&filter='.$_GET['filter'] ?>" role="button">Back</a>
			 <button id="btnDelete" type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#confirmDelete">Delete</button>
			 <button id="btnSend" type="submit" class="btn btn-success mt-2">Save</button>
		</div> 
	</form>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Do you want to delete this comment?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        The comment will be deleted and can no longer be recovered.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="<?php echo $WEBROOT ?>admin/delete.php?filter=<?php echo $_GET['filter'] ?>&url=<?php echo $_GET['url'] ?>&id=<?php echo $id ?>"  class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
