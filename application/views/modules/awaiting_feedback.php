<div style="width: 94%; border-top: thin dashed gray;">
<br/>Awaiting Feedback<br/>
<ol class="ol-list" id="feedback-list">
	<?php 
	if (is_array($awaiting_feedback) && count($awaiting_feedback) > 0) { 
	
		foreach($awaiting_feedback as $saleId => $name)
		{ 
	?>
		<li class="feedback-li"><a class="feedback_item" href="#" title="Sale #<?=$saleId?>"><?=$name?></a></li>
	<?php 
		}
	} 
	else
	{ 
	?>
	You have no transactions awaiting feedback
	<?php 
	}
	?>
</ol>
</div>