<?php
include 'include/checklogin.php';

// Fetch referral list
$query = "
    SELECT r.id, r.referral_code, r.name, rr.role_name, r.contact, r.email, r.created_by, r.created_at
    FROM tbl_referral_master r
    JOIN tbl_referral_role rr ON r.role_id = rr.role_id
    WHERE r.is_delete = 0 and rr.id != 6
    ORDER BY r.id DESC
";
$result = $con->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $con->prepare("UPDATE tbl_referral_master SET is_active = 0, is_delete = 1 WHERE id = ?");

    if (!$stmt) {
        echo "Prepare failed: " . $con->error;
        exit;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Execute failed: " . $stmt->error;
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
                            <h1 class="m-0">Referral List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Referral List</li>
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
                                    <h3 class="card-title">Referral Records</h3>
                                    <a href="add_refferal_code.php" class="btn btn-primary btn-sm float-right">+ Add Referral</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Referral Code</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Contact</th>
                                                    <th>Email</th>
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
                                                                    <td>{$row['referral_code']}</td>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['role_name']}</td>
                                                                    <td>{$row['contact']}</td>
                                                                    <td>{$row['email']}</td>                                     
                                                                
                                                                    <td>
                                                                        <a href='referral_update.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                                                        <a href='javascript:void(0);' 
                                                                                class='btn btn-sm btn-danger delete-btn' 
                                                                                data-id='{$row['id']}'>Delete</a>

                                                                    </td>
                                                            </tr>";
                                                        $i++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Referral Code</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Contact</th>
                                                    <th>Email</th>
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
                    let referralId = this.getAttribute("data-id");
                    let row = this.closest("tr");

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This referral will be deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // AJAX call to delete
                            fetch("view_refferal_code.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: "id=" + referralId
                                })
                                .then(res => res.text())
                                .then(data => {
                                    if (data.trim() === "success") {
                                        Swal.fire(
                                            'Deleted!',
                                            'Referral has been removed.',
                                            'success'
                                        );
                                        row.remove(); // remove row from table
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            'Something went wrong.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(() => {
                                    Swal.fire(
                                        'Error!',
                                        'Server not responding.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>


</body>

</html>