<?php $this->load->view('includes/members_header'); ?>
	<div id="cpanelwrapper" class="cpanel">
		<div class="cpanel-left">
		<?php 
		if (is_array($lefts))
		{
			foreach($lefts as $title => $content)
			{
			?>
			<div class="cpanel-left-box">
				<div class="cpanel-left-box-header">
					<span class="header-text mycollection"<?=FormatHeaderStyle($title)?>><?=$title?></span>
					<span class="backtodash"><a href="<?=current($back_loc)?>"  style="color:orange"><img src="/img/<?=key($back_loc)?>" /></a></span>
				</div>
				<?=$content?>
				<div class="cpanel-left-box-footer"></div>
			</div>
			<?php 
			}
		} 
		?>
	</div>
	<div class="cpanel-right">
		<?php 
		if (is_array($rights))
		{
			foreach($rights as $title => $content)
			{
			?>
			<div class="cpanel-right-box-header"><span class="header-text actions"><?=$title?></span></div>
			<?=$content?>
			<div class="cpanel-right-box-footer"></div>
		<?php 
			}
		} 
		?>
	</div>
</div>
<?php $this->load->view('includes/members_footer'); ?>