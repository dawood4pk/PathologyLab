<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$data['title'] = 'Home';
		$this->load->model('index_model');

		if($this->session->userdata('logged_in'))
	   	{
		 	$session_data = $this->session->userdata('logged_in');
			
			if ($session_data['usertype'] == 'admin')
			{
				$data['id'] = $session_data['id'];
				$data['usertype'] = $session_data['usertype'];
				$data['username'] = $session_data['username'];
			}
			$this->load->view('index', $data);
	   	}
	   	else
	   	{
			//exit;
			$this->load->view('index', $data);
			//redirect(base_url(),'refresh');
	   	}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: login									          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function login()
    {
        if( isset($_POST['username']) && isset($_POST['Password']))
        {
    		$strUserName = strtolower(trim(strip_tags($this->input->post('username'))));
			//$strPassword = base64_encode($this->input->post('Password'));
			$strPassword = md5($this->input->post('Password'));

			if($strUserName != '' && $strPassword != '')
			{
				$this->load->model('login_form_model');
				$result = $this->login_form_model->login($strUserName, $strPassword);
				if($result)
				{
					 $sess_array = array();
					 foreach($result as $row)
					 {
					   $sess_array = array(
						 'id' => $row->id,
						 'username' => $row->username,
						 'usertype' => 'admin'
					   );

					   $this->session->set_userdata('logged_in', $sess_array);
					 	echo 1;
					   }
					 //redirect(base_url(),'refresh');
				}
				else
				{
					echo "Invalid username or password.";
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
	//										Function: logout								          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function logout()
	{
		$this->session->sess_destroy();
		redirect( base_url(),'refresh' );
	}//End of logout function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: patients								          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function patients()
    {
		if($this->session->userdata('logged_in'))
		{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('patient_model');

				$nPerPage = 10;
				$config['uri_segment']  =   3;
				$config['num_links']    =   2;
				$config['first_link']   =   '<<';
				$config['last_link']    =   '>>';
				$config['base_url']     =   base_url() . 'home/patients';
				$config['total_rows']   =  $this->patient_model->patient_count();
				$config['per_page']     =   $nPerPage;
				$offset = $this->uri->segment(3);
				if( $offset == "" )
					$offset=0;
				$this->pagination->initialize( $config );
				$data["paging_links"] = $this->pagination->create_links();
				$arPatientList['arPatientList'] = $this->patient_model->patient_list( $nPerPage,$offset );
				$arPatientList['strMsg'] = "List of Patients.";
				$this->load->view( "patient_list", $arPatientList );
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
    }//End of patients function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: patient								          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function patient()
	{
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('patient_model');
				if(isset($_GET['pid']))
				{
					$nPId = $_GET['pid'];
					$arDataP = $this->patient_model->get_patient_data( $nPId );
					//echo "<pre>";print_r($arDataP);exit;
					$arPatient['strUserName'] = $arDataP[0]['patient_username'];
					$arPatient['strPassCode'] = $arDataP[0]['patient_passcode'];
					$arPatient['strFirstName'] = $arDataP[0]['patient_firstname'];
					$arPatient['strLastName'] = $arDataP[0]['patient_lastname'];
					$arPatient['strHiddenFld'] = "<input type=hidden name=id value=$nPId>";
				}
				else
				{
					$arPatient['strUserName'] = "";
					$arPatient['strPassCode'] = "";
					$arPatient['strFirstName'] = "";
					$arPatient['strLastName'] = "";
					$arPatient['strHiddenFld'] = "";
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
			$this->load->view('patient_view', $arPatient);
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
	}//End of patient function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: patient_save								      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function patient_save()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$strFirstName = trim(strip_tags($this->input->post('fname')));
				$strLastName = trim(strip_tags($this->input->post('lname')));
				$strUuserName = trim(strip_tags($this->input->post('uname')));
				$strPassCode = trim(strip_tags($this->input->post('pcode')));
					
				if($strFirstName == "" || $strLastName == "" || $strUuserName == "" || $strPassCode == "" )
				{
					$this->session->set_userdata('error', 'Empty Field.');
					redirect(base_url().'home/patient','refresh');
				}
				else
				{
					
					$this->load->model('patient_model');
					//patient_id,
					//,,	,
					$patientData = array(
								'patient_username'=>$strUuserName,
								'patient_passcode'=>$strPassCode,
								'patient_firstname'=>$strFirstName,
								'patient_lastname'=>$strLastName
							   );
					
					if( isset($_POST['id']) )
					{
						$pId = trim( strip_tags( $_POST['id'] ) );
						$this->patient_model->update_patient($pId, $patientData);
					}
					else
					{
						$patientId = $this->patient_model->save_patient( $patientData );
					}
					
					redirect(base_url().'home/patients','refresh');
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}	
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
    }//End of patient_save function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: patientdelete								      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function patientdelete()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{

				$this->load->model('patient_model');

				if( isset($_GET['pid']) )
				{
					$nPId = trim( strip_tags($_GET['pid']) );
					$this->patient_model->patient_delete( $nPId );
				}
				$this->patients();

			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}	
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
    }//End of patientdelete function.
	//////////////////////////
	//////////////////////////////////////////
	////////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: reports								          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function reports()
    {
		if($this->session->userdata('logged_in'))
		{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				$nPerPage = 10;
				$config['uri_segment']  =   3;
				$config['num_links']    =   2;
				$config['first_link']   =   '<<';
				$config['last_link']    =   '>>';
				$config['base_url']     =   base_url() . 'home/reports';
				$config['total_rows']   =  $this->report_model->report_count();
				$config['per_page']     =   $nPerPage;
				$offset = $this->uri->segment(3);
				if( $offset == "" )
					$offset=0;
				$this->pagination->initialize( $config );
				$data["paging_links"] = $this->pagination->create_links();
				$arReportList['arReportList'] = $this->report_model->report_list( $nPerPage,$offset );
				$arReportList['strMsg'] = "List of Reports.";
				$this->load->view( "report_list", $arReportList );
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
    }//End of reports function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: report								          //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function report()
	{
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('patient_model');
				$this->load->model('report_model');

				$arReport['patient_cmd'] = $this->patient_model->get_patient_cmb();

				if(isset($_GET['rid']))
				{
					$nRId = $_GET['rid'];
					$arDataR = $this->report_model->get_report_data( $nRId );
					//echo "<pre>";print_r($arDataR);exit;
					$arReport['strReportId'] = $arDataR[0]['report_id'];
					$arReport['strReportName'] = $arDataR[0]['report_name'];
					$arReport['strPatientId'] = $arDataR[0]['patient_id'];
					$arReport['strHiddenFld'] = "<input type=hidden name=id value=$nRId>";
					
				}
				else
				{
					$arReport['strReportId'] = "";
					$arReport['strReportName'] = "";
					$arReport['strPatientId'] = 0;
					$arReport['strHiddenFld'] = "";
				}

				$this->load->view('report_view', $arReport);
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
	}//End of report function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: report_save								      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function report_save()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('patient_model');
				$this->load->model('report_model');

				//print_r($_POST);
				//----------------
				//echo "<pre>";print_r($_POST);
				//return;

				if(isset($_POST['rowcount']) && $_POST['rowcount']> 0)
				{
					$nRCount = trim($_POST['rowcount']);
					$strReportName = trim(strip_tags($this->input->post('rname')));
					$strPatientId = trim($_POST['patientID']);

					$repData = array(
						'report_name'=>$strReportName,
						'patient_id'=>$strPatientId
					);

					if(isset($_POST['id']))
					{
						$rId = trim($_POST['id']);
						$this->report_model->update_report($rId,$repData);
						$this->report_model->patient_report_delete($rId);
					}
					else
					{
						$rId = $this->report_model->save_report($repData);
					}

					//---------------------------------

					for($cnt=1;$cnt<=$nRCount;$cnt++)
					{
						if(isset($_POST['myGrid_t_testname_'.$cnt]))
						{
							$strTestId = trim($this->input->post('myGrid_t_id_'.$cnt));
							$strTestName = trim($this->input->post('myGrid_t_testname_'.$cnt));
							$strTestResult = trim($this->input->post('myGrid_t_testresult_'.$cnt));

							$patientReportData = array(
								'report_id'=>$rId,
								'test_id'=>$strTestId,
								'test_result'=>$strTestResult
							);
							$this->report_model->save_patient_report($patientReportData);
							
						}
					}
					redirect(base_url().'home/reports','refresh');
					
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
		
    }//End of report_save function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: reportdelete		        		    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	public function reportdelete()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				if(isset($_GET['rid']))
				{
					$nRId = trim($_GET['rid']);
					$this->report_model->patient_report_delete($nRId);
					$this->report_model->report_delete($nRId);
				}
				$this->reports();
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
    }//End of reportdelete function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: get_medical_test_info				    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function get_medical_test_info()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				if(isset($_POST['testname']))
				{
					$testNanme = $_POST['testname'];
					$arrTestInfo = $this->report_model->get_medical_test_info($testNanme);
					//echo 'dawood:'.$arrTestInfo[0]['test_id'];return;
					if(isset($arrTestInfo[0]['test_name']))
					{
						$strInfo = $arrTestInfo[0]['test_id']."|".$arrTestInfo[0]['test_name'];
						echo $strInfo;
					}
					else
						echo 0;
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
		
    }//End of get_medical_test_info function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: save_medical_test					    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function save_medical_test()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				if(isset($_POST['testname']))
				{
					$strTestName = trim(strip_tags($this->input->post('testname')));
					$testData = array('test_name'=>$strTestName);
					$testId = $this->report_model->save_medical_test($testData);
					if( $testId > 0 )
						echo trim($testId);
					else
						echo 0;
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
		
    }//End of save_medical_test function.

	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: save_medical_test					    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	function edit_medical_test()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				if(isset($_POST['testid']))
				{
					$strTestId = trim(strip_tags($this->input->post('testid')));
					$strTestName = trim(strip_tags($this->input->post('testname')));

					$testData = array('test_name'=>$strTestName);
					$testId = $this->report_model->update_medical_test($strTestId, $testData);
					//echo $artId.'<-Dawood';return;

					if( $testId > 0 )
						echo trim($artId);
					else
						echo 0;
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
		
    }//End of edit_medical_test function.
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//										Function: medical_test_ac					    	      //
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// to get medical test to auto complete
    function medical_test_ac()
    {
		if($this->session->userdata('logged_in'))
	   	{
			$sess = $this->session->userdata('logged_in');
			if ( $sess['usertype'] == 'admin')
			{
				$this->load->model('report_model');

				//echo "<pre>";        print_r($_POST);         exit;
				if(isset($_GET['term']))
				{
					$strTestName = strtolower(trim($_GET['term']));
					if($strTestName!="")
					{
						$arrArt=$this->report_model->medical_test_to_ac($strTestName);
						echo $arrArt;
					}
				}
			}
			else
			{
				print '<p>You are not authorized to view this page.</p>';
			}
		}
		else
		{
			print '<p>Please <a href="'.base_url().'">Login</a></p>';
		}
		
    }//End of medical_test_ac function.
}
