<div class="cpanel-right-box-content orange_links" style="text-align: left; width: 230px; padding: 0pt 0px 0pt 11px;">
	<div  style="width: 94%; border-bottom: thin dashed gray;">
	<br/>Your Member Rating<br/>
	<div style="margin: 5px; text-align: center;"><?php $this->load->view('modules/member_rating');?></div>
	</div>
	<?php $this->load->view('modules/pending_purchases'); ?>	
	<?php $this->load->view('modules/pending_sales'); ?>
	<? if ($this->phpsession->get('personVO')->getPremium() == 1) { ?>
	<?php $this->load->view('modules/active_sales'); ?>
	<?php } ?>
	<?php $this->load->view('modules/awaiting_feedback'); ?>
	
</div>