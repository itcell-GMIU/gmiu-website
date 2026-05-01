<?php

// ✅ Define menu items dynamically
$menuItems = [
	[
		'title' => 'Dashboard',
		'icon' => 'fa fa-home',
		'link' => 'index.php',
		'roles' => [1, 2, 3]
	],
	[
		'title' => 'Levels Setting',
		'icon' => 'fa fa-gear',
		'link' => 'javascript:;',
		'roles' => [1, 2, 3],
		'submenu' => [
			['title' => 'Acedemic Level', 'link' => 'acedemic-level.php', 'roles' => [1]],
			['title' => 'Education Level', 'link' => 'education-level.php', 'roles' => [1]],
			['title' => 'Edu. Level Description', 'link' => 'education-level-description.php', 'roles' => [1, 2, 3]],
			['title' => 'Branch Management', 'link' => 'branch-management.php', 'roles' => [1, 2, 3]],
			['title' => 'Branch Details Add', 'link' => 'branch-details-add.php', 'roles' => [1, 2, 3]],
		]
	],
	[
		'title' => 'Image Setting',
		'icon' => 'fa fa-image',
		'link' => 'javascript:;',
		'roles' => [1, 2, 3],
		'submenu' => [
			['title' => 'Images Categories', 'link' => 'image-category-manage.php', 'roles' => [1]],
			['title' => 'Upload Images', 'link' => 'upload-images.php', 'roles' => [1, 2, 3]],
		]
	],
];

// ✅ Helper function to check role
function hasAccess($roles, $role_id)
{
	return in_array($role_id, $roles);
}
?>

<div class="left-side-bar">
	<div class="brand-logo">
		<a href="index.php">
			<img src="src/images/logowithbg.png" alt="">
		</a>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu pt-0">
			<ul id="accordion-menu">
				<li>
					<a class="dropdown-toggle no-arrow">
						<span class="mtext" style="font-weight: 600; font-size: 18px;"><?= $role_name; ?></span>
					</a>
				</li>
				<hr class="mt-0">

				<?php foreach ($menuItems as $menu): ?>
					<?php if (!hasAccess($menu['roles'], $role_id))
						continue; ?>
					<li class="dropdown">
						<a href="<?= $menu['link']; ?>"
							class="dropdown-toggle <?= isset($menu['submenu']) ? '' : 'no-arrow'; ?>">
							<span class="<?= $menu['icon']; ?>"></span><span class="mtext"><?= $menu['title']; ?></span>
						</a>
						<?php if (isset($menu['submenu'])): ?>
							<ul class="submenu">
								<?php foreach ($menu['submenu'] as $sub): ?>
									<?php if (!hasAccess($sub['roles'], $role_id))
										continue; ?>
									<li><a href="<?= $sub['link']; ?>"><?= $sub['title']; ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>
</div>