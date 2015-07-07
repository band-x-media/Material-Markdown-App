
<div class="navigation-drawer-overlay"></div>

<aside id="navigation-drawer" class="navigation-drawer navigation-drawer-default navigation-drawer-fixed-left" role="navigation">

	<div class="wrapper">

		<nav class="navigation-drawer-nav">

			<ul class="list-level-1">

				<?php foreach($nav as $primary) { ?>

				<li role="presentation" class="<?php if($primary["active"]) echo 'active clicked'; ?>">

					<a href="<?php echo Scope::url($primary['uri']); ?>" class="toggle-navigation<?php if($primary["active"]) echo ' active'; ?>">

						<?php echo $primary['name']; ?>
						<?php if(!empty($primary['children'])) { ?>
						<i class="material-icons"><?php echo $primary["active"] ? 'close' : 'expand_more'; ?></i>
						<?php } ?>

					</a>

					<?php if(!empty($primary['children'])) { ?>

						<ul class="list-level-2">

						<?php foreach($primary['children'] as $secondary) { ?>

							<li role="presentation" class="<?php if($secondary['active']) echo 'active current'; ?>">

								<a href="<?php echo Scope::url($secondary['href']); ?>">
									<?php echo $secondary['name']; ?>
								</a>

							</li>

						<?php } ?>

						</ul>

					<?php } ?>

				</li>

				<?php } ?>

			</ul>

		</nav>

	</div>

</aside>
