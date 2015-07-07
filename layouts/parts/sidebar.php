
<div class="list-group">

	<?php foreach($items["children"] as $item) { ?>

	<a href="<?php echo Scope::url($item["href"]); ?>" class="list-group-item<?php if($item["active"]) echo ' active'; ?>">
		<?php echo UI_Icon::create("material", $item["active"] ? (empty($item["children"]) ? "arrow_forward" : "expand_more") : "chevron_right"); ?>
		<?php echo $item["data"]["meta"]->title; ?>
	</a>

	<?php if($item["active"] && !empty($item["children"])) { ?>

		<?php foreach($item["children"] as $sub) { ?>
		<a href="<?php echo Scope::url($sub["href"]); ?>" class="list-group-item list-group-item-level-2<?php if($sub["active"]) echo ' active'; ?>">
			<?php echo $sub["data"]["meta"]->title; ?>
		</a>
		<?php } ?>

	<?php } ?>

	<?php } ?>

</div>
