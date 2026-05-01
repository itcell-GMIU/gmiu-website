<?php
// --- PHP Data Generation: 50 Sample Records ---

// Helper arrays to generate varied dummy data
$firstNames = ['Aarav', 'Vivaan', 'Aditya', 'Vihaan', 'Arjun', 'Sai', 'Reyansh', 'Ayaan', 'Krishna', 'Ishaan', 'Riya', 'Saanvi', 'Aanya', 'Aaradhya', 'Anika', 'Navya', 'Diya', 'Pari', 'Myra', 'Ananya'];
$middleNames = ['Kumar', 'Lal', 'Chandra', 'Prasad', 'Singh', 'Raj', 'Nath', 'Dev', 'Prakash', 'Mohan'];
$lastNames = ['Sharma', 'Verma', 'Gupta', 'Singh', 'Chauhan', 'Patel', 'Shah', 'Mehta', 'Joshi', 'Pandya', 'Desai', 'Reddy', 'Nair', 'Menon', 'Iyer'];
$genders = ['Male', 'Female'];
$schools = ['St. Xavier\'s High School', 'Delhi Public School', 'Podar International', 'Kendriya Vidyalaya', 'Amity International', 'Ryan International'];
$faculties = ['Science', 'Commerce', 'Arts'];
$levels = ['Undergraduate', 'Postgraduate', 'Diploma'];
$statuses = ['Hot', 'Warm', 'Cold', 'Enrolled', 'Cancelled'];
$modes = ['Walk-in', 'Phone Call', 'Website', 'Referral'];
$staff = ['Rajesh Kumar', 'Priya Singh', 'Amit Patel', 'Sneha Sharma'];
$counselors = ['Anita Desai', 'Vikram Rathod', 'Sunita Mehta'];
$remarks = ['Follow-up required', 'Interested in hostel', 'Asked for brochure', 'Will visit with parents', 'Looking for scholarship'];

$inquiries = []; // This will hold our 50 records

for ($i = 1; $i <= 50; $i++) {
    $fn = $firstNames[array_rand($firstNames)];
    $mn = $middleNames[array_rand($middleNames)];
    $ln = $lastNames[array_rand($lastNames)];
    $faculty = $faculties[array_rand($faculties)];

    // Assign program based on faculty
    if ($faculty == 'Science') {
        $program = ['B.Sc. IT', 'B.Sc. Physics', 'M.Sc. Chemistry'][array_rand(['B.Sc. IT', 'B.Sc. Physics', 'M.Sc. Chemistry'])];
    } elseif ($faculty == 'Commerce') {
        $program = ['B.Com', 'M.Com', 'BBA'][array_rand(['B.Com', 'M.Com', 'BBA'])];
    } else {
        $program = ['B.A. English', 'M.A. History', 'B.A. Psychology'][array_rand(['B.A. English', 'M.A. History', 'B.A. Psychology'])];
    }

    $inquiries[] = [
        'inquiryId' => 2025000 + $i,
        'firstName' => $fn,
        'middleName' => $mn,
        'lastName' => $ln,
        'gender' => $genders[array_rand($genders)],
        'lastSchool' => $schools[array_rand($schools)],
        'mobile1' => '98' . rand(10000000, 99999999),
        'mobile2' => (rand(0, 1) ? '97' . rand(10000000, 99999999) : '-'),
        'email' => strtolower($fn . '.' . $ln) . '@example.com',
        'facultyName' => $faculty,
        'levelName' => $levels[array_rand($levels)],
        'programName' => $program,
        'lastExam' => ['HSC', 'CBSE 12th', 'Diploma Final Year'][array_rand(['HSC', 'CBSE 12th', 'Diploma Final Year'])],
        'lastExamStatus' => ['Passed', 'Awaiting Result'][array_rand(['Passed', 'Awaiting Result'])],
        'status' => $statuses[array_rand($statuses)],
        'inquiryMode' => $modes[array_rand($modes)],
        'assignStaff' => $staff[array_rand($staff)],
        'counselor' => $counselors[array_rand($counselors)],
        'callCount' => rand(0, 5),
        'lastRemark' => $remarks[array_rand($remarks)],
    ];
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>View My Inquiries</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">View My Inquiry</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <div class="dropdown">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown">
                                    September 2025
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Export List</a>
                                    <a class="dropdown-item" href="#">Policies</a>
                                    <a class="dropdown-item" href="#">View Assets</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="table-responsive table-sm">
                        <table class="data-table table-striped table-hover nowrap">
                            <thead>
                                <tr align="center">
                                    <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                    <th scope="row" style="color:black;"><b>Inquiry Id</b></th>
                                    <th scope="row" style="color:black;"><b>First Name</b></th>
                                    <th scope="row" style="color:black;"><b>Middle Name</b></th>
                                    <th scope="row" style="color:black;"><b>Last Name</b></th>
                                    <th scope="row" style="color:black;"><b>Gender</b></th>
                                    <th scope="row" style="color:black;"><b>Last School Name</b></th>
                                    <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                    <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                    <th scope="row" style="color:black;"><b>Email</b></th>
                                    <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                    <th scope="row" style="color:black;"><b>Level Name</b></th>
                                    <th scope="row" style="color:black;"><b>Program Name</b></th>
                                    <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                    <th scope="row" style="color:black;"><b>Last Exam Status</b></th>
                                    <th scope="row" style="color:black;"><b>Status</b></th>
                                    <th scope="row" style="color:black;"><b>Inquiry Mode</b></th>
                                    <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                    <th scope="row" style="color:black;"><b>Counselor</b></th>
                                    <th scope="row" style="color:black;"><b>Call Count</b></th>
                                    <th scope="row" style="color:black;"><b>Last Remark</b></th>
                                    <th scope="row" style="color:black;"><b>Remarks</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inquiries as $index => $inquiry): ?>
                                    <tr align="center">
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $inquiry['inquiryId']; ?></td>
                                        <td><?php echo $inquiry['firstName']; ?></td>
                                        <td><?php echo $inquiry['middleName']; ?></td>
                                        <td><?php echo $inquiry['lastName']; ?></td>
                                        <td><?php echo $inquiry['gender']; ?></td>
                                        <td><?php echo $inquiry['lastSchool']; ?></td>
                                        <td><?php echo $inquiry['mobile1']; ?></td>
                                        <td><?php echo $inquiry['mobile2']; ?></td>
                                        <td><?php echo $inquiry['email']; ?></td>
                                        <td><?php echo $inquiry['facultyName']; ?></td>
                                        <td><?php echo $inquiry['levelName']; ?></td>
                                        <td><?php echo $inquiry['programName']; ?></td>
                                        <td><?php echo $inquiry['lastExam']; ?></td>
                                        <td><?php echo $inquiry['lastExamStatus']; ?></td>
                                        <td><?php echo $inquiry['status']; ?></td>
                                        <td><?php echo $inquiry['inquiryMode']; ?></td>
                                        <td><?php echo $inquiry['assignStaff']; ?></td>
                                        <td><?php echo $inquiry['counselor']; ?></td>
                                        <td><?php echo $inquiry['callCount']; ?></td>
                                        <td><?php echo $inquiry['lastRemark']; ?></td>
                                        <td><button class="btn btn-sm btn-primary" type="button"><i class="fa fa-plus"></i>
                                                Add</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr align="center">
                                    <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                    <th scope="row" style="color:black;"><b>Inquiry Id</b></th>
                                    <th scope="row" style="color:black;"><b>First Name</b></th>
                                    <th scope="row" style="color:black;"><b>Middle Name</b></th>
                                    <th scope="row" style="color:black;"><b>Last Name</b></th>
                                    <th scope="row" style="color:black;"><b>Gender</b></th>
                                    <th scope="row" style="color:black;"><b>Last School Name</b></th>
                                    <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                    <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                    <th scope="row" style="color:black;"><b>Email</b></th>
                                    <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                    <th scope="row" style="color:black;"><b>Level Name</b></th>
                                    <th scope="row" style="color:black;"><b>Program Name</b></th>
                                    <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                    <th scope="row" style="color:black;"><b>Last Exam Status</b></th>
                                    <th scope="row" style="color:black;"><b>Status</b></th>
                                    <th scope="row" style="color:black;"><b>Inquiry Mode</b></th>
                                    <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                    <th scope="row" style="color:black;"><b>Counselor</b></th>
                                    <th scope="row" style="color:black;"><b>Call Count</b></th>
                                    <th scope="row" style="color:black;"><b>Last Remark</b></th>
                                    <th scope="row" style="color:black;"><b>Remarks</b></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $('document').ready(function () {
            $('.data-table').DataTable({
                scrollX: true, // 👈 enables horizontal scroll
                scrollCollapse: true,
                autoWidth: false,
                responsive: false, // 👈 pure horizontal scroll (not hiding)
                columnDefs: [
                    {
                        targets: "datatable-nosort",
                        orderable: false,
                    },
                    {
                        targets: [], // 👈 example: hide column 3 & 5 (0-based index)
                        visible: false
                    }
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print',
                    {
                        extend: 'colvis',     // 👈 Column visibility button
                        text: 'Columns'      // 👈 Button label
                    }
                ]
            });
        });

    </script>
</body>

</html>