<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['id']; ?>

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

    <title>PAC Form 3</title>

</head>

<body>
    <div class="a4-page mx-auto mt-3">
        <div class="col-md-12 p-4 py-0 pt-4 d-flex">
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="font-weight-bolder text-danger font-weight-bold col-md-4">Student Name</td>
                            <td class="font-weight-bolder col-md-8"></td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Mobile number (Student)
                            </td>
                            <td class="font-weight-bold col-md-8"></td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Mobile number (Parents)
                            </td>
                            <td class="font-weight-bold col-md-8"></td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Level</td>
                            <td class="font-weight-bold col-md-8">
                                <div class="d-flex mx-2">
                                    <div class="d-flex">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">R</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">D</p>
                                    </div>
                                </div>
                            </td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Faculty / Program Name
                            </td>
                            <td class="font-weight-bold col-md-8"></td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Level</td>
                            <td class="font-weight-bold col-md-8">
                                <div class="d-flex">
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">Diploma</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">UG</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">PG</p>
                                    </div>
                                </div>
                            </td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Admission Type</td>
                            <td class="font-weight-bold col-md-8">
                                <div class="d-flex">
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">1<sup>st</sup> Year</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">2<sup>nd</sup> Year</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">Dual Degree</p>
                                    </div>
                                </div>
                            </td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Branch / Specialization
                            </td>
                            <td class="font-weight-bold col-md-8"></td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Quota (UQ/MQ/VQ/SQ)</td>
                            <td class="font-weight-bold col-md-8">
                                <div class="d-flex">
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">UQ</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">MQ</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">VQ</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">SQ</p>
                                    </div>
                                </div>
                            </td> <!-- Empty cell for input -->
                        </tr>
                        <tr>
                            <td class="font-weight-bold text-danger font-weight-bold col-md-4">Category</td>
                            <td class="font-weight-bold col-md-8">
                                <div class="d-flex">
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">OPEN</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">EWS</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">SEBC</p>
                                    </div>
                                    <div class="d-flex mx-2">
                                        <input type="checkbox">
                                        <p class="mb-0 text-danger mx-1">SC/ST</p>
                                    </div>
                                </div>
                            </td> <!-- Empty cell for input -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <div class="heading px-3 mt-2 bg-danger d-flex align-items-center rounded"
                    style="margin-left: 10px; height: 30px;">
                    <p class="mb-0 text-white cfs-13 mb-0">PAC Form - (Part - 1)</p>
                </div>
                <div class="border px-3 mt-2 rounded" style="margin-left: 10px;">
                    <p class="mb-0 text-danger cfs-13">Form No :- <?php
                    $query = "SELECT pacid  FROM tbl_pac_form";
                    $resultSet = $con->query($query);
                    if ($resultSet) {
                        $data = $resultSet->fetch_assoc();
                        if ($data['pacid']) {
                            echo $data['pacid'];
                        }
                    }
                    ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-12 p-4 py-0 mt-2">
            <p class="font-weight-bold text-danger mb-0 cfs-13">Congratulations! We are pleased to inform you that you
                have been selected for provisionale admission for the batch 2024-25 as per order of Merit. The program
                is likely to commence from month of june 2024. This admission offer is provisional and subject to
                fulfilling the eligibility criteria and document submission at Eligibility section. Fees structure is as
                below.</p>
        </div>
        <div class="col-md-12 p-4 py-0 mt-2">
            <table class="table table-bordered col-md-12">
                <thead class="text-center">
                    <tr>
                        <td class="text-danger font-weight-bold col-md-8">
                            <li>Token fees Amount paid & Date of admission</li>
                        </td>
                        <td class="text-danger font-weight-bold col-md-2"></td>
                        <td class="text-danger font-weight-bold col-md-2"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-8">
                            <li>Remaining fees & Deadline to fees paid</li>
                        </td>
                        <td class="text-danger font-weight-bold col-md-2"></td>
                        <td class="text-danger font-weight-bold col-md-2"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-2">
                            <li>1<sup>st</sup> Semester Fees (ID card, Enrollment, Examination, Admission fees, Book
                                bank fees are considered in total fees)</li>
                        </td>
                        <td class="text-danger font-weight-bold col-md-2" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="text-danger font-weight-bold col-md-2" colspan="3" rowspan="2">Remark :-</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-12 p-4 py-0 mt-2">
            <p class="font-weight-bold text-danger mb-0 cfs-13">Read below points carefuly,</p>
        </div>
        <div class="col-md-12 p-4 py-0 mt-1">
            <ul>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Admission will be confirmed subject to
                    approvel by Admission committee/University based on Eligibility</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">ID card, Enrollment, Examination, Admission
                    fees are considered in total fees.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">This information given above is true and best
                    of my kowledge, if found false the admission granted will be canceled. I agree and accept without
                    reservation that at any time if the perticulars are found untrue, incorrect, incomplete my
                    application can be considered invalid. University has right cancel admission at any time.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Once fees are paid, it will not be refunded.
                    Also branch and program will not be changed after token fees are paid.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Scholarship/bank loan is the sole
                    responsibility of student; it's not to consent for fees. Fees must be paid by students as per
                    university guidelines or timeline.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Uniform fees will be 800/- Uniform fees will
                    be extra. Contact stationary section for the collection before commencement of term and Student
                    service fees will be extra to pay.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Admission fees are Non-Refundable &
                    Non-Transferable for the students who taken admission through governing body (ACPC, ACPDC).</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">Remaining fees will have to paid given
                    deadline as above. Fees may vary as per FRC/University guidlines.</li>
                <li class="text-danger font-weight-bold col-md-12 cfs-13">2<sup>nd</sup> Semester fees must be paid by
                    onlibe mode.</li>
            </ul>
        </div>
        <div class="col-md-12 p-4 py-0 mt-2">
            <p class="font-weight-bold text-danger mb-0 cfs-13">I have read all above conditions regarding admission,
                and admission cell have informed us about the admission criteria, Non-refundable policy and fees
                structure.</p>
        </div>
        <div class="col-md-12 p-4 py-0 d-flex justify-content-between mt-2">
            <div class="col-md-5">
                <div class="border rounded text-center">
                    <hr class="mt-5">
                    <p class="font-weight-bold text-danger mb-1">Student's Signature</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="border rounded text-center">
                    <hr class="mt-5">
                    <p class="font-weight-bold text-danger mb-1">Parent's/Guardian Signature</p>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <button class="noprint btn btn-primary" onclick="window.print()">Print</button>
    </div>
</body>