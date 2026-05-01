<?php
if (1 != 1) {
	// Take value as role_id and text as role_name from the options list:
	// 60 = IT CELL
	// 11 = Super Admin
	// 12 = Inquiry Admin
	// 13 = Reception
	// 14 = Inquiry Head
	// 15 = Inquiry Faculty
	// 16 = Counselor / Admission Officer
	// 21 = Marketting Visit
	// 22 = Promotional Coordinator
	// 25 = Designer
	// 57 = Lead Manager
	// 59 = Survilence Staff
}

// ✅ Define menu items dynamically
$menuItems = [
	[
		'title' => 'Dashboard',
		'icon' => 'fa fa-home',
		'link' => 'index.php',
		'roles' => [11, 12, 13, 14, 15, 16, 21, 22, 25, 57, 59, 60]
	],
	[
		'title' => 'Candidate',
		'icon' => 'fa fa-user-plus',
		'link' => 'javascript:;',
		'roles' => [11, 12, 13, 57, 60],
		'submenu' => [
			['title' => 'Registration', 'link' => 'candidate-add.php', 'roles' => [13]],
			['title' => 'View Candidate', 'link' => 'candidate-view.php', 'roles' => [11, 12, 13, 57, 60]],
			['title' => 'Not Assigned Inquiry', 'link' => 'candidate-view.php?url_for=notassignedinq', 'roles' => [11, 12, 57, 60]],
			['title' => 'Upload Confidential CSV', 'link' => 'data-upload.php', 'roles' => [57]],
			['title' => 'Upload Inquiry CSV', 'link' => 'data-upload-other-inq.php', 'roles' => [12]],
		]
	],
	[
		'title' => 'Inquiry',
		'icon' => 'fa fa-question-circle',
		'link' => 'javascript:;',
		'roles' => [11, 12, 16, 57, 15, 14, 60],
		'submenu' => [
			['title' => 'Assign', 'link' => 'inquiry-assign.php', 'roles' => [12, 57, 60]],
			['title' => 'View', 'link' => 'candidate-view.php?url_for=inq', 'roles' => [11, 12, 57, 14, 60]],
			['title' => 'View My Inquiry', 'link' => 'candidate-view.php?url_for=myinq', 'roles' => [16, 15]],
			['title' => 'Approved Inquiry', 'link' => 'candidate-view.php?url_for=approvedinq', 'roles' => [11, 12, 16, 57, 15, 14, 60]],
			['title' => 'Rejected Inquiry', 'link' => 'candidate-view.php?url_for=rejectedinq', 'roles' => [11, 12, 16, 57, 15, 14, 60]],
			['title' => 'Closed Inquiry', 'link' => 'candidate-view.php?url_for=closedinq', 'roles' => [11, 12, 16, 57, 15, 14, 60]],
			['title' => 'Approved By Other Inq.', 'link' => 'candidate-view.php?url_for=approvedbyother', 'roles' => [15, 16]],
		]
	],
	[
		'title' => 'Calling Remarks',
		'icon' => 'fa fa-comment-dots',
		'link' => 'javascript:;',
		'roles' => [11, 60],
		'submenu' => [
			['title' => 'Manage Calling Remarks', 'link' => 'calling-remarks-manage.php', 'roles' => [11, 60]],
			['title' => 'Manage Calling Conversation', 'link' => 'calling-conversation-manage.php', 'roles' => [11, 60]],
		]
	],
	[
		'title' => 'Call Report',
		'icon' => 'fa fa-phone',
		'link' => 'call_report.php',
		'roles' => [11, 12, 14, 15, 16, 57, 22, 60]
	],
	[
		'title' => 'Calls Reminder',
		'icon' => 'fa fa-bell',
		'link' => 'call-reminder.php',
		'roles' => [15, 16]
	],
	[
		'title' => 'Daily Task',
		'icon' => 'fa fa-clipboard',
		'link' => 'javascript:;',
		'roles' => [11, 12, 13, 16, 25, 21, 57, 22, 59, 60],
		'submenu' => [
			['title' => 'Add', 'link' => 'dailytask-add.php', 'roles' => [12, 13, 16, 25, 21, 57, 59]],
			['title' => 'View', 'link' => 'dailytask-view.php', 'roles' => [12, 13, 16, 25, 21, 57, 59]],
			['title' => 'Report', 'link' => 'dailytask-report.php', 'roles' => [11, 22, 60]],
			['title' => 'Remark', 'link' => 'dailytask-remark.php', 'roles' => [11, 22, 60]],
		]
	],
	[
		'title' => 'Summary Sheet',
		'icon' => 'fa fa-file-text',
		'link' => 'summary-view.php',
		'roles' => [11, 57, 60],
	],
	[
		'title' => 'Staff Details',
		'icon' => 'fa fa-user',
		'link' => 'javascript:;',
		'roles' => [57, 60],
		'submenu' => [
			['title' => 'Add', 'link' => 'staff-add.php', 'roles' => [57, 60]],
			['title' => 'View', 'link' => 'staff-veiw.php', 'roles' => [57, 60]],
			['title' => 'Delete', 'link' => 'staff-delete.php', 'roles' => [60]],
			['title' => 'CSV', 'link' => 'staff-csv-upload.php', 'roles' => [57, 60]],
		]
	],
	[
		'title' => 'Marketing Visit',
		'icon' => 'fa fa-map-marked-alt',
		'link' => 'javascript:;',
		'roles' => [21, 22, 60],
		'submenu' => [
			['title' => 'Add Marketing Visit', 'link' => 'marketing-visit-add.php', 'roles' => [21]],
			['title' => 'View Marketing Visit', 'link' => 'marketing-visit-view.php', 'roles' => [21]],
			['title' => 'Marketing Visit Report', 'link' => 'marketing-visit-report.php', 'roles' => [22, 60]],
		]
	],
	[
		'title' => 'View Fees',
		'icon' => 'fa fa-file-invoice-dollar',
		'link' => 'fees-structure.php',
		'roles' => [11, 12, 13, 14, 15, 16, 21, 22, 25, 57, 60],
	],
	[
		'title' => 'Documents',
		'icon' => 'fa fa-folder-open',
		'link' => 'javascript:;',
		'roles' => [11, 12, 13, 14, 15, 16, 21, 22, 25, 57, 59, 60],
		'submenu' => [
			['title' => 'Add Documents', 'link' => 'documents-add.php', 'roles' => [11, 60]],
			['title' => 'View Documents', 'link' => 'documents-view.php', 'roles' => [11, 12, 13, 14, 15, 16, 21, 22, 25, 57, 59, 60]],
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