<?php
	define("TITLE", "PathologyLab");
	$this->load->view('includes/toptemplate.php');
?>

<table align="center" border="0" width="80%">
    <tr><td ><a  href="<?php echo base_url() ?>home/patient"> <img alt="Add New" src="<?php echo IMGPATH?>add_1.png"> </a> </td>
    <td align="right" valign="bottom" class="msgs"><?php echo $strMsg ?> </td>
    <tr>
    <tr><td colspan="2">
        <table align="center" width="100%"  border="1" cellspacing="0" cellpadding="2" class="LstTbl">

            <tr style="background-color:#B6B6B6;"> 
                <td>User Name</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>&nbsp;</td> 
                <td>&nbsp;</td> 
            </tr>
        <?php

           foreach($arPatientList as $row)
           {
               
           ?>                   
            <tr>
                
                <td><a href=<?php echo base_url() ?>home/patient?pid=<?php echo $row['patient_id'] ?>> <?php echo $row['patient_username'] ?></a></td>
                <td><?php echo $row['patient_firstname'] ?></td>
                <td><?php echo $row['patient_lastname'] ?></td>
                <td><a href=<?php echo base_url() ?>home/patient?pid=<?php echo $row['patient_id'] ?>> <img  alt="Edit" src="<?php echo IMGPATH?>edit.png" > </a></td>    
                <td><a href=<?php echo base_url() ?>home/patientdelete?pid=<?php echo $row['patient_id'] ?> onClick="return confirm('Are you sure you want to delete this record?');" > <img alt="Delete" src="<?php echo IMGPATH?>mail_delete.png" > </a></td>
            </tr>
        <?php }
      if( $this->pagination->create_links() != "") { 
 ?>    
        <tr><td colspan="8" align="right">  <?php  echo $this->pagination->create_links(); ?> </td> 
        
        <?php } ?>
        </table>
    </td></tr></table>   
<?php
	$this->load->view('includes/bottomtemplate.php');
?>