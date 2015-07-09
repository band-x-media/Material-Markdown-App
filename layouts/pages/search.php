<div class="container">

<?php if(empty($resultContent)) { ?>

<div class="empty-state clean">
	<i class="icon icon-xxl material-icons">search</i>
	<h3>No Results</h3>
	<p>Your search didn't turn up any results.</p>

	<form role="form" class="form-inline" method="post" action="<?php echo Scope::url("search"); ?>">

		<div class="form-group material">
			<input type="text" name="query" class="form-control text-blue-grey text-900" placeholder="Try Again" value="<?php echo @$_POST["query"]; ?>">
			<button class="btn bg-blue-grey btn-block bg-900" type="submit">
				Search
			</button>
		</div>

	</form>

</div>

<?php } else { ?>

<div class="list">

	<?php foreach($resultContent as $result) { ?>

	<div class="list-item">

		<div class="list-item-content">

			<div class="list-item-primary-content">
				
				<p class="line-1"><a href="<?php echo $result["href"]; ?>"><?php echo $result["name"]; ?></a></p>
				<p class="line-3"><?php echo $result["href"]; ?></p>

			</div>

		</div>

	</div>

	<?php } ?>

</div>

<?php } ?>

</div>
