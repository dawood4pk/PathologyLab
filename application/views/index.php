<?php
	define("TITLE", "PathologyLab");
	$this->load->view('includes/toptemplate.php');
?>

<?php
	if($this->session->userdata('logged_in'))
	{
		print '';
	}//End of Session If.
	else
	{
		print '<a href="'.base_url().'patient">Patient Login</a>';
	}// End of Session Else.
?>

<?php
	$this->load->view('includes/bottomtemplate.php');
?>