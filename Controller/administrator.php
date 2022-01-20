<?php

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class administrator{

    public $app;

	public function __construct(){

		$this->app = new View;
	}

public function index() {
    if(Session::exists("adminId")){
        Redirect::url("administrator/dashboard");
        exit;
    }else{
        $this->app->views("administrator/index");
    }
}

//admin login
public function adminSingIn(){

    if(Session::exists('adminId')){
        Redirect::url("administrator/dashboard");
        exit;
    }

        if(Input::exists("email") && Input::exists("pass")){

            $email = Input::get("email");
            $pass = Input::get("pass");
            $admins  = Admin::all(['email' => $email]);

              if(count($admins) < 1) {

                    textMsg("Invalid username and password.","error");
                    Redirect::url("administrator/index");
                    exit;

              }

            if($admins[0]->status == 1){
                if(Pass::verify($admins[0]->pass,$pass)){
                    Session::put("adminId",$admins[0]->id);
                    Session::put("adminEmail",$admins[0]->email);
                    Session::put("adminName",$admins[0]->name);
					setcookie('adminName', $admins[0]->name, time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('adminEmail', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('adminId', $admins[0]->id, time() + (86400 * 30), "/"); // 86400 = 1 day
                    textMsg("Login Successfully.","success");
                    Redirect::url("administrator/dashboard");
                    exit;

                }else{
                    textMsg("Password din not match try again.","error");
                    Redirect::url("administrator/index");
                    exit;
                }
            }else{
                    textMsg("Invalid username and password.","error");
                    Redirect::url("administrator/index");
                    exit;
            }

     }
}
//admin logout
public function adminLogout(){
	setcookie('adminName', '', time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('adminEmail', '', time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie('adminId', '', time() + (86400 * 30), "/"); // 86400 = 1 day
                    
	unset($_SESSION['adminId']);
	unset($_SESSION['adminEmail']);
	unset($_SESSION['adminName']);
	textMsg("Logout Success","success");
    Redirect::url("administrator/index");
    exit;
}
// Dashboard
public function dashboard(){
    isAdminLogin();
    $today = strtotime(date('y-m-d'));
    $leads = Lead::all(['status'=>1]);
    $tomorrow = $today+86400;
    $notifications = Notification::all(['conditions'=>"id < 21 and notifyto = 0 order by date desc limit 5"]);
    $reminders = Followup::all(['conditions' => "reminder_date >=  $today and reminder_date < $tomorrow order by date DESC"]);
    $reminders1 = Followup::all(['conditions'=>"reminder_date < $today order by date DESC"]);
	$reminders2 = Followup::all(['conditions'=>"reminder_date >=  $today and reminder_date < $tomorrow and assigned_by=".Session::get('adminId')." order by date DESC"]);
	$reminders3 = Followup::all(['conditions'=>"repeat_in!=0 and duration!='' and reminder_date >=  $today and reminder_date < $tomorrow and assigned_by=".Session::get('adminId')]);
    $this->app->views("administrator/dashboard",['notifications' => $notifications,'reminders3'=>$reminders3, 'reminders' => $reminders,'reminders1' => $reminders1,'reminders2' => $reminders2, 'leads' => $leads]);
}
//setting
public function setting(){
		isAdminLogin();
        $id = Session::get('adminId');
        $admins = Admin::all(['id'=>$id]);
        $this->app->views("administrator/setting",(['admins' => $admins[0]]));
}
//admin password
public function changePass(){
    isAdminLogin();
    if(Input::exists("pass") || Input::exists("cpass") || Input::exists("adminId")){
        $pass = Input::get("pass");
        $id = Input::get("adminId");
        $cpass = Input::get("cpass");

        if(empty($pass) || empty($cpass)){
            textMsg("Required fields are empty.","error");
            Redirect::url("administrator/setting");
            exit;
        }else{
             if($pass == $cpass){
              $admins = Admin::find($_SESSION['adminId']);
              $check = Pass::verify($admins->pass,$pass);

             if($admins->save()){
                createNotification(0,0,"Admin Password Changed");
                textMsg("password has been updated.","success");
                Redirect::url("administrator/setting");
                exit;
            }else{
                textMsg("Something went wrong try again.","error");
                Redirect::url("administrator/setting");
                exit;
            }
        }else{
                textMsg("Confirm password did not match.","error");
                Redirect::url("administrator/setting");
                exit;
        }

       }

      }else{
        textMsg("Something went wrong try again.","error");
        Redirect::url("administrator/setting");
        exit;
      }

}

//admin information
public function updateinfo(){
    isAdminLogin();
if(Input::exists("name")||Input::exists("mob")||Input::exists("email") || Input::exists("adminId")){

        $name = Input::get("name");
        $mob = Input::get("mob");
        $id = Input::get("adminId");
        $email = Input::get("email");


    if(empty($name)|| empty($mob)|| empty($email)|| empty($id)){
            textMsg("Required fields are empty.","error");
            Redirect::url("administrator/setting");
            exit;
        }else{

              $id = Session::get('adminId');
              $admins = Admin::all(['id'=>$id]);
              $admins[0]->name = $name;
              $admins[0]->mobile = $mob;
              $admins[0]->email = $email;

             if($admins[0]->save()){
                createNotification(0,0,"Admin Update Information");
                textMsg("Information has been updated.","success");
                Redirect::url("administrator/setting");
                exit;
            }else{
                textMsg("Something went wrong try again.","error");
                Redirect::url("administrator/setting");
                exit;
            }

        }

      }else{
        textMsg("Something went wrong try again.","error");
        Redirect::url("administrator/setting");
        exit;
      }

}




// All Users
public function users(){
    isAdminLogin();
    $users = Subadmin::all(['status'=>1]);
    $this->app->views("administrator/users",(['users'=>$users]));

}
// add New  Users
public function addNewUser(){
    isAdminLogin();
    $this->app->views("administrator/addNewUser");

}
//add Users
public function addUser(){
        isAdminLogin();

        if(Input::exists("token") && Input::exists("name") && Input::exists("mob") && Input::exists("email") && Input::exists("pass") && Input::exists("cpass") && Input::exists("address")&& Input::exists("state")&& Input::exists("city")){

            $key = Input::get("token");
            $name = Input::get("name");
            $mob = Input::get("mob");
            $email = Input::get("email");
            $pass = Input::get("pass");
            $cpass = Input::get("cpass");
            $address = Input::get("address");
            $state = Input::get("state");
            $city = Input::get("city");



            if(empty($key) || empty($name) || empty($mob) || empty($email) || empty($pass) || empty($cpass)){

                  textMsg("All fields are required","error");
                  Redirect::url("administrator/addNewUser");
                  exit;
            }else{
                    if($pass != $cpass){
                        textMsg("Confirm password did not match.","error");
                        Redirect::url("administrator/addNewUser");
                        exit;
                    }
                    $users = Subadmin::all(['email' =>$email]);
                    if(count($users)>0){
                        textMsg("This email already exists try again","error");
                        Redirect::url("administrator/addNewUser");
                        exit;

                    }
                    $users = Subadmin::all(['mobile' =>$mob]);
                    if(count($users)>0){
                        textMsg("This mobile already exists try again","error");
                        Redirect::url("administrator/addNewUser");
                        exit;

                    }

                    $users = new Subadmin();
				    $users->name = $name;
				    $users->mobile = $mob;
				    $users->email = $email;
				    $users->pass = Pass::hash($pass);
                    $users->address = $address;
				    $users->city = $city;
				    $users->states = $state;
				    $users->status = 1;
					$users->role = Input::get("role");
				    $users->date = time();

                    if(isset($_FILES['photo'])){
                        $path = uploads($_FILES['photo']);
                        if($path[1] == "success"){
                            $users->photo = $path[0];
                        }
                    }

                if($users->save()){
                    createNotification(0,0,"Admin Create New User ".$users->name);
                    createNotification(0,$users->id,"Admin Create Your Profile");
                    $to = "$email";
                    $subject = "Welcome To CRM";
                    $header = "MIME-Version: 1.0\r\n";
                    $header .= "From: Pollux Global: <no-reply@polluxglobal.com> \r\n";
                    $header .= "Content-Type:text/html; charset=iso-8859-1\r\n";
                    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                    $message = "<table style='width:100%;padding: 2vw;background:#fafafa;text-align:left;'><thead><tr><th colspan='3'><a href='#' target='_blank' style='text-decoration:none;color:#000;font-size:22px;display:inline-block;float:left;margin-bottom:30px;'>CRM Administrator</a></th></tr></thead><tbody><tr><td colspan='3' style='color:#6f6f6f;font-family:Open Sans;font-size:13px;line-height: 22px;margin-top:15px;display:block;margin-bottom:40px;'></td></tr><tr><td style='border-top:1px solid #ddd;margin-top:20px;display:block;padding:10px 0px;overflow:hidden;border-bottom:1px solid #ddd;'><div style='color:#404040;text-align: center;font-size:15px;font-weight:600;font-family:Open Sans;'>Help & Support<ul style='list-style-type: none;margin: 0px;padding: 0px; overflow:hidden; margin-top: 10px;'><li style='overflow: hidden;font-weight:100;margin-right: 20px;display:inline-block;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.polluxglobal.com/crm/assets/mobile.png' style='float:left;height: 16px;margin-right: 10px;'> +91 00000 00000</li><li style='overflow: hidden;display: inline-block;font-weight:100;margin-right: 20px;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.polluxglobal.com/crm/assets/email.png' style='float:left;height: 16px;margin-right: 10px;'> no-reply@polluxglobal.com</li></ul></div></td></tr></tbody></table>";


                    $sentOk = sendMail($to,$subject,$message,$header);
                    if($sentOk){

                        textMsg("New User added succesfully","success");
                        Redirect::url("administrator/users/");
                        exit;
                    }else{
                        textMsg("somethis went wrong try again","error");
                        Redirect::url("administrator/addNewUser");
                        exit;

                    }


                }else{
                        textMsg("somethis went wrong try again","error");
                        Redirect::url("administrator/addNewUser");
                        exit;

                }


            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/addNewUser");
        exit;

    }
}
//profile
public function profile($id){
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/users/");
        exit;
    }else{

        $users = Subadmin::all(['id'=>$id]);
        if(count($users)>0){

            $this->app->views("administrator/profile",(['users'=>$users[0]]));

        }else{

            textMsg("Invaild users try again","error");
            Redirect::url("administrator/users/");
            exit;

        }


    }
}
//edit User
public function editUser($id){
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/users/");
        exit;
    }else{

        $users = Subadmin::all(['id'=>$id]);
        if(count($users)>0){

            $this->app->views("administrator/editUser",(['data'=>$users[0]]));

        }else{

            textMsg("Invaild users try again","error");
            Redirect::url("administrator/users/");
            exit;

        }


    }
}
 //update user
public function updateUser(){
        isAdminLogin();

        if(Input::exists("id") && Input::exists("token") && Input::exists("name") && Input::exists("mob") && Input::exists("email") && Input::exists("pass") && Input::exists("cpass") && Input::exists("address")&& Input::exists("state")&& Input::exists("city")){

            $key = Input::get("token");
            $id = Input::get("id");
            $name = Input::get("name");
            $mob = Input::get("mob");
            $email = Input::get("email");
            $pass = Input::get("pass");
            $cpass = Input::get("cpass");
            $address = Input::get("address");
            $state = Input::get("state");
            $city = Input::get("city");



            if(empty($key) ||empty($id) || empty($name) || empty($mob) || empty($email) || empty($address) ||  empty($state) || empty($city)){

                  textMsg("All fields are required","error");
                  Redirect::url("administrator/users");
                  exit;
            }else{
                    if($pass != $cpass){
                        textMsg("Confirm password did not match.","error");
                        Redirect::url("administrator/users");
                        exit;
                    }

                    $users = Subadmin::all(['id'=>$id]);
                    $users[0]->name = $name;
        				    $users[0]->mobile = $mob;
        				    $users[0]->email = $email;
        				    $users[0]->address = $address;
        				    $users[0]->city = $city;
        				    $users[0]->states = $state;

                    if(!empty($pass)){
                         $users[0]->pass = Pass::hash($pass);
                    }

                    if(isset($_FILES['photo'])){
                        $path = uploads($_FILES['photo']);
                        if($path[1] == "success"){
                            $users[0]->photo = $path[0];
                        }
                    }

                if($users[0]->save()){

                        createNotification(0,0,"Admin Update ".$users[0]->name." Profile");
                        createNotification(0,$users[0]->id,"Admin Update Your Profile");
                        textMsg("User update succesfully","success");
                        Redirect::url("administrator/users/");
                        exit;

                }else{
                        textMsg("somethis went wrong try again","error");
                        Redirect::url("administrator/users");
                        exit;

                }


            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/addNewUser");
        exit;

    }
}



//deleteUser
public function deleteUser(){

    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");

	  if($id == 0 ){
	    echo  json_encode(['result' => "Something went wrong try again"]);
	   exit;
	  }
       $users = Subadmin::all(['id' => $id]);

        if(count($users) > 0){
			$leads = Lead::all(['user_id'=>$id]);

			if(count($leads) <= 0){
                $name = $users[0]->name;
				if($users[0]->delete()){
                    createNotification(0,0,"Admin Deleted ".$name." Profile");
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
			}else{

				echo  json_encode(['result' => "Lead Assigned to this User"]);

			}

        }
    }

}



// // industries
// public function allIndustries(){
//     isAdminLogin();
//     $industries = Industry::all(['status'=>1]);
//     $this->app->views("administrator/allIndustries",(['industries'=>$industries]));
// }
// //add industries
// public function addIndustries(){
//     isAdminLogin();
//     if(Input::exists("token") && Input::exists("name")){

//             $key = Input::get("token");
//             $name = Input::get("name");

//             if(empty($key) || empty($name)){
//                   textMsg("All fields are required","error");
//                   Redirect::url("administrator/allIndustries");
//                   exit;
//             }else{

//                 $industries = Industry::all(['name' =>$name]);
//                 if(count($industries)>0){
//                         textMsg("This name already exists try again","error");
//                         Redirect::url("administrator/allIndustries");
//                         exit;

//                 }else{

//                     $industries = new Industry();
// 				    $industries->name = $name;
// 				    $industries->date = time();
// 				    $industries->status = 1;

//                     if($industries->save()){

//                             textMsg("New Industry added succesfully","success");
//                             Redirect::url("administrator/allIndustries");
//                             exit;

//                     }else{
//                             textMsg("somethis went wrong try again","error");
//                             Redirect::url("administrator/allIndustries");
//                             exit;

//                     }
//                 }
//             }

//     }else{

//         textMsg("somethis went wrong try again ","error");
//         Redirect::url("administrator/allIndustries");
//         exit;

//     }
// }

// //deleteindtry
// public function deleteindtry(){

//     isAdminLogin();

//     if(!Input::exists("id")){
//         echo  json_encode(['result' => "Required correct id to do this action."]);
// 	    exit;

//     }else{
// 	   $id = Input::get("id");
//        $data = Industry::all(['id' => $id]);
//         if(count($data) > 0){
// 			$leads = Lead::all(['industry_id' => $id]);
// 			if(count($leads) <= 0){
// 				if($data[0]->delete()){
// 					echo  json_encode(['result' => "success"]);
// 				}else{
// 					echo  json_encode(['result' => "Something went wrong try again"]);
// 				}
// 			}else{
// 				echo  json_encode(['result' => "Industry Used in  Lead"]);
// 			}

//         }
//     }

// }


// leads

public function leads(){
    isAdminLogin();
    $this->app->views("administrator/leads");
}








public function description(){
    isAdminLogin();
    $this->app->views("administrator/description");
}






public function loadAllLeads(){
    isAdminLogin();

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
        $condition = "status = 1 and ( Concat (id, firm_name, '', address_1, '', address_2, '', address_3, '', address_4, '', city, '', state, '', zipcode, '', phone, '', firm_crd, '', website, '', new_ceo_name, '', ceo_name, '', ceo_email, '', ceo_number, '', ceo_linkedin, '', ceo_letter_type, '', ceo_crd, '', ceo_finop_name, '', ceo_finop_card, '', cco_name, '', new_cco_name, '', cco_email, '', cco_number, '', cco_linkedin, '', cco_crd, '', cco_state, '', industry_id) like'%".$searchval."%' )";
    }else{
        $condition = " status = 1";
    }

    $i = 1;
    $leads = Lead::find_by_sql("SELECT * FROM leads where ".$condition." limit $start,$length");
    $totalleads = Lead::find_by_sql("SELECT count(*) as totalleads FROM leads where ".$condition);


    foreach($leads as $data){
		
    
//die("SELECT * FROM logs where leadid=".$data->id." limit 1 order by id DESC");
if($data->verify_business==1)
{
$verify_status = 'Verified on '.date('m-d-Y',$data->verify_business_on);	
}
else
{
$verify_status='';	
}

        $logs = Log::find_by_sql("SELECT * FROM logs where leadid=".$data->id." order by id DESC limit 1");
		if(!empty($logs))
		{
		foreach($logs as $ll)
		{
		$last_up = date('d-m-Y',$ll->date);
		$change = $ll->msg;
		}
		}
		else
		{
		$last_up = '';
		$change = '';
		}
        $leadstatus = Leadstatu::all(['id'=>$data->lead_status_id]);
		$leadfrom = Leadstype::all(['id'=>$data->leadfrom]);
		$leadsubstatus = Leadsubstatu::all(['id'=>$data->lead_substatus_id]);
		$leadsubsubstatus = Leadsubsubstatu::all(['id'=>$data->lead_subsubstatus_id]);
        if(count($leadstatus)){
          $leadstatusname = $leadstatus[0]->name;
        }else{
          $leadstatusname = "";
        }
		if(count($leadsubsubstatus)){
          $leadsubsubstatusname = $leadsubsubstatus[0]->name;
        }else{
          $leadsubsubstatusname = "";
        }
		
		if(count($leadsubstatus)){
          $leadsubstatusname = $leadsubstatus[0]->name;
        }else{
          $leadsubstatusname = "";
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
            $assignto,
            '<a href="'.BASEURL.'administrator/viewLead/'.$data->id.'">'.$data->firm_name.'</a>',
$data->firm_crd,
            //$data->new_ceo_name,
            '<a href="'.BASEURL.'administrator/viewLead/'.$data->id.'">'.$data->ceo_name.'</a>',
            $data->ceo_email,
			$leadstatusname,
			$leadsubstatusname,
			$leadsubsubstatusname,
			
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
            //$data->address_3,
            //$data->address_4,
            $data->city,
            $data->state,
            $data->zipcode,
            $data->phone,
            
            $data->website,
            $leadfrom[0]->name,
			$verify_status,
			$last_up,
			$change,
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

public function loadTypeWiseLeads($lead_type,$leadcurrentstatusid = 0, $leadcurrentsubstatusid = 0 ){
    isAdminLogin();
//die('test'.$leadcurrentsubstatusid);
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
        $condition = "status = 1 and ( Concat (id, firm_name, '', address_1, '', address_2, '', address_3, '', address_4, '', city, '', state, '', zipcode, '', phone, '', firm_crd, '', website, '', new_ceo_name, '', ceo_name, '', ceo_email, '', ceo_number, '', ceo_linkedin, '', ceo_letter_type, '', ceo_crd, '', ceo_finop_name, '', ceo_finop_card, '', cco_name, '', new_cco_name, '', cco_email, '', cco_number, '', cco_linkedin, '', cco_crd, '', cco_state, '', industry_id) like'%".$searchval."%' )  and leadfrom = ".$lead_type;
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
    $leads = Lead::find_by_sql("SELECT * FROM leads where ".$condition." limit $start,$length");
    $totalleads = Lead::find_by_sql("SELECT count(*) as totalleads FROM leads where ".$condition);
    $leadsdata = array();

    foreach($leads as $data){


if($data->verify_business==1)
{
$verify_status = 'Verified on '.date('m-d-Y',$data->verify_business_on);	
}
else
{
$verify_status='';	
}


        $leadstatus = Leadstatu::all(['id'=>$data->lead_status_id]);
        $leadfrom = Leadstype::all(['id'=>$data->leadfrom]);
        if(count($leadstatus)){
          $leadstatusname = $leadstatus[0]->name;
        }else{
          $leadstatusname = "";
        }
        $leadlink='<a href="'.BASEURL.'administrator/viewLead/'.$data->id.'/'.$lead_type.'">'.$data->firm_name.'</a>';
        if($leadcurrentstatusid){
          $leadlink='<a href="'.BASEURL.'administrator/viewLead/'.$data->id.'/'.$lead_type.'/'.$leadcurrentstatusid.'">'.$data->firm_name.'</a>';
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
            $assignto,
            $leadlink,
            $data->firm_crd,
            //$data->new_ceo_name,
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
            
            
            $data->address_1,
            $data->address_2,
            
            $data->city,
            $data->state,
            $data->zipcode,
            $data->phone,
            $leadfrom[0]->name,
			$verify_status,
            $data->website,
            
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






// new_lead
public function addNewLead(){
    isAdminLogin();
    $business_lines = Businessline::all(['status'=>1]);	
    $this->app->views("administrator/addNewLead", (['business_lines'=>$business_lines]));

}








//add_lead
public function addlead(){

    isAdminLogin();
    if(Input::exists("token") && Input::exists("firm_name") && Input::exists("address_1") && Input::exists("city") && Input::exists("state") && Input::exists("zipcode") && Input::exists("phone") && Input::exists("firm_crd") && Input::exists("website") && Input::exists("ceo_name") && Input::exists("ceo_email") && Input::exists("lead_status") && Input::exists("leadfrom")  && Input::exists("user") && Input::exists("aboutlead")){

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
        $lead_substatus=Input::get("lead_substatus");
		$lead_subsubstatus=Input::get("lead_subsubstatus");
        $leadfrom = Input::get("leadfrom");
        if(Input::get('bus_type')=='names')
{
	
        $business_lines = Input::get('business_lines');
		
		if($business_lines=='')
		{
	$business_liness='';
		}
		else
		{
        $business_liness = implode(',', $business_lines);
		}
}
else
{
 $business_lines = Input::get('business_lines1');
 if($business_lines=='')
		{
	$business_liness='';
		}
else
{
 $business_liness = implode(',', $business_lines);   
}
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
                  Redirect::url("administrator/addNewLead");
                  exit;
        }else{

            	if(empty($user)){
                	$user = 0;
            	}

                $leads = new Lead();
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
				$leads->lead_substatus_id = $lead_substatus;
				$leads->lead_subsubstatus_id = $lead_subsubstatus;
				$leads->rom_branch_count = $rom_branch_count;
                $leads->date = time();
				$leads->status = 1;

                if($leads->save()){

                    textMsg("New lead added succesfully","success");
                    Redirect::url("administrator/leads");
                    exit;

                }else{
                    textMsg("somethis went wrong try again","error");
                    Redirect::url("administrator/addNewLead");
                    exit;

                }



        }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/addNewLead");
        exit;

    }
}









//view Lead
public function viewLead($id,$leadtype=null,$leadcurrentstatus=null){
     isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/leads/");
        exit;
    }else{

        $leads = Lead::all(['id'=>$id]);
        $leadarticles = LeadArticle::all(['lead_id'=>$id]);
        if(count($leads)>0 && $leads[0]->status==1){

            $this->app->views("administrator/viewLead",(['data'=>$leads[0],'type'=> $leadtype,'leadcurrentstatus' => $leadcurrentstatus,'leadarticles' => $leadarticles]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/leads/");
            exit;

        }

    }
}










//edit Lead
public function editLead($id){
     isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/leads/");
        exit;
    }else{

        $leads = Lead::all(['id'=>$id]);
        if(count($leads)>0 && $leads[0]->status==1){

            $business_lines = Businessline::all(['status'=>1]); 
            $this->app->views("administrator/editLead",(['data'=>$leads[0], 'business_lines'=>$business_lines]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/leads/");
            exit;

        }

    }
}










//updateLead
public function updateLead()
{
    isAdminLogin();
    if(Input::exists("leadid") && Input::exists("firm_name") && Input::exists("address_1") && Input::exists("address_2") && Input::exists("address_3") && Input::exists("address_4") && Input::exists("city") && Input::exists("state") && Input::exists("zipcode") && Input::exists("phone") && Input::exists("firm_crd") && Input::exists("website") && Input::exists("new_ceo_name") && Input::exists("ceo_name") && Input::exists("ceo_email") && Input::exists("ceo_number") && Input::exists("ceo_linkedin") && Input::exists("optradio") && Input::exists("ceo_crd") && Input::exists("ceo_finop_name") && Input::exists("ceo_finop_card") && Input::exists("cco_name") && Input::exists("new_cco_name") && Input::exists("cco_email") && Input::exists("cco_number") && Input::exists("cco_linkedin") && Input::exists("cco_crd") && Input::exists("cco_state")&& Input::exists("lead_status")&& Input::exists("lead_substatus") && Input::exists("leadfrom")  && Input::exists("user") && Input::exists("aboutlead")){

        $leadid = Input::get("leadid");
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
        //$ceo_letter_type = Input::get("optradio");
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
		$lead_substatus=Input::get("lead_substatus");
		$lead_subsubstatus=Input::get("lead_subsubstatus");
        //$industry = Input::get("industry");
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
        $leadfrom = Input::get("leadfrom");

        $user = Input::get("user");
        $aboutlead = Input::get("aboutlead");
		$arr=array();
foreach($user as $u)
{
array_push($arr,$u);
}
$user=implode(',',$arr);

        if(empty($firm_name)){

                  textMsg("All fields are required","error");
                  Redirect::url("administrator/leads/");
                  exit;
        }else{

                $leads = Lead::all(['id'=>$leadid]);
				if(count($leads)>0){

					if(empty($user)){
		                        	$user = 0;
		                    	}
                    //die('new=>'.$firm_name." Old=>".$leads[0]->firm_name);
					if($firm_name!=$leads[0]->firm_name)
					{
					$msg = "Firm Name Changed from ".$leads[0]->firm_name." to ".$firm_name;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($address_1!=$leads[0]->address_1)
					{
					$msg = "Address Changed from ".$leads[0]->address_1." to ".$address_1;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($city!=$leads[0]->city)
					{
					$msg = "City Name Changed from ".$leads[0]->city." to ".$city;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($state!=$leads[0]->state)
					{
					$msg = "State Name Changed from ".$leads[0]->state." to ".$state;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($zipcode!=$leads[0]->zipcode)
					{
					$msg = "Zipcode Changed from ".$leads[0]->zipcode." to ".$zipcode;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($phone!=$leads[0]->phone)
					{
					$msg = "Phone Changed from ".$leads[0]->phone." to ".$phone;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($website!=$leads[0]->website)
					{
					$msg = "Website Changed from ".$leads[0]->website." to ".$website;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($ceo_name!=$leads[0]->ceo_name)
					{
					$msg = "CEO Name Changed from ".$leads[0]->ceo_name." to ".$ceo_name;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($ceo_email!=$leads[0]->ceo_email)
					{
					$msg = "CEO Email Changed from ".$leads[0]->ceo_email." to ".$ceo_email;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($ceo_linkedin!=$leads[0]->ceo_linkedin)
					{
					$msg = "CEO LinkedIn Changed from ".$leads[0]->ceo_linkedin." to ".$ceo_linkedin;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($business_liness!=$leads[0]->industry_id)
					{
					$msg = "Business Lines Changed from ".$leads[0]->industry_id." to ".$business_liness;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					if($user!=$leads[0]->user_id)
					{
					$msg = "Assigned User ids Changed from ".$leads[0]->user_id." to ".$user;
					createLog('Admin', 'Admin', $msg, $leadid = $leadid, $lead_type_id = $leadfrom, $lead_status_id = $lead_status);	
					}
					$leads[0]->firm_name = $firm_name;
					$leads[0]->address_1 = $address_1;
					$leads[0]->address_2 = $address_2;
					$leads[0]->address_3 = $address_3;
					$leads[0]->address_4 = $address_4;
					$leads[0]->city = $city;
					$leads[0]->state = $state;
					$leads[0]->zipcode = $zipcode;
					$leads[0]->phone = $phone;
					$leads[0]->firm_crd = $firm_crd;
					$leads[0]->website = $website;
					$leads[0]->new_ceo_name = $new_ceo_name;
					$leads[0]->ceo_name = $ceo_name;
					$leads[0]->ceo_email = $ceo_email;
					$leads[0]->ceo_number = $ceo_number;
					$leads[0]->ceo_linkedin = $ceo_linkedin;
					$leads[0]->ceo_letter_type = $ceo_letter_type;
					$leads[0]->ceo_crd = $ceo_crd;
					$leads[0]->ceo_finop_name = $ceo_finop_name;
					$leads[0]->ceo_finop_card = $ceo_finop_card;
					$leads[0]->cco_name = $cco_name ;
					$leads[0]->new_cco_name = $new_cco_name;
					$leads[0]->cco_email = $cco_email;
					$leads[0]->cco_number = $cco_number;
					$leads[0]->cco_linkedin = $cco_linkedin;
					$leads[0]->cco_crd = $cco_crd;
					$leads[0]->cco_state = $cco_state;
					$leads[0]->lead_status_id = $lead_status;
					$leads[0]->lead_substatus_id = $lead_substatus;
					$leads[0]->rom_branch_count = Input::get('rom_branch_count');
					$leads[0]->lead_subsubstatus_id = $lead_subsubstatus;
					
					$leads[0]->industry_id = $business_liness  ;
					$leads[0]->leadfrom = $leadfrom ;
					$leads[0]->user_id = $user;
					$leads[0]->aboutlead = $aboutlead ;

//die("test=>".$lead[0]->lead_substatus_id);
					if($leads[0]->save()){

						textMsg("Lead Updated succesfully","success");
						Redirect::url("administrator/viewLead/".$leadid);
						exit;

					}else{
						textMsg("somethis went wrong try again","error");
						Redirect::url("administrator/leads/");
						exit;

					}
				}else{
						textMsg("somethis went wrong try again","error");
						Redirect::url("administrator/leads/");
						exit;

				}



        }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leads/");
        exit;

    }
}









//deletesigLead
public function deletesigLead(){

    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");
       $data = Lead::all(['id' => $id]);

        if(count($data) > 0){
            if($data[0]->delete()){
                echo  json_encode(['result' => "success"]);
            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }
    }

}












public function sentMail(){
    isAdminLogin();
     if(!Input::exists("token") && !Input::exists("email") && !Input::exists("subject") && !Input::exists("msg")){
  	        textMsg("Required fields are empty 1.","error");
            Redirect::url("administrator/leads/");
            exit;

      }else{

         $token = Input::get("token");
		 $email = Input::get("email");
         $sub = Input::get("subject");
		$msg =  Input::get("msg");
		$lead_id = Input::get("lead_id");

            if(empty($token) || empty($msg) || empty($email) ||empty($sub)) {

                textMsg("Required fields are empty 2.","error");
                Redirect::url("administrator/leads/");
                exit;
		    }else{

		      $to = $email;
		      $subject = $sub;
		      $header = "MIME-Version: 1.0\r\n";
	          $header .= "From: Broker Dealer: <no-reply@brokerdealerforsale.com> \r\n";
	          $header .= "Content-Type:text/html; charset=iso-8859-1\r\n";
	          $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
              $message = "<table style='width:100%;padding: 2vw;background:#fafafa;text-align:left;'><thead><tr><th colspan='3'><a href='#' target='_blank' style='text-decoration:none;color:#000;font-size:22px;display:inline-block;float:left;margin-bottom:30px;'>CRM Administrator</a></th></tr></thead><tbody><tr><td colspan='3' style='color:#6f6f6f;font-family:Open Sans;font-size:13px;line-height: 22px;margin-top:15px;display:block;margin-bottom:40px;'>";
	          $message .= $msg;
              $message .= "</td></tr><tr><td style='border-top:1px solid #ddd;margin-top:20px;display:block;padding:10px 0px;overflow:hidden;border-bottom:1px solid #ddd;'><div style='color:#404040;text-align: center;font-size:15px;font-weight:600;font-family:Open Sans;'>Help & Support<ul style='list-style-type: none;margin: 0px;padding: 0px; overflow:hidden; margin-top: 10px;'><li style='overflow: hidden;font-weight:100;margin-right: 20px;display:inline-block;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.brokerdealerforsale.com/crm/assets/mobile.png' style='float:left;height: 16px;margin-right: 10px;'> +91 00000 00000</li><li style='overflow: hidden;display: inline-block;font-weight:100;margin-right: 20px;line-height: 20px;font-size: 14px;color: #414753;'><img src='http://demo.brokerdealerforsale.com/crm/assets/email.png' style='float:left;height: 16px;margin-right: 10px;'> no-reply@brokerdealerforsale.com</li></ul></div></td></tr></tbody></table>";




                $sentOk = mail($to,$subject,$message,$header);
				if($sentOk){
				    textMsg("Enquiry has been sent successfully..","success");
					$leads_list = Lead::all(['id'=>$lead_id]);
					
					if(count($leads_list)>0)
					{
						//die('test'.gettype($leads_list[0]->lead_status_id));
						if($leads_list[0]->leadfrom==1)
						{
						if($leads_list[0]->lead_status_id==37)
						{
					$leads_list[0]->lead_status_id = 38;
						}
					    else if($leads_list[0]->lead_status_id==38)
						{
					$leads_list[0]->lead_status_id = 49;		
						}
						
						}
						else
						{
						if($leads_list[0]->lead_status_id==55)
						{
					$leads_list[0]->lead_status_id = 75;
						}
					    else if($leads_list[0]->lead_status_id==75)
						{
					$leads_list[0]->lead_status_id = 76;		
						}	
						}
					$leads_list[0]->save();
						
					}
                    Redirect::url("administrator/leads/");
                    exit;
                }else{
                    textMsg("Something went wrong try again..","error");
                    Redirect::url("administrator/leads/");
                    exit;
                }
            }

     }

}







//uploadlead
public function uploadlead(){
    isAdminLogin();
    $this->app->views("administrator/uploadlead");
}


//add Users
public function addNotes(){
    isAdminLogin();

    if(Input::exists("token") && Input::exists("msg") && Input::exists("id")){

        $key = Input::get("token");
        $msg = Input::get("msg");
        $lead_id = Input::get("id");
		
$type = Input::get("type");
        $leadcurrentstatus = Input::get("leadcurrentstatus");
        $adminid = Session::get('adminId');



        if(empty($key)|| empty($msg) || empty($lead_id)){

            textMsg("All fields are required","error");
            Redirect::url("administrator/leads/");
            exit;
        }else{

            $leads = Lead::all(['id' => $lead_id]);
            if(count($leads)>0){



                $notes = new Note();
				$notes->user_id = $adminid;
				$notes->lead_id = $lead_id;
				$notes->msg = $msg;
                $notes->status = 1;
				$notes->date = time();

                if($notes->save()){

                        textMsg("New note added succesfully","success");
                        $redirecturl = "administrator/viewLead/$lead_id/";
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
                        Redirect::url("administrator/leads");
                        exit;

                }

            }else{
                textMsg("somethis went wrong try again","error");
                Redirect::url("administrator/leads/");
                exit;

            }

        }

    }else{
        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leads");
        exit;

    }
}

//edit notes







public function editNotes(){
    isAdminLogin();

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
            Redirect::url("administrator/leads/");
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
                        $redirecturl = "administrator/viewLead/$lead_id/";
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
                        Redirect::url("administrator/leads");
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











//Delete Note


















public function deleteNotes()
{
isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");
	   $lead_id=Input::get("lead_id");
       $data = Note::all(['id' => $id]);

        if(count($data) > 0){
            if($data[0]->delete()){
                textMsg("Note deleted succesfully","success");
                        $redirecturl = "administrator/viewLead/$lead_id/";
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



















public function notification(){
    isAdminLogin();
    $connects = Connect::all(['status'=>1,'notyfy_id'=>0]);
    $notifications = Notification::all(['conditions'=>"id < 21 and notifyto = 0 order by date desc limit 30"]);
    $this->app->views("administrator/notification",(['connects'=>$connects,'notifications' => $notifications]));
}

public function view_notification(){
    isAdminLogin();
    $notifications = Notification::all(['conditions'=>"id < 21 and notifyto = 0 order by date desc limit 30"]);
    $this->app->views("administrator/view_notification",['notifications' => $notifications]);
}




//assignUserLead
public function assignUserLead(){

    isAdminLogin();

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




//assign Selected Leads to  User
public function assignSelectedLeads(){

    isAdminLogin();

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




//Reminder create for lead
public function followup(){

    isAdminLogin();

    if(!Input::exists("id") && !Input::exists("msg") && !Input::exists("reminddate")){
        echo  json_encode(['result' => "Fill All field"]);
	      exit;

    }else{

        $msg = Input::get("msg");

        $leadsid = Input::get("id");
        $reminddate = Input::get("reminddate");
		$user_id = Input::get("user_id");

        if(empty($msg) || empty($leadsid) || empty($reminddate)){

          echo  json_encode(['result' => "Fill All field"]);
          exit;

        }else{

          $leads = Lead::all(['id' => $leadsid]);
          if(count($leads) > 0){
              $followup = new Followup();
              $followup->leadid = $leadsid;
              $followup->reminder_date = strtotime($reminddate);
              $followup->msg = $msg;
              $followup->is_seen = 0;
			  $followup->user_id = $user_id;
              $followup->date = time();
              if($followup->save()){

                echo  json_encode(['result' => "success"]);
              }else{

                  echo  json_encode(['result' => "Something went wrong try again"]);
              }
          }else{
              echo  json_encode(['result' => "Something went wrong try again"]);
          }
          exit;
        }

    }

}









//leadStatusChange
public function leadStatusChange(){

    isAdminLogin();

    if(!Input::exists("id") && !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
		$id = Input::get("id");
		$leadstatus = Leadstatu::all(['id'=>$id]);
		if(count($leadstatus) > 0){
			$leadid = Input::get("leadid");

			$leads = Lead::all(['id' => $leadid]);
			if(count($leads) > 0){

				$leads[0]->lead_status_id = $id;

				if($leads[0]->save()){
					echo  json_encode(['result' => "success"]);

				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}

			}else{
				echo  json_encode(['result' => "Something went wrong try again"]);
			}
		}else{
			echo  json_encode(['result' => "Something went wrong try again"]);
		}

    }

}








//leadSubStatusChange
public function leadSubstatusChange(){

    isAdminLogin();

    if(!Input::exists("id") && !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
		$id = Input::get("id");
		$leadstatus = Leadsubstatu::all(['id'=>$id]);
		if(count($leadstatus) > 0){
			$leadid = Input::get("leadid");

			$leads = Lead::all(['id' => $leadid]);
			if(count($leads) > 0){

				$leads[0]->lead_substatus_id = $id;

				if($leads[0]->save()){
					echo  json_encode(['result' => "success"]);

				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}

			}else{
				echo  json_encode(['result' => "Something went wrong try again"]);
			}
		}else{
			echo  json_encode(['result' => "Something went wrong try again"]);
		}

    }

}





// leadsfrom
public function leadsfrom(){
    isAdminLogin();
    $leadstypes = Leadstype::all(['status'=>1]);
    $this->app->views("administrator/leadsfrom",(['leadstypes'=>$leadstypes]));
}







//add leadsfrom
public function addleadsfrom(){
    isAdminLogin();
    if(Input::exists("token") && Input::exists("name")){

            $key = Input::get("token");
            $name = Input::get("name");

            if(empty($key) || empty($name)){
                  textMsg("All fields are required","error");
                  Redirect::url("administrator/leadsfrom");
                  exit;
            }else{
 $leadstypes = Leadstype::all(['name' =>$name]);
                if(count($leadstypes)>0){
                        textMsg("This name already exists try again","error");
                        Redirect::url("administrator/leadsfrom");
                        exit;

                }else{

            $leadstypes = new Leadstype();
				    $leadstypes->name = $name;
				    $leadstypes->date = time();
				    $leadstypes->status = 1;

                    if($leadstypes->save()){

                            textMsg("New Lead type added succesfully","success");
                            Redirect::url("administrator/leadsfrom");
                            exit;

                    }else{
                            textMsg("somethis went wrong try again","error");
                            Redirect::url("administrator/leadsfrom");
                            exit;

                    }
                }
            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leadsfrom");
        exit;

    }
}









//update leadsfrom
public function updateLeadsfrom(){
    isAdminLogin();
    if(Input::exists("id") && Input::exists("name")){

        $id = Input::get("id");
        $name = Input::get("name");

        if(empty($id) || empty($name)){
              textMsg("All fields are required","error");
              Redirect::url("administrator/leadsfrom");
              exit;
        }else{

            $leadstypes = Leadstype::all(['name' =>$name]);
                if(count($leadstypes)>0){
                    textMsg("This name already exists try again","error");
                    Redirect::url("administrator/leadsfrom");
                    exit;

                }else{
                    $leadstypes = Leadstype::all(['id' =>$id]);
                    $leadstypes[0]->name = $name;

                    if($leadstypes[0]->save()){

                            textMsg("Lead type Update succesfully","success");
                            Redirect::url("administrator/leadsfrom");
                            exit;

                    }else{
                            textMsg("somethis went wrong try again","error");
                            Redirect::url("administrator/leadsfrom");
                            exit;

                    }
                }
            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leadsfrom");
        exit;

    }
}











//view leadfrom
public function leadfrom($id){
     isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/leadsfrom/");
        exit;
    }else{

        $leadstypes = Leadstype::all(['id'=>$id]);
        if(count($leadstypes)>0){

            $this->app->views("administrator/leadfrom",(['leadstypes'=>$leadstypes[0]]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/leadsfrom/");
            exit;

        }

    }
}



public function leadstatusdetail($id)
{
	isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/leadsfrom/");
        exit;
    }
	
else{

        $leadstatus = Leadstatu::all(['id'=>$id]);
        if(count($leadstatus)>0){

            $this->app->views("administrator/addLeadSubstatus",(['leadstatus'=>$leadstatus[0]]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/leadsfrom/");
            exit;

        }

}
	
}


//add Surface


public function insertStatus()
{
$this->app->views("administrator/insertStatus");	
}
public function addStatus(){
    isAdminLogin();
	
    if(Input::exists("leadstypes") && Input::exists("name")){

            
            $leadid = Input::get("leadstypes");
            $name = Input::get("name");

            if(empty($leadid) || empty($name)){
                  textMsg("All fields are required","error");
                  Redirect::url("administrator/leadsfrom/");
                  exit;
            }else{

				$leadstypes = Leadstype::all(['id'=>$leadid]);

				if(count($leadstypes)>0){

					$leadstatus = Leadstatu::all(['name' =>$name, 'lead_type_id'=>$leadid]);
					if(count($leadstatus)>0){
							textMsg("This name already exists try again","error");
							Redirect::url("administrator/leadfrom/$leadid");
							exit;

					}else{

						$leadstatus = new Leadstatu();
						$leadstatus->lead_type_id = $leadid;
						$leadstatus->name = $name;
						$leadstatus->date = time();
						$leadstatus->status = 1;

						if($leadstatus->save()){
								textMsg("New Status added succesfully","success");
								Redirect::url("administrator/leadfrom/$leadid/");
								exit;
						}else{
								textMsg("somethis went wrong try again","error");
								Redirect::url("administrator/leadsfrom");
								exit;

						}
					}
				}else{
					textMsg("somethis went wrong try again","error");
					Redirect::url("administrator/leadfrom/$leadid/");
					exit;

				}
            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leadsfrom");
        exit;

    }
}



public function addSubstatus()
{

    isAdminLogin();
	
    if(Input::exists("leadstypes") && Input::exists("name")){

            
            $leadid = Input::get("leadstypes");
            $name = Input::get("name");

            if(empty($leadid) || empty($name)){
				
                  textMsg("All fields are required","error");
                  Redirect::url("administrator/leadsfrom/");
                  exit;
            }else{

				$leadstypes = Leadstatu::all(['id'=>$leadid]);

				if(count($leadstypes)>0){

					$leadstatus = Leadsubstatu::all(['name' =>$name, 'lead_status_id'=>$leadid]);
					if(count($leadstatus)>0){
						
							textMsg("This name already exists try again","error");
							Redirect::url("administrator/leadfrom/$leadid");
							exit;

					}else{
                        //die('test');
						$leadstatus = new Leadsubstatu();
						$leadstatus->lead_status_id = $leadid;
						$leadstatus->name = $name;
						$leadstatus->date = time();
						$leadstatus->status = 1;

						if($leadstatus->save()){
								textMsg("New Status added succesfully","success");
								Redirect::url("administrator/leadstatusdetail/$leadid/");
								exit;
						}else{
								textMsg("somethis went wrong try again","error");
								Redirect::url("administrator/leadsfrom");
								exit;

						}
					}
				}else{
					textMsg("somethis went wrong try again","error");
					Redirect::url("administrator/leadstatusdetail/$leadid/");
					exit;

				}
            }

    }else{

        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leadsfrom");
        exit;

    }
	
}















//deleteStatus
public function deleteStatus(){

    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");


	if($id == 8){
		echo  json_encode(['result' => "Something went wrong try again"]);
		exit;
	}
	if($id == 37){
        	echo  json_encode(['result' => "Something went wrong try again"]);
		exit;
	}
        if($id == 55){
        	echo  json_encode(['result' => "Something went wrong try again"]);
		exit;
	}




       $data = Leadstatu::all(['id' => $id]);
        if(count($data) > 0){

			$leads = Lead::all(['lead_status_id' => $id]);

			if(count($leads) <= 0){
				if($data[0]->delete()){
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
			}else{
				echo  json_encode(['result' => "Status Used in  Lead"]);
			}

        }
    }

}







public function deleteSubstatus()
{


    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");


	if($id == 1){
		echo  json_encode(['result' => "Something went wrong try again"]);
		exit;
	}




       $data = Leadsubstatu::all(['id' => $id]);
        if(count($data) > 0){
if($data[0]->delete()){
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
		/*	$leads = Lead::all(['lead_status_id' => $id]);

			if(count($leads) <= 0){
				if($data[0]->delete()){
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
			}else{
				echo  json_encode(['result' => "Status Used in  Lead"]);
			}
*/
        }
    }

	
}







//type wise status
public function typeWiseStatus() {

        if(!Input::exists("typeid")){
            echo json_encode(['result' => "Required correct id to do this action."]);
            exit;

        }else{
            $typeid = Input::get("typeid");
            $leadstatus = Leadstatu::all(['lead_type_id'=>$typeid]);
			$lead_status = Leadstatu::all(['lead_type_id'=>$typeid]);
			
            if(count($leadstatus) > 0){
                $leadstatus = Json::encodeObj($leadstatus);
				
                echo json_encode(['result'=>"success",'leadstatus'=>$leadstatus]);
            }else{
                echo json_encode(['result' => "Status not available in this Type"]);
                exit;
            }

        }

    }
	
	
	
	
	
	
//status wise substatus
public function statusWiseSubstatus() {

        if(!Input::exists("typeid")){
            echo json_encode(['result' => "Required correct id to do this action."]);
            exit;

        }else{
            $typeid = Input::get("typeid");
            $leadsubstatus = Leadsubstatu::all(['lead_status_id'=>$typeid]);
            if(count($leadsubstatus) > 0){
                $leadsubstatus = Json::encodeObj($leadsubstatus);
				
                echo json_encode(['result'=>"success",'leadsubstatus'=>$leadsubstatus]);
            }else{
                echo json_encode(['result' => "Substatus not available in this Type"]);
                exit;
            }

        }

    }











//status wise substatus
public function substatusWiseSubsubstatus() {

        if(!Input::exists("typeid")){
            echo json_encode(['result' => "Required correct id to do this action."]);
            exit;

        }else{
            $typeid = Input::get("typeid");
            $leadsubsubstatus = Leadsubsubstatu::all(['lead_substatus_id'=>$typeid]);
            if(count($leadsubsubstatus) > 0){
                $leadsubsubstatus = Json::encodeObj($leadsubsubstatus);
				echo json_encode(['result'=>"success",'leadsubsubstatus'=>$leadsubsubstatus]);
            }else{
                echo json_encode(['result' => "Sub-substatus not available in this Type"]);
                exit;
            }

        }

    }









public function lead($leadstype,$leadstatus=''){

    $leadstatus = str_replace("_"," ",$leadstatus);

    isAdminLogin();

    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("administrator/lead_by_type",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("user/notFound");
        exit;

    }
}










public function leadstatus($leadstype,$leadstatus='',$leadsubstatus=''){
    $leadstatus = str_replace("_"," ",$leadstatus);
    $leadsubstatus = str_replace("_"," ",$leadsubstatus);
	//die('tst'.$leadstatus);
    isAdminLogin();
    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("administrator/lead_by_status",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'leadcurrentsubstatus'=>$leadsubstatus, 'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("user/notFound");
        exit;

    }
}







public function createLeadFromExcel(){

    isAdminLogin();
    // check file name is not empty

    if (!empty($_FILES['leadexcelfile']['name'])) {

        // Get File extension eg. 'xlsx' to check file is excel sheet
        $pathinfo = pathinfo($_FILES["leadexcelfile"]["name"]);

        // check file has extension xlsx, xls and also check
        // file is not empty
       if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
               && $_FILES['leadexcelfile']['size'] > 0 ) {

            // Temporary file name
            $inputFileName = $_FILES['leadexcelfile']['tmp_name'];

            // Read excel file by using ReadFactory object.
            $reader = ReaderFactory::create(Type::XLSX);

            // Open file
            $reader->open($inputFileName);
            $count = 1;

            $data = array();

            foreach ($reader->getSheetIterator() as $sheet) {

                // Number of Rows in Excel sheet
                foreach ($sheet->getRowIterator() as $key=>$row) {

                    // It reads data after header. In the my excel sheet,
                    // header is in the first row.
                    if($key == 1){
                        if(!((strtolower($row[0]) == strtolower("NAME OF FIRM")) && (strtolower($row[1]) == strtolower("ADDRESS 1")) && (strtolower($row[2]) == strtolower("ADDRESS 2")) && (strtolower($row[3]) == strtolower("ADDRESS 3")) && (strtolower($row[4]) == strtolower("ADDRESS 4")) && (strtolower($row[5]) == strtolower("CITY")) && (strtolower($row[6]) == strtolower("STATE")) && (strtolower($row[7]) == strtolower("ZIP CODE")) && (strtolower($row[8]) == strtolower("TELEPHONE NUMBER")) && (strtolower($row[9]) == strtolower("FIRM CRD")) && (strtolower($row[10]) == strtolower("Company Website")) && (strtolower($row[11]) == strtolower("CEO NAME")) && (strtolower($row[12]) == strtolower("CEO Email")) && (strtolower($row[13]) == strtolower("CEO Cell Number")) && (strtolower($row[14]) == strtolower("CEO Linkedin")) && (strtolower($row[15]) == strtolower("CEO CRD")) && (strtolower($row[16]) == strtolower("FINOP NAME")) && (strtolower($row[17]) == strtolower("FINOP CRD")) && (strtolower($row[18]) == strtolower("CCO NAME")) && (strtolower($row[19]) == strtolower("CCO Email")) && (strtolower($row[20]) == strtolower("CCO Cell")) && (strtolower($row[21]) == strtolower("CCO Linkedin")) && (strtolower($row[22]) == strtolower("CCO CRD")) && (strtolower($row[23]) == strtolower("STATES REGISTERED IN")) && (strtolower($row[24]) == strtolower("TYPES OF BIZ")) && (strtolower($row[25]) == strtolower("INTRODUCING ARRANGEMENTS")))){

                                textMsg("Upload Excel file with correct header title and sequence","error");
                                echo json_encode(['result' => "Upload Excel file with correct header title and sequence"]);
                                // Redirect::url("administrator/uploadlead");
                                exit;
                        }
                    }else{
                        break;
                    }
                }
            }

            $le=array();
            // Number of sheet in excel file
            foreach ($reader->getSheetIterator() as $sheetno=>$sheet) {

                // Number of Rows in Excel sheet
                foreach ($sheet->getRowIterator() as $key=>$row) {

                    // It reads data after header. In the my excel sheet,
                    // header is in the first row.
                    if($key == 1 && $sheetno > 1){
                            // echo strtolower($row[0])." === ".strtolower("NAME OF FIRM")." = ".(strtolower($row[0]) == strtolower("NAME OF FIRM"))."<br/>";
                            // echo strtolower($row[1])." === ".strtolower("ADDRESS 1")." = ".(strtolower($row[1]) == strtolower("ADDRESS 1"))."<br/>";
                            // echo strtolower($row[2])." === ".strtolower("ADDRESS 2")." = ".(strtolower($row[2]) == strtolower("ADDRESS 2"))."<br/>";
                            // echo strtolower($row[3])." === ".strtolower("ADDRESS 3")." = ".(strtolower($row[3]) == strtolower("ADDRESS 3"))."<br/>";
                            // echo strtolower($row[4])." === ".strtolower("ADDRESS 4")." = ".(strtolower($row[4]) == strtolower("ADDRESS 4"))."<br/>";
                            // echo strtolower($row[5])." === ".strtolower("CITY")." = ".(strtolower($row[5]) == strtolower("CITY"))."<br/>";
                            // echo strtolower($row[6])." === ".strtolower("STATE")." = ".(strtolower($row[6]) == strtolower("STATE"))."<br/>";
                            // echo strtolower($row[7])." === ".strtolower("ZIP CODE")." = ".(strtolower($row[7]) == strtolower("ZIP CODE"))."<br/>";
                            // echo strtolower($row[8])." === ".strtolower("TELEPHONE NUMBER")." = ".(strtolower($row[8]) == strtolower("TELEPHONE NUMBER"))."<br/>";
                            // echo strtolower($row[9])." === ".strtolower("FIRM CRD")." = ".(strtolower($row[9]) == strtolower("FIRM CRD"))."<br/>";
                            // echo strtolower($row[10])." === ".strtolower("Company Website")." = ".(strtolower($row[10]) == strtolower("Company Website"))."<br/>";
                            // echo strtolower($row[11])." === ".strtolower("CEO NAME")." = ".(strtolower($row[11]) == strtolower("CEO NAME"))."<br/>";
                            // echo strtolower($row[12])." === ".strtolower("CEO Email")." = ".(strtolower($row[12]) == strtolower("CEO Email"))."<br/>";
                            // echo strtolower($row[13])." === ".strtolower("CEO Cell Number")." = ".(strtolower($row[13]) == strtolower("CEO Cell Number"))."<br/>";
                            // echo strtolower($row[14])." === ".strtolower("CEO Linkedin")." = ".(strtolower($row[14]) == strtolower("CEO Linkedin"))."<br/>";
                            // echo strtolower($row[15])." === ".strtolower("CEO CRD")." = ".(strtolower($row[15]) == strtolower("CEO CRD"))."<br/>";
                            // echo strtolower($row[16])." === ".strtolower("FINOP NAME")." = ".(strtolower($row[16]) == strtolower("FINOP NAME"))."<br/>";
                            // echo strtolower($row[17])." === ".strtolower("FINOP CRD")." = ".(strtolower($row[17]) == strtolower("FINOP CRD"))."<br/>";
                            // echo strtolower($row[18])." === ".strtolower("CCO NAME")." = ".(strtolower($row[18]) == strtolower("CCO NAME"))."<br/>";
                            // echo strtolower($row[19])." === ".strtolower("CCO Email")." = ".(strtolower($row[19]) == strtolower("CCO Email"))."<br/>";
                            // echo strtolower($row[20])." === ".strtolower("CCO Cell")." = ".(strtolower($row[20]) == strtolower("CCO Cell"))."<br/>";
                            // echo strtolower($row[21])." === ".strtolower("CCO Linkedin")." = ".(strtolower($row[21]) == strtolower("CCO Linkedin"))."<br/>";
                            // echo strtolower($row[22])." === ".strtolower("CCO CRD")." = ".(strtolower($row[22]) == strtolower("CCO CRD"))."<br/>";
                            // echo strtolower($row[23])." === ".strtolower("STATES REGISTERED IN")." = ".(strtolower($row[23]) == strtolower("STATES REGISTERED IN"))."<br/>";
                            // echo strtolower($row[24])." === ".strtolower("TYPES OF BIZ")." = ".(strtolower($row[24]) == strtolower("TYPES OF BIZ"))."<br/>";
                            // echo strtolower($row[25])." === ".strtolower("INTRODUCING ARRANGEMENTS")." = ".(strtolower($row[25]) == strtolower("INTRODUCING ARRANGEMENTS"))."<br/>";

                        // if(!((strtolower($row[0]) == strtolower("NAME OF FIRM")) && (strtolower($row[1]) == strtolower("ADDRESS 1")) && (strtolower($row[2]) == strtolower("ADDRESS 2")) && (strtolower($row[3]) == strtolower("ADDRESS 3")) && (strtolower($row[4]) == strtolower("ADDRESS 4")) && (strtolower($row[5]) == strtolower("CITY")) && (strtolower($row[6]) == strtolower("STATE")) && (strtolower($row[7]) == strtolower("ZIP CODE")) && (strtolower($row[8]) == strtolower("TELEPHONE NUMBER")) && (strtolower($row[9]) == strtolower("FIRM CRD")) && (strtolower($row[10]) == strtolower("Company Website")) && (strtolower($row[11]) == strtolower("CEO NAME")) && (strtolower($row[12]) == strtolower("CEO Email")) && (strtolower($row[13]) == strtolower("CEO Cell Number")) && (strtolower($row[14]) == strtolower("CEO Linkedin")) && (strtolower($row[15]) == strtolower("CEO CRD")) && (strtolower($row[16]) == strtolower("FINOP NAME")) && (strtolower($row[17]) == strtolower("FINOP CRD")) && (strtolower($row[18]) == strtolower("CCO NAME")) && (strtolower($row[19]) == strtolower("CCO Email")) && (strtolower($row[20]) == strtolower("CCO Cell")) && (strtolower($row[21]) == strtolower("CCO Linkedin")) && (strtolower($row[22]) == strtolower("CCO CRD")) && (strtolower($row[23]) == strtolower("STATES REGISTERED IN")) && (strtolower($row[24]) == strtolower("TYPES OF BIZ")) && (strtolower($row[25]) == strtolower("INTRODUCING ARRANGEMENTS")))){

                        //         textMsg("Upload Excel file with correct header title and sequence","error");
                        //         Redirect::url("administrator/uploadlead");
                        //         exit;
                        // }else{
                            // $data["firm_name"] = array();
                            // $data["address_1"] = array();
                            // $data["address_2"] = array();
                            // $data["address_3"] = array();
                            // $data["address_4"] = array();
                            // $data["city"] = array();
                            // $data["state"] = array();
                            // $data["zipcode"] = array();
                            // $data["phone"] = array();
                            // $data["firm_crd"] = array();
                            // $data["website"] = array();
                            // // $data["new_ceo_name"] = array();
                            // $data["ceo_name"] = array();
                            // $data["ceo_email"] = array();
                            // $data["ceo_number"] = array();
                            // $data["ceo_linkedin"] = array();
                            // // $data["ceo_letter_type"] = array();
                            // $data["ceo_crd"] = array();
                            // $data["ceo_finop_name"] = array();
                            // $data["ceo_finop_card"] = array();
                            // $data["cco_name"] = array();
                            // // $data["new_cco_name"] = array();
                            // $data["cco_email"] = array();
                            // $data["cco_number"] = array();
                            // $data["cco_linkedin"] = array();
                            // $data["cco_crd"] = array();
                            // $data["cco_state"] = array();
                            // // $data["lead_status_id"] = array();
                            // $data["industry_id"] = array();
                            // // $data["leadfrom"] = array();
                            // // $data["user_id"] = array();
                            // $data["aboutlead"] = array();
                            // // $data["date"] = array();
                            // // $data["status"] = array();
                        // }

                    }else{

                        if ($count > 1) {

                            // Data of excel sheet
                            $firm_name = $row[0];
                            $address_1 = $row[1];
                            $address_2 = $row[2];
                            $address_3 = $row[3];
                            $address_4 = $row[4];
                            $city = $row[5];
                            $state = $row[6];
                            $zipcode = $row[7];
                            $phone = $row[8];
                            $firm_crd = $row[9];
                            $website = $row[10];
                            $new_ceo_name = "";
                            $ceo_name = $row[11];
                            $ceo_email = $row[12];
                            $ceo_number = $row[13];
                            $ceo_linkedin = $row[14];
                            $ceo_letter_type = "no";
                            $ceo_crd = $row[15];
                            $ceo_finop_name = $row[16];
                            $ceo_finop_card = $row[17];
                            $cco_name = $row[18];
                            $new_cco_name = "";
                            $cco_email = $row[19];
                            $cco_number = $row[20];
                            $cco_linkedin = $row[21];
                            $cco_crd = $row[22];
                            $cco_state = $row[23];
                            $industry_id = $row[24];
                            if(stripos(trim($row[14]),"linkedin") !== false){
                                $leadfrom = 1;
                            }else{
                                $leadfrom = 3;
                            }
                            if($leadfrom == 1){
                                $lead_status = 37;
                            }else{
                                $lead_status = 8;
                            }
                            $user_id = 0;
                            $aboutlead = $row[25];

                            $leads = new Lead();
                            // $leads = new stdClass();
                            // $leads->key = $key;
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
                            $leads->industry_id = $industry_id ;
                            $leads->leadfrom = $leadfrom ;
                            $leads->user_id = $user_id;
                            $leads->aboutlead = $aboutlead ;
                            $leads->date = time();
                            $leads->status = 1;

                            array_push($le, $leads);
                            $leads->save();


                        }
                        $count++;
                    }
                }
            }

            // Close excel file
            $reader->close();

            textMsg("Lead Added form Excel File succesfully","success");
            var_dump($le);
            // echo json_encode(['leads' => $le]);
            // echo json_encode(['result' => "success"]);
            // Redirect::url("administrator/leads");
            exit;

        } else {

            textMsg("Please Select Valid Excel File","error");
            echo json_encode(['result' => "Please Select Valid Excel File"]);
            // Redirect::url("administrator/uploadlead");
            exit;
        }

    } else {

        textMsg("Please Select Excel File","error");
        echo json_encode(['result' => "Please Select Excel File"]);
        // Redirect::url("administrator/uploadlead");
        exit;

    }
}








public function viewtype($leadstype)
{
    isAdminLogin();
    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("administrator/viewtype",['lead_type'=>$leadtype[0]->id]);

    }else{
        Redirect::url("user/notFound");
        exit;

    }
}



    //get New Notifications
    public function getAdminNewNotifications() {

        isAdminLogin();
        if(!Input::exists("typeid")){
            echo json_encode(['result' => "Required correct id to do this action."]);
            exit;

        }else{
            $time = Input::get('time');
            $notifications = Notification::all(['conditions'=>"notifyto = 0 AND date > $time order by date desc limit 20"]);
            $checktime = time();
            $html = "";
            foreach ($notifications as $notification) {
                if($notification->createdby == 0){
                    $username = "Admin";
                    $userimg = "";
                }else{
                    $users = Subadmin::all(['id'=>$notification->createdby]);
                    if(count($users)>0){
                        $username = $users[0]->name;
                        $userimg = $users[0]->photo;
                    }else{
                        $username = "";
                        $userimg = "";
                    }
                }


                $html .= '<li>';
                $html .= '<a href="'.BASEURL.'administrator/view_notification/">';
                if($userimg == ""){
                    $html .= '<img src="'.BASEURL.'assets/administrator/img/user.png" alt="">';
                }else{
                    $html .= '<img src="'.BASEURL.'uploads/images/<?=$userimg;?>" alt="">';
                }

                $html .= '<h5>'.$username.'<span>'.timerFormat($notification->date,time()).' ago</span></h5>';
                $html .= '<p>'.$notification->msg;
                if($notification->leadid !=0 ){
                    $leadofnoti = Lead::all(['id' => $notification->leadid]);
                    if(count($leadofnoti) > 0){

                    }
                }
                $html .= '</p>';
                $html .= '</a>';
                $html .= '</li>';
            }

            echo json_encode(['result'=>"success",'html'=>$html, "totalnewnotifications" => count($notifications), 'time' => $checktime]);

        }



    }
//add reminds
public function actionDate(){
    isAdminLogin();

    if(Input::exists("token") && Input::exists("msg") && Input::exists("createdate") && Input::exists("id")){

        $key = Input::get("token");
        $msg = Input::get("msg");
        $reminddate = Input::get("reminddate");
        $lead_id = Input::get("id");
        $type = Input::get("type");
		$priority = Input::get("priority");
        $leadcurrentstatus = Input::get("leadcurrentstatus");
        $adminid = Session::get('adminId');
        $user = implode(',',Input::get("user"));
		$repeat = Input::get('number');
		$duration = Input::get('duration');



        if(empty($key)|| empty($msg) || empty($lead_id) || empty($reminddate)){

            textMsg("All fields are required","error");
            Redirect::url("administrator/leads/");
            exit;
        }else{

            $leads = Lead::all(['id' => $lead_id]);
            if(count($leads)>0){



        //         $reminds = new Remind();
				// $reminds->user_id = $adminid;
				// $reminds->lead_id = $lead_id;
				// $reminds->msg = $msg;
        //         $reminds->reminddate = strtotime($reminddate);
        //         $reminds->status = 1;
				// $reminds->createdate = time();
        $followup = new Followup();
        $followup->leadid = $lead_id;
        $followup->reminder_date = strtotime($reminddate);
        $followup->msg = $msg;
        $followup->assigned_by = Session::get('adminId');
				    $followup->priority = $priority;
                    $followup->user_id = $user;
		
        $followup->is_seen = 0;
		$followup->repeat_in = $repeat;
				$followup->duration= $duration;
        $followup->date = time();

                if($followup->save()){

                        textMsg("Reminder set succesfully","success");
                        $redirecturl = "administrator/viewLead/$lead_id/";
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
                        Redirect::url("administrator/leads");
                        exit;

                }

            }else{
                textMsg("somethis went wrong try again","error");
                Redirect::url("administrator/leads/");
                exit;

            }

        }

    }else{
        textMsg("somethis went wrong try again ","error");
        Redirect::url("administrator/leads");
        exit;

    }
}


//deletesigLead
public function deletnoty(){

    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");
       $data = Remind::all(['id' => $id]);

        if(count($data) > 0){
            if($data[0]->delete()){
                echo  json_encode(['result' => "success"]);
            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }
    }

}


public function work(){

  isAdminLogin();
  $users = Subadmin::all(['status'=>1]);
  $this->app->views("administrator/work",['users' => $users]);

}



public function getWork(){
  isAdminLogin();
  if(!Input::exists("date")){
      echo  json_encode(['result' => "Select Date"]);
      exit;

  }else{
      $date = Input::get("date");
      $userid = Input::get('user');
      $today = strtotime($date);
      $tomorrow = $today+86400;
       $leadtypes = Leadstype::all();
       $html = "";
       

           $html .= '<ul class="list-group">';
           
             $condition = "";
             if(Input::exists("user") && !empty($userid)){
               $condition = "createdby = ".$userid." and ";
             }
             $condition = " date >=  ".$today." and date < ".$tomorrow;
             $notification = Statuslog::find_by_sql("SELECT count(*) as totalnotification FROM statuslogs where ".$condition);
			 $notif = Statuslog::find_by_sql("SELECT * FROM statuslogs where ".$condition);
             if($notification[0]->totalnotification > 0){

              $html .= '<table class="table table-striped alldatatbl"><thead><tr><td>Lead ID</td><td>Lead</td><td>Previous Status</td><td>New Status</td>
						  <td>Changed By</td>
						  <td>Date Of Change</td>
						  </tr>
							  </thead>';
              //$html .= $notification[0]->totalnotification.'</span>';
			foreach ($notif as $not)
			{
			  $html .= '<tbody><tr><td>';
              $html .= $not->leadid;
			  $html .= '</td><td>';
			  $name = Lead::all(['id'=>$not->leadid]);
			  $html .= $name[0]->firm_name;
			  $html .= '</td><td>';
			  $prev = Leadstype::all(['id'=>$not->prev_type]);
							  $prev1 = Leadstatu::all(['id'=>$not->prev_status]);
							  $prev2 = Leadsubstatu::all(['id'=>$not->prev_substatus]);
							  $prev3 = Leadsubsubstatu::all(['id'=>$not->prev_subsubstatus]);
			if(empty($prev2))
							  {$prev_sub='';}
							  else
							  {$prev_sub=' > '.$prev2[0]->name;}
							  if(empty($prev3))
							  {$prev_subsub='';}
							  else
							  {
							  $prev_subsub= ' > '.$prev3[0]->name;	  
							  }
				$html.=$prev[0]->name.' > '.$prev1[0]->name.$prev_sub.$prev_subsub;
				$html.='</td><td>';
				$new = Leadstype::all(['id'=>$not->new_type]);
							  $new1 = Leadstatu::all(['id'=>$not->new_status]);
							  $new2 = Leadsubstatu::all(['id'=>$not->new_substatus]);
							  $new3 = Leadsubsubstatu::all(['id'=>$not->new_subsubstatus]);
							  if(empty($new2))
							  {$new_sub='';}
							  else
							  {$new_sub=' > '.$new2[0]->name;}
							  if(empty($new3))
							  {$new_subsub='';}
							  else
							  {
							  $new_subsub= ' > '.$new3[0]->name;	  
							  }
			 $html .= $new[0]->name.' > '.$new1[0]->name.$new_sub.$new_subsub;
			 $html .='</td><td>';
			if($not->changed_by!=0)
							  {
								$user = Subadmin::all(['id'=>$not->changed_by]);  
							$html.= $user[0]->name;	  
							  }
							  else
							  {
							$html.= "Admin";	  
							  }
			 $html.='</td><td>';
			 $html.=date('m-d-Y',$not->date);
			 $html.='</td></tr></tbody';
				
				
			}
				$html .= '</table>';
            }
          
          $html .= '</ul>';
        
        echo  json_encode(['result' => "success", "notificationlist" => $html]);
   }
}

public function articles(){
    // echo 1;
  isAdminLogin();
  $articles = Article::all();
  $this->app->views("administrator/articles",['articles' => $articles]);

}

public function addNewArticle(){
    // echo 1;
  isAdminLogin();
  $leads = Lead::all();
  $this->app->views("administrator/addNewArticle",['leads' => $leads]);

}

//add new article and mark leads which already send article
public function addArticle(){

    isAdminLogin();

    if(!Input::exists("name") && !Input::exists("content")){
      textMsg("Article Name and content is required","error");
      Redirect::url("administrator/addNewArticle/");
      exit;

    }else{

        $name = Input::get("name");

        $content = Input::get("content");

        $article = new Article();
        $article->name = $name;
        $article->description = $content;
        $article->date = time();
        if($article->save()){

            if(Input::exists("leadids") && is_array(Input::get("leadids"))){

              $leadids = Input::get("leadids");
              $leads = Lead::all(['conditions' => "id IN (".implode(",", $leadids).")"]);
              if(count($leads) > 0){
                  foreach ($leads as $lead) {
                    $leadarticle = new LeadArticle();
                    $leadarticle->lead_id = $lead->id;
                    $leadarticle->article_id = $article->id;
                    $leadarticle->date = time();
                    $leadarticle->save();
                  }
              }
            }
            textMsg("Article Save Successfully","success");
            Redirect::url("administrator/addNewArticle/");
            exit;
        }else{
            textMsg("Something went wrong","error");
            Redirect::url("administrator/addNewArticle/");
            exit;
        }

    }
}


public function editArticle($id){

  isAdminLogin();
  $article = Article::all(['id' => $id]);
  if(count($article) > 0){

      $article = $article[0];
      $leads = Lead::all();
      $artical_leadids = [];
      $leadarticles = LeadArticle::all(["article_id" => $article->id]);
      foreach ($leadarticles as $value) {
        $artical_leadids[] = $value->lead_id;
      }
      $this->app->views("administrator/editArticle",['leads' => $leads, 'article' => $article, 'artical_leadids' => $artical_leadids]);

  }

}

//update article and mark leads which already send article
public function updateArticle(){

    isAdminLogin();
    if(!Input::exists("article_id")){
      textMsg("Something went wrong","error");
      Redirect::url("administrator/articles/");
      exit;
    }
    $article_id = Input::get("article_id");

    if(!Input::exists("name") && !Input::exists("content")){
      textMsg("Article Name and content is required","error");
      Redirect::url("administrator/editArticle/$article_id");
      exit;

    }else{

        $name = Input::get("name");

        $content = Input::get("content");

        $article = Article::all(['id'=>$article_id]);
        if(count($article) > 0){
            $article = $article[0];
            $article->name = $name;
            $article->description = $content;
            $article->date = time();
            if($article->save()){

              if(Input::exists("leadids") && is_array(Input::get("leadids"))){

                $leadarticles = LeadArticle::all(["article_id" => $article->id]);
                foreach ($leadarticles as $value) {
                   $value->delete();
                }
                $leadids = Input::get("leadids");
                $leads = Lead::all(['conditions' => "id IN (".implode(",", $leadids).")"]);
                if(count($leads) > 0){
                  // $artical_leadids = [];
                  // $leadarticles = LeadArticle::all(["article_id" => $article->id]);
                  // foreach ($leadarticles as $value) {
                  //   $artical_leadids[] = $value->lead_id;
                  // }
                  foreach ($leads as $lead) {

                    $leadarticle = new LeadArticle();
                    $leadarticle->lead_id = $lead->id;
                    $leadarticle->article_id = $article->id;
                    $leadarticle->date = time();
                    $leadarticle->save();
                  }
                }
              }
              textMsg("Article Updated Successfully","success");
              Redirect::url("administrator/articles/");
              exit;
            }else{
              textMsg("Something went wrong","error");
              Redirect::url("administrator/editArticle/$article_id");
              exit;
            }
        }

    }
}

//deletesigLead
public function deleteArticle(){

    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	      exit;

    }else{
	     $id = Input::get("id");
       $article = Article::all(['id' => $id]);

        if(count($article) > 0){
            if($article[0]->delete()){
                $leadarticles = LeadArticle::all(["article_id" => $id]);
                foreach ($leadarticles as $value) {
                   $value->delete();
                }
                echo  json_encode(['result' => "success"]);
            }else{
                echo  json_encode(['result' => "Something went wrong try again"]);
            }

        }
    }

}

//deletesigLead
public function sendArticletoLead(){

    isAdminLogin();

    if(!Input::exists("id") || !Input::exists("leadid")){
        echo  json_encode(['result' => "Required correct ids to do this action."]);
	      exit;

    }else{

	     $id = Input::get("id");
	     $leadid = Input::get("leadid");

       $lead = Lead::all(['id' => $leadid]);
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

  isAdminLogin();
  $articles = Article::all();
  $this->app->views("administrator/article-filter-page",['articles' => $articles]);

}

public function showFilterArticle(){
  isAdminLogin();

  if(Input::exists("token") && Input::exists("article") && Input::exists("showlead")){

      $key = Input::get("token");
      $articleid = Input::get("article");
      $showlead = Input::get("showlead");
      $leadfrom = Input::get("leadfrom");
      $lead_status = Input::get("lead_status");

      if(empty($key)|| empty($articleid) || empty($showlead)){

          textMsg("Article and Show Lead field is required","error");
          Redirect::url("administrator/articleFiltaration/");
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
            $leads = Lead::all(['conditions'=>$condition]);
            $articles = Article::all();
            $this->app->views("administrator/article-filter-page",['leads' => $leads, 'selectedarticle' => $selectedarticle, 'articles' => $articles, 'showlead' => $showlead, 'leadfrom' => $leadfrom, 'lead_status' => $lead_status]);

        }else{
            textMsg("Invalid Article selected","error");
            Redirect::url("administrator/articleFiltaration/");
            exit;
        }
      }

  }else{
      textMsg("somethis went wrong try again ","error");
      Redirect::url("administrator/articleFiltaration");
      exit;

  }
}


public function leadFiltaration(){

  isAdminLogin();
  $users = Subadmin::all(['status'=>1]);
  $business_lines = Businessline::all();
  $this->app->views("administrator/lead-filter-page",['users' => $users, 'business_lines'=>$business_lines]);

}

public function showFilterLeads(){
  isAdminLogin();

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
          Redirect::url("administrator/leadFiltaration/");
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
            $this->app->views("administrator/lead-filter-page",['users' => $users, 'lead_status'=>$lead_status, 'leads' => $leads, 'business_lines' => $business_lines, 'businesslines' => $businesslines, 'rom_branch_count'=>$rom_branch_counts, 'value_type'=>$rom_branch_counts, 'query'=>$query, 'value1'=>Input::get("value1"), 'lead_from'=>$leadfrom]);
			}
			else
			{
			$this->app->views("administrator/lead-filter-page",['users' => $users, 'lead_status'=>$lead_status, 'leads' => $leads, 'business_lines' => $business_lines, 'businesslines' => $businesslines, 'rom_branch_count'=>$rom_branch_counts, 'value_type'=>$rom_branch_counts, 'query'=>$query, 'value1'=>Input::get("value1"), 'value2'=>Input::get("value2"), 'lead_from'=>$leadfrom]);	
			}

      }

  }else{
      textMsg("somethis went wrong try again ","error");
      Redirect::url("administrator/leadFiltaration");
      exit;

  }


}






public function emailSend()
{
 $list = Newsletter::all();
 $status = Leadstatu::find_by_sql("SELECT DISTINCT name FROM leadstatus");
 $types= Leadstype::find_by_sql("SELECT * FROM leadstypes");
 $this->app->views("administrator/emailSend", (['list'=>$list, 'status'=>$status, 'types'=>$types]));	
}





public function emailSend1()
{
    require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'neil@bdforsale.com';                     // SMTP username
    $mail->Password   = 'CXG@2020@';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    
    

    // Attachments
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = Input::get("email_subject");
    $subject = Input::get("email_subject");
$campaign1 = Input::get("campaign");
$campaign = str_replace('_', ' ', $campaign1);
//$to = Input::get("receiver_email");
$template = Input::get("template");

$template=str_replace(' ','',$template);
//die ($template);
//die('test=>'.$template);
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
//$msg2=str_replace('|F_NAME|',$lead->ceo_name,$msg1);
$rp_ceo = explode(' ',$lead->ceo_name);
$msg2=str_replace('|F_NAME|',$rp_ceo[0],$msg1);
$msg=str_replace('|LINK_CLICK|',$link,$msg2);
$msg .= '<img src="http://bdforsale.com/administrator/emailtrack?code='.$track_code.'" width="1" height="1"  />';
//$msg .= '<br/><a href="http://bdforsale.com/administrator/emailtrack?code='.$track_code.'">testing</a>';
//die($msg);

$to = $lead->ceo_email;

$mail->setFrom('neil@brokerdealerforsale.com', 'Neil Delaney');
    $mail->addAddress( $to);     // Add a recipient
  
    $mail->Body    = $msg;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->track_code=$track_code;
    $mail->status="not opened";
    
    //$subject = "Bdforsale Inquiry";
    // $mail->$to1 = ($lead->ceo_name, $to);
    $mail->isHTML(true); 
    $mail->send();
    echo 'Message has been sent';
}
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
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





// public function emailclick()
// {
// date_default_timezone_set("Asia/Kolkata");
// if(isset($_GET['code']))
// {
// $code=$_GET['code'];
// $email=Email::all(['track_code'=>$code]);
// $email[0]->subject= $email[0]->subject;						
// $email[0]->msg= $email[0]->msg;
// $email[0]->email_id=$email[0]->email_id;
// $email[0]->track_code=$email[0]->track_code;
// $email[0]->status="clicked";
// $email[0]->open_datetime= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
// $email[0]->save();
// echo '<meta http-equiv="refresh" content="0;url=http://brokerdealerforsale.com">';
// }	
// }




public function emailer()
{

isAdminLogin();
     
$this->app->views("administrator/bulkemail");

}



public function emaileditor($id)
{
	isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/newsletterList/");
        exit;
    }else{

        $newsletters = Newsletter::all(['id'=>$id]);
        
        if(count($newsletters)>0){

        $this->app->views("administrator/editNewsletter",(['data'=>$newsletters[0]]));

        }
		else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/newsletterList/");
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
//die($code);
$id= $_POST['id'];
$newsletter = Newsletter::all(['id'=>$id]);
$newsletter[0]->code=$code;
$newsletter[0]->dates= date("Y-m-d H:i:s", STRTOTIME(date('h:i:sa')));
$newsletter[0]->save();
Redirect::url('/administrator/newsletterList');
//$this->app->views("administrator/insertcode");	
}





public function newsletterList()
{
	 isAdminLogin();
	$list=Newsletter::all(['status'=>1]);
    $this->app->views("administrator/newsletters",(['list'=>$list]));
}




public function viewNewsletter($id){
     isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/newsletterList/");
        exit;
    }else{

        $newsletters = Newsletter::all(['id'=>$id]);
        
        if(count($newsletters)>0){

        $this->app->views("administrator/viewnewsletter",(['data'=>$newsletters[0]]));

        }
		else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/newsletterList/");
            exit;

        }

    }
}


public function deleteNewsletter($id)
{
isAdminLogin();
if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/newsletterList/");
        exit;
}
else
{
	$newsletter = Newsletter::all(['id'=>$id]);
	if(count($newsletter)>0)
{
	$newsletter[0]->delete();
	Redirect::url("administrator/newsletterList/");	
}
else
{
	textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/newsletterList/");
        exit;
}
}
}





public function showCampaignList()
{
 isAdminLogin();
 $opened=array();
 $not_opened=array();
 $clicked=array();
 $template_id= array();
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
 
$this->app->views("administrator/campaign",(['list'=>$list, 'opened'=>$opened, 'not_opened'=>$not_opened, 'clicked'=>$clicked, 'temp_id'=>$temp_id])); }

public function showCampaign($campaign)
{
$space_remove = str_replace('_', ' ', $campaign);
isAdminLogin();
$list=Email::all(['campaign'=>$space_remove]);
if($campaign == null)
{
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/campaign/");
        exit;
}
else
{
$this->app->views("administrator/showCampaign",(['list'=>$list]));	
}
}








public function getCount()
{
isAdminLogin();
$tt = Leadstatu::find_by_sql("SELECT id from leadstatus where lead_type_id=".$_POST['type']." AND name='".$_POST['status']."'");
$count=count(Lead::find_by_sql("SELECT * from leads where lead_status_id=".$tt[0]->id));
echo $count;
}





public function getSubstatus()
{
isAdminLogin();
$tt = Leadsubstatu::find_by_sql("SELECT name from leadsubstatus where lead_status_id=".$_POST['status']."");
foreach($tt as $tt1)
{
echo $tt1->name.', ';	
}

}







public function sendFilterCampaign()
{
isAdminLogin();
//print_r($_POST['emails']);
$tst = explode(',',$_POST['emails'][0]);
$count = count($tst);
//die(print_r($tst));
 $list = Newsletter::all();
 $this->app->views("administrator/emailSendFilter", (['list'=>$list, 'count'=>$count, 'emails'=>$_POST['emails'][0]]));
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
            $link = '<div style="width:100%; margin:0 auto; max-width:100px; text-align:center; background:#1ed7d1; padding:10px 15px;"><a  style=" color:#fff; text-decoration:none; font-weight:bold;"href="http://bdforsale.com/administrator/emailclick?code=' . $track_code . '">Click Here</a></div>';
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
             echo '<script>window.location.href="http://bdforsale.com/administrator/leadFiltaration?msg=Emailer Sent Successfully"</script>';
            

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
            // echo 'Message has been sent';
             echo '<meta http-equiv="refresh" content="0;url=http://bdforsale.com/administrator/leadFiltaration?msg=Emailer Sent Successfully">';
       
    }
        else
        {
        echo "email not sent";	
        }
    }
        
    }
}



















public function getTest()
{
//echo phpinfo();
echo ini_get('session.gc_maxlifetime');    

}




public function followUps()
{
$today = strtotime('today');
$list_today = Followup::find_by_sql("SELECT * from followups where reminder_date LIKE '".$today."' order by date DESC");
$list_prev = Followup::find_by_sql("SELECT * from followups where reminder_date < '".$today."' order by date DESC");
$list_future = Followup::find_by_sql("SELECT * from followups where reminder_date > '".$today."' order by date DESC");
//echo strtotime('today');
$this->app->views("administrator/showFollowups",(['list_today'=>$list_today,'list_prev'=>$list_prev,'list_future'=>$list_future]));		
}




public function sendGrid()
{
require("sendgrid-php/sendgrid-php.php");
$from = new SendGrid\Email("Neil Delaney", "neil@brokerdealerforsale.com");
$subject = "Sending with SendGrid is Fun";
$to = new SendGrid\Email("Elmer", "naveen.uniyal5@gmail.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
//print_r($sg);
echo $response->statusCode();
}






































public function leadsubstatusdetail($id)
{
	isAdminLogin();
      if($id == null){
        textMsg("Something went wrong try again!" ,"error");
        Redirect::url("administrator/leadsfrom/");
        exit;
    }
	
else{

        $leadsubstatus = Leadsubstatu::all(['id'=>$id]);
        if(count($leadsubstatus)>0){

            $this->app->views("administrator/addLeadSubsubstatus",(['leadsubstatus'=>$leadsubstatus[0]]));

        }else{

            textMsg("Invaild lead try again","error");
            Redirect::url("administrator/leadsfrom/");
            exit;

        }

}
	
}
















public function addSubsubstatus()
{

    isAdminLogin();
	
    if(Input::exists("leadstypes") && Input::exists("name")){

            
            $leadid = Input::get("leadstypes");
            $name = Input::get("name");

            if(empty($leadid) || empty($name)){
				
                  textMsg("All fields are required","error");
                  Redirect::url("administrator/leadsfrom/");
                  exit;
            }else{

				$leadstypes = Leadsubstatu::all(['id'=>$leadid]);

				if(count($leadstypes)>0){

					$leadsubstatus = Leadsubsubstatu::all(['name' =>$name, 'lead_substatus_id'=>$leadid]);
					if(count($leadsubstatus)>0){
						
							textMsg("This name already exists try again","error");
							Redirect::url("administrator/leadfrom/$leadid");
							exit;

					}else{
                        //die('test');
						$leadsubstatus = new Leadsubsubstatu();
						$leadsubstatus->lead_substatus_id = $leadid;
						$leadsubstatus->name = $name;
						$leadsubstatus->date = time();
						$leadsubstatus->status = 1;

						if($leadsubstatus->save()){
								textMsg("New Status added succesfully","success");
								Redirect::url("administrator/leadsubstatusdetail/$leadid/");
								exit;
						}else{
								textMsg("something went wrong try again1","error");
								Redirect::url("administrator/leadsfrom");
								exit;

						}
					}
				}else{
					textMsg("something went wrong try again2","error");
					Redirect::url("administrator/leadsubstatusdetail/$leadid/");
					exit;

				}
            }

    }else{

        textMsg("something went wrong try again3","error");
        Redirect::url("administrator/leadsfrom");
        exit;

    }
	
}






public function deleteSubsubstatus()
{


    isAdminLogin();

    if(!Input::exists("id")){
        echo  json_encode(['result' => "Required correct id to do this action."]);
	    exit;

    }else{
	   $id = Input::get("id");


	if($id == 1){
		echo  json_encode(['result' => "Something went wrong try again"]);
		exit;
	}




       $data = Leadsubsubstatu::all(['id' => $id]);
        if(count($data) > 0){
if($data[0]->delete()){
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
		/*	$leads = Lead::all(['lead_status_id' => $id]);

			if(count($leads) <= 0){
				if($data[0]->delete()){
					echo  json_encode(['result' => "success"]);
				}else{
					echo  json_encode(['result' => "Something went wrong try again"]);
				}
			}else{
				echo  json_encode(['result' => "Status Used in  Lead"]);
			}
*/
        }
    }

	
}



public function leadsubstatus($leadstype,$leadstatus='',$leadsubstatus='', $leadsubsubstatus=''){
    $leadstatus = str_replace("_"," ",$leadstatus);
    $leadsubstatus = str_replace("_"," ",$leadsubstatus);
	$leadsubsubstatus = str_replace("_"," ",$leadsubsubstatus);
	//die('tst'.$leadstatus);
    isAdminLogin();
    $leadtype = Leadstype::all(['name'=>$leadstype]);
    if(count($leadtype)){
        $this->app->views("administrator/lead_by_substatus",['lead_type'=>$leadtype[0]->id,'leadcurrentstatus'=>$leadstatus,'leadcurrentsubstatus'=>$leadsubstatus, 'leadcurrentsubsubstatus'=>$leadsubsubstatus, 'lead_typename'=>$leadtype[0]->name]);

    }else{
        Redirect::url("/administrator");
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




if($leads[0]->leadfrom!=$leadfrom)
{
$v1 = Leadstype::all(['id'=>$leads[0]->leadfrom]);
$v2 = Leadstype::all(['id'=>$leadfrom]);	
$msg = "Lead Type Changed from ".$v1[0]->name." to ".$v2[0]->name;
                    createLog('Admin', 'Admin', $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}
	
if($leads[0]->lead_status_id!=$lead_status)
{
$v11 = Leadstatu::all(['id'=>$leads[0]->lead_status_id]);
$v21 = Leadstatu::all(['id'=>$lead_status]);
$msg = "Lead Status Changed from ".$v11[0]->name." to ".$v21[0]->name;
                    createLog('Admin', 'Admin', $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}	




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
$statuslog->changed_by = 0;
$statuslog->date = strtotime(date('y-m-d'));
$statuslog->save();
	
}	









	
if($leads[0]->lead_substatus_id!=$lead_substatus)
{
$v111 = Leadsubstatu::all(['id'=>$leads[0]->lead_substatus_id]);
$v211 = Leadsubstatu::all(['id'=>$lead_substatus]);
$msg = "Lead Sub-Status Changed from ".$v111[0]->name." to ".$v211[0]->name;
                    createLog('Admin', 'Admin', $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}
	
if($leads[0]->lead_subsubstatus_id!=$lead_subsubstatus)
{
$v1111 = Leadsubsubstatu::all(['id'=>$leads[0]->lead_subsubstatus_id]);
$v2111 = Leadsubsubstatu::all(['id'=>$lead_subsubstatus]);
$msg = "Lead Sub-Substatus Changed from ".$v1111[0]->name." to ".$v2111[0]->name;
                    createLog('Admin', 'Admin', $msg, $leadid = $id, $lead_type_id = $leadfrom, $lead_status_id = $lead_status); 	
}	
              $leads[0]->leadfrom = $leadfrom;
              $leads[0]->lead_status_id = $lead_status;
              $leads[0]->lead_substatus_id = $lead_substatus;
              $leads[0]->lead_subsubstatus_id = $lead_subsubstatus;

             if($leads[0]->save())
             {
            Redirect::url("/administrator/viewLead/".$id);
            exit;
             }
else
{
echo "error"    ;
}
}







public function view_logs(){
    isAdminLogin();
    $logs = Statuslog::find_by_sql("SELECT * from statuslogs order by id DESC");
    $this->app->views("administrator/view_logs",['logs' => $logs]);
}




public function editRequests()
{
//die('test');
$useredits = Useredit::all();
$this->app->views("administrator/editRequests",(['useredits'=>$useredits]));	
}



public function viewEdits($id)
{
$viewEdits = Useredit::all(['id'=>$id]);
$this->app->views("administrator/viewEdits",(['data'=>$viewEdits]));
}




public function deleteEdits($id)
{
$Edits = Useredit::all(['id'=>$id]);
$Edits[0]->delete()	;
Redirect::url("/administrator");
}





public function markComplete($id)
{
$edit = Useredit::all(['id'=>$id]);
$edit[0]->status = 1;
$edit[0]->save();
Redirect::url("/administrator");	
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
Redirect::url("/administrator");	
	
}



public function deleteFollowup($id)
{

$follows = Followup::all(['id'=>$id]);
//die(print_r($follows->id));
$follows[0]->delete();
return header('Location:'.BASEURL.'/administrator/followups');	
}







public function editFollowup($id)
{
$data = Followup::all(['id'=>$id]);
$this->app->views("administrator/editFollowup",(['data'=>$data]));
}





public function updateFollowup()
{
	//die('test'.strtotime(input::get('reminder_date')));
//die(input::get('leadid'));
$edit = Followup::all(['id'=>Input::get('id')]);
$edit[0]->leadid = Input::get('leadid');
$edit[0]->msg = Input::get('msg');
$edit[0]->user_id = implode(',',Input::get('user'));
$edit[0]->priority = Input::get('priority');
$edit[0]->reminder_date = strtotime(Input::get('reminder_date'));
$followup->assigned_by = Input::get('assigned_by');
$edit[0]->save();	
return header('Location:'.BASEURL.'/administrator/followups');	
}




public function addArchive($id)
{
$leads = Lead::all(['id'=>$id]);
//Redirect::url("/administrator/viewLead/".$id);
$insert = new Archive();
$insert->status = 1;
$insert->leadid= $leads[0]->id;
$insert->lead_crd = $leads[0]->firm_crd;
$insert->date = strtotime(date('d-m-Y'));
$insert->save();


$leads[0]->status = 0;
$leads[0]->save();
//echo 'Archived';
Redirect::url("administrator/leads/");
}










public function archiveLeads()
{
 $archives = Archive::all(); 
 $this->app->views("administrator/archiveList",(['archives'=>$archives])); 
}







public function restoreLead($id)
{
$data = Archive::all(['id'=>$id]);
$lead = Lead::all(['id'=>$data[0]->leadid]);
$lead[0]->status = 1;
$lead[0]->save();
$data[0]->delete();
//echo "restored";
Redirect::url("administrator/leads");
}





public function leadSearch($id)
{
$leads = Lead::all(['leadfrom'=>$id]);
$this->app->views("administrator/leadSearch",(['lead_category'=>$id,'leads'=>$leads]));

}

public function leadsUser()
{
 isAdminLogin();
 $leads = Addlead::all();
 $this->app->views('administrator/userLeads',['leads'=>$leads]);   
}


















public function verifyBusinesslines($id)
{
$data = Lead::all(['id' => $id]);
$data[0]->verify_business = 1;
$data[0]->verify_business_on = time();
$data[0]->save();	
Redirect::url("administrator/viewLead/".$id);	
}




























public function rejectEdits()
{
$data = Useredit::all(['id' => Input::get('id')]);
$data[0]->status = 2;
$data[0]->comments = Input::get('comments');
$data[0]->save();
Redirect::url("administrator/editRequests/");	

	
}

public function ssp()
{
$this->app->views('ssp.class');   	
}


public function server_side()
{
$this->app->views('server_side');   	
}
















public function accessRequests()
{
$access = Access::all();
//die('tt=>'.$_COOKIE['userId']);
$this->app->views("administrator/accessRequests",(['access'=>$access]));		
}


public function acceptRequest($id)
{
$data = Access::all(['id' => $id]);
$data[0]->status = 1;

$data[0]->save();
Redirect::url("administrator/accessRequests/");
		
}



public function rejectRequest($id)
{
$data = Access::all(['id' => $id]);
$data[0]->status = 2;

$data[0]->save();
Redirect::url("administrator/accessRequests/");
		
}






































public function uploadcampaign()
    {
        isAdminLogin();
        $this->app->views("administrator/uploadcampaign");
    }
    
 
 
 public function createCampaignFromExcel()
 {
    

        isAdminLogin();
        // check file name is not empty

        if (!empty($_FILES['leadexcelfile']['name'])) {
            

            // Get File extension eg. 'xlsx' to check file is excel sheet
            $pathinfo = pathinfo($_FILES["leadexcelfile"]["name"]);

            // check file has extension xlsx, xls and also check
            // file is not empty
            if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls')
                && $_FILES['leadexcelfile']['size'] > 0
            ) {

                // Temporary file name
                $inputFileName = $_FILES['leadexcelfile']['tmp_name'];

                // Read excel file by using ReadFactory object.
                $reader = ReaderFactory::create(Type::XLSX);

                // Open file
                $reader->open($inputFileName);
                $count = 1;

                $data = array();

                foreach ($reader->getSheetIterator() as $sheet) {

                    // Number of Rows in Excel sheet
                    foreach ($sheet->getRowIterator() as $key => $row) {

                        // It reads data after header. In the my excel sheet,
                        // header is in the first row.
                        if ($key == 1) {
							//die($key);
							
                            if (!((strtolower($row[11]) == strtolower("firm_crd")))) {

                                textMsg("Upload Excel file with correct header title and sequence", "error");
                                echo json_encode(['result' => "Upload Excel file with correct header title and sequence"]);
                                // Redirect::url("administrator/uploadlead");
                                exit;
                            }
                        } else {
                            break;
                        }
                    }
                }

                $le = array();
                // Number of sheet in excel file
                foreach ($reader->getSheetIterator() as $sheetno => $sheet) {

                    // Number of Rows in Excel sheet
                    foreach ($sheet->getRowIterator() as $key => $row) {

                        // It reads data after header. In the my excel sheet,
                        // header is in the first row.
                        if ($key == 1 && $sheetno > 1) {

                        } else {

                            if ($count > 1) {
                                
                                

                                // Data of excel sheet
                                $firm_crd = $row[11];
                                

                                $cleads = new Clead();
                                // $leads = new stdClass();
                                // $leads->key = $key;
                                $cleads->firm_crd = $firm_crd;
                                
                                $cleads->date = time();
                                $cleads->status = 1;

                                array_push($le, $cleads);
                                $cleads->save();
                            }
                            $count++;
                        }
                    }
                }

                // Close excel file
                $reader->close();

                textMsg("Excel Uploaded Successfully", "success");
                echo json_encode(['result' => "Excel Uploaded Successfully"]);
				exit;
				var_dump($le);
                // echo json_encode(['leads' => $le]);
                // echo json_encode(['result' => "success"]);
                // Redirect::url("administrator/leads");
                exit;
            } else {

                textMsg("Please Select Valid Excel File", "error");
                echo json_encode(['result' => "Please Select Valid Excel File"]);
                // Redirect::url("administrator/uploadlead");
                exit;
            }
        } else {

            textMsg("Please Select Excel File", "error");
            echo json_encode(['result' => "Please Select Excel File"]);
            // Redirect::url("administrator/uploadlead");
            exit;
        }
     
     
     
 }















































































 public function SendCampaignMail(){
        isAdminLogin();
        $users = Subadmin::all(['status' => 1]);
        $business_lines = Businessline::all();
        $campleads = Clead::all();
        $this->app->views("administrator/SendCampaignMail", ['users' => $users, 'business_lines' => $business_lines, 'campleads' => $campleads]);

    }
    
    


public function sendCFilterCampaign()
    {
        isAdminLogin();
        //print_r($_POST['emails']);
        $tst = explode(',', $_POST['emails'][0]);
        $count = count($tst);
        //die(print_r($tst));
        $list = Newsletter::all();
        $this->app->views("administrator/emailCampaignSendFilter", (['list' => $list, 'count' => $count, 'emails' => $_POST['emails'][0]]));
    } 
    
    





public function sendCLeadFilterCampaign()
    {
	

        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions


        {
            $email = new PHPMailer(true);
            //Server settings
            $email->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $email->isSMTP();                                            // Send using SMTP
            $email->Host       = 'mail.brokerdealerforsale.com';                       // Set the SMTP server to send through
            $email->SMTPAuth   = true;                                   // Enable SMTP authentication
            $email->Username   = 'notifications@bdfs.brokerdealerforsale.com';             // SMTP username
            $email->Password   = '123456';                         // SMTP password
            $email->SMTPSecure = NULL;        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $email->Port       = 587;
            //$email->SMTPKeepAlive = true;                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

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
                $tt = Lead::find_by_sql("SELECT * from leads where ceo_email LIKE '" . $lead . "'");
                //die(print_r($tt[0]->ceo_email));
                $track_code = md5(rand());
                $link = '<div style="width:100%; margin:0 auto; max-width:100px; text-align:center; background:#1ed7d1; padding:10px 15px;"><a  style=" color:#fff; text-decoration:none; font-weight:bold;"href="http://markuplounge.com/bdfsmarchcrm/administrator/emailclick?code=' . $track_code . '">Click Here</a></div>';
                //$msg2=str_replace('|F_NAME|',$tt[0]->ceo_name,$msg1);
                $rp_ceo = explode(' ', $tt[0]->ceo_name);
                $msg2 = str_replace('|F_NAME|', $rp_ceo[0], $msg1);
                $msg = str_replace('|LINK_CLICK|', $link, $msg2);
                $msg .= '<img src="http://bdforsale.com/administrator/emailtrack?code=' . $track_code . '" width="1" height="1" />';
                //$msg .= '<br/><a href="http://markuplounge.com/bdfsmarchcrm/administrator/emailtrack?code='.$track_code.'">testing</a>';
                //die($msg);  
                $header .= "Content-type:text/html;charset=UTF-8";

                $to = $tt[0]->ceo_email;
                $to1 = $tt[0]->ceo_name;
                $users = [
                    ['email' => $to, 'name' => $to1],
                ];

                if ($header) {
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
                            //echo "Message sent to: ({$user['email']}) {$email->ErrorInfo}\n";
                        } catch (Exception $e) {
                            echo "Mailer Error ({$user['email']}) {$email->ErrorInfo}\n";
                        }

                        $email->clearAddresses();
                    }
                    


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
                    //echo '<meta http-equiv="refresh" content="0;url=http://bdforsale.com/administrator/SendCampaignMail?msg=Emailer Sent Successfully">';

                } else {
                    echo "email not sent";
                }
            }
        }
    }



}//mainfunction
