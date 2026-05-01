<?php
include '../include/checklogin.php'; // This should already include your $con database connection

// 1. GET AND VALIDATE PARAMETERS
// Get form_type (required) and other_type (optional) from the URL
$form_type = isset($_GET['form_type']) ? $_GET['form_type'] : null;
$other_type = isset($_GET['other_type']) ? $_GET['other_type'] : null;

// Stop execution if form_type isn't provided
if ($form_type === null) {
    die("Error: A 'form_type' is required in the URL.");
}

// 2. INITIALIZE DYNAMIC VARIABLES
$page_title = "";
$table_headers = [];
$sql_select = "";
$sql_from = "";
$sql_order_by = "";
$sql_where_parts = [];
$sql_params = [];
$sql_param_types = "";

// 3. CONFIGURE CONTENT BASED ON FORM_TYPE
switch ($form_type) {
    case '1': // AI-ML Program
    case '2': // CA Program
        // Both form types 1 and 2 share the same columns and base table
        $page_title = ($form_type == '1') ? "AI-ML Program Registration" : "CA Program Registration";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Standard",
            "District",
            "School",
            "Email",
            "Duration",
            "Timing Slot"
        ];

        $sql_select = "id, full_name, mobile, standard, district, school_name, email, start_date, end_date, time_slot";
        $sql_from = "FROM tbl_promotional_form_data";

        // Add form_type to WHERE clause
        $sql_where_parts[] = "form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i"; // 'i' for integer

        $sql_order_by = "ORDER BY id DESC";
        break;

    case '3': // Virtual Counselling
        $page_title = "Virtual Counselling Registration";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Email",
            "Faculty",
            "Extra",
            "Date",
            "Timing Slot"
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.description, tpfd.time_slot, tf.name as faculty_name";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd JOIN tbl_faculty AS tf ON tpfd.faculty_id = tf.id";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '4': // GGC Scholarship Form
        $page_title = "GGC Scholarship Form";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Email",
            "Standard",
            "Test Date",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.standard";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '5': // After 10th Scholarship Test
        $page_title = "After 10th Scholarship Test";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Email",
            "Standard",
            "Test Date",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.standard";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '6': // After 10th Scholarship Test
        $page_title = "After 10th Scholarship Test Mahuva";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Email",
            "Standard",
            "Test Date",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.standard";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '7': // After 10th Scholarship Test
        $page_title = "12th Scholarship Test for Science, Arts & Commerce";
        $table_headers = [
            "#",
            "Full Name",
            "Mobile Number",
            "Email",
            "Parents Mobile Number",
            "School Name",
            "District",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile, tpfd.email, tpfd.mobile2, tpfd.district, tpfd.school_name";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '8':
        $page_title = "Career Chart Leads";
        $table_headers = [
            "#",
            "Mobile Number",
            "Email",
            "Created At"
        ];

        $sql_select = "tpfd.id, tpfd.mobile, tpfd.created_at";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '9':
        $page_title = "Gyanmanjari Girls' College Admission Form";
        $table_headers = [
            "#",
            "Student Name",
            "School Name",
            "Mobile Number",
            "E-mail Address",
            "Course Interested (Standard)",
            "Address",
            "Preferred Date for Counselling",
            "Preferred Time for Counselling"
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.email, tpfd.mobile, tpfd.school_name, tpfd.standard, tpfd.address, tpfd.start_date, tpfd.time_slot";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '10': // Design Admission Form
        $page_title = "Design Admission Form";
        $table_headers = [
            "#",
            "Full Name",
            "School Name",
            "Mobile Number",
            "Email",
            "Exam Preference",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.school_name, tpfd.mobile, tpfd.email, tpfd.other_type";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '11': // PLM Entrance Test Registration
        $page_title = "PLM Entrance Test Registration";
        $table_headers = [
            "#",
            "Full Name",
            "Standard",
            "Graduation Details",
            "Mobile Number",
            "Email",
            "Date",
            "Time",
            "School Name",
            "District",
            "Mode of Exam"
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.standard, tpfd.graduation_details, tpfd.mobile, tpfd.email, tpfd.start_date, tpfd.time_slot, tpfd.school_name, tpfd.district, tpfd.other_type";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '12': // DDCET Registration
        $page_title = "DDCET Registration";
        $table_headers = [
            "#",
            "Full Name",
            "College Name",
            "Mobile Number",
            "Email",
            "Enrollment No",
            "Exam Center",
            "Language",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.school_name, tpfd.mobile, tpfd.email, tpfd.other_type, tpfd.district, tpfd.description";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '13': // DDCET Registration
        $page_title = "Diploma Reel Lead";
        $table_headers = [
            "#",
            "Name",
            "Mobile",
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;

    case '14': // Free One Day Vacation Workshop Registration Form
        $page_title = "Free One Day Vacation Workshop Registration Form";
        $table_headers = [
            "#",
            "Full Name",
            "Given Exam",
            "Mobile Number",
            "Email",
            "Workshop Dates",
            "Workshops",
            "Career Interest"
        ];

        $sql_select = "tpfd.id, tpfd.full_name, tpfd.standard, tpfd.mobile, tpfd.email, tpfd.extra_column1, tpfd.extra_column2, tpfd.extra_column3";
        $sql_from = "FROM tbl_promotional_form_data AS tpfd";

        // Add form_type to WHERE clause (with table alias)
        $sql_where_parts[] = "tpfd.form_type = ?";
        $sql_params[] = $form_type;
        $sql_param_types .= "i";

        $sql_order_by = "ORDER BY tpfd.id DESC";
        break;
        
         case '15': // DDCET Registration
                $page_title = "GUJCET Lead";
                $table_headers = [
                    "#",
                    "Name",
                    "Mobile",
                ];
        
                $sql_select = "tpfd.id, tpfd.full_name, tpfd.mobile";
                $sql_from = "FROM tbl_promotional_form_data AS tpfd";
        
                // Add form_type to WHERE clause (with table alias)
                $sql_where_parts[] = "tpfd.form_type = ?";
                $sql_params[] = $form_type;
                $sql_param_types .= "i";
        
                $sql_order_by = "ORDER BY tpfd.id DESC";
                break;
    default:
        die("Invalid 'form_type' specified.");
}

// 4. ADD OPTIONAL 'other_type' TO QUERY
if (!empty($other_type)) {
    // Use 'tpfd.' alias if it's form_type 3
    $alias = ($form_type == '3') ? "tpfd." : "";

    $sql_where_parts[] = "{$alias}other_type = ?";
    $sql_params[] = $other_type;
    $sql_param_types .= "s"; // 's' for string
}

// 5. ASSEMBLE AND EXECUTE FINAL QUERY
$sql_where = "WHERE " . implode(" AND ", $sql_where_parts);
$sql = "SELECT $sql_select $sql_from $sql_where $sql_order_by";

// Prepare and execute the statement securely
$cmd = $con->prepare($sql);
if (!$cmd) {
    die("SQL Prepare Failed: " . $con->error);
}

if (!empty($sql_params)) {
    $cmd->bind_param($sql_param_types, ...$sql_params);
}

$cmd->execute();
$result = $cmd->get_result();

// HTML output starts here. PHP variables $page_title, $table_headers, and $result will be used.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo htmlspecialchars($page_title); ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"><?php echo htmlspecialchars($page_title); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>
                                            <?php echo htmlspecialchars($page_title); ?></b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <?php foreach ($table_headers as $header): ?>
                                                <th scope="row" style="color:black;">
                                                    <b><?php echo htmlspecialchars($header); ?></b>
                                                </th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // 6. DYNAMICALLY RENDER TABLE ROWS
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr align="center">
                                                <?php if ($form_type == '1' || $form_type == '2'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['district']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['school_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row">
                                                        <?php
                                                        echo date("d M Y", strtotime($row['start_date'])) . ' - ' . date("d M Y", strtotime($row['end_date']));
                                                        ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php
                                                        echo ($row['time_slot'] == 'sun-1-3') ? '1:00 PM - 3:00 PM' : '4:00 PM - 6:00 PM';
                                                        ?>
                                                    </td>
                                                <?php elseif ($form_type == '3'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['faculty_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['description']); ?></td>
                                                    <td scope="row">
                                                        <?php
                                                        echo date("d M Y", strtotime($row['start_date']));
                                                        ?>
                                                    </td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['time_slot']); ?></td>
                                                <?php elseif ($form_type == '4'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row">
                                                        <?php
                                                        echo date("d M Y", strtotime($row['start_date']));
                                                        ?>
                                                    </td>
                                                <?php elseif ($form_type == '5'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row">
                                                        <?php
                                                        echo date("d M Y", strtotime($row['start_date']));
                                                        ?>
                                                    </td>

                                                <?php elseif ($form_type == '6'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row">
                                                        <?php
                                                        echo date("d M Y", strtotime($row['start_date']));
                                                        ?>
                                                    </td>
                                                <?php elseif ($form_type == '7'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile2']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['school_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['district']); ?></td>
                                                <?php elseif ($form_type == '8'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>>
                                                    <td scope="row"><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                <?php elseif ($form_type == '10'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['school_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['other_type']); ?></td>
                                                <?php elseif ($form_type == '11'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['graduation_details']); ?>
                                                    </td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['start_date']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['time_slot']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['school_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['district']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['other_type']); ?></td>
                                                <?php elseif ($form_type == '12'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['school_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['other_type']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['district']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['description']); ?></td>
                                                <?php elseif ($form_type == '13'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                <?php elseif ($form_type == '14'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['standard']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['extra_column1']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['extra_column2']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['extra_column3']); ?></td>
                                                <?php elseif ($form_type == '15'): ?>
                                                    <td scope="row"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                    <td scope="row"><?php echo htmlspecialchars($row['mobile']); ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <?php foreach ($table_headers as $header): ?>
                                                <th scope="row" style="color:black;">
                                                    <b><?php echo htmlspecialchars($header); ?></b>
                                                </th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </tfoot>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> <?php include '../include/importfooter.php'; ?>
    </div> <?php include '../include/importjs.php'; ?>

</body>

</html>