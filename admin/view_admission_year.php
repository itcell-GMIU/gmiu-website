<?php
include 'include/checklogin.php';

// Fetch biannual program list
$query = "
    SELECT 
        bp.id,
        p.name AS program_name,
        f.name AS faculty_name,
        l.name AS level_name,
        bp.admission_year,
        bp.created_at
    FROM tbl_biannual_programs bp
    JOIN tbl_program p ON bp.program_id = p.id
    LEFT JOIN tbl_faculty f ON p.faculty_id = f.id
    LEFT JOIN tbl_level l ON p.level_id = l.id
    WHERE bp.is_active = 1
    ORDER BY bp.id DESC
";
$result = $con->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $con->prepare("UPDATE tbl_biannual_programs SET is_active = 0, is_delete = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'include/importnav.php'; ?>
        <?php include 'include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Biannual Program List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Biannual Programs</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">Biannual Admission Programs</h3>
                                    <a href="admission-data.php" class="btn btn-primary btn-sm float-right">+ Add
                                        Program</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Program</th>
                                                    <th>Faculty</th>
                                                    <th>Level</th>
                                                    <th>Admission Year</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    $i = 1;
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>
                                                            <td>{$i}</td>
                                                            <td>{$row['program_name']}</td>
                                                            <td>{$row['faculty_name']}</td>
                                                            <td>{$row['level_name']}</td>
                                                            <td>{$row['admission_year']}</td>
                                                            <td>
                                                                <a href='biannual_update.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                                                <a href='javascript:void(0);' 
                                                                    class='btn btn-sm btn-danger delete-btn' 
                                                                    data-id='{$row['id']}'>Delete</a>
                                                            </td>
                                                        </tr>";
                                                        $i++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Program</th>
                                                    <th>Faculty</th>
                                                    <th>Level</th>
                                                    <th>Admission Year</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'include/importfooter.php'; ?>
    <?php include 'include/importjs.php'; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-btn").forEach(function(button) {
            button.addEventListener("click", function() {
                let programId = this.getAttribute("data-id");
                let row = this.closest("tr");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This program will be deleted from biannual admission!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("view_biannual_programs.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: "id=" + programId
                            })
                            .then(res => res.text())
                            .then(data => {
                                if (data.trim() === "success") {
                                    Swal.fire('Deleted!',
                                        'Program removed from Biannual admission.',
                                        'success');
                                    row.remove();
                                } else {
                                    Swal.fire('Error!', 'Something went wrong.',
                                        'error');
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'Server not responding.',
                                    'error');
                            });
                    }
                });
            });
        });
    });
    </script>
</body>

</html>