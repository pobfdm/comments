<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php
	include_once('../lib/utils.php');
	$code=getQuestionCode();
?>
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
	<!-- Prism-->
	<link href="../css/prism.css" rel="stylesheet" />
	<script src="../js/prism.js"></script>
</head>

<body>
<div id="lav"></div>
<div id="stargateJS"></div>


<div class="jumbotron border">
<h1 class="display-6"><?php echo $TITLE ?></h1>
<div id="usersComments"></div>	
<hr class="my-4">
<small class="text-muted"><?php echo $UNDER_TITLE ?></small>
<div id="stargate" class="centered" style="margin-top:10px; max-width: 400px"></div>
<form id="frmComments">
<input type="hidden" id="url" name="url" value="">
<input type="hidden" id="question_code" name="question_code" value="<?php echo $code ?>">
	  
  <div class="row mb-2">
    <div class="col">
      <input type="text" id="user" name="user" class="form-control" placeholder="User">
    </div>
    <div class="col">
      <input type="email" id="email" name="email" class="form-control" placeholder="E-mail">
    </div>
  </div>



<div class="row">
	<div class="col">	
		<textarea id="text" name="text" class="form-control" id="exampleFormControlTextarea1" style="height: 200px" placeholder="Your comment"></textarea>
		
	</div>	
</div>
<div class="row  mb-2">
	<div class="col">
		<label id="labelAnswer" for="answer" class="col-form-label"><?php  echo getQuestionTextFromCode($code) ?> = ?</label>
		<input type="text" id="answer" name="answer" class="form-control" placeholder="your answer" style="width: 300px">
    </div>
</div> 
 
 <div align="right">
	 <div id="btnSpinner" class="spinner-border text-secondary" role="status" style="display: None"><span class="sr-only">Loading...</span></div>
	 <button id="btnSend" type="submit" class="btn btn-secondary mt-2"><?php echo $labelButtonSend ?></button>
</div> 
  </form>

</div>
<script>
$(document).ready(function(){
		spinner='<div class="spinner-border text-secondary" role="status"><span class="sr-only">Loading...</span></div>';
		$('#url').val(window.location.href);
		$('#usersComments').html(spinner).load('<?php echo $WEBROOT ?>/pages/show_comments.php?url='+window.location.href);
		
		$("#frmComments").submit(function(){ 
				$("#btnSend").prop("disabled",true);
				$("#btnSpinner").css("display","block");
                var querystring = $(this).serialize();
 
                 $.ajax({
                    url: '<?php echo $WEBROOT ?>/pages/send.php',    
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
		
		
		
		
		$( "input, textarea" ).focus(function() {
			$(this).removeClass('inputError')
		});
		
		
		
	}); //ready
		
		
		
	</script>
</body>
</html>
