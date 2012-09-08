<div id="community_add" title="Adding a new <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?>" style="font-size:14px;">
	<div class="community_image" style="text-align:center"><img src="/img/mlp/full/nopic.jpg" id="catalog_image" /></div>
	<form id="community_add_form">
		<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <input type="text" id="community_name" name="community_name" value="" />
		<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <textarea id="community_description" name="community_description"></textarea>
		<br/>Manufacturer: <input type="text" id="community_manufacturer" name="community_manufacturer" value="" />
		<?php foreach($collection_attributes as $attributeId => $attributeText): ?>
	    <br/><?=$attributeText?> : <?=form_input('community_attr_'.$attributeId, '' , 'id=community_attr_'.$attributeId)?>
	    <?php endforeach; ?>
	</form>
</div>