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

	<?php foreach($resultContent as $result) { ?>

	<div class="paper seamless">

		<p>
			<a href="<?php echo $result["href"]; ?>"><?php echo $result["name"]; ?></a><br />
			<span class="text-muted"><?php echo $result["href"]; ?></span>
		</p>

	</div>

	<?php } ?>

<?php } ?>

</div>
