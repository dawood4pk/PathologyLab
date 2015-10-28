<?php
class login_form_model extends CI_Model
{
    function Login_mod_new()
    {
		// Call the Model constructor
        //parent||CI_Model();
		parent::Model();
       	//$this->load->database();
    }

	//---------------------------------
	// Function: login
	//---------------------------------
     function login($username, $password)
	 {
	   	$this -> db -> select('*');
	   	$this -> db -> from('users');
	   	$this -> db -> where('username', $username);
		$this -> db -> where('password', $password);
	   	$this -> db -> limit(1);
	   	$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
		 	return false;
		}
	 }
	 
	 //---------------------------------
	// Function: login
	//---------------------------------
     function patients_login($username, $password)
	 {
	   	$this -> db -> select('*');
	   	$this -> db -> from('patients');
	   	$this -> db -> where('patient_username', $username);
		$this -> db -> where('patient_passcode', $password);
	   	$this -> db -> limit(1);
	   	$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
		 	return false;
		}
	 }
}
?>