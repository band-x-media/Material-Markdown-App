
<div class="tool-bar bg-blue-grey bg-50">

	<div class="col-xs-7">

		<h3><a class="text-blue-grey text-900" href="<?php echo Scope::url(""); ?>"><?php echo $siteTitle; ?></a></h3>

	</div>

	<div class="col-xs-5">

		<form role="form" class="form-inline" method="post" action="<?php echo Scope::url("search"); ?>">

			<div class="form-group material full-width">
				<input type="text" name="query" class="form-control text-blue-grey text-900" placeholder="Search" value="<?php echo @$_POST["query"]; ?>">
				<button class="btn bg-blue-grey bg-900" type="submit">
					<i class="icon material-icons">search</i>
				</button>
			</div>

		</form>

	</div>

</div>
