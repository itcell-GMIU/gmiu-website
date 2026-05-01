<form id="payment_detail" method="POST">
    <table class="table table-bordered">
        <thead>
            <tr>

                <td colspan="2" class="dp"><b>Please Verify and Pay Token Fee</b>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>

                <td class="center"><b>Name</b></td>
                <td> <input type="text"
                        value="<?php echo $stu_first_name . " " . $stu_middle_name . " " . $stu_last_name ?>"
                        class="form-control inp" name="last_name" disabled></td>

            </tr>

            <tr class="dp">

                <td class="center"><b>Faculty<span class="form_error_message">*</span></b></b>
                </td>
                <td><select class="form-control tp" id="faculty_id" name="faculty_id" <?php if ($payment_status == "success" || $account_office_status=="submitted") {
                    echo "disabled";
                } ?> required>

                        <?php
                        $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                        $result = $con->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if ($row['id'] == $stu_faculty_id) {
                                    echo '<option selected value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                } else {
                                    echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>

                </td>

            </tr>
            <tr class="dp">

                <td class="center"><b>Level<span class="form_error_message">*</span></b></td>
                <td><select class="form-control tp" id="level_id" name="level_id" <?php if ($payment_status == "success" || $account_office_status=="submitted") {
                    echo "disabled";
                } ?>>
                        <option value="">--Please select--</option>

                    </select></span></td>

            </tr>
            <tr class="dp">

                <td class="center"><b>Program<span class="form_error_message">*</span></b></td>
                <td>
                    <select class="form-control tp" id="program_id" name="program_id" <?php if ($payment_status == "success" || $account_office_status=="submitted") {
                        echo "disabled";
                    } ?>>
                        <option value="">--Please select--</option>
                    </select>

                </td>

            </tr>
            <tr class="dp">

                <td class="center"><b>Mode</b></td>
                <td><select id="admission_mode" name="mode" class="form-control tp" <?php if ($payment_status == "success" || $account_office_status=="submitted") {
                    echo "disabled";
                } ?>>
                        <option id="regular_option" value="regular" <?php if ($mode == "regular") {
                            echo "selected";
                        } ?>>Regular
                        </option>
                        <option id="genius_option" value="genius" <?php if ($mode == "genius") {
                            echo "selected";
                        } ?>>Genius
                        </option>
                        <option id="minor_option" value="minor" <?php if ($mode == "minor") {
                            echo "selected";
                        } ?>>Minor
                        </option>
                    </select></td>
            </tr>
             <tr class="dp">
                <td class="center"><b>Method</b></td>
                <td><select id="admission_method" name="method" class="form-control tp" <?php if ($payment_status == "success" || $account_office_status == "submitted") {
                    echo "disabled";
                } ?>>
                        <option id="reg" value="reg" <?php if ($method == "reg") {
                            echo "selected";
                        } ?>>Regular
                        </option>
                        <option id="plm" value="plm" <?php if ($method == "plm") {
                            echo "selected";
                        } ?>>PLM
                        </option>
                    </select></td>
            </tr>
            <tr class="dp">
                <td class="center"><b>Payment Mode</b></td>
                <td><select name="payment_mode" id="payment_mode" class="form-control tp payment_mode" <?php if ($payment_status == "success" || $account_office_status=="submitted") {
                    echo "disabled";
                } ?>>
                        <option value="online" <?php if ($payment_mode == "online") {
                            echo "selected";
                        } ?>>Online
                        </option>
                        <option value="offline" <?php if ($payment_mode == "offline") {
                            echo "selected";
                        } ?>>Offline
                        </option>
                    </select></td>
            </tr>

            <tr>
                <!-- <th scope="row">2</th> -->
                <td class="center"><b>Token Amount</b></td>
                <td> <input type="text" class="form-control inp" name="token_mount" id="token_amount" disabled>
                </td>
            </tr>
             <?php
            // Case: Payment success (online or offline approved)
            if ($payment_status == "success" || $account_office_status == "approved" || $account_office_status == "submitted") {
                // Map Person Who Assisted Admission values to labels
                $feedback_labels = [
                    "social_media" => "Social media (WhatsApp, API, Instagram, FB, Telegram, Twitter, LinkedIn)",
                    "voice" => "Voice broadcasting (tune call)",
                    "counselor" => "Counselor",
                    "faculty" => "Faculty",
                    "student" => "Student",
                    "school_teacher" => "School Teacher/coaching teacher/support center",
                    "fm" => "FM/hoardings/newspaper advertisement/leaflet",
                    "acpc" => "ACPC/ACPDC site",
                    "own" => "Own",
                    "other" => "Other"
                ];

                // Map admission year values to labels
                $admission_year_labels = [
                    "2025-26_july" => "2025-26 (REGULAR)",
                    "2026-27_jan" => "2026-27 (BIANNUAL)",
                    "2026-27_july" => "2026-27 (REGULAR)"
                ];
            ?>
                <tr>
                    <td class="center"><b>Person Who Assisted Admission</b></td>
                    <td><?php echo !empty($feedback_source) ? $feedback_labels[$feedback_source] : "-"; ?></td>
                </tr>
                <tr>
                    <td class="center"><b>Referral Code</b></td>
                    <td><?php echo !empty($referral_code) ? $referral_code : "-"; ?></td>
                </tr>
                <tr>
                    <td class="center"><b>Admission Year</b></td>
                    <td><?php echo !empty($admission_year) ? $admission_year_labels[$admission_year] : "-"; ?></td>
                </tr>

            <?php
            }
            // Case: Payment not yet done
            else {
            ?>
                <!-- Show form fields for feedback/referral/admission year -->
                <tr>
                    <td class="center"><b>Person Who Assisted Admission<span class="form_error_message">*</span></b></td>
                    <td>
                        <select class="form-control tp" id="feedback_source" name="feedback_source" required>
                            <option value="">--Please select--</option>
                            <option value="social_media">Social media (WhatsApp, API, Instagram, FB, Telegram, Twitter, LinkedIn)</option>
                            <option value="voice">Voice broadcasting (tune call)</option>
                            <option value="counselor">Counselor</option>
                            <option value="faculty">Faculty</option>
                            <option value="student">Student</option>
                            <option value="school_teacher">School Teacher/coaching teacher/support center</option>
                            <option value="fm">FM/hoardings/newspaper advertisement/leaflet</option>
                            <option value="acpc">ACPC/ACPDC site</option>
                            <option value="own">Own</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                </tr>

                <!-- Referral Code (hidden by default) -->
                <tr id="referral_code_row" style="display:none;">
                    <td class="center"><b>Referral Code</b></td>
                    <td>
                        <input type="text" class="form-control inp" name="referral_code" id="referral_code"
                        pattern="[A-Z0-9]{7}" title="Referral code must be 7 characters, containing only uppercase letters and numbers" required>
                    </td>
                </tr>

                 <!--OTP (only if School Teacher selected) -->
                <tr id="otp_row" style="display:none;">
                    <td class="center"><b>Enter OTP</b></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control inp" name="referral_otp" id="referral_otp" disabled>
                            <button type="button" class="btn btn-primary" id="send_otp_btn">Send OTP</button>
                            <button type="button" class="btn btn-success" id="verify_otp_btn" disabled>Verify OTP</button>
                        </div>
                        <small id="otp_status" style="color:green;"></small>
                    </td>
                </tr>

                <tr>
                    <td class="center"><b>Admission Year<span class="form_error_message">*</span></b></td>
                    <td>
                        <select class="form-control tp" id="admission_year" name="admission_year" required>
                            <option value="">--Please select--</option>
                            <option value="2025-26_july" <?php if ($admission_year == "2025-26_july") echo "selected"; ?>>2025-26 (REGULAR)</option>
                            <option value="2026-27_jan" <?php if ($admission_year == "2026-27_jan") echo "selected"; ?>>2026-27 (BIANNUAL)</option>
                            <option value="2026-27_july" <?php if ($admission_year == "2026-27_july") echo "selected"; ?>>2026-27 (REGULAR)</option>
                        </select>
                    </td>
                </tr>
            <?php
            }
            ?>
            <?php if ($payment_status == "success") {
                $confirm = 1; // The value you want to set for is_admission_confirm (1 for confirm).
                 // Prepare the SQL statement for updating the is_admission_confirm column.
                 $stmt2 = $con->prepare("UPDATE tbl_inquiry_student SET is_admission_confirm = ?  WHERE admission_student_id = $student_id ");
                 
                 // Bind the values to the prepared statement.
                 $stmt2->bind_param("i", $confirm);
                 
                 // Execute the UPDATE statement.
                 $result = $stmt2->execute();
                ?>
            <tr>
                <th scope="row">Payment Status</th>
                <td class="center">
                    <?php if($payment_status=="success")
                    {
                        ?>
                    <span style="background-color:green" class="badge badge-success">
                        <?php echo $payment_status; ?>
                    </span>
                    <?php  }
                    else
                    {?>
                    <span style="background-color:red" class="badge badge-success">
                        <?php echo $payment_status; ?>
                    </span>
                    <?php  } ?>

                </td>
            </tr>
            <tr>
                <th scope="row">Payment Receipt</th>
                <td class="center"><a href="receipt.php" target="_blank">View Receipt</a></td>
            </tr>

            <?php } else if($account_office_status!="approved" &&$account_office_status!="rejected" && $payment_mode=="offline")
                {
                    ?>
            <th scope="row">Account Office Status</th>
            <td class="center">

                <span style="background-color:green" class="badge badge-success">
                    <?php echo $account_office_status; ?>
                </span>
                <br>
                <br>
                <b> Note:You need to pay fees at college fees
                    department than after approval you will be
                    able
                    to
                    process further.</b>


            </td>
            <?php  }
                else{
                ?>

            <tr class="offline_mode_tr" style="display: none;">
                <td scope="row"></td>
                <td class="center">
                    <li>You need to pay fees at college fees
                        department than after approval you will be
                        able
                        to
                        process further.</li> <br> <button id="offline-submit-btn">Submit Request For Offline
                        Payment Mode</button>
                </td>
            </tr>
            <tr class="online_mode_tr">
                <td scope="row"></td>
                      <td class="center"><button id="ebz-checkout-btn" type="submit" data-form_name="payment_detail">Pay
                        Now</button>
                      </td>
                   
            </tr>
            <?php } ?>
              <tr id="semester_fee_container" style="display: none;">
                        <td colspan="2">
                            <h5><b>Semester-wise Fees
                            <?php  if($stu_faculty_id == '27'){ ?>
                            <span class="form_error_message">*25% Scholarship Applicable </span>
                            <?php } ?>
                            </b></h5>
                            <div id="semester_fees"></div>
                        </td>
            </tr>
           <?php
            $query = "SELECT id, document FROM tbl_gmiu_doc";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $document = $row ['document'];
                }
            }
            ?>
            <tr>
                <!-- <th scope="row">2</th> -->
                <td class="center"><b>Note*</b></td>
                <td>
                    <!--<b>For details of course list and fees structure <a target="_BLANK" href="<?php //echo $upload_website_admin_url .'/fee_structure/document/' . $document; ?>">click here</a></b>-->
                    <p>
                    <ul>
                        <li>Admission will be confirmed
                            subject to approval by admission committee/university.</li>
                        <li>If at any
                            stage of the admissions process, it is found that applicant
                            does
                            not meet the eligibility criteria or that the information
                            furnished by him/her is incorrect, then such applications
                            will
                            be eliminated from admission process and fees paid will be
                            forfeited or refund as per policy.</li>
                        <li>Applicants submitting the
                            application form of any program/course to University are
                            assumed
                            to have read the rules and policies related to eligibility,
                            provisional admission, cancellation of admission and refund
                            of
                            fees and disclaimers mentioned above and agree to the same,
                            as
                            mentioned in the website.</li>
                        <br>
                        <p>
                        <h5><b>Note For Payment:</b></h5>
                        </p>
                        <li>
                            <h5><b>Online Mode: If any transaction is failed and amount is debited from account wait for
                                    24
                                    hours to generate the receipt.</b></h5>
                        </li>
                        <li>
                            <h5><b>Offline Mode: Once Account office will approve the payment receipt will be
                                    generated.And
                                    than after you can proceed with next steps.
                                </b></h5>
                        </li>
                        <li>
                            <h5>
                              <b>
                                For any payment related issue contact 
                                <a href="tel:8799144658">8799144658</a> 
                                OR 
                                <a href="mailto:accounts@gmiu.edu.in">accounts@gmiu.edu.in</a>
                              </b>
                            </h5>

                        </li>
                       
                    </ul>
                    </p>

                </td>
            </tr>

        </tbody>
    </table>

</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const feedback = document.getElementById("feedback_source");
        const referralRow = document.getElementById("referral_code_row");
        const otpRow = document.getElementById("otp_row");
        const referralInput = document.getElementById("referral_code");
        const otpInput = document.getElementById("referral_otp");
        const sendOtpBtn = document.getElementById("send_otp_btn");
        const verifyOtpBtn = document.getElementById("verify_otp_btn");
        const otpStatus = document.getElementById("otp_status");
        const payNowBtn = document.getElementById("ebz-checkout-btn"); // your Pay Now button

        feedback.addEventListener("change", function() {
            const val = this.value;

            referralRow.style.display = "none";
            otpRow.style.display = "none";
            referralInput.required = false;
            otpInput.required = false;
            otpInput.disabled = true;
            verifyOtpBtn.disabled = true;

            payNowBtn.disabled = false; // default (only disabled if OTP required)

            if (val === "counselor" || val === "faculty" || val === "school_teacher") {
                referralRow.style.display = "table-row";
                // referralInput.required = true;
                 // comment out if counselor referalcode is required
            }

            if (val === "school_teacher") {
                otpRow.style.display = "table-row";
                // otpInput.required = true;
                // payNowBtn.disabled = true; // must verify OTP before paying
                otpInput.disabled = referralInput.value.trim() === ""; // enable only if referral entered
                verifyOtpBtn.disabled = referralInput.value.trim() === "";
            }
        });
        // Run once on page load to set correct visibility
        const event = new Event("change");
        feedback.dispatchEvent(event);
        // Send OTP via AJAX
        sendOtpBtn.addEventListener("click", function() {
            let referralCode = referralInput.value.trim();
            if (!referralCode) {
                alert("Enter referral code first.");
                return;
            }

            fetch("send_otp.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "referral_code=" + encodeURIComponent(referralCode)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        otpStatus.innerText = data.message;
                        otpStatus.style.color = "green";
                        otpInput.disabled = false;
                        verifyOtpBtn.disabled = false;
                    } else {
                        otpStatus.innerText = data.message;
                        otpStatus.style.color = "red";
                    }
                })
                .catch(err => {
                    otpStatus.innerText = "Error sending OTP.";
                    otpStatus.style.color = "red";
                });
        });

        // Verify OTP
        verifyOtpBtn.addEventListener("click", function() {
            let enteredOtp = otpInput.value.trim();
            if (!enteredOtp) {
                alert("Enter OTP first.");
                return;
            }

            fetch("verify_otp.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "otp=" + encodeURIComponent(enteredOtp)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        otpStatus.innerText = "OTP verified successfully!";
                        otpStatus.style.color = "green";
                        payNowBtn.disabled = false; // enable pay now
                    } else {
                        otpStatus.innerText = "Invalid OTP.";
                        otpStatus.style.color = "red";
                        payNowBtn.disabled = true;
                    }
                })
                .catch(err => {
                    otpStatus.innerText = "Error verifying OTP.";
                    otpStatus.style.color = "red";
                });
        });
    });
</script>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const code = document.getElementById('referral_code').value.trim();
    const regex = /^[A-Z0-9]{7}$/;

    // Only validate if user entered something
    if (code !== "" && !regex.test(code)) {
        alert(
            'Referral code must be 7 characters long, containing only uppercase letters and numbers (e.g., 26TF001).'
        );
        e.preventDefault(); // Prevent form submission
    }
});
</script>