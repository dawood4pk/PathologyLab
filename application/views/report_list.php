<?php
	define("TITLE", "PathologyLab");
	$this->load->view('includes/toptemplate.php');
?>

<table align="center" border="0" width="80%">
    <tr><td ><a  href="<?php echo base_url() ?>home/report"> <img alt="Add New" src="<?php echo IMGPATH?>add_1.png"> </a> </td>
    <td align="right" valign="bottom" class="msgs"><?php echo $strMsg ?> </td>
    <tr>
    <tr><td colspan="2">
        <table align="center" width="100%"  border="1" cellspacing="0" cellpadding="2" class="LstTbl">

            <tr style="background-color:#B6B6B6;"> 
                <td>Report Name</td>
                <td>Patient First Name</td>
                <td>Patient Last Name</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php

           foreach($arReportList as $row)
           {
               
           ?>                   
            <tr>
                
                <td><a href=<?php echo base_url() ?>home/report?rid=<?php echo $row['report_id'] ?>> <?php echo $row['report_name'] ?></a></td>
                <td><?php echo $row['patient_firstname'] ?></td>
                <td><?php echo $row['patient_lastname'] ?></td>
                <td><a href=<?php echo base_url() ?>home/report?rid=<?php echo $row['report_id'] ?>> <img  alt="Edit" src="<?php echo IMGPATH?>edit.png" > </a></td>    
                <td><a href=<?php echo base_url() ?>home/reportdelete?rid=<?php echo $row['report_id'] ?> onClick="return confirm('Are you sure you want to delete this record?');" > <img alt="Delete" src="<?php echo IMGPATH?>mail_delete.png" > </a></td>
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