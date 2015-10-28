<?php
	if($this->session->userdata('logged_in'))
	{
?>
		<script type="text/javascript" src="<?php echo JSPATH?>script.js?v=1.0"></script>
<?php      
        
	}// end of session if.
	else
	{
		?>
			<script type="text/javascript" src="<?php echo JSPATH?>script.js?v=1.0"></script>
			<script src="<?php echo JSPATH?>login.js?v=2.0"></script>
		<?php
    }
?>