<?php
	define("TITLE", "PathologyLab - Patient");
?>
<!DOCTYPE html>
<html lang="en" >
<!--[if lt IE 9]>
     <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo TITLE?></title>
        <?php
			$this->load->view('includes/include_top.php');
		?>
    </head>
    <body>

		<?php
		
			if($this->session->userdata('logged_in'))
			{
				$sess = $this->session->userdata('logged_in');
				if ( $sess['usertype'] == 'patient')
				{
					?>
					<P>Welcome <?php print $sess['patient_username']; ?> [<?php print $sess['patient_lastname']; ?>, <?php print $sess['patient_firstname']; ?>]</p>
					<ul>
						<li>
							<a href="<?php echo base_url()?>patient/report">PDF</a>
						</li>
						<li>
							<a class="button" href="<?php echo base_url()?>home/logout">logout</a>
						</li>
					</ul>

					<table align="center" border="0" width="80%">
						<tr>
						<tr>
						<tr><td colspan="2">
							<table align="center" width="100%"  border="1" cellspacing="0" cellpadding="2" class="LstTbl">
								<tr style="background-color:#B6B6B6;"> 
									<td>Report Name</td>
									<td>Test Name</td>
									<td>Test Result</td>

								</tr>
							<?php

							   foreach($patient_report as $row)
							   {
								   
							   ?>                   
								<tr>
									
									<td><?php echo $row['report_name'] ?></td>
									<td><?php echo $row['test_name'] ?></td>
									<td><?php echo $row['test_result'] ?></td>
								</tr>
							<?php }?>
							</table>
						</td></tr></table>
					<?php
					
					//print '<pre>';print_r($patient_report);
				}
				else
				{
					print '<p>You are not authorized to view this page.</p>';
				}
			}
			else
			{
				?>
					<div class="login form">
						<div class="header">
							<h2>Patient Login</h2>
						</div>

						<div id="errorDiv"></div>

						<form id="patientLoginForm" name="patientLoginForm" method="post">
							<input type="hidden" name="baseURL" value="<?php echo base_url();?>">
							<input type="text" id="patientusername" name="patientusername" placeholder="Patient Username" />
							<input type="text" id="patientpasscode" name="patientpasscode" placeholder="Pass Code" />
							<input id="patientLoginBtn" type="Submit" value="Login" />
							<hr>
						</form>
					</div>
				<?php
			}
	
	$this->load->view('includes/bottomtemplate.php');
?>