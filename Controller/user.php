<?php

class user{

    public $app;

	public function __construct(){

		$this->app = new View;
	}

	public function index() {
     isUserLogin();
            Redirect::url("user/dashboard");
     
	}
    // 404 page not found
	public function notFound(){

		$this->app->views("user/404");
	}



public function login() {
     $this->app->views("user/index");
            

	}
    public function dashboard() {
        isUserLogin();
        //date_default_timezone_set("Asia/Calcutta");
        //die(date('y-m-d'));
        //echo date_default_timezone_get();
        $today = strtotime(date('y-m-d'));
        $tomorrow = $today+86400;
        $id = Session::get('userId');
        
		$leads = Lead::find_by_sql("SELECT * FROM leads where status=1 AND FIND_IN_SET(".$id.", user_id)");
		
		
        $users  = Subadmin::all(['id' => $id]);
        $reminders2 = Followup::all(['conditions'=>"reminder_date >=  $today and reminder_date < $tomorrow and repeat_in=0 and duration='' and FIND_IN_SET('".$id."', user_id)" ]);
	 //die(print_r($reminders2));
     //die("reminder_date >=  $today and reminder_date < $tomorrow and FIND_IN_SET('".Session::get('userId')."', user_id)");
     $reminders1 = Followup::all(['conditions'=>"reminder_date < $today and repeat_in=0 and duration='' and FIND_IN_SET('".$id."', user_id)"]);
     //die("reminder_date < $today and FIND_IN_SET('".Session::get('userId')."', user_id)");
	 $reminders = Followup::all(['conditions'=>"reminder_date >=  $today and reminder_date < $tomorrow and repeat_in=0 and duration='' and assigned_by=".$id]);
	 $reminders3 = Followup::all(['conditions'=>"repeat_in!=0 and duration!='' and reminder_date >=  $today and reminder_date < $tomorrow and assigned_by=".$id]);
	 //die("reminder_date >=  $today and reminder_date < $tomorrow and assigned_by=".Session::get('userId'));
     $this->app->views("user/dashboard",(['users'=>$users,'reminders3'=>$reminders3, 'reminders' => $reminders, 'leads'=>$leads, 'reminders1'=>$reminders1, 'reminders2'=>$reminders2]));
	

	}


//user login
public function userSingIn(){
//die(Input::get("email"));
    if(Session::exists('userId')){
        Redirect::url("dashboard");
        exit;
    }
    if(Input::exists("email") && Input::exists("pass")){

        $email = Input::get("email");
        $pass = Input::get("pass");
        $users  = Subadmin::all(['email' => $email]);
          //die('ddd');
        if(count($users) < 1) {
            textMsg("Invalid username and password.","error");
            Redirect::url("user/index/");
            exit;
        }

            if($users[0]->status == 1){
				//die('dfddf');
                if(Pass::verify($users[0]->pass,$pass)){
                    Session::put("userId",$users[0]->id);
                    Session::put("userEmail",$users[0]->email);
                    Session::put("userName",$users[0]->name);
					Session::put("userRole",$users[0]->role);
					setcookie('userName', $users[0]->name, time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('userEmail', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('userId', $users[0]->id, time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('userRole', $users[0]->role, time() + (86400 * 30), "/"); // 86400 = 1 day
                    textMsg("Login Successfully.","success");
                    Redirect::url("user/dashboard");
                    exit;

                }else{
                    textMsg("Password din not match try again.","error");
                    Redirect::url("user/index/");
                    exit;
                }
            }else{
                textMsg("Your account has been deactive please contact Administrator","error");
                Redirect::url("user/index/");
                exit;
            }

     }
}

//user logout
public function userSingout(){
    //die('t');
    setcookie('userEmail', '', time() + (86400 * 30), "/"); // 86400 = 1 day
	setcookie('userId', '', time() + (86400 * 30), "/"); // 86400 = 1 day
	setcookie('userName', '', time() + (86400 * 30), "/"); // 86400 = 1 day
	setcookie('userRole', '', time() + (86400 * 30), "/"); // 86400 = 1 day
	unset($_SESSION['userId']);
	unset($_SESSION['userEmail']);
	unset($_SESSION['userName']);
    unset($_SESSION['EnailVery']);
	unset($_SESSION['userRole']);
     
    
    textMsg("Logout Success","success");
    Redirect::url("user/index");
    exit;
}


public function changepassword() {
        isUserLogin();
        $id = Session::get('userId');
        $users  = Subadmin::all(['id' => $id]);
        $this->app->views("user/changepassword",(['users'=>$users]));
}

//user password change
public function userPass(){
    isUserLogin();
    if(Input::exists("pass") || Input::exists("cpass") || Input::exists("token")){

        $pass = Input::get("pass");
        $key = Input::get("token");
        $cpass = Input::get("cpass");

        if(empty($pass) || empty($cpass)|| empty($key)){
            textMsg("Required fields are empty.","error");
            Redirect::url("user/changepassword");
            exit;
        }else{

             if($pass == $cpass){
                $uid = Session::get('userId');
                $users = Subadmin::all(['id'=>$uid]);
                $check = Pass::verify($users[0]->pass,$pass);
                $users[0]->pass = Pass::hash($pass);

             if($users[0]->save()){
                textMsg("password has been updated.","success");
                Redirect::url("user/changepassword");
                exit;
            }else{
                textMsg("Something went wrong try again.","error");
                Redirect::url("user/changepassword");
                exit;
            }
        }else{
              textMsg("Confirm password did not match.","error");
                Redirect::url("user/changepassword");
                exit;
        }

       }

      }else{
        textMsg("Something went wrong try again.","error");
        Redirect::url("user/changepassword");
        exit;
      }

}


public function leads(){
        isUserLogin();

        $this->app->views("user/leads");
}

public function loadAllLeads(){
    isUserLogin();
    $uid = Session::get('userId');
    // Datatables Variables
    $draw = intval(Input::get("draw"));
    $start = intval(Input::get("start"));
    $length = intval(Input::get("length"));

    $search = Input::get("search");
    $searchval = $search['value'];
    $condition = "status = 1";
    // $searchval = "securi";
    // $start = 20;
    // $length = 20;
	
	
    if($searchval != "" ){
        
		$condition = "status = 1 and (Concat (firm_name, '', address_1, '', address_2, '', address_3, '', address_4, '', city, '', state, '', zipcode, '', phone, '', firm_crd, '', website, '', new_ceo_name, '', ceo_name, '', ceo_email, '', ceo_number, '', ceo_linkedin, '', ceo_letter_type, '', ceo_crd, '', ceo_finop_name, '', ceo_finop_card, '', cco_name, '', new_cco_name, '', cco_email, '', cco_number, '', cco_linkedin, '', cco_crd, '', cco_state, '', industry_id) like'%".$searchval."%' )";
    }else{
        $condition = "status = 1";
    }

    $i = 1;
    $leads = Lead::find_by_sql("SELECT * FROM leads where ".$condition." AND FIND_IN_SET(".$uid.", user_id) limit $start,$length");
    $totalleads = Lead::find_by_sql("SELECT count(*) as totalleads FROM leads where ".$condition);
//$test = Lead::find_by_sql("SELECT * FROM leads WHERE FIND_IN_SET(".$uid.", user_id)");


    foreach($leads as $data){

        $leadstatus = Leadstatu::all(['id'=>$data->lead_status_id]);
        if(count($leadstatus)){
          $leadstatusname = $leadstatus[0]->name;
        }else{
          $leadstatusname = "";
        }
		if($data->user_id == 0){
          $assignto = 'Admin';
        }else{
			$data1=explode(',',$data->user_id);
			$arr=array();
			foreach($data1 as $data1)
			{
            $assignusers = Subadmin::all(['id'=>$data1]);
            $assignto = $assignusers[0]->name;
			array_push($arr,$assignto);
        }
		 $assignto=implode('<br>',$arr);  
		}
        $leadsdata[] = array(
            '<Input type="checkbox" name="checkedleads" class="leads_checkbox" value="'.$data->id.'">',
            "#".sprintf('%04d',$data->id),
            '<a href="'.BASEURL.'user/viewLead/'.$data->id.'">'.$data->firm_name.'</a>',
$data->firm_crd,
            //$data->new_ceo_name,
            '<a href="'.BASEURL.'user/viewLead/'.$data->id.'">'.$data->ceo_name.'</a>',
            $data->ceo_email,
			$leadstatusname,
            $data->ceo_number,
            $data->ceo_linkedin,
            //$data->ceo_letter_type,
            $data->ceo_crd,
            $data->ceo_finop_name,
            $data->ceo_finop_card,
            $data->cco_name,
            $data->new_cco_name,
            $data->cco_email,
            $data->cco_number,
            $data->cco_linkedin,
            $data->cco_crd,
            $data->cco_state,
            
            $data->address_1,
            $data->address_2,
            $data->address_3,
            $data->address_4,
            $data->city,
            $data->state,
            $data->zipcode,
            $data->phone,
            
            $data->website,
            $data->leadfrom,
            $data->id
        );
    }

    $output = array(
        "draw" => $draw,
        "recordsTotal" => (int) ($totalleads[0]->totalleads),
        "recordsFiltered" => (int) ($totalleads[0]->totalleads),
        "data" => $leadsdata
    );
	
    echo json_encode($output);
    exit();
}

//Reminder create for lead

public function followup(){

    isUserLogin();

    if(!Input::exists("id") && !Input::exists("msg") && !Input::exists("reminddate")){
        echo  json_encode(['result' => "Fill All field"]);
	      exit;

    }else{

        $msg = Input::get("msg");
		$user_id = Input::get('user_id');
        $user = Input::get("assigned_by");

        $leadsid = Input::get("id");
        $reminddate = Input::get("reminddate");
        $arr=array();
        foreach($user as $u)
        {
        array_push($arr,$u);
        }
        $user=implode(',',$arr);


        if(empty($msg) || empty($leadsid) || empty($reminddate)){

          echo  json_encode(['result' => "Fill All field"]);
          exit;

        }else{

          $leads = Lead::all(['id' => $leadsid]);
          if(count($leads) >= 0){
              $uid = Session::get('userId');
              $arr = explode(',', $leads[0]->user_id);
              if(in_array($uid, $arr)){
                $followup = new Followup();
                $followup->leadid = $leadsid;
                $followup->reminder_date = strtotime($reminddate);
                $followup->msg = $msg;
                $followup->assigned_by = Session::get('userId');
				$followup->user_id = $user;
                $followup->is_seen = 0;
                $followup->date = time();
                if($followup->save()){

                  echo  json_encode(['result' => "success"]);
                }else{

                    echo  json_encode(['result' => "Something went wrong try again1"]);
                }
              }else{
                echo  json_encode(['result' => "Something went wrong try again-2"]);

              }

          }else{
              echo  json_encode(['result' => "Something went wrong try again3"]);
          }
          exit;
        }

    }

}

/*
Old Followup

public function followup(){

    isUserLogin();

    if(!Input::exists("id") && !Input::exists("msg") && !Input::exists("reminddate")){
        echo  json_encode(['result' => "Fill All field"]);
	      exit;

    }else{

        $msg = Input::get("msg");
		$user_id = Input::get('user_id');

        $leadsid = Input::get("id");
        $reminddate = Input::get("reminddate");

        if(empty($msg) || empty($leadsid) || empty($reminddate)){

          echo  json_encode(['result' => "Fill All field"]);
          exit;

        }else{

          $leads = Lead::all(['id' => $leadsid]);
          if(count($leads) >= 0){
              $uid = Session::get('userId');
              $arr = explode(',', $leads[0]->user_id);
              if(in_array($uid, $arr)){
                $followup = new Followup();
                $followup->leadid = $leadsid;
                $followup->reminder_date = strtotime($reminddate);
                $followup->msg = $msg;
				$followup->user_id = Session::get('userId');
                $followup->is_seen = 0;
                $followup->date = time();
                if($followup->save()){

                  echo  json_encode(['result' => "success"]);
                }else{

                    echo  json_encode(['result' => "Something went wrong try again1"]);
                }
              }else{
                echo  json_encode(['result' => "Something went wrong try again-2"]);

              }

          }else{
              echo  json_encode(['result' => "Something went wrong try again3"]);
          }
          exit;
        }

    }

}

*/



//view Lead
public function viewLead($id,$leadtype=null,$leadcurrentstatus=null){
     isUserLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/leads/");
        exit;
    }else{

        $uid = Session::get('userId');
        $leads = Lead::all(['id'=>$id]);
	$leadarticles = LeadArticle::all(['lead_id'=>$id]);
        if(count($leads)>0 && $leads[0]->status==1){

            $this->app->views("user/viewLead",(['data'=>$leads[0],'type'=> $leadtype,'leadcurrentstatus' => $leadcurrentstatus,'leadarticles' => $leadarticles]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("user/leads/");
            exit;

        }

    }
}


public function notification(){
    isUserLogin();
    $connects = Connect::all(['status'=>1,'notyfy_id'=>0]);
    $this->app->views("user/notification",(['connects'=>$connects]));
}

public function view_notification(){
   isUserLogin();
    $this->app->views("user/view_notification");
}


public function lead($leadstype,$leadstatus=''){

    $leadstatus = str_replace("_"," ",$leadstatus);

    isUserLogin();

    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("user/lead_by_type",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("user/notFound");
        exit;

    }
}

public function loadTypeWiseLeads($lead_type,$leadcurrentstatusid = 0, $leadcurrentsubstatusid = 0){
    isUserLogin();
    $uid = Session::get('userId');
    // Datatables Variables
    $draw = intval(Input::get("draw"));
    $start = intval(Input::get("start"));
    $length = intval(Input::get("length"));

    $search = Input::get("search");
    $searchval = $search['value'];
    $condition = "status = 1";
    // $searchval = "securi";
    // $start = 20;
    // $length = 20;
    if($searchval != "" ){
        $condition = "status = 1  and ( Concat (firm_name, '', address_1, '', address_2, '', address_3, '', address_4, '', city, '', state, '', zipcode, '', phone, '', firm_crd, '', website, '', new_ceo_name, '', ceo_name, '', ceo_email, '', ceo_number, '', ceo_linkedin, '', ceo_letter_type, '', ceo_crd, '', ceo_finop_name, '', ceo_finop_card, '', cco_name, '', new_cco_name, '', cco_email, '', cco_number, '', cco_linkedin, '', cco_crd, '', cco_state, '', industry_id) like'%".$searchval."%' )  and leadfrom = ".$lead_type;
    }else{
        $condition = " status = 1 and leadfrom = ".$lead_type;
    }
    if($leadcurrentstatusid){
      $condition.=" and lead_status_id = $leadcurrentstatusid";
    }
	if($leadcurrentsubstatusid){
      $condition.=" and lead_substatus_id = $leadcurrentsubstatusid";
    }
    $i = 1;
    $leads = Lead::find_by_sql("SELECT * FROM leads where ".$condition." AND FIND_IN_SET(".$uid.", user_id) limit $start,$length");
    $totalleads = Lead::find_by_sql("SELECT count(*) as totalleads FROM leads where ".$condition." AND FIND_IN_SET(".$uid.", user_id)");
    $leadsdata = array();

    foreach($leads as $data){
        $leadstatus = Leadstatu::all(['id'=>$data->lead_status_id]);
        if(count($leadstatus)){
          $leadstatusname = $leadstatus[0]->name;
        }else{
          $leadstatusname = "";
        }
        $leadlink='<a href="'.BASEURL.'user/viewLead/'.$data->id.'/'.$lead_type.'">'.$data->firm_name.'</a>';
        if($leadcurrentstatusid){
          $leadlink='<a href="'.BASEURL.'user/viewLead/'.$data->id.'/'.$lead_type.'/'.$leadcurrentstatusid.'">'.$data->firm_name.'</a>';
        }
        $leadsdata[] = array(
            
			'<Input type="checkbox" name="checkedleads" class="leads_checkbox" value="'.$data->id.'">',
            "#".sprintf('%04d',$data->id),
            "#".sprintf('%04d',$data->id),
            $leadlink,
            $data->firm_crd,
            $data->ceo_name,
            $data->ceo_email,
			$leadstatusname,
            $data->ceo_number,
            $data->ceo_linkedin,
            //$data->ceo_letter_type,
            $data->ceo_crd,
            $data->ceo_finop_name,
            $data->ceo_finop_card,
            $data->cco_name,
            $data->new_cco_name,
            $data->cco_email,
            $data->cco_number,
            $data->cco_linkedin,
            $data->cco_crd,
            $data->cco_state,
            
            $data->address_1,
            $data->address_2,
            $data->address_3,
            $data->address_4,
            $data->city,
            $data->state,
            $data->zipcode,
            $data->phone,
            
            $data->website,
            $data->lead_status_id,
            $data->id
        );
    }

    $output = array(
        "draw" => $draw,
        "recordsTotal" => (int) ($totalleads[0]->totalleads),
        "recordsFiltered" => (int) ($totalleads[0]->totalleads),
        "data" => $leadsdata
    );

    echo json_encode($output);
    exit();
}

//leadStatusChange
public function leadStatusChange(){

     isUserLogin();

    if(!Input::exists("id") && !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
		$id = Input::get("id");
        $uid =  Session::get('userId');
		$leadstatus = Leadstatu::all(['id'=>$id]);
		if(count($leadstatus) > 0){
			$leadid = Input::get("leadid");

			$leads = Lead::all(['id' => $leadid]);
			if(count($leads) > 0){

				$leads[0]->lead_status_id = $id;

				if($leads[0]->save()){
					createNotification($uid, $uid, "Change Lead <a href='".BASEURL."user/viewLead/".$leads[0]->id."'>#".sprintf('%04d',$leads[0]->id)."</a> status to ".$leadstatus[0]->name, $leads[0]->id, $leadstatus[0]->lead_type_id, $leadstatus[0]->id);
          createNotification($uid,0, "Change Lead <a href='".BASEURL."user/viewLead/".$leads[0]->id."'>#".sprintf('%04d',$leads[0]->id)."</a> status to ".$leadstatus[0]->name, $leads[0]->id, $leadstatus[0]->lead_type_id, $leadstatus[0]->id);
					echo  json_encode(['result' => "success"]);

				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}

			}else{
				echo  json_encode(['result' => "Something went wrong try again".$leadid]);
			}
		}else{
			echo  json_encode(['result' => "Something went wrong try again"]);
		}

    }

}
    //add Users
public function addNotes(){
   isUserLogin();

    if(Input::exists("token") && Input::exists("msg") && Input::exists("id")){

        $key = Input::get("token");
        $msg = Input::get("msg");
        $lead_id = Input::get("id");
$type = Input::get("type");
        $leadcurrentstatus = Input::get("leadcurrentstatus");
        $userid = Session::get('userId');



        if(empty($key)|| empty($msg) || empty($lead_id)){

            textMsg("All fields are required","error");
            Redirect::url("user/leads/");
            exit;
        }else{

            $leads = Lead::all(['id' => $lead_id]);
            if(count($leads)>0){



                $notes = new Note();
				$notes->user_id = $userid;
				$notes->lead_id = $lead_id;
				$notes->msg = $msg;
                $notes->status = 1;
				$notes->date = time();

                if($notes->save()){

                        textMsg("New note added succesfully","success");
                        $redirecturl = "user/viewLead/$lead_id/";
                        if($type != null || $type != ''){
                          $redirecturl.=$leads[0]->leadfrom."/";
                          if($leadcurrentstatus != null || $leadcurrentstatus != ''){
                            $redirecturl.=$leadcurrentstatus."/";
                          }
                        }

                        Redirect::url($redirecturl);
                        exit;

                }else{
                        textMsg("somethis went wrong try again","error");
                        Redirect::url("user/leads");
                        exit;

                }

            }else{
                textMsg("somethis went wrong try again","error");
                Redirect::url("user/leads/");
                exit;

            }

        }

    }else{
        textMsg("somethis went wrong try again ","error");
        Redirect::url("user/leads");
        exit;

    }
}





//edit notes







public function editNotes()
{
    isUserLogin();

    if(Input::exists("token") && Input::exists("msg") && Input::exists("id")){

        $key = Input::get("token");
        $msg = Input::get("msg");
        $lead_id = Input::get("id");
		$id = Input::get("note_id");
        $type = Input::get("type");
        $leadcurrentstatus = Input::get("leadcurrentstatus");
        $adminid = Session::get('adminId');



        if(empty($key)|| empty($msg) || empty($lead_id)){

            textMsg("All fields are required","error");
            Redirect::url("user/leads/");
            exit;
        }else{

            $leads = Lead::all(['id' => $lead_id]);
            if(count($leads)>0){
             $notes1=Note::all(['id'=>$id]);
			 //die('test'.count($notes1));
if(count($notes1)>0)
{
//die('tst'.$notes1[0]->id);
$notes1[0]->id=$notes1[0]->id;
$notes1[0]->user_id=$notes1[0]->user_id;
$notes1[0]->lead_id=$notes1[0]->lead_id;
$notes1[0]->status=$notes1[0]->status;
$notes1[0]->msg=$msg;

                if($notes1[0]->save()){

                        textMsg("Note updated succesfully","success");
                        $redirecturl = "user/viewLead/$lead_id/";
                        if($type != null || $type != ''){
                          $redirecturl.=$leads[0]->leadfrom."/";
                          if($leadcurrentstatus != null || $leadcurrentstatus != ''){
                            $redirecturl.=$leadcurrentstatus."/";
                          }
                        }

                        Redirect::url($redirecturl);
                        exit;

                }else{
                        textMsg("something went wrong try again","error");
                        Redirect::url("user/leads");
                        exit;

                }}
				
				

            }else{
                textMsg("something went wrong try again","error");
                Redirect::url("administrator/leads/");
                exit;

            }

        }

    }else{
        textMsg("something went wrong try again ","error");
        Redirect::url("administrator/leads");
        exit;

    }
}








public function deleteNotes()
{
    isUserLogin();
    if(!Input::exists("id"))
	{
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }
	else
	{
	   $id = Input::get("id");
	   $lead_id=Input::get("lead_id");
       $data = Note::all(['id' => $id]);

        if(count($data) > 0){
            if($data[0]->delete()){
                textMsg("Note deleted succesfully","success");
                        $redirecturl = "user/viewLead/$lead_id/";
                        if($type != null || $type != ''){
                          $redirecturl.=$leads[0]->leadfrom."/";
                          if($leadcurrentstatus != null || $leadcurrentstatus != ''){
                            $redirecturl.=$leadcurrentstatus."/";
                          }
                        }

                        Redirect::url($redirecturl);
                        exit;
            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }
    }
		
}































public function sentMail()
{
    isUserLogin();
     if(!Input::exists("token") && !Input::exists("email") && !Input::exists("subject") && !Input::exists("msg")){
            textMsg("Required fields are empty 1.","error");
            Redirect::url("user/leads/");
            exit;

      }else{

         $token = Input::get("token");
         $email = Input::get("email");
         $sub = Input::get("subject");
        $msg =  Input::get("msg");

            if(empty($token) || empty($msg) || empty($email) ||empty($sub)) {

                textMsg("Required fields are empty2.","error");
                Redirect::url("user/leads/");
                exit;
            }else{

              $to = "$email";
              $subject = "$sub";
              $header = "MIME-Version: 1.0\r\n";
              $header .= "From: Pollux Global: <no-reply@polluxglobal.com> \r\n";
              $header .= "Content-Type:text/html; charset=iso-8859-1\r\n";
              $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
              $message = "<table style='width:100%;padding: 2vw;background:#fafafa;text-align:left;'><thead><tr><th colspan='3'><a href='#' target='_blank' style='text-decoration:none;color:#000;font-size:22px;display:inline-block;float:left;margin-bottom:30px;'>CRM Administrator</a></th></tr></thead><tbody><tr><td colspan='3' style='color:#6f6f6f;font-family:Open Sans;font-size:13px;line-height: 22px;margin-top:15px;display:block;margin-bottom:40px;'>";
              $message .= $msg;
              $message .= "</td></tr><tr><td style='border-top:1px solid #ddd;margin-top:20px;display:block;padding:10px 0px;overflow:hidden;border-bottom:1px solid #ddd;'><div style='color:#404040;text-align: center;font-size:15px;font-weight:600;font-family:Open Sans;'>Help & Support<ul style='list-style-type: none;margin: 0px;padding: 0px; overflow:hidden; margin-top: 10px;'><li style='overflow: hidden;font-weight:100;margin-right: 20px;display:inline-block;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.polluxglobal.com/crm/assets/mobile.png' style='float:left;height: 16px;margin-right: 10px;'> +91 00000 00000</li><li style='overflow: hidden;display: inline-block;font-weight:100;margin-right: 20px;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.polluxglobal.com/crm/assets/email.png' style='float:left;height: 16px;margin-right: 10px;'> no-reply@polluxglobal.com</li></ul></div></td></tr></tbody></table>";





                $sentOk = sendMail($to,$subject,$message,$header);
                if($sentOk){
                    textMsg("Enquiry has been sent successfully..","success");
                    Redirect::url("user/leads/");
                    exit;
                }else{
                    textMsg("Something went wrong try again..","error");
                    Redirect::url("user/leads/");
                    exit;
                }
            }

     }

}



//add reminds

public function actionDate()
{
    isUserLogin();

    if(Input::exists("token") && Input::exists("msg") && Input::exists("createdate") && Input::exists("id")){
        
        $key = Input::get("token");
        $msg = Input::get("msg");
        $reminddate = Input::get("reminddate");
        $lead_id = Input::get("id");
        $type = Input::get("type");
        $priority = Input::get("priority");
        $leadcurrentstatus = Input::get("leadcurrentstatus");
        $userid = Session::get('userId');
        $user = implode(',',Input::get("user"));
		$repeat = Input::get('number');
		$duration = Input::get('duration');
        
         /* $arr=array();
        foreach($user as $u)
        {
        array_push($arr,$u);
        }
        $user=implode(',',$arr);
        */



        if(empty($key)|| empty($msg) || empty($lead_id) || empty($reminddate)){

            textMsg("All fields are required","error");
            Redirect::url("user/leads/");
            exit;
        }else{


            $leads = Lead::all(['id' => $lead_id]);
            //$leads = Lead::all(['id' => $lead_id, 'user_id' => $userid]);
            if(count($leads)>0){



        //         $reminds = new Remind();
				// $reminds->user_id = $userid;
				// $reminds->lead_id = $lead_id;
				// $reminds->msg = $msg;
        //         $reminds->reminddate = strtotime($reminddate);
        //         $reminds->status = 1;
				// $reminds->createdate = time();
                $followup = new Followup();
                $followup->leadid = $lead_id;
                $followup->reminder_date = strtotime($reminddate);
                $followup->msg = $msg;
				$followup->user_id = $user;
				$followup->priority = $priority;
                $followup->assigned_by = Session::get('userId');
                $followup->is_seen = 0;
				$followup->repeat_in = $repeat;
				$followup->duration= $duration;
                $followup->date = time();

                if($followup->save()){

                        textMsg("Reminder set succesfully","success");
                        $redirecturl = "user/viewLead/$lead_id/";
                        if($type != null || $type != ''){
                          $redirecturl.=$leads[0]->leadfrom."/";
                          if($leadcurrentstatus != null || $leadcurrentstatus != ''){
                            $redirecturl.=$leadcurrentstatus."/";
                          }
                        }

                        Redirect::url($redirecturl);
                        exit;

                }else{
                        textMsg("something went wrong try again1","error");
                        Redirect::url("user/leads");
                        exit;

                }

            }else{
                textMsg("something went wrong try again2","error");
                Redirect::url("user/leads/");
                exit;

            }

        }

    }else{
        textMsg("something went wrong try again3 ","error");
        Redirect::url("user/leads");
        exit;

    }
}


// public function actionDate(){
//     isUserLogin();

//     if(Input::exists("token") && Input::exists("msg") && Input::exists("createdate") && Input::exists("id")){

//         $key = Input::get("token");
//         $msg = Input::get("msg");
//         $reminddate = Input::get("reminddate");
//         $lead_id = Input::get("id");
//         $type = Input::get("type");
//         $leadcurrentstatus = Input::get("leadcurrentstatus");
//         $userid = Session::get('userId');



//         if(empty($key)|| empty($msg) || empty($lead_id) || empty($reminddate)){

//             textMsg("All fields are required","error");
//             Redirect::url("user/leads/");
//             exit;
//         }else{


//             $leads = Lead::all(['id' => $lead_id]);
//             //$leads = Lead::all(['id' => $lead_id, 'user_id' => $userid]);
//             if(count($leads)>0){



//         //         $reminds = new Remind();
// 				// $reminds->user_id = $userid;
// 				// $reminds->lead_id = $lead_id;
// 				// $reminds->msg = $msg;
//         //         $reminds->reminddate = strtotime($reminddate);
//         //         $reminds->status = 1;
// 				// $reminds->createdate = time();
//                 $followup = new Followup();
//                 $followup->leadid = $lead_id;
//                 $followup->reminder_date = strtotime($reminddate);
//                 $followup->msg = $msg;
// 				$followup->user_id = Session::get('userId');
//                 $followup->is_seen = 0;
//                 $followup->date = time();

//                 if($followup->save()){

//                         textMsg("Reminder set succesfully","success");
//                         $redirecturl = "user/viewLead/$lead_id/";
//                         if($type != null || $type != ''){
//                           $redirecturl.=$leads[0]->leadfrom."/";
//                           if($leadcurrentstatus != null || $leadcurrentstatus != ''){
//                             $redirecturl.=$leadcurrentstatus."/";
//                           }
//                         }

//                         Redirect::url($redirecturl);
//                         exit;

//                 }else{
//                         textMsg("something went wrong try again1","error");
//                         Redirect::url("user/leads");
//                         exit;

//                 }

//             }else{
//                 textMsg("something went wrong try again2","error");
//                 Redirect::url("user/leads/");
//                 exit;

//             }

//         }

//     }else{
//         textMsg("something went wrong try again3 ","error");
//         Redirect::url("user/leads");
//         exit;

//     }
// }




//deletesigLead
public function deletnoty(){

    isUserLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");
        $userid = Session::get('userId');
       $data = Remind::all(['id' => $id, 'user_id' => $userid]);

        if(count($data) > 0){
            if($data[0]->delete()){
                echo  json_encode(['result' => "success"]);
            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
        }
    }

}
















public function work(){

  isUserLogin();
  $this->app->views("user/work");

}

public function getWork(){
  isUserLogin();
  if(!Input::exists("date")){
      echo  json_encode(['result' => "Select Date"]);
      exit;

  }else{
      $date = Input::get("date");
      $userid = Session::get('userId');
      $today = strtotime($date);
      $tomorrow = $today+86400;
       $leadtypes = Leadstype::all();
       $html = "";
       foreach ($leadtypes as $leadtype) {

         $html .= '<ul class="list-group">';
           $leadstatus = Leadstatu::all(['lead_type_id'=>$leadtype->id]);
           foreach ($leadstatus as $status) {
             $condition = "createdby = ".$userid." and notifyto = 0 and date >=  ".$today." and date < ".$tomorrow." and lead_status_id = ".$status->id;

             $notification = Notification::find_by_sql("SELECT count(*) as totalnotification FROM notifications where ".$condition);
             if($notification[0]->totalnotification > 0){

              $html .= '<li class="list-group-item"><span class="badge">';
              $html .= $notification[0]->totalnotification.'</span>';
              $html .= $leadtype->name.' : '. $status->name;
              $html .= '</li>';
            }
          }
          $html .= '</ul>';
        }
        echo  json_encode(['result' => "success", "notificationlist" => $html]);
   }
}


// new_lead
public function addNewLead(){
    isUserLogin();
    $business_lines = Businessline::all(['status'=>1]);
    $this->app->views("user/addNewLead", (['business_lines'=>$business_lines]));

}

//add_lead
public function addlead(){
$dd = Lead::find_by_sql('select max(id) as max_value from leads');
    isUserLogin();
    if(Input::exists("token") && Input::exists("firm_name") && Input::exists("address_1") && Input::exists("address_2") && Input::exists("address_3") && Input::exists("address_4") && Input::exists("city") && Input::exists("state") && Input::exists("zipcode") && Input::exists("phone") && Input::exists("firm_crd") && Input::exists("website") && Input::exists("new_ceo_name") && Input::exists("ceo_name") && Input::exists("ceo_email") && Input::exists("ceo_number") && Input::exists("ceo_linkedin") && Input::exists("optradio") && Input::exists("ceo_crd") && Input::exists("ceo_finop_name") && Input::exists("ceo_finop_card") && Input::exists("cco_name") && Input::exists("new_cco_name") && Input::exists("cco_email") && Input::exists("cco_number") && Input::exists("cco_linkedin") && Input::exists("cco_crd") && Input::exists("cco_state")&& Input::exists("lead_status") && Input::exists("industry") && Input::exists("leadfrom")  && Input::exists("user") && Input::exists("aboutlead")){

        $token = Input::get("token");
        $firm_name = Input::get("firm_name");
        $address_1 = Input::get("address_1");
        $address_2 = Input::get("address_2");
        $address_3 = Input::get("address_3");
        $address_4 = Input::get("address_4");
        $city = Input::get("city");
        $state = Input::get("state");
        $zipcode = Input::get("zipcode");
        $phone = Input::get("phone");
        $firm_crd = Input::get("firm_crd");
        $website = Input::get("website");
        $new_ceo_name = '';
        $ceo_name = Input::get("ceo_name");
        $ceo_email = Input::get("ceo_email");
        $ceo_number = '';
        $ceo_linkedin = '';
        $ceo_letter_type = '';
        $ceo_crd = '';
        $ceo_finop_name = '';
        $ceo_finop_card = '';
        $cco_name = '';
        $new_cco_name = '';
        $cco_email = '';
        $cco_number = '';
        $cco_linkedin = '';
        $cco_crd = '';
        $cco_state = '';
        $lead_status = Input::get("lead_status");
        $industry = Input::get("industry");
        $leadfrom = Input::get("leadfrom");

        if(Input::get('bus_type')=='names')
{
        $business_lines = Input::get('business_lines');
        $business_liness = implode(',', $business_lines);
}
else
{
 $business_lines = Input::get('business_lines1');
 $business_liness = implode(',', $business_lines);   
}
        //die($business_liness);
        $user = Input::get("user");
        
        $arr=array();
foreach($user as $u)
{
array_push($arr,$u);
}
$user=implode(',',$arr);
        $aboutlead = Input::get("aboutlead");
        $rom_branch_count = Input::get("rom_branch_count");



        if(empty($token) || empty($ceo_name) || empty($ceo_email) ){

                  textMsg("All fields are required","error");
                  Redirect::url("user/addNewLead");
                  exit;
        }else{

                $leads = new Lead();
                $leads->id = $dd[0]->max_value+1;
                $leads->firm_name = $firm_name;
                $leads->address_1 = $address_1;
                $leads->address_2 = $address_2;
                $leads->address_3 = $address_3;
                $leads->address_4 = $address_4;
                $leads->city = $city;
                $leads->state = $state;
                $leads->zipcode = $zipcode;
                $leads->phone = $phone;
                $leads->firm_crd = $firm_crd;
                $leads->website = $website;
                $leads->new_ceo_name = $new_ceo_name;
                $leads->ceo_name = $ceo_name;
                $leads->ceo_email = $ceo_email;
                $leads->ceo_number = $ceo_number;
                $leads->ceo_linkedin = $ceo_linkedin;
                $leads->ceo_letter_type = $ceo_letter_type;
                $leads->ceo_crd = $ceo_crd;
                $leads->ceo_finop_name = $ceo_finop_name;
                $leads->ceo_finop_card = $ceo_finop_card;
                $leads->cco_name = $cco_name ;
                $leads->new_cco_name = $new_cco_name;
                $leads->cco_email = $cco_email;
                $leads->cco_number = $cco_number;
                $leads->cco_linkedin = $cco_linkedin;
                $leads->cco_crd = $cco_crd;
                $leads->cco_state = $cco_state;
                $leads->lead_status_id = $lead_status;
                //$leads->industry_id = $industry ;
                $leads->leadfrom = $leadfrom ;
                $leads->user_id = $user;
                $leads->aboutlead = $aboutlead ;
                $leads->industry_id = $business_liness;
                $leads->rom_branch_count = $rom_branch_count;
                $leads->date = time();
                $leads->status = 1;
                if($leads->save()){

                    textMsg("New lead added succesfully","success");
                    
                    $insert = new Addlead();
                    $insert->leadid = $dd[0]->max_value+1;
                    $insert->lead = $firm_name;
                    $insert->added_by = Session::get('userId');
                    $insert->date = date('d-m-Y');
                    $insert->status = 1;
                    $insert->save();
                    Redirect::url("user/leads");
                    exit;

                }else{
                    textMsg("something went wrong try again","error");
                    Redirect::url("user/addNewLead");
                    exit;

                }



        }

    }else{

        textMsg("something went wrong try again ","error");
        Redirect::url("user/addNewLead");
        exit;

    }
}







//assign Selected Leads to  User
public function assignSelectedLeads()
{

    isUserLogin();

    if(!Input::exists("userid") && !Input::exists("leadsid")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{

        $id = Input::get("userid");
        $leadsid = Input::get("leadsid");

        if($id != 0){

            $subadmins = Subadmin::all(['id'=>$id]);
            if(count($subadmins) < 1){
                echo  json_encode(['result' => "Something went wrong try again"]);
                exit;
            }
            $assignto = $subadmins[0]->name;
        }else{
          $assignto = "Admin";
        }

        $leads = Lead::all(['conditions' => "id IN (".implode(",", $leadsid).")"]);
        if(count($leads) > 0){
            foreach ($leads as $lead) {
              $lead->user_id = $id;
              if(!$lead->save()){
                  echo  json_encode(['result' => "Something went wrong try again"]);
              }
            }
            echo  json_encode(['result' => "success","assignedUser"=>ucwords($assignto)]);
				
        }else{
            echo  json_encode(['result' => "Something went wrong try again"]);
        }
        exit;

    }

}




















public function sendArticletoLead()
{

    isUserLogin();

    if(!Input::exists("id") || !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct ids to do this action."]);
	      exit;

    }else{

	     $id = Input::get("id");
	     $leadid = Input::get("leadid");
       $uid = Session::get('userId');

       $lead = Lead::all(['id' => $leadid, 'user_id'=>$uid]);
       $article = Article::all(['id' => $id]);

        if(count($lead) > 0){
          if(count($article) > 0){
              $leadarticles = LeadArticle::all(["article_id" => $id, 'lead_id' => $leadid]);
              if(count($leadarticles) > 0){

                  echo  json_encode(['result' => "This Article Already Send to this lead"]);
              }else{
                  $leadarticle = new LeadArticle();
                  $leadarticle->lead_id = $lead[0]->id;
                  $leadarticle->article_id = $article[0]->id;
                  $leadarticle->date = time();
                  $leadarticle->save();
                  echo  json_encode(['result' => "success"]);
              }

          }else{
            echo  json_encode(['result' => "Invalid Article Try Again"]);
          }
        }else{
          echo  json_encode(['result' => "Something went wrong try again"]);
        }
    }

}

public function articleFiltaration(){

  isUserLogin();
  $articles = Article::all();
  $this->app->views("user/article-filter-page",['articles' => $articles]);

}

public function showFilterArticle(){
  isUserLogin();

  if(Input::exists("token") && Input::exists("article") && Input::exists("showlead")){

      $key = Input::get("token");
      $articleid = Input::get("article");
      $showlead = Input::get("showlead");
      $leadfrom = Input::get("leadfrom");
      $lead_status = Input::get("lead_status");

      if(empty($key)|| empty($articleid) || empty($showlead)){

          textMsg("Article and Show Lead field is required","error");
          Redirect::url("user/articleFiltaration/");
          exit;
      }else{

        $selectedarticle = Article::all(['id' => $articleid]);
        if(count($selectedarticle) > 0){

            $selectedarticle = $selectedarticle[0];

            $artical_leadids = [];
            $leadarticles = LeadArticle::all(["article_id" => $selectedarticle->id]);
            foreach ($leadarticles as $value) {
              $artical_leadids[] = $value->lead_id;
            }
            if($showlead == "send"){
              $condition = "id IN (".implode(",", $artical_leadids).")";

            }elseif($showlead == "unsend"){
              $condition = "id NOT IN (".implode(",", $artical_leadids).")";
            }
            if(!empty($leadfrom)){
              $condition .= " and leadfrom = $leadfrom";
            }
            if(!empty($lead_status)){
              $condition .= " and lead_status_id = $lead_status";
            }
            $uid = Session::get('userId');
            $condition .= " and user_id = $uid";
            $leads = Lead::all(['conditions'=>$condition]);
            $articles = Article::all();
            $this->app->views("user/article-filter-page",['leads' => $leads, 'selectedarticle' => $selectedarticle, 'articles' => $articles, 'showlead' => $showlead, 'leadfrom' => $leadfrom, 'lead_status' => $lead_status]);

        }else{
            textMsg("Invalid Article selected","error");
            Redirect::url("user/articleFiltaration/");
            exit;
        }
      }

  }else{
      textMsg("somethis went wrong try again ","error");
      Redirect::url("user/articleFiltaration");
      exit;

  }
}


public function leadFiltaration(){

  isUserLogin();
  $users = Subadmin::all(['status'=>1]);
  $business_lines = Businessline::all();
  $this->app->views("user/lead-filter-page",['users' => $users, 'business_lines'=>$business_lines]);

}

public function showFilterLeads(){
  isUserLogin();
if(Input::exists("token")){

      //$key = Input::get("token");	
      $businesslines = Input::get("business_lines");
	  $query = Input::get('query_type');
	  $rom_branch_counts = Input::get("value_type");
	  
	  //die(print_r($rom_branch_counts));
      //$selecteduser = Input::get("user");
      $leadfrom = Input::get("leadfrom");
      $lead_status = Input::get("lead_status");

      if(empty($businesslines) && empty($rom_branch_counts) && empty($selecteduser) && empty($leadfrom) && empty($lead_status)){

          textMsg("Please select atleast one filter","error");
          Redirect::url("user/leadFiltaration/");
          exit;
      }else{
            $condition = "";
            if(!empty($businesslines)){
			  //$business_linee=implode(', ',$business_lines);
			  $numItems = count($businesslines);
			  //die('test=>'.$numItems);
			  $i=0;
              foreach ($businesslines as $business_line) {
				  if($query == 'or')
				  {
				  if ($i==0)
				  {
					$condition .= "( ";  
				}
                $condition .= 'industry_id LIKE "%,'.$business_line.',%"';	
				if(++$i!=$numItems)
				{
				$condition .= ' '.$query.' ';	
				}
				if ($i==$numItems)
				  {
					$condition .= "  )";  
				}
				  }
				else
				{
				$condition .= 'industry_id LIKE "%,'.$business_line.',%"';	
				if(++$i!=$numItems)
				{
				$condition .= ' '.$query.' ';	
				}
				} 
              }
            }
			if(!empty($rom_branch_counts))
			{
			if($rom_branch_counts=='single')
			{
			$condition .= " and `rom_branch_count` =".Input::get("value1")." ";
			}
			else
			{
			$condition .= " and `rom_branch_count` BETWEEN ".Input::get("value1")." AND ".Input::get("value2");	
			}
			}
			//die($condition);
            if(!empty($selecteduser)){
              $condition .= " and user_id = $selecteduser";
            }
            if(!empty($leadfrom)){
              $condition .= " and leadfrom = $leadfrom";
            }
            if(!empty($lead_status)){
              $condition .= " and lead_status_id = $lead_status";
            }
			$condition .= " and status=1";
            $condition = ltrim($condition," and ");
			//die($condition);
            $leads = Lead::all(['conditions'=>$condition]);
            $users = Subadmin::all(['status'=>1]);
			$business_lines = Businessline::all(['status'=>1]);
			if($rom_branch_counts=='single')
			{
            $this->app->views("user/lead-filter-page",['users' => $users, 'lead_status'=>$lead_status, 'leads' => $leads, 'business_lines' => $business_lines, 'businesslines' => $businesslines, 'rom_branch_count'=>$rom_branch_counts, 'value_type'=>$rom_branch_counts, 'query'=>$query, 'value1'=>Input::get("value1"), 'lead_from'=>$leadfrom]);
			}
			else
			{
			$this->app->views("user/lead-filter-page",['users' => $users, 'lead_status'=>$lead_status, 'leads' => $leads, 'business_lines' => $business_lines, 'businesslines' => $businesslines, 'rom_branch_count'=>$rom_branch_counts, 'value_type'=>$rom_branch_counts, 'query'=>$query, 'value1'=>Input::get("value1"), 'value2'=>Input::get("value2"), 'lead_from'=>$leadfrom]);	
			}

      }

  }else{
      textMsg("somethis went wrong try again ","error");
      Redirect::url("user/leadFiltaration");
      exit;

  }
}

public function unsubscribe()
{
mail('naveen@markuplounge.com', 'unsubscribe', '');	
$this->app->views('user/unsubscribe');
}




// Campaign & Emailer

public function emailer()
{

isUserLogin();
$this->app->views("user/bulkemail");

}

public function newsletterList()
{
	 isUserLogin();
	$list=Newsletter::all(['status'=>1]);
    $this->app->views("user/newsletters",(['list'=>$list]));
}

public function viewNewsletter($id){
     isUserLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/newsletterList/");
        exit;
    }else{

        $newsletters = Newsletter::all(['id'=>$id]);
        
        if(count($newsletters)>0){

        $this->app->views("user/viewnewsletter",(['data'=>$newsletters[0]]));

        }
		else{

            textMsg("Invaild lead try again","error");
            Redirect::url("user/newsletterList/");
            exit;

        }

    }
}


public function emaileditor($id)
{
	isUserLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/newsletterList/");
        exit;
    }else{

        $newsletters = Newsletter::all(['id'=>$id]);
        
        if(count($newsletters)>0){

        $this->app->views("user/editNewsletter",(['data'=>$newsletters[0]]));

        }
		else{

            textMsg("Invaild lead try again","error");
            Redirect::url("user/newsletterList/");
            exit;

        }

    }
}

public function savenewsletter()
{
$code = $_POST['id1'];
$name = $_POST['template_name'];
$newsletter=new Newsletter();
$newsletter->name=$name;
$newsletter->code=$code;
$newsletter->dates= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
$newsletter->save();
Redirect::url('/administrator/newsletterList');
//$this->app->views("administrator/insertcode");	
}




public function updatenewsletter()
{
$code = $_POST['id1'];
$name = $_POST['template_name'];
$id= $_POST['id'];
$newsletter = Newsletter::all(['id'=>$id]);
$newsletter[0]->code=$code;
$newsletter[0]->dates= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
$newsletter[0]->save();
Redirect::url('/user/newsletterList');
}


public function deleteNewsletter($id)
{
isUserLogin();
if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/newsletterList/");
        exit;
}
else
{
	$newsletter = Newsletter::all(['id'=>$id]);
	if(count($newsletter)>0)
{
	$newsletter[0]->delete();
	Redirect::url("user/newsletterList/");	
}
else
{
	textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/newsletterList/");
        exit;
}
}
}






public function showCampaignList()
{
 isUserLogin();
 $opened=array();
 $not_opened=array();
 $clicked=array();
 $template_id= array();
 $template_name=array();
 $list=Email::find_by_sql("SELECT * from emails group by campaign order by id");
 foreach ($list as $list1)
 {
 $open=count(Email::find_by_sql("SELECT * from emails where campaign='".$list1->campaign."' AND status='opened'"));
 $not_open=count(Email::find_by_sql("SELECT * from emails where campaign='".$list1->campaign."' AND status='not opened'"));
 $click=count(Email::find_by_sql("SELECT * from emails where campaign='".$list1->campaign."' AND status='clicked'"));
 $temp_id = Newsletter::find_by_sql("SELECT * from newsletters");
 //echo $temp_id[0]->id.'<br/>';
 //array_push($template_id, $temp_id[0]->id);
 array_push($opened, $open);
 array_push($not_opened, $not_open);
 array_push($clicked, $click);
 }
 
$this->app->views("user/campaign",(['list'=>$list, 'opened'=>$opened, 'not_opened'=>$not_opened, 'clicked'=>$clicked, 'temp_id'=>$temp_id])); 
		
}




public function showCampaign($campaign)
{
$space_remove = str_replace('_', ' ', $campaign);
isUserLogin();
 $list=Email::all(['campaign'=>$space_remove]);
if($campaign == null)
{
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("user/campaign/");
        exit;
}
else
{
$this->app->views("user/showCampaign",(['list'=>$list]));	
}
}




public function emailSend()
{
 $list = Newsletter::all();
 $status = Leadstatu::find_by_sql("SELECT DISTINCT name FROM leadstatus");
 $types= Leadstype::find_by_sql("SELECT * FROM leadstypes");
 $this->app->views("user/emailSend", (['list'=>$list, 'status'=>$status, 'types'=>$types]));	
}

public function emailSend1()
{
//header('Content-Type: text/plain; charset=utf-8');
$header = "From:noreply@brokerdealerforsale.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type:text/html;charset=UTF-8";
$subject = Input::get("email_subject");
$campaign1 = Input::get("campaign");
$campaign = str_replace('_', ' ', $campaign1);
//$to = Input::get("receiver_email");
$template = Input::get("template");
$status= Input::get("status");
$type= Input::get("type");
$id= Leadstatu::all(['lead_type_id'=>$type, 'name'=>$status]);
$msg1 = Input::get('email_body');
//$msg2 = strip_tags($msg1);
foreach($id as $ids)
{
//die('ttttttt=><pre>'.$ids->id.'</pre>');
$leads = Lead::all(['lead_status_id'=>$ids->id]);
}

foreach ($leads as $lead)
{
$track_code = md5(rand());
$link = '<div style="width:100%; margin:0 auto; max-width:100px; text-align:center; background:#1ed7d1; padding:10px 15px;"><a  style=" color:#fff; text-decoration:none; font-weight:bold;"href="http://bdforsale.com/administrator/emailclick?code='.$track_code.'">Click Here</a></div>';
$msg2=str_replace('|F_NAME|',$lead->ceo_name,$msg1);
$msg=str_replace('|LINK_CLICK|',$link,$msg2);
$msg .= '<img src="http://bdforsale.com/administrator/emailtrack?code='.$track_code.'" width="1" height="1"/>';
//$msg .= '<br/><a href="http://localhost/bdforsale.com/administrator/emailtrack?code='.$track_code.'">testing</a>';
//die($msg);
$to = $lead->ceo_email;
//echo $to.'<br>';
if(mail($to, $subject, $msg, $header))
{	
$emails = new Email();
$emails->campaign=$campaign;
$emails->template=$template;
$emails->subject= $subject;
$emails->date_= date('y-m-d'); 
$emails->msg= $msg;
$emails->email_id=$to;
$emails->ceo_name=$lead->ceo_name;
$emails->track_code=$track_code;
$emails->status="not opened";
$emails->save();
//echo "email sent";
}
else
{
echo "email not sent";	
}
//echo $lead->ceo_email.'<br/>';
}
Redirect::url("user/emailSend?msg=Emailer Sent Successfully");
exit;
//die('test'.Input::get('email_body'));

}





public function emailtrack()
{
date_default_timezone_set("Asia/Kolkata");
if(isset($_GET['code']))
{
$code=$_GET['code'];
$email=Email::all(['track_code'=>$code]);
$email[0]->subject= $email[0]->subject;						
$email[0]->msg= $email[0]->msg;
$email[0]->email_id=$email[0]->email_id;
$email[0]->track_code=$email[0]->track_code;
$email[0]->status="opened";
$email[0]->open_datetime= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
$email[0]->save();	
}	
}


public function emailclick()
{
date_default_timezone_set("Asia/Kolkata");
if(isset($_GET['code']))
{
$code=$_GET['code'];
$email=Email::all(['track_code'=>$code]);
$email[0]->subject= $email[0]->subject;						
$email[0]->msg= $email[0]->msg;
$email[0]->email_id=$email[0]->email_id;
$email[0]->track_code=$email[0]->track_code;
$email[0]->status="clicked";
$email[0]->open_datetime= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
$email[0]->save();
echo '<meta http-equiv="refresh" content="0;url=http://brokerdealerforsale.com">';
}	
}

public function getCount()
{
$tt = leadstatu::find_by_sql("SELECT id from leadstatus where lead_type_id='".$_POST['type']."' AND name='".$_POST['status']."'");
$count=count(lead::find_by_sql("SELECT * from leads where lead_status_id=".$tt[0]->id));

echo $count;

}

public function followups()
{
//die('dd');
$user_id = Session::get('userId');
//die('test'.$user_id);
$today = strtotime('today');
$list_today = Followup::find_by_sql("SELECT * from followups where reminder_date LIKE '".$today."' AND user_id=".$user_id);

$list_prev = Followup::find_by_sql("SELECT * from followups where reminder_date < '".$today."' AND user_id=".$user_id);
$list_future = Followup::find_by_sql("SELECT * from followups where reminder_date > '".$today."' AND user_id=".$user_id);
//echo strtotime('today');
//die('test');
$this->app->views("user/showFollowups", (['list_today'=>$list_today, 'list_prev'=>$list_prev, 'list_future'=>$list_future]));		
}











public function sendFilterCampaign()
{
//isAdminLogin();
//print_r($_POST['emails']);
$tst = explode(',',$_POST['emails'][0]);
$count = count($tst);
//die(print_r($tst));
 $list = Newsletter::all();
 $this->app->views("user/emailSendFilter", (['list'=>$list, 'count'=>$count, 'emails'=>$_POST['emails'][0]]));
}





public function sendLeadFilterCampaign()
{

    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions


    {
        $email = new PHPMailer(true);
        //Server settings
        //$email->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $email->isSMTP();                                            // Send using SMTP
        $email->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $email->SMTPAuth   = true;                                   // Enable SMTP authentication
        $email->Username   = 'neil@bdforsale.com';                     // SMTP username
        $email->Password   = 'CXG@2020@';                               // SMTP password
        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $email->Port       = 587; 
        $email->SMTPKeepAlive = true;                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients

        $email->isHTML(true);

        // $mail=new Email();    
        $header .= "Content-type:text/html;charset=UTF-8";                            // Set email format to HTML
        $email->Subject = Input::get("email_subject");
        $subject = Input::get("email_subject");
        $campaign1 = Input::get("campaign");
        $campaign = str_replace('_', ' ', $campaign1);
        //$to = Input::get("receiver_email");
        $template = Input::get("template");

        $template = str_replace(' ', '', $template);

        $msg1 = Input::get('email_body');
        //$msg2 = strip_tags($msg1);
        $tst = explode(',', $_POST['emails']);
        
        foreach ($tst as $lead) {

            //die($_POST['emails']);
            //$dd = "SELECT * from leads where ceo_email LIKE '".$lead."'";
            //die(print_r($dd));
            $tt = Lead::find_by_sql("SELECT * from leads where ceo_email  LIKE '" . $lead . "'");
            //die(print_r($tt[0]->ceo_email));
            $track_code = md5(rand());
            $link = '<div style="width:100%; margin:0 auto; max-width:100px; text-align:center; background:#1ed7d1; padding:10px 15px;"><a  style=" color:#fff; text-decoration:none; font-weight:bold;"href="http://bdforsale.com//administrator/emailclick?code=' . $track_code . '">Click Here</a></div>';
            //$msg2=str_replace('|F_NAME|',$tt[0]->ceo_name,$msg1);
            $rp_ceo = explode(' ', $tt[0]->ceo_name);
            $msg2 = str_replace('|F_NAME|', $rp_ceo[0], $msg1);
            $msg = str_replace('|LINK_CLICK|', $link, $msg2);
            $msg .= '<img src="http://bdforsale.com/administrator/emailtrack?code=' . $track_code . '" width="1" height="1" />';
            //$msg .= '<br/><a href="http://localhost/bdforsale.com/administrator/emailtrack?code='.$track_code.'">testing</a>';
            //die($msg);
            $to = $tt[0]->ceo_email;
            $to1=$tt[0]->ceo_name;
            $users = [
                ['email' => $to, 'name' => $to1],
                
          
              ];
            if($header)
            {
                foreach ($users as $user) {	

            $email->setFrom('neil@brokerdealerforsale.com', 'Neil Delaney');
            $email->addAddress($to);     // Add a recipient
            
            $email->Body    = $msg;
            $email->date_ = date('y-m-d');
            $email->email_id = $to;
            $email->campaign = $campaign;
            $email->template = $template;
            $email->AltBody = $track_code;
            $email->status = "not opened";


            //$subject = "Bdforsale Inquiry";
            // $mail->$to1 = ($lead->ceo_name, $to);
            $email->isHTML(true);

            try {
                $email->send();
                echo "Message sent to: ({$user['email']}) {$email->ErrorInfo}\n";
            } catch (Exception $e) {
                echo "Mailer Error ({$user['email']}) {$email->ErrorInfo}\n";
            }
          
            $email->clearAddresses();
        } 
            echo '<script>window.location.href="http://bdforsale.com/user/leadFiltaration?msg=Emailer Sent Successfully"</script>';
            
            
            $emails = new Email();
            $emails->campaign = $campaign;
            $emails->template = $template;
            $emails->subject = $subject;
            $emails->date_ = date('y-m-d');
            $emails->msg = $msg;
            $emails->email_id = $to;
            $emails->ceo_name = $tt[0]->ceo_name;
            $emails->track_code = $track_code;
            $emails->status = "not opened";
            $emails->save();
            echo 'Message has been sent';
            echo '<meta http-equiv="refresh" content="0;url=http://bdforsale.com/user/leadFiltaration?msg=Emailer Sent Successfully">';
       
    }
        else
        {
        echo "email not sent";	
        }
    }
        
    }
}







public function sendLeadFilterCampaignOld()
{
require("sendgrid-php/sendgrid-php.php");
//header('Content-Type: text/plain; charset=utf-8');
$header = "From:chris@brokerdealerforsale.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type:text/html;charset=UTF-8";
$subject = Input::get("email_subject");
$campaign1 = Input::get("campaign");
$campaign = str_replace('_', ' ', $campaign1);
//$to = Input::get("receiver_email");
$template = Input::get("template");

$template=str_replace(' ','',$template);
//die ($template);
//die('test=>'.$template);
$msg1 = Input::get('email_body');
//$msg2 = strip_tags($msg1);
$tst = explode(',',$_POST['emails']);
foreach ($tst as $lead)
{
//die($_POST['emails']);
//$dd = "SELECT * from leads where ceo_email LIKE '".$lead."'";
//die(print_r($dd));
$tt = Lead::find_by_sql("SELECT * from leads where ceo_email LIKE '".$lead."'");
//die(print_r($tt[0]->ceo_email));
$track_code = md5(rand());
$link = '<div style="width:100%; margin:0 auto; max-width:100px; text-align:center; background:#1ed7d1; padding:10px 15px;"><a  style=" color:#fff; text-decoration:none; font-weight:bold;"href="http://bdforsale.com/administrator/emailclick?code='.$track_code.'">Click Here</a></div>';
$rp_ceo = explode(' ',$tt[0]->ceo_name);
$msg2=str_replace('|F_NAME|',$rp_ceo[0],$msg1);
//$msg2=str_replace('|F_NAME|',$tt[0]->ceo_name,$msg1);
$msg=str_replace('|LINK_CLICK|',$link,$msg2);
$msg .= '<img src="http://bdforsale.com/administrator/emailtrack?code='.$track_code.'" width="1" height="1"/>';
//$msg .= '<br/><a href="http://localhost/bdforsale.com/administrator/emailtrack?code='.$track_code.'">testing</a>';
//die($msg);
$to = $tt[0]->ceo_email;
//echo $to.'<br>';
if($header)
{	
$from = new SendGrid\Email("Chris", "neil@brokerdealerforsale.com");
//$subject = "Bdforsale Inquiry";
$to1 = new SendGrid\Email("Elmer", $to);
$content = new SendGrid\Content("text/html", $msg);
$mail = new SendGrid\Mail($from, $subject, $to1, $content);
$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
$emails = new Email();
$emails->campaign=$campaign;
$emails->template=$template;
$emails->subject= $subject;
$emails->date_= date('y-m-d'); 
$emails->msg= $msg;
$emails->email_id=$to;
$emails->ceo_name=$tt[0]->ceo_name;
$emails->track_code=$track_code;
$emails->status="not opened";
$emails->save();
//echo "email sent";
}
else
{
echo "email not sent";	
}
//echo $lead->ceo_email.'<br/>';
}
//die('done');
Redirect::url("user/leadFiltaration?msg=Emailer Sent Successfully");
exit;
//die('test'.Input::get('email_body'));	
}









public function leadstatus($leadstype,$leadstatus='',$leadsubstatus='')
{
    $leadstatus = str_replace("_"," ",$leadstatus);
    $leadsubstatus = str_replace("_"," ",$leadsubstatus);
	//die('tst'.$leadstatus);
    isUserLogin();
    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("user/lead_by_status",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'leadcurrentsubstatus'=>$leadsubstatus, 'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("/user");
        exit;

    }
}





public function leadsubstatus($leadstype,$leadstatus='',$leadsubstatus='', $leadsubsubstatus='')
{
    $leadstatus = str_replace("_"," ",$leadstatus);
    $leadsubstatus = str_replace("_"," ",$leadsubstatus);
	$leadsubsubstatus = str_replace("_"," ",$leadsubsubstatus);
	//die('tst'.$leadstatus);
    isUserLogin();
    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("user/lead_by_substatus",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'leadcurrentsubstatus'=>$leadsubstatus, 'leadcurrentsubsubstatus'=>$leadsubsubstatus, 'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("/user");
        exit;

    }
}


public function updateLead1()
{
$id = Input::get('leadid');
$leadfrom = Input::get('leadfrom');
$lead_status =  Input::get('lead_status');
$lead_substatus =   Input::get('lead_substatus');
$lead_subsubstatus =    Input::get('lead_subsubstatus');
$leads = Lead::all(['id'=>$id]);
	$uid = Session::get('userId');
if($leads[0]->leadfrom!=$leadfrom)
{
$v1 = Leadstype::all(['id'=>$leads[0]->leadfrom]);
$v2 = Leadstype::all(['id'=>$leadfrom]);	
$msg = "Lead Type Changed from ".$v1[0]->name." to ".$v2[0]->name;
                    createLog($uid, $uid, $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}
	
if($leads[0]->lead_status_id!=$lead_status)
{
$v11 = Leadstatu::all(['id'=>$leads[0]->lead_status_id]);
$v21 = Leadstatu::all(['id'=>$lead_status]);
$msg = "Lead Status Changed from ".$v11[0]->name." to ".$v21[0]->name;
                    createLog($uid, $uid, $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}	
	
if($leads[0]->lead_substatus_id!=$lead_substatus)
{
$v111 = Leadsubstatu::all(['id'=>$leads[0]->lead_substatus_id]);
$v211 = Leadsubstatu::all(['id'=>$lead_substatus]);
$msg = "Lead Sub-Status Changed from ".$v111[0]->name." to ".$v211[0]->name;
                    createLog($uid, $uid, $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}







//die('test');

if($leads[0]->leadfrom!=$leadfrom || $leads[0]->lead_status_id!=$lead_status ||  $leads[0]->lead_substatus_id!=$lead_substatus || $leads[0]->lead_subsubstatus_id!=$lead_subsubstatus)
{
$statuslog = new Statuslog();
$statuslog->leadid = $id;
$statuslog->prev_type = $leads[0]->leadfrom;
$statuslog->new_type = $leadfrom;
$statuslog->prev_status = $leads[0]->lead_status_id;
$statuslog->new_status = $lead_status;
$statuslog->prev_substatus = $leads[0]->lead_substatus_id;
$statuslog->new_substatus = $lead_substatus;
$statuslog->prev_subsubstatus = $leads[0]->lead_subsubstatus_id;
$statuslog->new_subsubstatus = $lead_subsubstatus;
$statuslog->changed_by = $uid;
$statuslog->date = strtotime(date('y-m-d'));
$statuslog->save();
	
}









	
if($leads[0]->lead_subsubstatus_id!=$lead_subsubstatus)
{
$v1111 = Leadsubsubstatu::all(['id'=>$leads[0]->lead_subsubstatus_id]);
$v2111 = Leadsubsubstatu::all(['id'=>$lead_subsubstatus]);
$msg = "Lead Sub-Substatus Changed from ".$v1111[0]->name." to ".$v2111[0]->name;
                    createLog($uid, $uid, $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}	
	

              $leads[0]->leadfrom = $leadfrom;
              $leads[0]->lead_status_id = $lead_status;
              $leads[0]->lead_substatus_id = $lead_substatus;
              $leads[0]->lead_subsubstatus_id = $lead_subsubstatus;

             if($leads[0]->save())
             {
            Redirect::url("/user/viewLead/".$id);    
             }
else
{
echo "error"    ;
}
}









public function suggestEdits()
{
//die('test=>'.Input::get('fields'));    
$leadid = Input::get('leadid');

$crd = Input::get('crd');
$fields = Input::get('fields');
$ff = implode(',',$fields);
$remarks =	Input::get('remarks');
//die($remarks);
$useredit = new Useredit();	
$useredit->leadid = $leadid;
$useredit->crd = $crd;
$useredit->fields = $ff;
$useredit->remarks = $remarks;
$useredit->date = date('d-m-Y');
$useredit->status = 0;
$useredit->user_id = Input::get('user_id');
$useredit->save();
Redirect::url("/user/viewLead/".$leadid);
}








public function followMarkComplete($id)
{
$edit = Followup::all(['id'=>$id]);
if($edit[0]->repeat_in!=0)
{

$datee = date('Y-m-d',$edit[0]->reminder_date);
$duration = date('Y-m-d', strtotime($datee. ' + '.$edit[0]->repeat_in.' '.$edit[0]->duration));
//die('old=>'.$datee.'new=>'.$duration); 
$dur = strtotime($duration);
//die('test=>'.$dur);


$edit[0]->reminder_date = $dur;
$edit[0]->save();	
}
else
{
$edit[0]->status = 1;
$edit[0]->save();
}
Redirect::url("/user");	
}












public function editRequests()
{
    //die('test=>'.Session::get('userId'));
$useredits = Useredit::all(['user_id'=>Session::get('userId')]);
$this->app->views("user/editRequests",(['useredits'=>$useredits]));    
}




public function deleteFollowup($id)
{

$follows = Followup::all(['id'=>$id]);
//die(print_r($follows->id));
$follows[0]->delete();
return header('Location:'.BASEURL.'/user/followups');  
}

public function editFollowup($id)
{
$data = Followup::all(['id'=>$id]);
$this->app->views("user/editFollowup",(['data'=>$data]));
}

public function updateFollowup()
{
//die('test'.strtotime(Input::get('reminder_date')));
//die(input::get('leadid'));
$edit = Followup::all(['id'=>Input::get('id')]);
$edit[0]->leadid = Input::get('leadid');
$edit[0]->msg = Input::get('msg');
$edit[0]->user_id = implode(',',Input::get("user"));
$edit[0]->priority = Input::get('priority');
$edit[0]->reminder_date = strtotime(Input::get('reminder_date'));
$followup->assigned_by = Input::get('assigned_by');
$edit[0]->save();   
Redirect::url("/user/"); 
}










//assignUserLead
public function assignUserLead(){

    isUserLogin();

    if(!Input::exists("id") && !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{

        $id = Input::get("id");

        $leadid = Input::get("leadid");

        $leads = Lead::all(['id' => $leadid]);
        if(count($leads) > 0){
            if($id != 0){

                $subadmins = Subadmin::all(['id'=>$id]);
                if(count($subadmins) < 1){
                    echo  json_encode(['result' => "Something went wrong try again"]);
                    exit;
                }
            }
            $leads[0]->user_id = $id;
            if($leads[0]->save()){
                echo  json_encode(['result' => "success"]);

            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }else{
            echo  json_encode(['result' => "Something went wrong try again"]);
        }


    }

}









public function replyEdits()
{
$data = Useredit::all(['id' => Input::get('id')]);
$data[0]->reply = Input::get('reply');
$data[0]->save();
Redirect::url("user/editRequests/");	

	
}









public function lookUp()
{
$this->app->views("user/lookUp");	
}









public function getLeadViaEmail() {



        if(!Input::exists("email")){
            echo json_encode(['result' => "Required correct email to do this action."]);
            exit;

        }else{
            $email = Input::get("email");
            $lead= Lead::all(['ceo_email'=>$email]);
			
			
            if(count($lead) > 0){
                
				
                echo json_encode(['result'=>"success",'lead'=>$lead[0]->firm_name,'id'=>$lead[0]->id]);
            }else{
                echo json_encode(['result' => "Lead not available for this email",'lead'=>'Lead not available for this email']);
                exit;
            }

        }

    }





















public function requestAccess($id)
{
$lead= Lead::all(['id'=>$id]);
$this->app->views("user/requestAccess",(['lead'=>$lead]));	
}


public function requestAccessSave()
{
$leadid = Input::get('leadid');

$crd = Input::get('crd');

$comments =	Input::get('comments');
//die($remarks);
$useredit = new Access();	
$useredit->leadid = $leadid;
$useredit->crd = $crd;
$useredit->comments = $comments;
$useredit->date = date('d-m-Y');
$useredit->status = 0;
$useredit->user_id = Input::get('user_id');
$useredit->save();
//Redirect::url("/user/viewLead/".$leadid);
echo "done";	
}




public function accessRequests()
{
$access = Access::all(['user_id'=>$_COOKIE['userId']]);
//die('tt=>'.$_COOKIE['userId']);
$this->app->views("user/accessRequests",(['access'=>$access]));		
}







}// main function
