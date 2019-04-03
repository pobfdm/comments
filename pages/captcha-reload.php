<?php
include_once('../lib/utils.php');
$code=getQuestionCode();

?>
<script>
	$('#labelAnswer').html('<?php  echo getQuestionTextFromCode($code) ?>');
	$('#question_code').val('<?php  echo $code ?>');
</script>
