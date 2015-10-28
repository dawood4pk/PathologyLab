<?php
	define("JSPATH", base_url()."includes/js/");
	define("IMGPATH", base_url()."includes/images/");
	define("CSSPATH", base_url()."includes/css/");
?>
<link href="<?php echo CSSPATH ?>jquery-ui.css?v=1.0" rel="stylesheet" type="text/css" />
<link href="<?php echo CSSPATH ?>main.css?v=1.0" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo IMGPATH?>favicon.ico" type="image/vnd.microsoft.icon">
<script src="<?php echo JSPATH?>jquery.js"></script>
<script src="<?php echo JSPATH?>jquery-ui.js"></script>
<script>
	var js_img_path ='<?php echo base_url(). "includes/images/"; ?>';
	var js_base_path ='<?php echo base_url() ?>';
</script>