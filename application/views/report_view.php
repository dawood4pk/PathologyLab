<?php
	define("TITLE", "PathologyLab");
	$this->load->view('includes/toptemplate.php');
	$this->load->view('medical_test_popup.php');
?>
	<form id="validateForm" method="post" action="report_save">
		<?php echo $strHiddenFld ?>
		<div class="mainDiv">

			<h3> REPORT </h3>
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
							REPORT NAME :
						</div>
						<div >
							<input maxlength="100" id="rname" title="Report Name" name="rname" type="text" value="<?php echo $strReportName; ?>" />
						</div>
					</div>

					<div>
						PATIENT NAME :
					</div>
					<div>
						<?php
                            $arrCombo[0] = array( "name" =>"patientID", "type"=>"cmb", "cData"=>$patient_cmd, "value"=>$strPatientId, "size"=>1, "class" =>"patient", "sText" => "Select Patient");
                            $strCtrl = GetCtrl( $arrCombo[0] );
                            echo $strCtrl;
                        ?>
					</div>
				</div>

                <div id='test_edit_popup' style='display:none;position:absolute;top:225px; background-color:transparent;height:30px;width:50px;padding:5px; ' >
                     <input id='edit'; type='button' value='Edit' onclick='EditTestInfo();' />
                     <input type="hidden" id="rowno" value="0">
                </div>

				<!--  Grid insert code starts  -->
                <div id="gridArea" class="gridArea"  >
				  	
					<?php
                        $arGridFlds['arHeaderFlds'] =array(
                                array(),
                                array(),
                                array()
                        );

                    $arGridFlds['arGridFlds'] =array(
                            array("label"=>"","name" =>"id","size"=>0,"type"=>"hidden"),

                            array("label"=>"TEST NAME","name" =>"testname","size"=>300,"type"=>"text","max"=>100 ,"js"=>"onblur=GetTestInfo(this); onmouseover=ShowEditTest('test_edit_popup',this.name);" ,"title"=> "Test Name"),

                            array("label"=>"TEST RESULT","name" =>"testresult", "max"=>"100","size"=>600,"type"=>"text","align"=>"center"),

                    );
                    //$arGridFlds['extra_row'] =array("label"=>"Notes","name" =>"notes","size"=>100,"type"=>"text" );
                    $arGridFlds['nIntRows']=10;
                    $arGridFlds['oddRowColor']="#F6F6F6";
                    $arGridFlds['evenRowColor']="#FBFBFB";
                    $arGridFlds['totalRequiredForCols']=array(5,7);
                    //$arGridFlds['nFixHeaderTop']=288;

                    if($strReportId != "")
                    /////////////////////////////////////////david

//print '<pre>';print_r($this->report_model->get_patient_medical_test_report_data_detail($strReportId));

                    $arGridFlds['arData']=$this->report_model->get_patient_medical_test_report_data_detail($strReportId);
                    $this->load->view('grid',$arGridFlds);  ?>
            	</div>
				<!--  Grid insert code end  -->

				<div id='footer_buttons' class="btn_save">
					<input class="btn-submit" id="btnaction" type="submit" value=<?php if(isset($_GET['rid'])){echo "Update";}else{echo "Save";}?> />
					<a href="<?php echo base_url()?>home/reports">Cancel</a>
				</div>
			</div>
		</div>

	</form>

<?php
	$this->load->view('includes/bottomtemplate.php');
?>