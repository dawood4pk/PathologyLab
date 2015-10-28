<?php
	define("TITLE", "PathologyLab");
	$this->load->view('includes/toptemplate.php');
?>
	<form id="validateForm" method="post" action="patient_save">
		<?php echo $strHiddenFld ?>
		<div class="mainDiv">

			<h3> PATIENT </h3>
			 <div class="body-content">
				 <?php
				 if($this->session->userdata('error') != '')
				 {
					 ?>
					<div style="color:#F00"><?php echo $this->session->userdata('error'); ?></div>
					<?php
					$this->session->set_userdata('error','');
				 }
				 ?>
				<div class="panel">

					<div>
						<div>
							FIRST NAME :
						</div>
						<div >
							<input maxlength="100" id="fname" title="First Name" name="fname" type="text" value="<?php echo $strFirstName; ?>" />
						</div>
					</div>

					<div>
						LAST NAME :
					</div>
					<div>
						<input maxlength="100" id="lname" name="lname" type="text" title="Last Name" value="<?php echo $strLastName; ?>" />
					</div>
				</div>

				<div class="panel">

					<div>
						<div>
							USER NAME :
						</div>
						<div>

							<input type="text" title="User Name" id="uname" name="uname" value="<?php echo $strUserName; ?>"  />

						</div>
					</div>
					<div>
						<div>
							PASS CODE :
						</div>
						<div>
							<input type="text" title="Pass Code" name="pcode" id="pcode" value="<?php echo $strPassCode; ?>"  />

						</div>
					</div>
				</div>

				<div id='footer_buttons' class="btn_save">
					<input class="btn-submit" id="btnaction" type="submit" value=<?php if(isset($_GET['pid'])){echo "Update";}else{echo "Save";}?> />
					<a href="<?php echo base_url()?>home/patients">Cancel</a>
				</div>
			</div>
		</div>

	</form>

<?php
	$this->load->view('includes/bottomtemplate.php');
?>