<?php
 

  if(!empty($_POST['g-recaptcha-response']))
  {
        $secret = '6Lc6bMEaAAAAAJyttNnKbXggVFf8DLqWNx8gjGC0';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        
        if($responseData->success)
		header('Location: homepage.html');
		
	        //$message = "g-recaptcha varified successfully";
        else
	        $message = "Some error in vrifying g-recaptcha";
	        echo $message;
   }
?>
