<?php 

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate'); 

require __DIR__ .'\twilio-php-master\Twilio\autoload.php';
use Twilio\Rest\Client;
 include("../../config.php");

		$postdata = file_get_contents("php://input"); 
		parse_str($postdata);
		$errorcode=0;
 
       if(!isset($api_key) || empty($api_key) || $api_key!='APIKEY')
	   { 
			header("HTTP/1.1 204 No Content");
			die();
		 
	   }else 
	   { 
	    
       if($errorcode==0)
            {	
					
					if(!isset($phone) || !is_numeric($phone))
					{
						$errorcode=2; 
					}
					 
					 if($errorcode==0)
					 {
						   
							if(date('a') == 'am'){
								$msg= 'Good morning! Your promocode is AM123';
							}else{
								$msg= 'Hello! Your promocode is PM456';
							}

							$client = new Client($account_sid, $auth_token);
							try{
							$rescode=$client->messages->create("+".$phone,
												array('from' => $fromnumber,
													  'body' => $msg)
											  );
						 
							$sid=$rescode->sid; 				
 							$body=$rescode->body;
							if (isset($sid))
							{ 		
								$response['sid']=$sid;
								$response['body']=$body;
							}
 
 
							}catch(Exception $e) {
								 
									$response['error_message']=$e->getMessage();
									 
								}
 
					 }
     
             } 
       }
	  

 
			$postdata = json_encode($response);
			echo trim($postdata);
	   
?>
