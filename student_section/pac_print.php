<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['id']; ?>
<?php
function getIntegerPart($value)
{
    return (int) $value; // Typecasting to int removes decimal part
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="pac-form.css">

    <title>PAC Form Print</title>
</head>

<body>
    <?php
    // SQL query to fetch data from the tbl_pac_form table
    $sqlQuery = "SELECT * FROM tbl_pac_form where pacid = $id";
    $resultSet = $con->query($sqlQuery);

    // Check if any records are returned
    if ($resultSet->num_rows < 2) {
        // Loop through each row and display the data
        while ($row = $resultSet->fetch_assoc()) {
             $program_id = $row['program_id'];
            
             // Step 2: Get branch_code from tbl_program
            $sql2 = "SELECT branch_code , name FROM tbl_program WHERE id = $program_id";
            $resultpac = $con->query($sql2);
        
            if ($resultpac && $resultpac->num_rows > 0) {
                $row2 = $resultpac->fetch_assoc();
                // echo "Branch Code: " . $row2['branch_code'];
            } 
            $result1 = $con->query("SELECT name FROM tbl_level WHERE id = " . $row['level_id']);
            while ($row1 = $result1->fetch_assoc()) {
                $level_name = $row1['name'];
            }

            if ($row['formno'] < 10) {
                $formno = "000" . $row['formno'];
            } else if ($row['formno'] > 9 && $row['formno'] < 100) {
                $formno = "00" . $row['formno'];
            } else if ($row['formno'] > 99 && $row['formno'] < 1000) {
                $formno = "0" . $row['formno'];
            } else if ($row['formno'] > 999) {
                $formno = $row['formno'];
            }
            ?>
            <div class="a4-page mx-auto d-none">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="logo mt-1" style="margin-left: 10px;">
                        <img src="gmiulogo.jpg" alt="" width="200px">
                    </div>
                    <div class="heading px-3 mt-1 bg-dark d-flex align-items-center rounded" style="height: 50px;">
                        <h5 class="mb-0 text-white">PAC Form - (Part - 1)</h5>
                    </div>
                    <div class="formno p-3">
                        <p>Form No : 2025 / <?php echo $formno; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 p-4 py-0 mt-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="font-weight-bolder text-dark font-weight-bold col-md-4">Student Name</td>
                                <td class="font-weight-bolder text-dark font-weight-bold col-md-8">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Mobile number (Student)</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['studentMobile']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Mobile number (Parents)</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['parentMobile']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Email ID</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['studentEmail']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Mode</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex mx-2">
                                        <div class="d-flex">
                                            <input type="checkbox" <?php echo ($row['mode'] == 'R') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">R</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['mode'] == 'SM') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">SM</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo ($row['mode'] == 'CBPA') ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">CBPA</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Faculty / Program Name</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] . " / ";
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    echo $row3['name'];
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Level</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['level2'], 'Diploma') !== false) ? 'checked' : ''; ?>>
                                            <label for="Diploma">Diploma</label>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['level2'], 'UG') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">UG</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['level2'], 'PG') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">PG</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['level2'], 'PHD') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">PHD</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['level2'], 'VOC') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1">VOC</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Admission Type</td>
                                <td class="font-weight-bold col-md-8">
                                    <div class="d-flex">
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], '1st Year') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">1<sup>st</sup>&nbsp;Year</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], '2nd Year') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">2<sup>nd</sup>&nbsp;Year</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], 'Dual Degree') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">Dual&nbsp;Degree</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], 'VOC') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">VOC</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], 'Minor') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">Minor</p>
                                        </div>
                                        <div class="d-flex mx-2">
                                            <input type="checkbox" <?php echo (strpos($row['admissionType'], 'Honour') !== false) ? 'checked' : ''; ?>>
                                            <p class="mb-0 text-dark mx-1 cfs-10">Honour</p>
                                        </div>
                                    </div>
                                </td> <!-- Empty cell for input -->
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Branch / Specialization</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['branchSpecialization']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Date of Provisional admitted
                                </td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['dateProvisional']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Mode of Payment
                                </td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['mode_of_payment']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-4">Remarks</td>
                                <td class="font-weight-bold text-dark font-weight-bold col-md-8">
                                    <?php echo $row['remarks']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered mb-0">
                        <thead class="text-center">
                            <tr>
                                <td class="text-dark font-weight-bold text-center">Sr.<br> No</td>
                                <td class="text-dark font-weight-bold align-middle">Department</td>
                                <td class="text-dark font-weight-bold">Authority Name &<br> Mobile Number</td>
                                <td class="text-dark font-weight-bold">Stemp & Signature<br> with Date</td>
                                <td class="text-dark font-weight-bold align-middle">Remark</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold text-center">1</td>
                                <td class="text-dark font-weight-bold">Account Section - 01</td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold text-center" rowspan="2">2</td>
                                <td class="text-dark font-weight-bold" rowspan="2">Eligibility Section <br>Account Section -
                                    02</td>
                                <td class="text-dark font-weight-bold" rowspan="2"></td>
                                <td class="text-dark font-weight-bold" rowspan="2"></td>
                                <td class="text-dark font-weight-bold" rowspan="2"></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold text-center">3</td>
                                <td class="text-dark font-weight-bold">Department</td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold text-center">4</td>
                                <td class="text-dark font-weight-bold">Library</td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                                <td class="text-dark font-weight-bold"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="font-weight-bold text-dark mb-0" style="font-size: 13px;">&#8226;&nbsp;&nbsp;Provisional
                        admission will be confirmed after fill and submit this form to eligibility section.</p>
                </div>
                <div class="d-flex p-4 py-0 mt-0 justify-content-between">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-dark font-weight-bold col-md-5">Remaining Semester Fees</td>
                                    <td class="text-dark font-weight-bold col-md-7">
                                        <?php echo getIntegerPart($row['remainingFees']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-dark font-weight-bold col-md-5">Remaining Fees Deadline</td>
                                    <td class="text-dark font-weight-bold col-md-7"><?php echo $row['remainingPayDate']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-bordered col-md-12">
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-dark font-weight-bold" colspan="2" rowspan="2"><span
                                            style="font-weight: bold;">Stamp</span> <br> (Admission
                                        cell)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="print-hr" style="height: 2px; background-color: #000000;"></div>
                <div class="d-flex justify-content-between col-md-12">
                    <p class="font-weight-bold text-dark my-0 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                        Account Section - 02
                        (OFFICE COPY)</p>
                    <p class="font-weight-bold text-dark my-0 p-4 py-0">Form No : 2025 / <?php echo $formno; ?></p>
                </div>
                <div class="col-md-12 p-4 py-0">
                    <table class="table table-bordered mb-1">
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Date of admission</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['dateAdmission']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" style="font-size: 9px;">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Faculty</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'];
                                    // . " / ";
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    // echo $row3['name'];
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['parentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Level</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php echo $level_name; ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Admission Type</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['admissionType']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Quota</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['quota']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Token fees amount</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                    <?php echo getIntegerPart($row['tokenFeesAmount']); ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                  <?php
                                    $result3 = $con->query("SELECT branch_code, name, shortname FROM tbl_program WHERE id = " . $row['program_id']);

                                    while ($row3 = $result3->fetch_assoc()) {
                                        $branch = $row3['branch_code'];
                                        $name = isset($row3['name']) ? trim($row3['name']) : '';
                                        $shortname = isset($row3['shortname']) ? trim($row3['shortname']) : '';
                                        $minor = isset($row3['minor']) ? trim($row3['minor']) : '';
                                        $honour = isset($row3['honour']) ? trim($row3['honour']) : '';
                                    
                                        // Skip if name and shortname are both empty or 'N/A'
                                        if (($name == '' || strtolower($name) == 'n/a') &&
                                            ($shortname == '' || strtolower($shortname) == 'n/a')) {
                                            continue;
                                        }
                                    
                                        // Decide what to show as name
                                        if (strlen($name) > 30 && !empty($shortname) && strtolower($shortname) != 'n/a') {
                                            $nameToShow = $shortname;
                                        } else {
                                            $nameToShow = $name;
                                        }
                                    
                                        // Build the output
                                        $output = $branch . " / " . $nameToShow;
                                    
                                        if (!empty($minor) && strtolower($minor) != 'n/a') {
                                            $output .= " / " . $minor;
                                        }
                                    
                                        if (!empty($honour) && strtolower($honour) != 'n/a') {
                                            $output .= " / " . $honour;
                                        }
                                    
                                        echo $output . "<br>";
                                    }

                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Token fees Paid date</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['tokenFeesPaidDate']; ?>

                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Whatsapp Number</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['whatsappNumber']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remaining Semester fees</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                    <?php echo getIntegerPart($row['remainingFees']); ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remaining fees pay date</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['remainingPayDate']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remarks</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" colspan="3">
                                    <?php echo $row['remarks']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="print-hr" style="height: 2px; background-color: #000000;"></div>
                <div class="d-flex justify-content-between col-md-12">
                    <p class="font-weight-bold text-dark my-0 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                        Account Section - 01
                        (OFFICE COPY)</p>
                    <p class="font-weight-bold text-dark my-0 p-4 py-0">Form No : 2025 / <?php echo $formno; ?></p>
                </div>
                <div class="col-md-12 p-4 py-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Date of admission</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['dateAdmission']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" style="font-size: 9px;">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Mo. number</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Faculty/Program Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] . " / ";
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    echo $row3['name'];
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Parents Mo. number</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['parentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Level</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php echo $level_name; ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Admission Type</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['admissionType']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                    <?php echo $row['branchSpecialization']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Token fees amount</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                    <?php echo getIntegerPart($row['tokenFeesAmount']); ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remaining Semester fees</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">
                                    <?php echo getIntegerPart($row['remainingFees']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Token fees Paid date</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['tokenFeesPaidDate']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remaining fees pay date</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['remainingPayDate']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Remarks</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" colspan="3">
                                    <?php echo $row['remarks']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="a4-page mx-auto" style="line-height: 1;">
                <div class="col-md-12 d-flex">
                    <div class="logo mt-3" style="margin-left: 10px;">
                        <h6>ELLIGIBILITY CELL</h6>
                    </div>
                    <div class="heading px-3 mt-2 bg-dark d-flex align-items-center rounded mr-auto"
                        style="height: 35px; margin-left: 80px;">
                        <h5 class="mb-0 text-white">PAC Form - (Part - 2)</h5>
                    </div>
                </div>
                <div class="d-flex justify-content-between col-md-12">
                    <p class="font-weight-bold text-dark my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                        Eligibility
                        Section
                        (OFFICE COPY)</p>
                    <p class="font-weight-bold text-dark my-2 p-4 py-0">Form No : 2025 / <?php echo $formno; ?></p>
                </div>
                <div class="print-hr mb-2" style="height: 2px; background-color: #000000;"></div>
                <div class="col-md-12 p-4 py-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Date of admission</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['dateAdmission']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" style="font-size: 9px;">
                                    <?php echo $row['studentName']; ?>
                                </td>

                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 1</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Faculty</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] ;
                                    // . " / ";
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    // echo $row3['name'];
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 2</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['parentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Level</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php echo $level_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mode</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['mode']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10">
                                    <?php
                                    $result3 = $con->query("SELECT branch_code, name, shortname FROM tbl_program WHERE id = " . $row['program_id']);

                                   while ($row3 = $result3->fetch_assoc()) {
                                        $branch = $row3['branch_code'];
                                        $name = isset($row3['name']) ? trim($row3['name']) : '';
                                        $shortname = isset($row3['shortname']) ? trim($row3['shortname']) : '';
                                        $minor = isset($row3['minor']) ? trim($row3['minor']) : '';
                                        $honour = isset($row3['honour']) ? trim($row3['honour']) : '';
                                    
                                        // Skip if name and shortname are both empty or 'N/A'
                                        if (($name == '' || strtolower($name) == 'n/a') &&
                                            ($shortname == '' || strtolower($shortname) == 'n/a')) {
                                            continue;
                                        }
                                    
                                        // Decide what to show as name
                                        if (strlen($name) > 30 && !empty($shortname) && strtolower($shortname) != 'n/a') {
                                            $nameToShow = $shortname;
                                        } else {
                                            $nameToShow = $name;
                                        }
                                    
                                        // Build the output
                                        $output = $branch . " / " . $nameToShow;
                                    
                                        if (!empty($minor) && strtolower($minor) != 'n/a') {
                                            $output .= " / " . $minor;
                                        }
                                    
                                        if (!empty($honour) && strtolower($honour) != 'n/a') {
                                            $output .= " / " . $honour;
                                        }
                                    
                                        echo $output . "<br>";
                                    }

                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Admission Type</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['admissionType']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Quota</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['quota']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Email ID</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentEmail']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">T-Shirt Size</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['tshirt_size']; ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">CBPA status: Yes/NO</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['cbpaStatus']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Category</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['category']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="print-hr" style="height: 2px; background-color: #000000;"></div>
                <div class="d-flex justify-content-between col-md-12">
                    <p class="font-weight-bold text-dark my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">Library
                        (OFFICE COPY)</p>
                    <p class="font-weight-bold text-dark my-2 p-4 py-0">Form No : 2025 / <?php echo $formno; ?></p>
                </div>
                <div class="col-md-12 p-4 py-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Date of admission</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['dateAdmission']; ?></td>

                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" style="font-size: 9px;">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 1</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Faculty</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] ;
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    // echo $row3['name'];
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 2</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['parentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Level</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php echo $level_name; ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mode</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['mode']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10">
                                    <?php
                                    $result3 = $con->query("SELECT branch_code, name, shortname FROM tbl_program WHERE id = " . $row['program_id']);

                                   while ($row3 = $result3->fetch_assoc()) {
                                        $branch = $row3['branch_code'];
                                        $name = isset($row3['name']) ? trim($row3['name']) : '';
                                        $shortname = isset($row3['shortname']) ? trim($row3['shortname']) : '';
                                        $minor = isset($row3['minor']) ? trim($row3['minor']) : '';
                                        $honour = isset($row3['honour']) ? trim($row3['honour']) : '';
                                    
                                        // Skip if name and shortname are both empty or 'N/A'
                                        if (($name == '' || strtolower($name) == 'n/a') &&
                                            ($shortname == '' || strtolower($shortname) == 'n/a')) {
                                            continue;
                                        }
                                    
                                        // Decide what to show as name
                                        if (strlen($name) > 30 && !empty($shortname) && strtolower($shortname) != 'n/a') {
                                            $nameToShow = $shortname;
                                        } else {
                                            $nameToShow = $name;
                                        }
                                    
                                        // Build the output
                                        $output = $branch . " / " . $nameToShow;
                                    
                                        if (!empty($minor) && strtolower($minor) != 'n/a') {
                                            $output .= " / " . $minor;
                                        }
                                    
                                        if (!empty($honour) && strtolower($honour) != 'n/a') {
                                            $output .= " / " . $honour;
                                        }
                                    
                                        echo $output . "<br>";
                                    }

                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Admission Type</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['admissionType']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Quota</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['quota']; ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Email ID</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentEmail']; ?></td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Photo Submitted Status</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['photoStatus']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="print-hr" style="height: 2px; background-color: #000000;"></div>
                <div class="d-flex justify-content-between col-md-12">
                    <p class="font-weight-bold text-dark my-2 p-4 py-0" style="font-size: 13px; font-weight: bolder;">
                        Department
                        (OFFICE COPY)</p>
                    <p class="font-weight-bold text-dark my-2 p-4 py-0">Form No : 2025 / <?php echo $formno; ?></p>
                </div>
                <div class="col-md-12 p-4 py-0">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Date of admission</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['dateAdmission']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Name</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13" style="font-size: 9px;">
                                    <?php echo $row['studentName']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 1</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Faculty</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php
                                $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = " . $row['faculty_id']);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo $row1['name'] ;
                                }
                                $result3 = $con->query("SELECT name FROM tbl_program WHERE id = " . $row['program_id']);
                                while ($row3 = $result3->fetch_assoc()) {
                                    // echo $row3['name'];
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mobile number - 2</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['parentMobile']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Level</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10"><?php echo $level_name; ?></td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Mode</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['mode']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Branch/Specialization</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-10">
                                    <?php
                                    $result3 = $con->query("SELECT branch_code, name, shortname FROM tbl_program WHERE id = " . $row['program_id']);

                                     while ($row3 = $result3->fetch_assoc()) {
                                        $branch = $row3['branch_code'];
                                        $name = isset($row3['name']) ? trim($row3['name']) : '';
                                        $shortname = isset($row3['shortname']) ? trim($row3['shortname']) : '';
                                        $minor = isset($row3['minor']) ? trim($row3['minor']) : '';
                                        $honour = isset($row3['honour']) ? trim($row3['honour']) : '';
                                    
                                        // Skip if name and shortname are both empty or 'N/A'
                                        if (($name == '' || strtolower($name) == 'n/a') &&
                                            ($shortname == '' || strtolower($shortname) == 'n/a')) {
                                            continue;
                                        }
                                    
                                        // Decide what to show as name
                                        if (strlen($name) > 30 && !empty($shortname) && strtolower($shortname) != 'n/a') {
                                            $nameToShow = $shortname;
                                        } else {
                                            $nameToShow = $name;
                                        }
                                    
                                        // Build the output
                                        $output = $branch . " / " . $nameToShow;
                                    
                                        if (!empty($minor) && strtolower($minor) != 'n/a') {
                                            $output .= " / " . $minor;
                                        }
                                    
                                        if (!empty($honour) && strtolower($honour) != 'n/a') {
                                            $output .= " / " . $honour;
                                        }
                                    
                                        echo $output . "<br>";
                                    }

                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Admission Type</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['admissionType']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Quota</td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['quota']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">Student Email ID </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['studentEmail']; ?>
                                </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13">WhatsApp Number </td>
                                <td class="text-dark font-weight-bold col-md-3 cfs-13"><?php echo $row['whatsappNumber']; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="print-hr" style="height: 2px; background-color: #000000;"></div>
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="logo mt-2" style="margin-left: 10px;">
                        <!-- <img src="gmiulogo.jpg" alt="" width="200px"> -->
                    </div>
                    <div class="">
                        <!-- <h5 class="mb-0 text-white">PAC Form - (Part - 1)</h5> -->
                    </div>
                    <div class="formno px-3 mt-2">
                        <p class="mb-0">Form No : 2025 / <?php echo $formno; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 p-4 py-0 d-flex mt-3">
                    <div class="col-md-4">
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">SSC (10<sup>th</sup>) Mark sheet of all attempt</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Diploma All Mark sheets</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Cast Certificate</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Income Certificate</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">7 Passport Size Photographs</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Registration Slip (ACPC)</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Admission Acknowledgement Slip (ACPC)</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Certificate for Defense Quota</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Medical Report (if any)</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Migration Certificate</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">HSC (12<sup>th</sup>) Mark sheet of all attempt</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">School Leaving Certificate</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Non Creamy Layer Certificate</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Adhar Card (Student & Parents)</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Bank Pass book / Cancel Cheque [Xe</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Fee Receipt for Registration Form</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Certificate for Physically Handicapp</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Anti-ragging Affidavit</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Attempt Certificate</p>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" class="ics">
                            <p class="cfs-10 text-dark mx-1 mb-1">Ex - Serviceman Certificate</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border" style="height: 100%; width: 100%;">
                            <p class="cfs-10 text-dark mt-1">&nbsp;&nbsp;Remarks :</p>
                            <div class="mt-auto">
                                <p class="cfs-10 text-dark">&nbsp;&nbsp;Name of Staff :</p>
                                <p class="cfs-10 text-dark">&nbsp;&nbsp;Signature of Staff :</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-5 mx-4">
                    <h6>FULL NAME OF STUDENT :<span class="text-decoration-underline"><?php echo $row['studentName']; ?><span></h6>
                </div>
            </div>

            <div class="d-flex justify-content-center my-2 noprint">
                <button class="noprint btn btn-primary" onclick="window.print()">Print</button>
            </div>

            <?php
        }
    } else {
        echo "No records found.";
    }
    ?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>