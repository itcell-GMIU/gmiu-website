<?php
include('include/config.php');

// Security Check: Only SUPER ADMIN or ADMIN can create users
if (!isset($_SESSION['role_id']) || ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 2)) {
    header("Location: index.php");
    exit();
}

$message = '';
$message_type = '';

// Handle Form Submission
if (isset($_POST['btn-create-user'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role_id = (int)$_POST['role_id'];

    // Check if email exists
    $check_sql = "SELECT id FROM tbl_staff WHERE email = ?";
    $stmt = $con->prepare($check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $message = "Error: Email already exists!";
        $message_type = "error";
    } else {
        $insert_sql = "INSERT INTO tbl_staff (name, email, password, role_id, is_active) VALUES (?, ?, ?, ?, 1)";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("sssi", $name, $email, $password, $role_id);
        if ($stmt->execute()) {
            $message = "User created successfully!";
            $message_type = "success";
        } else {
            $message = "Error creating user: " . $con->error;
            $message_type = "error";
        }
    }
}

// Fetch Roles (Excluding Super Admin)
$roles_sql = "SELECT id, name FROM tbl_role WHERE is_delete = 0 AND id != 1";
$roles_result = $con->query($roles_sql);
$roles = [];
if ($roles_result) {
    while ($r = $roles_result->fetch_assoc()) {
        $roles[] = $r;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('include/head.php'); ?>
    <title>Create User | TADA Portal</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }
        .form-header {
            margin-bottom: 25px;
            border-bottom: 2px solid #eff6ff;
            padding-bottom: 15px;
        }
        .form-header h4 {
            color: #1e293b;
            font-weight: 800;
            margin: 0;
        }
        .btn-create {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            font-weight: 700;
            border-radius: 10px;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body>
    <?php include('include/header.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="title">
                                <h4>Security & Users</h4>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active">Create User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <div class="form-header">
                        <h4><i class="fa fa-user-plus mr-2 text-primary"></i> Create New Portal User</h4>
                    </div>
                    
                    <form method="POST" action="">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter Full Name" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="user@example.com" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Temporary Password</label>
                            <input type="text" name="password" class="form-control form-control-lg" placeholder="Set a password" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Assign Role</label>
                            <select name="role_id" class="form-control form-control-lg" required>
                                <option value="">Select Role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="btn-create-user" class="btn-create mt-3">
                            <i class="fa fa-check-circle mr-2"></i> Register User
                        </button>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <?php if ($message): ?>
    <script>
        swal({
            title: "<?= $message ?>",
            icon: "<?= $message_type ?>",
            button: "Close"
        }).then(function() {
            <?php if($message_type == 'success'): ?>
            window.location.href = 'user-list.php';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>
