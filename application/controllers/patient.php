<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Default Constructor 									  //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct()
    {
        parent::__construct();
		//$this->load->library('uri');

		//Problem
	    //$this->load->library('Includes');
		//$this->load->library('session');
		//$this->load->library('validation');

		//Working
		//$this->load->helper('url_helper');
		//$this->lang->load('user','english');
        $this->load->library('pagination');
        $this->load->helper('phpfunctions');
		//$this->load->helper('url_helper');

    }//End of Constructor.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Default View  Load										  //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function index()
	{
		$this->load->model('report_model');
		$data['title'] = 'Patient';
		if($this->session->userdata('logged_in'))
	   	{
		 	$session_data = $this->session->userdata('logged_in');
			
			if ($session_data['usertype'] == 'patient')
			{
				$data['patient_id'] = $session_data['patient_id'];
				$data['usertype'] = $session_data['usertype'];
				$data['patient_username'] = $session_data['patient_username'];
				$data['patient_firstname'] = $session_data['patient_firstname'];
				$data['patient_lastname'] = $session_data['patient_lastname'];
				$data['patient_report'] =  $this->report_model->get_patient_report($session_data['patient_id']);
			}
		 	$this->load->view('patient/patient_login_form.php', $data);
	   	}
	   	else
	   	{
			//exit;
			$this->load->view('patient/patient_login_form.php', $data);
			//redirect(base_url(),'refresh');
	   	}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: login									          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function login()
    {
        if( isset($_POST['patientusername']) && isset($_POST['patientpasscode']))
        {
    		$strPatientUserName = strtolower(trim(strip_tags($this->input->post('patientusername'))));
			$strpatientPassCode = $this->input->post('patientpasscode');

			if($strPatientUserName != '' && $strpatientPassCode != '')
			{
				$this->load->model('login_form_model');
				$result = $this->login_form_model->patients_login($strPatientUserName, $strpatientPassCode);
				if($result)
				{
					 $sess_array = array();
					 foreach($result as $row)
					 {
					   $sess_array = array(
						 'patient_id' => $row->patient_id,
						 'patient_username' => $row->patient_username,
						 'patient_firstname' => $row->patient_firstname,
						 'patient_lastname' => $row->patient_lastname,
						 'usertype' => 'patient'
						 
					   );

					   $this->session->set_userdata('logged_in', $sess_array);
					 	echo 1;
					   }
					 //redirect(base_url(),'refresh');
				}
				else
				{
					echo "Invalid username or pass code.";
				}
			}
			else
			{
				//Error: Some of fileds are Empty.
				echo "Some of fileds are Empty.";
			}
		}
		else
		{
			//Error: Some fields are not Defined.
			echo "Some fields are not Defined.";
		}
    }// end of function login().
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: patient_username_ac				    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// to get patient username to auto complete
    function patient_username_ac()
    {
		$this->load->model('patient_model');

		//echo "<pre>";        print_r($_POST);         exit;
		if(isset($_GET['term']))
		{
			$strUserName = strtolower(trim($_GET['term']));
			if($strUserName!="")
			{
				$arrArt=$this->patient_model->patient_username_to_ac($strUserName);
				echo $arrArt;
			}
		}
    }//End of patient_username_ac function.

	 function report()
	 {
		 $this->load->library('cezpdf');
		 
		 if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'patient')
			{
				$this->load->model('report_model');
				$reportpdf = $this->report_model->get_patient_report($sess['patient_id']);
				foreach($reportpdf as $row)
				{
					$db_data[] = array('rname' => $row['report_name'], 'tname' => $row['test_name'], 'tresult' => $row['test_result']);
				}
				$col_names = array(
				 'rname' => 'Report Name',
				 'tname' => 'Test Name',
				 'tresult' => 'Test Result'
				 );

				 $this->cezpdf->ezTable($db_data, $col_names, 'Patient Report', array('width'=>550));
			}
			else
			{
				$this->cezpdf->ezText('Access Denied', 12, array('justification' => 'center'));
				$this->cezpdf->ezSetDy(-10);
				$content = 'You are not authorized to view this page.';
				$this->cezpdf->ezText($content, 10);
			}
		}
		else
		{
			$this->cezpdf->ezText('Access Denied', 12, array('justification' => 'center'));
			$this->cezpdf->ezSetDy(-10);
			$content = 'Please Login.</a>.';
			$this->cezpdf->ezText($content, 10);
		}
		 
		 $this->cezpdf->ezStream();
		 //$this->cezpdf->ezOutput();
	 }
}
