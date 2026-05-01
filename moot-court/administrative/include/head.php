<!-- Basic Page Info -->
<meta charset="utf-8">
<title>Calling Software</title>

<!-- Site favicon -->
<!-- Standard Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="src/images/fav/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="src/images/fav/favicon-32x32.png">
<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" href="src/images/fav/apple-touch-icon.png">
<!-- Android Chrome Icons -->
<link rel="icon" type="image/png" sizes="192x192" href="src/images/fav/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="512x512" href="src/images/fav/android-chrome-512x512.png">
<!-- Theme Color (for Android / Windows browser UI) -->
<meta name="theme-color" content="#ffffff">

<!-- custom css   -->
<link rel="stylesheet" href="src/styles/custom.css">

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="vendors/styles/style.css">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag() { dataLayer.push(arguments); }
	gtag('js', new Date());

	gtag('config', 'UA-119386393-1');
</script>

<!-- DataTables -->
<link rel="stylesheet" href="../../admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Datatable styles   -->
<!-- <link rel="stylesheet" type="text/css" href="src/plugins/datatables/media/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/media/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/media/css/responsive.dataTables.css"> -->
<!-- Datatable styles ends  -->

<!-- Select 2 option   -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Font Awesome Link   -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
	integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	table.dataTable {
		width: max-content !important;
		min-width: calc(100% + 80px);
	}

	.dataTables_scrollHeadInner,
	.dataTables_scrollHeadInner table {
		width: max-content !important;
	}

	.data-table th,
	.data-table td {
		white-space: nowrap;
		padding: 8px 12px;
	}

	table.dataTable>thead .sorting:before,
	table.dataTable>thead .sorting_asc:before,
	table.dataTable>thead .sorting_desc:before,
	table.dataTable>thead .sorting_asc_disabled:before,
	table.dataTable>thead .sorting_desc_disabled:before,
	table.dataTable>thead .sorting:after,
	table.dataTable>thead .sorting_asc:after,
	table.dataTable>thead .sorting_desc:after,
	table.dataTable>thead .sorting_asc_disabled:after,
	table.dataTable>thead .sorting_desc_disabled:after {
		top: 4px;
	}
</style>