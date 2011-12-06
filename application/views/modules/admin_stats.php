<div style="text-align:center; width:100%"><br/><br/><?php
if (isset($stats))
{
	foreach ($stats as $desc => $val)
	{
		?>
		<?=$desc?> : <?=$val?><br/><br/>
		<?
	}
}
?></div>