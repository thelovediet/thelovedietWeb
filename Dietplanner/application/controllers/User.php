<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User extends REST_Controller {
	public function __construct(){
	parent::__construct();
	 $this->load->model('User_model');	 
	
	}
public function forgetpassword_post(){
	$email=$_POST['email'];
	$checkuserexit['data']=$this->User_model->get_by(array('email' => $email));
	

	if(!$checkuserexit['data']){
		
	}else{
		print_R($checkuserexit['data']);
		
		die();
	  $token=md5(uniqid(rand(), true));
	  $result_forgetpassword = array(
            'userid' => $userid,
            'email' => $email,
            'token' => $token
          );
		  
		 $result= $this->db->insert('forgetpassword', $result_forgetpassword);
	     $insert_id = $this->db->insert_id();

		if($insert_id === FALSE)
        {
            
        }else{
			$link="http://fliptransfers.com/forgetpassword.php?token=".$token;
			$emailbody="Hello</br> Please click on the link below to change your passsword </br> <a href=".$link.">".$link."</a>";
			
			 $issent=$this->forgetPasswordEmail($email,$emailbody); 
			if($issent){
				
				
			}else{
				
			}
        }
	}
	
	
  }
   
public function login_post(){
	$data=$this->post();
	$password=md5($data['password']);
	$email=$data['email'];
	$checkuserexit['data']=$this->User_model->get_by(array('email' => $email,'password'=>$password));
	
	if($checkuserexit['data']){
	   $this->response([
                    'result' =>$checkuserexit,
                    'status' =>true,
                    'message' =>'Login Successfully.'
                ], REST_Controller::HTTP_OK);
	}else{
		 $this->response([
                    'result' =>[],
                    'status' =>false,
                    'message' =>'Invalid Email or Password.'
                ], REST_Controller::HTTP_OK);
	}
}	
public function register_post(){
	$data=$this->post();
	$password=md5($data['password']);
	$data['password']=$password;
	$email=$data['email'];
	$checkuserexit['data']=$this->User_model->get_by(array('email' => $email));
	if($checkuserexit['data']){
	   $this->response([
                    'result' => $checkuserexit,
                    'status' => true,
                    'message' => 'User Already Exit with this email'
                ], REST_Controller::HTTP_OK);
	}
	$result=$this->User_model->insert($data);
	
	if($result){
		$data2['data']=$this->User_model->get_by(array('id' => $result));
		$this->response([
                    'result' => $data2,
                    'status' => true,
                    'message' => 'New User Has been registered'
                ], REST_Controller::HTTP_OK);
	}else{
		$this->response([
                    'result' => [],
                    'status' => FALSE,
                    'message' => 'Failed to Create the new user'
                ], REST_Controller::HTTP_OK);
	}
	
           
}
}
