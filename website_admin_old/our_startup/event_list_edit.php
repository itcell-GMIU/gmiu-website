<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current data for the given ID
    $stmt = $con->prepare("SELECT list_ename, event_type, month, department FROM tbl_event WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $list_ename = $row['list_ename'];
        $event_type = $row['event_type'];
        $month = $row['month'];
        $department = $row['department'];
    } else {
        $_SESSION['status'] = "Event record not found.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
        exit;
    }
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $list_ename = $_POST['list_ename'];
    $event_type = $_POST['event_type'];
    $month = date('d-F-Y l', strtotime($_POST['month'])); // Formatting month to "03-July-2024 Wednesday"
    $department = $_POST['department'];

    // Update the record in the database
    $stmt = $con->prepare("UPDATE tbl_event SET list_ename = ?, event_type = ?, month = ?, department = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $list_ename, $event_type, $month, $department, $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Event record updated successfully.";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Failed to update the event record.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Event List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Event List</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Event list Details</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="list_ename">List Name</label>
                                    <input type="text" name="list_ename" class="form-control" id="list_ename" value="<?php echo htmlspecialchars($list_ename, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="event_type">Event Type</label>
                                    <input type="text" name="event_type" class="form-control" id="event_type" value="<?php echo htmlspecialchars($event_type, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="month">Month</label>
                                    <input type="date" name="month" class="form-control" id="month" value="<?php echo isset($month) ? date('Y-m-d', strtotime($month)) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <input type="text" name="department" class="form-control" id="department" value="<?php echo htmlspecialchars($department, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include '../include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <?php include '../include/importjs.php'; ?>
</body>

</html>