<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends MY_Model {

   public function __construct()
    {
        parent::__construct();
		
		}
	protected $_table="users";
	protected $primary_key="id";
	protected $return_type="array";
	public $before_create = array('created_at','updated_at' );
	
	
}