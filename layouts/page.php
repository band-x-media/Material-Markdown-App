
		<?php echo $nav; ?>

		<nav class="app-bar <?php if(!empty(@$section["children"])) echo 'app-bar-has-tabs '; ?>app-bar-static has-tool-bar app-bar-translucent bg-blue-grey">

			<?php echo $toolbar; ?>

			<a class="navigation-drawer-toggle" href="#">
				<i class="icon icon-lg material-icons text-white">menu</i>
			</a>

			<h1 class="title">

				<?php if(@$section["level"] === 2) { ?>
				<span class="hidden-sm hidden-xs">
					<a href="<?php echo $first["href"]; ?>"><?php echo $first["data"]["meta"]->title; ?></a>
					<span class="divider">❯</span>
				</span>
				<?php } ?>

				<?php echo @$page["data"]["meta"]->title; ?>&nbsp;

			</h1>

			<?php if(!empty(@$section["children"])) { ?>

			<ul class="nav nav-tabs nav-ripple nav-tab-yellow">

				<?php foreach($section["children"] as $child) { ?>

				<li role="presentation" class="<?php if($child["active"]) echo "active" ; ?>">

					<?php if(!empty($child["children"])) { ?>

					<a href="<?php echo $child["href"]; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo $child["data"]["meta"]->title; ?>
						<i class="icon material-icons">arrow_drop_down</i>
					</a>

					<ul class="dropdown-menu" aria-labelledby="dLabel">

						<li>
							<a href="<?php echo $child["href"]; ?>" class="<?php if($child["current"]) echo "active" ; ?>">
								<?php echo $child["data"]["meta"]->title; ?>
							</a>
						</li>

						<?php foreach($child["children"] as $subChild) { ?>

						<li>
							<a href="<?php echo $subChild["href"]; ?>" class="<?php if($subChild["active"]) echo "active" ; ?>">
								<?php echo $subChild["name"]; ?>
							</a>
						</li>

						<?php } ?>

					</ul>

					<?php } else { ?>

					<a href="<?php echo $child["href"]; ?>">
						<?php echo $child["data"]["meta"]->title; ?> 
					</a>

					<?php } ?>

				</li>

				<?php } ?>
	
			</ul>

			<?php } ?>

		</nav>

		<div class="content-container">

			<?php if(!empty($page["data"]["meta"]->tagline)) echo "<div class=\"container\"><p class=\"lead\">{$page['data']['meta']->tagline}</p></div>"; ?>

			<div class="breather-lg"></div>

			<?php if(@$sidebar) { ?>

				<div class="container">
				<div class="row">
					<div class="col-md-8">
						<?php echo $content; ?>
					</div>
					<div class="col-md-4">
						<?php echo $sidebar; ?>
					</div>
				</div>
				</div>

			

			

			<?php 

				} else {

					if(empty($page["data"]["meta"]->dontAddContainer)) echo "<div class=\"container\">";

					 echo $content;

					if(empty($page["data"]["meta"]->dontAddContainer)) echo "</div>";

				}

			?>

		</div>
