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
			$this->load->view('includes/header.php');
			if($this->session->userdata('logged_in'))
			{
				$this->load->view('admin.php');
			}
			else
			{
				$this->load->view('login_form.php');
			}
		?>