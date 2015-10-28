<div class="header">
	<?php if($this->session->userdata('logged_in')){$sess = $this->session->userdata('logged_in');if ( $sess['usertype'] == 'admin'){?>
		<ul>
			<li>
				<a class="button" href="<?php echo base_url()?>home/patients">Patients</a>
			</li>
			<li>
				<a class="button" href="<?php echo base_url()?>home/reports">Reports</a>
			</li>
			<li>
				<a class="button" href="<?php echo base_url()?>home/logout">logout</a>
			</li>
		</ul>
	<?php }}?>
</div>