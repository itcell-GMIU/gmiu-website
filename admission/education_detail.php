<?php

$cmd = "Select eq.* from tbl_education_qualification as eq  where eq.student_id=? ";
$stmt = $con->prepare($cmd);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if ($result->num_rows == 1) {

    $row = $result->fetch_assoc();
    $ssc_boardname = $row['ssc_boardname'];
    $ssc_schoolname = $row['ssc_schoolname'];
    $ssc_percentage = $row['ssc_percentage'];
    $ssc_passingmonth = $row['ssc_passingmonth'];
    $ssc_passingyear = $row['ssc_passingyear'];
    $hsc_stream = $row['hsc_stream'];
    $hsc_boardseatnumber = $row['hsc_boardseatnumber'];
    $hsc_schoolname = $row['hsc_schoolname'];
    $hsc_percentage = $row['hsc_percentage'];
    $hsc_passingstatus = $row['hsc_passingstatus'];
    $hsc_passingmonth = $row['hsc_passingmonth'];
    $hsc_passingyear = $row['hsc_passingyear'];
    $hsc_passingboard = $row['hsc_passingboard'];
    $gujcet_appear = $row['gujcet_appear'];
    $gujcet_seatnumber = $row['gujcet_seatnumber'];
    $gujcet_applicationnumber = $row['gujcet_applicationnumber'];
    $jee_appear = $row['jee_appear'];
    $jee_seatnumber = $row['jee_seatnumber'];
    $jee_applicationnumber = $row['jee_applicationnumber'];
    $neet_appear = $row['neet_appear'];
    $neet_seatnumber = $row['neet_seatnumber'];
    $neet_applicationnumber = $row['neet_applicationnumber'];
    $graduation_course = $row['graduation_course'];
    $graduation_university = $row['graduation_university'];
    $graduation_college_name = $row['graduation_college_name'];
    $graduation_cpi = $row['graduation_cpi'];
    $graduation_passing_status = $row['graduation_passing_status'];
    $graduation_passing_month = $row['graduation_passing_month'];
    $graduation_passing_year = $row['graduation_passing_year'];
    $gmcet_score = $row['gmcet_score'];
    $cmat_score = $row['cmat_score'];
} else {
    $ssc_boardname = "";
    $ssc_schoolname = "";
    $ssc_percentage = "";
    $ssc_passingmonth = "";
    $ssc_passingyear = "";
    $hsc_stream = "";
    $hsc_boardseatnumber = "";
    $hsc_schoolname = "";
    $hsc_percentage = "";
    $hsc_passingstatus = "";
    $hsc_passingmonth = "";
    $hsc_passingyear = "";
    $hsc_passingboard = "";
    $gujcet_appear = "";
    $gujcet_seatnumber = "";
    $gujcet_applicationnumber = "";
    $jee_appear = "";
    $jee_seatnumber = "";
    $jee_applicationnumber = "";
    $neet_appear = "";
    $neet_seatnumber = "";
    $neet_applicationnumber = "";
    $graduation_course = "";
    $graduation_university = "";
    $graduation_college_name = "";
    $graduation_cpi = "";
    $graduation_passing_status = "";
    $graduation_passing_month = "";
    $graduation_passing_year = "";
    $gmcet_score = "";
    $cmat_score = "";
}

?>
<form id="education_detail" method="POST">
    <div class="row">
        <p class="heading-p">SSC / 10th</p>
        <hr>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="error">
                <label for="first_name">Board Name</label>
                <span class="form_error_message">*</span>
            </div>
            <select name="ssc_boardname" id="board_name_input_id" class="form-control select2me">
                <option selected="selected" value="">
                    Select Board
                    Name
                </option>
                <option value="Gujarat Board" <?php if ($ssc_boardname == "Gujarat Board") {
                    echo "selected";
                } ?>>
                    Gujarat Board
                </option>
                <option value="CBSE" <?php if ($ssc_boardname == "CBSE") {
                    echo "selected";
                } ?>>CBSE</option>
                <option value="ISCE" <?php if ($ssc_boardname == "ISCE") {
                    echo "selected";
                } ?>>ISCE
                </option>
                <option value="NIOS" <?php if ($ssc_boardname == "NIOS") {
                    echo "selected";
                } ?>>NIOS
                </option>
                <option value="IB" <?php if ($ssc_boardname == "IB") {
                    echo "selected";
                } ?>>IB
                </option>
                <option value="Andhra Pradesh Board of Intermediate Education" <?php if
                ($ssc_boardname == "Andhra Pradesh Board of Intermediate Education") {
                    echo "selected";
                } ?>>Andhra
                    Pradesh Board of Intermediate
                    Education
                </option>
                <option value="Andhra Pradesh Board of Secondary Education" <?php if
                ($ssc_boardname == "Andhra Pradesh Board of Secondary Education") {
                    echo "selected";
                } ?>>Andhra
                    Pradesh Board of Secondary Education
                </option>
                <option value="Assam Board of Secondary Education" <?php if
                ($ssc_boardname == "Assam Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Assam Board of Secondary Education
                </option>
                <option value="Bihar Intermediate Education Council" <?php if
                ($ssc_boardname == "Bihar Intermediate Education Council") {
                    echo "selected";
                } ?>>Bihar
                    Intermediate Education Council
                </option>
                <option value="Bihar School Examination Board" <?php if
                ($ssc_boardname == "Bihar School Examination Board") {
                    echo "selected";
                } ?>>Bihar
                    School Examination Board
                </option>
                <option value="Board of Higher Secondary Education,New Delhi" <?php if
                ($ssc_boardname == "Board of Higher Secondary Education,New Delhi") {
                    echo "selected";
                } ?>>Board of
                    Higher Secondary Education,New
                    Delhi
                </option>
                <option value="Board of School Education, Haryana" <?php if
                ($ssc_boardname == "Board of School Education, Haryana") {
                    echo "selected";
                } ?>>
                    Board of School Education, Haryana
                </option>
                <option value="Board of Secondary Education Kant Shahjahanpur Uttar Pradesh" <?php if
                ($ssc_boardname == "Board of Secondary Education Kant Shahjahanpur Uttar Pradesh") {
                    echo "selected"
                    ;
                } ?>>Board of Secondary Education Kant
                    Shahjahanpur Uttar
                    Pradesh</option>
                <option value="Board of Secondary Education Madhya Bharat Gwalior" <?php if
                ($ssc_boardname == "Board of Secondary Education Madhya Bharat Gwalior") {
                    echo "selected";
                } ?>>Board of Secondary Education
                    Madhya Bharat
                    Gwalior
                </option>
                <option value="Board of Secondary Education, Madhya Pradesh" <?php if
                ($ssc_boardname == "Board of Secondary Education, Madhya Pradesh") {
                    echo "selected";
                } ?>>Board of
                    Secondary Education, Madhya Pradesh
                </option>
                <option value="Board of Secondary Education, Rajasthan" <?php if
                ($ssc_boardname == "Board of Secondary Education, Rajasthan") {
                    echo "selected";
                } ?>>Board of
                    Secondary Education, Rajasthan </option>
                <option value="Board of Youth Education India" <?php if
                ($ssc_boardname == "Board of Youth Education India") {
                    echo "selected";
                } ?>>Board
                    of Youth Education India</option>
                <option value="Central Board Of Education Ajmer New Delhi" <?php if
                ($ssc_boardname == "Central Board Of Education Ajmer New Delhi") {
                    echo "selected";
                } ?>>Central
                    Board Of Education Ajmer New Delhi
                </option>
                <option value="Central Board Of Patna, Bihar" <?php if (
                    $ssc_boardname == "Central Board Of Patna, Bihar"
                ) {
                    echo "selected";
                } ?>>
                    Central Board Of Patna, Bihar</option>
                <option value="Chhattisgarh Board of Secondary Education" <?php if
                ($ssc_boardname == "Chhattisgarh Board of Secondary Education") {
                    echo "selected";
                } ?>>Chhattisgarh
                    Board of Secondary Education
                </option>
                <option value="Goa Board of Secondary & Higher Secondary Education" <?php if
                ($ssc_boardname == "Goa Board of Secondary & Higher Secondary Education") {
                    echo "selected";
                } ?>>Goa Board of Secondary &
                    Higher Secondary
                    Education
                </option>
                <option value="GSHSEB" <?php if ($ssc_boardname == "GSHSEB") {
                    echo "selected";
                } ?>>GSHSEB
                </option>
                <option value="Himachal Pradesh Board of School Education" <?php if
                ($ssc_boardname == "Himachal Pradesh Board of School Education") {
                    echo "selected";
                } ?>>Himachal
                    Pradesh Board of School Education
                </option>
                <option value="Institution of Secondary Distance Education" <?php if
                ($ssc_boardname == "Institution of Secondary Distance Education") {
                    echo "selected";
                } ?>>Institution of Secondary Distance Education
                </option>
                <option value="J&K State Board of School Education" <?php if
                ($ssc_boardname == "J&K State Board of School Education") {
                    echo "selected";
                } ?>>
                    J&K State Board of School Education
                </option>
                <option value="Jharkhand Academic Council" <?php if ($ssc_boardname == "Jharkhand Academic Council") {
                    echo "selected";
                } ?>>Jharkhand
                    Academic Council</option>
                <option value="Karnataka Board of the Pre-University Education" <?php if
                ($ssc_boardname == "Karnataka Board of the Pre-University Education") {
                    echo "selected";
                } ?>>Karnataka Board of the
                    Pre-University
                    Education
                </option>
                <option value="Karnataka Secondary Education Examination Board" <?php if
                ($ssc_boardname == "Karnataka Secondary Education Examination Board") {
                    echo "selected";
                } ?>>Karnataka Secondary Education
                    Examination
                    Board
                </option>
                <option value="Kerala Board of Public Examinations" <?php if
                ($ssc_boardname == "Kerala Board of Public Examinations") {
                    echo "selected";
                } ?>>
                    Kerala Board of Public Examinations
                </option>
                <option value="Madhya Pradesh State Open School Education Board" <?php if
                ($ssc_boardname == "Madhya Pradesh State Open School Education Board") {
                    echo "selected";
                } ?>>Madhya Pradesh State Open
                    School Education
                    Board
                </option>
                <option value="Maharashtra State Board of Secondary and Higher Secondary Education" <?php if
                ($ssc_boardname == "Maharashtra State Board of Secondary and Higher Secondary Education") {
                    echo "selected";
                } ?>>Maharashtra State Board of Secondary and
                    Higher
                    Secondary Education
                </option>
                <option value="Manipur Board of Secondary Education" <?php if
                ($ssc_boardname == "Manipur Board of Secondary Education") {
                    echo "selected";
                } ?>>Manipur Board of
                    Secondary Education
                </option>
                <option value="Manipur Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "Manipur Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Manipur
                    Council of Higher Secondary
                    Education
                </option>
                <option value="Meghalaya Board of School Education" <?php if
                ($ssc_boardname == "Meghalaya Board of School Education") {
                    echo "selected";
                } ?>>
                    Meghalaya Board of School Education
                </option>
                <option value="Mizoram Board of School Education" <?php if
                ($ssc_boardname == "Mizoram Board of School Education") {
                    echo "selected";
                } ?>>
                    Mizoram Board of School Education
                </option>
                <option value="Nagaland Board of School Education" <?php if
                ($ssc_boardname == "Nagaland Board of School Education") {
                    echo "selected";
                } ?>>
                    Nagaland Board of School Education
                </option>
                <option value="Northwest Accreditation Commission & [NWAC]" <?php if
                ($ssc_boardname == "Northwest Accreditation Commission & [NWAC]") {
                    echo "selected";
                } ?>>Northwest
                    Accreditation Commission & [NWAC]
                </option>
                <option value="Orissa Board of Secondary Education" <?php if
                ($ssc_boardname == "Orissa Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Orissa Board of Secondary Education
                </option>
                <option value="Orissa Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "Orissa Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Orissa
                    Council of Higher Secondary Education
                </option>
                <option value="Punjab School Education Board" <?php if (
                    $ssc_boardname == "Punjab School Education Board"
                ) {
                    echo "selected";
                } ?>>Punjab
                    School Education Board</option>
                <option value="Rajasthan Board of Secondary Education" <?php if
                ($ssc_boardname == "Rajasthan Board of Secondary Education") {
                    echo "selected";
                } ?>>Rajasthan Board
                    of Secondary Education
                </option>
                <option value="Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh" <?php if
                ($ssc_boardname == "Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh") {
                    echo "selected"
                    ;
                } ?>>
                    Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar
                    Pradesh</option>
                <option value="Tamil Nadu Board of Higher Secondary Education" <?php if
                ($ssc_boardname == "Tamil Nadu Board of Higher Secondary Education") {
                    echo "selected";
                } ?>>Tamil
                    Nadu Board of Higher Secondary
                    Education
                </option>
                <option value="Tamil Nadu Board of Secondary Education" <?php if
                ($ssc_boardname == "Tamil Nadu Board of Secondary Education") {
                    echo "selected";
                } ?>>Tamil Nadu
                    Board of Secondary Education
                </option>
                <option value="Tamilnadu Council for Open and Distance Learning" <?php if
                ($ssc_boardname == "Tamilnadu Council for Open and Distance Learning") {
                    echo "selected";
                } ?>>Tamilnadu Council for Open and
                    Distance
                    Learning
                </option>
                <option value="Telangana State Board of Intermediate Education" <?php if
                ($ssc_boardname == "Telangana State Board of Intermediate Education") {
                    echo "selected";
                } ?>>Telangana State Board of
                    Intermediate
                    Education
                </option>
                <option value="The West Bengal Council of Rabindra Open Schooling" <?php if
                ($ssc_boardname == "The West Bengal Council of Rabindra Open Schooling") {
                    echo "selected";
                } ?>>The
                    West Bengal Council of Rabindra Open
                    Schooling
                </option>
                <option value="Tripura Board of Secondary Education" <?php if
                ($ssc_boardname == "Tripura Board of Secondary Education") {
                    echo "selected";
                } ?>>Tripura Board of
                    Secondary Education
                </option>
                <option value="Uttar Pradesh Board of High School and Intermediate Education" <?php if
                ($ssc_boardname == "Uttar Pradesh Board of High School and Intermediate Education") {
                    echo "selected"
                    ;
                } ?>>Uttar Pradesh Board of High School and
                    Intermediate
                    Education</option>
                <option value="Uttarakhand Board of School Education" <?php if
                ($ssc_boardname == "Uttarakhand Board of School Education") {
                    echo "selected";
                } ?>>
                    Uttarakhand Board of School Education
                </option>
                <option value="H P Board Of School Education" <?php if (
                    $ssc_boardname == "H P Board Of School Education"
                ) {
                    echo "selected";
                } ?>>
                    H P Board Of School Education
                </option>
                <option value="J & K State Board Of School Education" <?php if
                ($ssc_boardname == "J & K State Board Of School Education") {
                    echo "selected";
                } ?>>
                    J & K State Board Of School Education
                </option>
                <option value="West Bengal Board of Secondary Education" <?php if
                ($ssc_boardname == "West Bengal Board of Secondary Education") {
                    echo "selected";
                } ?>>West Bengal
                    Board of Secondary Education
                </option>
                <option value="West Bengal Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "West Bengal Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>West
                    Bengal Council of Higher Secondary
                    Education
                </option>
                <option value="KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION" <?php if
                ($ssc_boardname == "KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION") {
                    echo "selected";
                } ?>>
                    KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION</option>
                <option value="West Bengal State Council of Vocational Education and Training" <?php if
                ($ssc_boardname == "West Bengal State Council of Vocational Education and Training") {
                    echo "selected";
                } ?>>West Bengal State Council of Vocational
                    Education and
                    Training</option>
            </select>

        </div>

        <div class="form-group col-md-6">
            <label for="middle_name">School Name</label><!-- <span class="form_error_message">*</span> -->
            <input name="ssc_schoolname" value="<?php echo $ssc_schoolname; ?>" type="text" maxlength="250"
                id="school_name_input_id" class="form-control" placeholder="Enter School Name" />

        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="last_name">Aggregate Percentage</label>
            <input value="<?php echo $ssc_percentage; ?>" name="ssc_percentage" type="number" maxlength="5"
                id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
        </div>

        <div class="form-group col-md-4">
            <label for="last_name">Passing Month</label><span class="form_error_message">*</span>
            <select name="ssc_passingmonth" id="passmon_input_id" class="form-control select2me">
                <option value=""> MM
                </option>
                <option value="01" <?php if ($ssc_passingmonth == "01") {
                    echo "selected";
                } ?>>01</option>
                <option value="02" <?php if ($ssc_passingmonth == "02") {
                    echo "selected";
                } ?>>02</option>
                <option value="03" <?php if ($ssc_passingmonth == "03") {
                    echo "selected";
                } ?>>03</option>
                <option value="04" <?php if ($ssc_passingmonth == "04") {
                    echo "selected";
                } ?>>04</option>
                <option value="05" <?php if ($ssc_passingmonth == "05") {
                    echo "selected";
                } ?>>05</option>
                <option value="06" <?php if ($ssc_passingmonth == "06") {
                    echo "selected";
                } ?>>06</option>
                <option value="07" <?php if ($ssc_passingmonth == "07") {
                    echo "selected";
                } ?>>07</option>
                <option value="08" <?php if ($ssc_passingmonth == "08") {
                    echo "selected";
                } ?>>08</option>
                <option value="09" <?php if ($ssc_passingmonth == "09") {
                    echo "selected";
                } ?>>09</option>
                <option value="10" <?php if ($ssc_passingmonth == "10") {
                    echo "selected";
                } ?>>10
                </option>
                <option value="11" <?php if ($ssc_passingmonth == "11") {
                    echo "selected";
                } ?>>11
                </option>
                <option value="12" <?php if ($ssc_passingmonth == "12") {
                    echo "selected";
                } ?>>12
                </option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="gender">Passing Year</label><span class="form_error_message">*</span>
           <?php
            $currentYear = date("Y");
            $startYear = 1950;
            ?>
            
            <select name="ssc_passingyear" id="passyear_input_id" class="form-control select2me">
                <option value="">YYYY</option>
                <?php for ($year = $currentYear ; $year >= $startYear; $year--): ?>
                    <option value="<?= $year ?>" <?= ($ssc_passingyear == $year) ? 'selected' : '' ?>> <?= $year ?> </option>
                <?php endfor; ?>
            </select>

        </div>
    </div>
    <?php
    if ($stu_level_id != 5) {
        ?>
                            <div class="row">
                                <p class="heading-p">10+2 / HSC / PUC / 12th</p>
                                <hr>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="mobile_number">Stream</label><span class="form_error_message">*</span>
                                    <select name="hsc_stream" id="stream_input_id" class="form-control select">
                                        <option value="" selected="selected">
                                            Select
                                            Stream
                                        </option>
                                        <option value="Science Stream" <?php if ($hsc_stream == "Science Stream") {
                                            echo "selected";
                                        } ?>>
                                            Science
                                            Stream</option>
                                        <option value="Commerce Stream" <?php if ($hsc_stream == "Commerce Stream") {
                                            echo "selected";
                                        } ?>>
                                            Commerce
                                            Stream
                                        </option>
                                        <option value="Arts Stream" <?php if ($hsc_stream == "Arts Stream") {
                                            echo "selected";
                                        } ?>>Arts
                                            Stream
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Board Name</label><span class="form_error_message">*</span>
                                    <select name="hsc_passingboard" id="board_name_input_id" class="form-control select2me">
                                        <option selected="selected" value="">
                                            Select Board Name
                                        </option>
                                        <option value="Gujarat Board" <?php if ($hsc_passingboard == "Gujarat Board") {
                                            echo "selected";
                                        } ?>>
                                            Gujarat Board
                                        </option>
                                        <option value="CBSE" <?php if ($hsc_passingboard == "CBSE") {
                                            echo "selected";
                                        } ?>>CBSE</option>
                                        <option value="ISCE" <?php if ($hsc_passingboard == "ISCE") {
                                            echo "selected";
                                        } ?>>ISCE
                                        </option>
                                        <option value="NIOS" <?php if ($hsc_passingboard == "NIOS") {
                                            echo "selected";
                                        } ?>>NIOS
                                        </option>
                                        <option value="IB" <?php if ($hsc_passingboard == "IB") {
                                            echo "selected";
                                        } ?>>IB
                                        </option>
                                        <option value="Andhra Pradesh Board of Intermediate Education" <?php if
                                        ($hsc_passingboard == "Andhra Pradesh Board of Intermediate Education") {
                                            echo "selected";
                                        } ?>>Andhra Pradesh Board of
                                            Intermediate
                                            Education
                                        </option>
                                        <option value="Andhra Pradesh Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Andhra Pradesh Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Andhra
                                            Pradesh Board of Secondary Education
                                        </option>
                                        <option value="Assam Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Assam Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>
                                            Assam Board of Secondary Education
                                        </option>
                                        <option value="Bihar Intermediate Education Council" <?php if
                                        ($hsc_passingboard == "Bihar Intermediate Education Council") {
                                            echo "selected";
                                        } ?>>Bihar
                                            Intermediate Education Council
                                        </option>
                                        <option value="Bihar School Examination Board" <?php if
                                        ($hsc_passingboard == "Bihar School Examination Board") {
                                            echo "selected";
                                        } ?>>Bihar
                                            School Examination Board
                                        </option>
                                        <option value="Board of Higher Secondary Education,New Delhi" <?php if
                                        ($hsc_passingboard == "Board of Higher Secondary Education,New Delhi") {
                                            echo "selected";
                                        } ?>>Board
                                            of Higher Secondary Education,New
                                            Delhi
                                        </option>
                                        <option value="Board of School Education, Haryana" <?php if
                                        ($hsc_passingboard == "Board of School Education, Haryana") {
                                            echo "selected";
                                        } ?>>
                                            Board of School Education, Haryana
                                        </option>
                                        <option value="Board of Secondary Education Kant Shahjahanpur Uttar Pradesh" <?php if
                                        ($hsc_passingboard == "Board of Secondary Education Kant Shahjahanpur Uttar Pradesh") {
                                            echo "selected";
                                        } ?>>Board of Secondary Education Kant
                                            Shahjahanpur Uttar
                                            Pradesh</option>
                                        <option value="Board of Secondary Education Madhya Bharat Gwalior" <?php if
                                        ($hsc_passingboard == "Board of Secondary Education Madhya Bharat Gwalior") {
                                            echo "selected";
                                        } ?>>Board of Secondary
                                            Education Madhya Bharat
                                            Gwalior
                                        </option>
                                        <option value="Board of Secondary Education, Madhya Pradesh" <?php if
                                        ($hsc_passingboard == "Board of Secondary Education, Madhya Pradesh") {
                                            echo "selected";
                                        } ?>>Board
                                            of Secondary Education, Madhya Pradesh
                                        </option>
                                        <option value="Board of Secondary Education, Rajasthan" <?php if
                                        ($hsc_passingboard == "Board of Secondary Education, Rajasthan") {
                                            echo "selected";
                                        } ?>>Board of
                                            Secondary Education, Rajasthan </option>
                                        <option value="Board of Youth Education India" <?php if
                                        ($hsc_passingboard == "Board of Youth Education India") {
                                            echo "selected";
                                        } ?>>Board
                                            of Youth Education India</option>
                                        <option value="Central Board Of Education Ajmer New Delhi" <?php if
                                        ($hsc_passingboard == "Central Board Of Education Ajmer New Delhi") {
                                            echo "selected";
                                        } ?>>Central
                                            Board Of Education Ajmer New Delhi
                                        </option>
                                        <option value="Central Board Of Patna, Bihar" <?php if
                                        ($hsc_passingboard == "Central Board Of Patna, Bihar") {
                                            echo "selected";
                                        } ?>>
                                            Central Board Of Patna, Bihar</option>
                                        <option value="Chhattisgarh Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Chhattisgarh Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Chhattisgarh Board of Secondary Education
                                        </option>
                                        <option value="Goa Board of Secondary & Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "Goa Board of Secondary & Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>Goa Board of Secondary &
                                            Higher Secondary
                                            Education
                                        </option>
                                        <option value="GSHSEB" <?php if ($hsc_passingboard == "GSHSEB") {
                                            echo "selected";
                                        } ?>>GSHSEB
                                        </option>
                                        <option value="Himachal Pradesh Board of School Education" <?php if
                                        ($hsc_passingboard == "Himachal Pradesh Board of School Education") {
                                            echo "selected";
                                        } ?>>Himachal
                                            Pradesh Board of School Education
                                        </option>
                                        <option value="Institution of Secondary Distance Education" <?php if
                                        ($hsc_passingboard == "Institution of Secondary Distance Education") {
                                            echo "selected";
                                        } ?>>Institution of Secondary Distance Education
                                        </option>
                                        <option value="J&K State Board of School Education" <?php if
                                        ($hsc_passingboard == "J&K State Board of School Education") {
                                            echo "selected";
                                        } ?>>
                                            J&K State Board of School Education
                                        </option>
                                        <option value="Jharkhand Academic Council" <?php if ($hsc_passingboard == "Jharkhand Academic Council") {
                                            echo "selected";
                                        } ?>>Jharkhand
                                            Academic Council</option>
                                        <option value="KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION" <?php if
                                        ($hsc_passingboard == "KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION") {
                                            echo "selected";
                                        } ?>>
                                            KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION</option>
                                        <option value="Karnataka Board of the Pre-University Education" <?php if
                                        ($hsc_passingboard == "Karnataka Board of the Pre-University Education") {
                                            echo "selected";
                                        } ?>>Karnataka Board of the
                                            Pre-University
                                            Education
                                        </option>
                                        <option value="Karnataka Secondary Education Examination Board" <?php if
                                        ($hsc_passingboard == "Karnataka Secondary Education Examination Board") {
                                            echo "selected";
                                        } ?>>Karnataka Secondary Education
                                            Examination
                                            Board
                                        </option>
                                        <option value="Kerala Board of Public Examinations" <?php if
                                        ($hsc_passingboard == "Kerala Board of Public Examinations") {
                                            echo "selected";
                                        } ?>>
                                            Kerala Board of Public Examinations
                                        </option>
                                        <option value="Madhya Pradesh State Open School Education Board" <?php if
                                        ($hsc_passingboard == "Madhya Pradesh State Open School Education Board") {
                                            echo "selected";
                                        } ?>>Madhya Pradesh State Open
                                            School Education
                                            Board
                                        </option>
                                        <option value="Maharashtra State Board of Secondary and Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "Maharashtra State Board of Secondary and Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>Maharashtra State Board of Secondary and
                                            Higher
                                            Secondary Education
                                        </option>
                                        <option value="Manipur Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Manipur Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Manipur Board
                                            of Secondary Education
                                        </option>
                                        <option value="Manipur Council of Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "Manipur Council of Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>Manipur Council of Higher
                                            Secondary
                                            Education
                                        </option>
                                        <option value="Meghalaya Board of School Education" <?php if
                                        ($hsc_passingboard == "Meghalaya Board of School Education") {
                                            echo "selected";
                                        } ?>>
                                            Meghalaya Board of School Education
                                        </option>
                                        <option value="Mizoram Board of School Education" <?php if
                                        ($hsc_passingboard == "Mizoram Board of School Education") {
                                            echo "selected";
                                        } ?>>
                                            Mizoram Board of School Education
                                        </option>
                                        <option value="Nagaland Board of School Education" <?php if
                                        ($hsc_passingboard == "Nagaland Board of School Education") {
                                            echo "selected";
                                        } ?>>
                                            Nagaland Board of School Education
                                        </option>
                                        <option value="Northwest Accreditation Commission & [NWAC]" <?php if
                                        ($hsc_passingboard == "Northwest Accreditation Commission & [NWAC]") {
                                            echo "selected";
                                        } ?>>Northwest Accreditation Commission &
                                            [NWAC]
                                        </option>
                                        <option value="Orissa Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Orissa Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>
                                            Orissa Board of Secondary Education
                                        </option>
                                        <option value="Orissa Council of Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "Orissa Council of Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>Orissa
                                            Council of Higher Secondary Education
                                        </option>
                                        <option value="Punjab School Education Board" <?php if
                                        ($hsc_passingboard == "Punjab School Education Board") {
                                            echo "selected";
                                        } ?>>Punjab
                                            School Education Board</option>
                                        <option value="Rajasthan Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Rajasthan Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Rajasthan
                                            Board of Secondary Education
                                        </option>
                                        <option value="Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh" <?php if
                                        ($hsc_passingboard == "Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh") {
                                            echo "selected";
                                        } ?>>
                                            Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar
                                            Pradesh</option>
                                        <option value="Tamil Nadu Board of Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "Tamil Nadu Board of Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>Tamil Nadu Board of Higher Secondary
                                            Education
                                        </option>
                                        <option value="Tamil Nadu Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Tamil Nadu Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Tamil Nadu
                                            Board of Secondary Education
                                        </option>
                                        <option value="Tamilnadu Council for Open and Distance Learning" <?php if
                                        ($hsc_passingboard == "Tamilnadu Council for Open and Distance Learning") {
                                            echo "selected";
                                        } ?>>Tamilnadu Council for Open and
                                            Distance
                                            Learning
                                        </option>
                                        <option value="Telangana State Board of Intermediate Education" <?php if
                                        ($hsc_passingboard == "Telangana State Board of Intermediate Education") {
                                            echo "selected";
                                        } ?>>Telangana State Board of
                                            Intermediate
                                            Education
                                        </option>
                                        <option value="The West Bengal Council of Rabindra Open Schooling" <?php if
                                        ($hsc_passingboard == "The West Bengal Council of Rabindra Open Schooling") {
                                            echo "selected";
                                        } ?>>The West Bengal Council
                                            of Rabindra Open
                                            Schooling
                                        </option>
                                        <option value="Tripura Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "Tripura Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>Tripura Board
                                            of Secondary Education
                                        </option>
                                        <option value="Uttar Pradesh Board of High School and Intermediate Education" <?php if
                                        ($hsc_passingboard == "Uttar Pradesh Board of High School and Intermediate Education") {
                                            echo "selected";
                                        } ?>>Uttar Pradesh Board of High School and
                                            Intermediate
                                            Education</option>
                                        <option value="Uttarakhand Board of School Education" <?php if
                                        ($hsc_passingboard == "Uttarakhand Board of School Education") {
                                            echo "selected";
                                        } ?>>
                                            Uttarakhand Board of School Education
                                        </option>
                                        <option value="H P Board Of School Education" <?php if
                                        ($hsc_passingboard == "H P Board Of School Education") {
                                            echo "selected";
                                        } ?>>
                                            H P Board Of School Education
                                        </option>
                                        <option value="J & K State Board Of School Education" <?php if
                                        ($hsc_passingboard == "J & K State Board Of School Education") {
                                            echo "selected";
                                        } ?>>
                                            J & K State Board Of School Education
                                        </option>
                                        <option value="West Bengal Board of Secondary Education" <?php if
                                        ($hsc_passingboard == "West Bengal Board of Secondary Education") {
                                            echo "selected";
                                        } ?>>West
                                            Bengal Board of Secondary Education
                                        </option>
                                        <option value="West Bengal Council of Higher Secondary Education" <?php if
                                        ($hsc_passingboard == "West Bengal Council of Higher Secondary Education") {
                                            echo "selected";
                                        } ?>>West Bengal Council of
                                            Higher Secondary
                                            Education
                                        </option>
                                        <option value="West Bengal State Council of Vocational Education and Training" <?php if
                                        ($hsc_passingboard == "West Bengal State Council of Vocational Education and Training") {
                                            echo "selected";
                                        } ?>>West Bengal State Council of Vocational
                                            Education and
                                            Training</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="dob">Seat Number</label><span class="form_error_message">*</span>
                                    <input value="<?php echo $hsc_boardseatnumber; ?>" name="hsc_boardseatnumber" type="number" maxlength="15"
                                        id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="blood_group">Passing Status</label><span class="form_error_message">*</span>
                                    <select name="hsc_passingstatus" id="status_input_id" class="form-control select">
                                        <option selected="selected" value="">
                                            Select Status
                                        </option>
                                        <option value="Pass" <?php if ($hsc_passingstatus == "Pass") {
                                            echo "selected";
                                        } ?>>
                                            Pass </option>
                                        <option value="Pursuing" <?php if ($hsc_passingstatus == "Pursuing") {
                                            echo "selected";
                                        } ?>>
                                            Pursuing </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="religion">School Name</label>
                                    <input value="<?php echo $hsc_schoolname; ?>" name="hsc_schoolname" type="text" maxlength="250"
                                        id="school_name_input_id" class="form-control" placeholder="Enter School Name" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="caste">Aggregate Percentage</label>
                                    <input value="<?php echo $hsc_percentage; ?>" name="hsc_percentage" type="number" maxlength="5"
                                        id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
                                </div>

                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="adhar">Passing Month</label><span class="form_error_message">*</span>
                                    <select name="hsc_passingmonth" id="passmon_input_id" class="form-control select2me">
                                        <option value=""> MM
                                        </option>
                                        <option value="01" <?php if ($hsc_passingmonth == "01") {
                                            echo "selected";
                                        } ?>>01</option>
                                        <option value="02" <?php if ($hsc_passingmonth == "02") {
                                            echo "selected";
                                        } ?>>02</option>
                                        <option value="03" <?php if ($hsc_passingmonth == "03") {
                                            echo "selected";
                                        } ?>>03</option>
                                        <option value="04" <?php if ($hsc_passingmonth == "04") {
                                            echo "selected";
                                        } ?>>04</option>
                                        <option value="05" <?php if ($hsc_passingmonth == "05") {
                                            echo "selected";
                                        } ?>>05</option>
                                        <option value="06" <?php if ($hsc_passingmonth == "06") {
                                            echo "selected";
                                        } ?>>06</option>
                                        <option value="07" <?php if ($hsc_passingmonth == "07") {
                                            echo "selected";
                                        } ?>>07</option>
                                        <option value="08" <?php if ($hsc_passingmonth == "08") {
                                            echo "selected";
                                        } ?>>08</option>
                                        <option value="09" <?php if ($hsc_passingmonth == "09") {
                                            echo "selected";
                                        } ?>>09</option>
                                        <option value="10" <?php if ($hsc_passingmonth == "10") {
                                            echo "selected";
                                        } ?>>10
                                        </option>
                                        <option value="11" <?php if ($hsc_passingmonth == "11") {
                                            echo "selected";
                                        } ?>>11
                                        </option>
                                        <option value="12" <?php if ($hsc_passingmonth == "12") {
                                            echo "selected";
                                        } ?>>12
                                        </option>
                                    </select>
                                </div>
                              <div class="form-group col-md-6">
                                <label for="adhar">Passing Year</label><span class="form_error_message">*</span>
                                <select name="hsc_passingyear" id="passyear_input_id" class="form-control select2me">
                                    <option value="">YYYY</option>
                                    <?php
                                        $currentYear = date("Y");
                                        $startYear = 1950;
                                        for ($year = $currentYear; $year >= $startYear; $year--) {
                                            $selected = ($hsc_passingyear == $year) ? "selected" : "";
                                            echo "<option value=\"$year\" $selected>$year</option>";
                                        }
                                    ?>
                                </select>
                            </div>


                            </div>

                            <?php
    }
    if ($stu_faculty_id == 1 || $stu_faculty_id == 15 || $stu_faculty_id == 2) {
        if ($stu_level_id != 5) {
            ?>

                                                    <div class="row">
                                                        <div class="row">
                                                            <p class="heading-p">Competitive Exam Details</p>
                                                            <hr>
                                                        </div>
                                                        <script>
                                                        function gujcet_appearCheck() {
                                                            if (document.getElementById('gujcet_appear_yes').checked) {
                                                                document.getElementById('ifgujcetyes').style.display = 'block';
                                                            } else {
                                                                document.getElementById('ifgujcetyes').style.display = 'none';
                                                            }
                                                        }
                                                        </script>
                                                        <div class="form-group col-md-4">
                                                            <label for="father">GUJCET Appearance</label><span class="form_error_message">*</span><br>
                                                            <input onclick="javascript:gujcet_appearCheck();" value="Yes" <?php if ($gujcet_appear == "Yes") {
                                                                echo "checked";
                                                            } ?> name="gujcet_appear" id="gujcet_appear_yes" type="radio">
                                                            Yes
                                                            <input onclick="javascript:gujcet_appearCheck();" value="No" <?php if ($gujcet_appear == "No") {
                                                                echo "checked";
                                                            } ?> name="gujcet_appear" id="gujcet_appear_no" type="radio">
                                                            No
                                                        </div>
                                                        <div id="ifgujcetyes" style="display:none;">
                                                            <div class="form-group col-md-4">
                                                                <label for="father">Seat Number</label>
                                                                <input value="<?php echo $gujcet_seatnumber; ?>" name="gujcet_seatnumber" type="text" maxlength="25"
                                                                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label for="mother">Application Number</label>
                                                                <input value="<?php echo $gujcet_applicationnumber; ?>" name="gujcet_applicationnumber" type="text"
                                                                    maxlength="25" id="application_number_input_id" class="form-control"
                                                                    placeholder="Enter Application Number" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <script>
                                                        function neet_appearCheck() {
                                                            if (document.getElementById('neet_appear_yes').checked) {
                                                                document.getElementById('ifneetyes').style.display = 'block';
                                                            } else {
                                                                document.getElementById('ifneetyes').style.display = 'none';
                                                            }
                                                        }
                                                        </script>
                                                        <div class="form-group col-md-4">
                                                            <label for="father_occupation">NEET Appearance</label><span class="form_error_message">*</span><br>
                                                            <input onclick="javascript:neet_appearCheck();" value="Yes" <?php if ($neet_appear == "Yes") {
                                                                echo "checked"
                                                                ;
                                                            } ?> name="neet_appear" id="neet_appear_yes" type="radio">
                                                            Yes
                                                            <input onclick="javascript:neet_appearCheck();" value="No" <?php if ($neet_appear == "No") {
                                                                echo "checked";
                                                            } ?> name="neet_appear" id="neet_appear_no" type="radio">
                                                            No
                                                        </div>

                                                        <div id="ifneetyes" style="display:none;">

                                                            <div class="form-group col-md-4">
                                                                <label for="father_occupation">Seat Number</label>
                                                                <input value="<?php echo $neet_seatnumber; ?>" name="neet_seatnumber" type="text" maxlength="25"
                                                                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label for="mother_occupation">Application Number</label>
                                                                <input value="<?php echo $neet_applicationnumber; ?>" name="neet_applicationnumber" type="text"
                                                                    maxlength="25" id="application_number_input_id" class="form-control"
                                                                    placeholder="Enter Application Number" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <script>
                                                        function jee_appearCheck() {
                                                            if (document.getElementById('jee_appear_yes').checked) {
                                                                document.getElementById('ifjeeyes').style.display = 'block';
                                                            } else {
                                                                document.getElementById('ifjeeyes').style.display = 'none';
                                                            }
                                                        }
                                                        </script>
                                                        <div class="form-group col-md-4">
                                                            <label for="parents_number">JEE Appearance</label><span class="form_error_message">*</span><br>
                                                            <input onclick="javascript:jee_appearCheck();" value="Yes" <?php if ($jee_appear == "Yes") {
                                                                echo "checked";
                                                            } ?> name="jee_appear" id="jee_appear_yes" type="radio">
                                                            Yes
                                                            <input onclick="javascript:jee_appearCheck();" value="No" <?php if ($jee_appear == "No") {
                                                                echo "checked";
                                                            }
                                                            ?> name="jee_appear" id="jee_appear_no" type="radio"> No
                                                        </div>
                                                        <div id="ifjeeyes" style="display:none;">
                                                            <div class="form-group col-md-4">
                                                                <label for="parents_number">Seat Number</label>
                                                                <input value="<?php echo $jee_seatnumber; ?>" name="jee_seatnumber" type="text" maxlength="25"
                                                                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
                                                            </div>

                                                            <div class="form-group col-md-4">
                                                                <label for="parents_email">Application Number</label>
                                                                <input value="<?php echo $jee_applicationnumber; ?>" name="jee_applicationnumber" type="text"
                                                                    maxlength="25" id="application_number_input_id" class="form-control"
                                                                    placeholder="Enter Application Number" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <?php
        }
    }
    ?>
    <?php
    if ($stu_level_id == 2 || $stu_level_id == 4) {
        ?>


                            <div class="row">
                                <div class="row">
                                    <p class="heading-p">Graduation Details</p>
                                    <hr>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="address">Graduation Course</label><span class="form_error_message">*</span>
                                    <input value="<?php echo $graduation_course; ?>" name="graduation_course" type="text" maxlength="250"
                                        id="course_input_id" class="form-control" placeholder="Enter Graduation Course" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="pincode">University</label><!-- <span class="form_error_message">*</span> -->
                                    <input value="<?php echo $graduation_university; ?>" name="graduation_university" type="text" maxlength="250"
                                        id="seat_number_input_id" class="form-control" placeholder="Select University Name" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="pincode">College Name</label><span class="form_error_message">*</span>
                                    <input value="<?php echo $graduation_college_name; ?>" name="graduation_college_name" type="text" maxlength="250"
                                     id="college_name_input_id" class="form-control" placeholder="Enter College Name" />
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="religion">Result/Percentage/CPI</label>
                                    <input value="<?php echo $graduation_cpi; ?>" name="graduation_cpi" type="number" maxlength="5"
                                        id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="caste">Passing Status</label><span class="form_error_message">*</span>
                                    <select name="graduation_passing_status" id="status_input_id" class="form-control select">
                                        <option selected="selected" value="">
                                            Select Status
                                        </option>
                                        <option value="Pass" <?php if ($graduation_passing_status == "Pass") {
                                            echo "selected";
                                        } ?>>
                                            Pass </option>
                                        <option value="Pursuing" <?php if ($graduation_passing_status == "Pursuing") {
                                            echo "selected";
                                        } ?>>
                                            Pursuing </option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="permanent_address">Passing Month</label><span class="form_error_message">*</span>

                                    <select name="graduation_passing_month" id="passmon_input_id" class="form-control select2me">
                                        <option value=""> MM
                                        </option>
                                        <option value="01" <?php if ($graduation_passing_month == "01") {
                                            echo "selected";
                                        } ?>>01</option>
                                        <option value="02" <?php if ($graduation_passing_month == "02") {
                                            echo "selected";
                                        } ?>>02</option>
                                        <option value="03" <?php if ($graduation_passing_month == "03") {
                                            echo "selected";
                                        } ?>>03</option>
                                        <option value="04" <?php if ($graduation_passing_month == "04") {
                                            echo "selected";
                                        } ?>>04</option>
                                        <option value="05" <?php if ($graduation_passing_month == "05") {
                                            echo "selected";
                                        } ?>>05</option>
                                        <option value="06" <?php if ($graduation_passing_month == "06") {
                                            echo "selected";
                                        } ?>>06</option>
                                        <option value="07" <?php if ($graduation_passing_month == "07") {
                                            echo "selected";
                                        } ?>>07</option>
                                        <option value="08" <?php if ($graduation_passing_month == "08") {
                                            echo "selected";
                                        } ?>>08</option>
                                        <option value="09" <?php if ($graduation_passing_month == "09") {
                                            echo "selected";
                                        } ?>>09</option>
                                        <option value="10" <?php if ($graduation_passing_month == "10") {
                                            echo "selected";
                                        } ?>>10
                                        </option>
                                        <option value="11" <?php if ($graduation_passing_month == "11") {
                                            echo "selected";
                                        } ?>>11
                                        </option>
                                        <option value="12" <?php if ($graduation_passing_month == "12") {
                                            echo "selected";
                                        } ?>>12
                                        </option>
                                    </select>
                                </div>
                               <div class="form-group col-md-6">
                                    <label for="permanent_pincode">Passing Year</label>
                                    <span class="form_error_message">*</span>
                                    <select name="graduation_passing_year" id="passyear_input_id" class="form-control select2me">
                                        <option value="" disabled <?= empty($graduation_passing_year) ? 'selected' : '' ?>>YYYY</option>
                                        <?php
                                        for ($year = date("Y"); $year >= 1950; $year--) {
                                            $selected = ($graduation_passing_year == $year) ? 'selected' : '';
                                            echo "<option value=\"$year\" $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="permanent_address">GMCET Score</label>
                                    <input value="<?php echo $gmcet_score; ?>" name="gmcet_score" type="text" maxlength="5"
                                        id="percentage_input_id" class="form-control" placeholder="Enter Score" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="permanent_pincode">CMAT Score</label>
                                    <input value="<?php echo $cmat_score; ?>" name="cmat_score" type="text" maxlength="5"
                                        id="percentage_input_id" class="form-control" placeholder="Enter Score" />
                                </div>

                            </div>
                            <?php
    }
    ?>

</form>