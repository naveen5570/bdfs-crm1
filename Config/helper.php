<?php

    function textMsg($msg,$title){

      $_SESSION['msg'] = $msg;
    
      $_SESSION['title'] = $title;

   }

   function isUserLogin(){
      
       if(isset($_SESSION['userId']) || isset($_COOKIE['userId'])){
$_SESSION['userId'] = $_COOKIE['userId'];
$_SESSION['userEmail'] = $_COOKIE['userEmail'];
$_SESSION['userName'] = $_COOKIE['userName'];
$_SESSION['userRole'] = $_COOKIE['userRole'];
          return 1;
          
       }else{

        textMsg("You must be Login first","error");
        Redirect::url("user/login");
        exit;
       }
   }

 function isAdminLogin(){

     if(isset($_SESSION['adminId']) || isset($_COOKIE['adminId'])){
$_SESSION['adminId'] = $_COOKIE['adminId'];
$_SESSION['adminEmail'] = $_COOKIE['adminEmail'];
$_SESSION['adminName'] = $_COOKIE['adminName'];
          return 1;
          
       }else{
         textMsg("You must be Login first","error");
        Redirect::url("admin");
          exit;
       }
 }  

function uploads($file){

	$allowedExts = array("jpeg","png","jpg","JPEG","PNG","JPG");

	$temp = explode(".", $file["name"]);
	
    $extension = strtolower(end($temp));
	$msg = null; 
	
	if ((($file["type"] == "image/png")
	|| ($file["type"] == "image/jpeg")
	|| ($file["type"] == "image/jpg")
	|| ($file["type"] == "image/PNG")
	|| ($file["type"] == "image/JPG")
	|| ($file["type"] == "image/JPEG")
	)
	&& ($file["size"] < 52428800)
	&& in_array($extension, $allowedExts)) {
	  if ($file["error"] > 0) {
	        $msg =  "Something went Wrong - Return Code: " . $file["error"] . "<br>";
	  } else {
	        $name = md5($file["name"]).time().'.'.$extension;
	        move_uploaded_file($file["tmp_name"],"uploads/images/" . $name);
	        
	        $msg = "success";
	        //Image::compress("uploads/images");
	   	 	//Image::delete("uploads/images");
	        return array($name,$msg);
	        
	      
	    }
	} else {
	        $msg = "Invalid File type";
		return array(null,$msg);
	}
 
}
function sendMail($to,$subject,$msg){
  
	$header = "MIME-Version: 1.0\r\n";
	$header .= "From: no-reply@polluxglobal.com \r\n";
	$header .= "Content-Type:text/html; charset=iso-8859-1\r\n";
	$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

	if (mail($to, $subject, $msg, $header)){
	    return 1;
	} else {
	    return 0;
	}
}

function rendomColor(){ 
	//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
	$Caracteres = 'ABCDEF0123456789'; 
	$Hash=array("#f93636","#5f57d1","#35990a","#c1b20e","#d34c4c","#36ad9b","#833ba5","#eb4cc4","#0090c5","#6fc500","#7fbaad","#a5a5aa","#610079", "#a4d2fd", "#ebf36f", "#b8d188", "#e8c27a" );
	/*
	$QuantidadeCaracteres = strlen($Caracteres); 
	$QuantidadeCaracteres--; 
	
	

	$Hash="#"; 
	    for($x=1;$x<=$qtd;$x++){ 
	        $Posicao = rand(0,$QuantidadeCaracteres); 
	        $Hash .= substr($Caracteres,$Posicao,1);
	    } 
*/
	return $Hash;
}

function createNotification($createdby, $notifyto, $msg, $leadid = 0, $lead_type_id = 0, $lead_status_id = 0){

	$notification = new Notification();
	$notification->createdby = $createdby;
	$notification->notifyto = $notifyto;
	$notification->msg = $msg;
	$notification->leadid = $leadid;
	$notification->lead_type_id = $lead_type_id;
	$notification->lead_status_id = $lead_status_id;
	$notification->date = time();
	$notification->isseen = 0;
	$notification->save();
}






function createLog($createdby, $notifyto, $msg, $leadid = 0, $lead_type_id = 0, $lead_status_id = 0){

	$notification = new Log();
	$notification->createdby = $createdby;
	$notification->notifyto = $notifyto;
	$notification->msg = $msg;
	$notification->leadid = $leadid;
	$notification->lead_type_id = $lead_type_id;
	$notification->lead_status_id = $lead_status_id;
	$notification->date = time();
	$notification->isseen = 0;
	$notification->save();
}


function timerFormat($start_time, $end_time, $std_format = false){   
    
	$total_time = $end_time - $start_time;
	$days       = floor($total_time /86400);        
	$hours      = floor($total_time /3600);     
	$minutes    = intval(($total_time/60) % 60);        
	$seconds    = intval($total_time % 60);     
	$results = "";
	if($std_format == false)
	{
	  if($days > 0) $results .= $days . (($days > 1)?" days ":" day ");     
	  if($hours > 0) $results .= $hours . (($hours > 1)?" hours ":" hour ");        
	  if($minutes > 0) $results .= $minutes . (($minutes > 1)?" minutes ":" minute ");
	  if($seconds > 0) $results .= $seconds . (($seconds > 1)?" seconds ":" second ");
	}
	else
	{
	  if($days > 0) $results = $days . (($days > 1)?" days ":" day ");
	  $results = sprintf("%s%02d:%02d:%02d",$results,$hours,$minutes,$seconds);
	}
	return $results;
}