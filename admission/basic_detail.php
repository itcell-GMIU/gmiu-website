<form id="basic_detail" method="POST">
    <div class="row">
        <p class="heading-p">Student Details</p>
        <hr>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="first_name">First Name</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="first_name" id="first_name"
                value="<?php echo $stu_first_name; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="middle_name">Middle Name</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="middle_name" id="middle_name"
                value="<?php echo $stu_middle_name; ?>">
        </div>
    </div>
    <div class="row">
        <!--    <hr> -->
        <div class="form-group col-md-6">
            <label for="last_name">Last Name</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="last_name" id="last_name"
                value="<?php echo $stu_last_name; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="gender">Gender</label><span class="form_error_message">*</span>
            <select class="form-control" name="gender" id="gender">
                <option value="">--Please Select Gender--</option>
                <option value="male" <?php if ($gender == "male") {
                    echo "selected";
                } ?>>Male</option>
                <option value="female" <?php if ($gender == "female") {
                    echo "selected";
                } ?>>Female</option>
                <option value="other" <?php if ($gender == "other") {
                    echo "selected";
                } ?>>Others</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="mobile_number">Mobile Number</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                value="<?php echo $stu_number; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label><span class="form_error_message">*</span>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $stu_email; ?>">
        </div>
    </div>
    <div class="row">
        <!--      <hr> -->
        <div class="form-group col-md-6">
            <label for="dob">Date Of Birth</label><span class="form_error_message">*</span>
            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $dob; ?>" placeholder="">
        </div>

        <div class="form-group col-md-6">
            <label for="blood_group">Blood Group</label><span class="form_error_message">*</span>
            <select class="form-control" name="blood_group" id="blood_group">
                <option value="">--Please Select Blood Group--</option>
                <option value="A+" <?php if ($blood_group == "A+") {
                    echo "selected";
                } ?>>A+</option>
                <option value="A-" <?php if ($blood_group == "A-") {
                    echo "selected";
                } ?>>A-</option>
                <option value="B+" <?php if ($blood_group == "B+") {
                    echo "selected";
                } ?>>B+</option>
                <option value="B-" <?php if ($blood_group == "B-") {
                    echo "selected";
                } ?>>B-</option>
                <option value="O+" <?php if ($blood_group == "O+") {
                    echo "selected";
                } ?>>O+</option>
                <option value="O-" <?php if ($blood_group == "O-") {
                    echo "selected";
                } ?>>O-</option>
                <option value="AB+" <?php if ($blood_group == "AB+") {
                    echo "selected";
                } ?>>AB+</option>
                <option value="AB-" <?php if ($blood_group == "AB-") {
                    echo "selected";
                } ?>>AB-</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!--  <hr> -->
        <div class="form-group col-md-6">
            <label for="religion">Religion</label><span class="form_error_message">*</span>
            <select class="form-control" name="religion" id="religion">
                <option value="">--Please Select Religion--</option>
                <option value="hindu" <?php if ($religion == "hindu") {
                    echo "selected";
                } ?>>Hindu</option>
                <option value="muslim" <?php if ($religion == "muslim") {
                    echo "selected";
                } ?>>Muslim</option>
                <option value="jain" <?php if ($religion == "jain") {
                    echo "selected";
                } ?>>Jain</option>
                <option value="buddhist" <?php if ($religion == "buddhist") {
                    echo "selected";
                } ?>>Buddhist</option>
                <option value="christian" <?php if ($religion == "christian") {
                    echo "selected";
                } ?>>Christian</option>
                <option value="sikh" <?php if ($religion == "sikh") {
                    echo "selected";
                } ?>>Sikh</option>
                <option value="other" <?php if ($religion == "other") {
                    echo "selected";
                } ?>>Other</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="caste">Category</label><span class="form_error_message">*</span>
            <select class="form-control" name="caste" id="caste">
                <option value="">--Please Select Category--</option>
                <option value="general" <?php if ($caste == "general") {
                    echo "selected";
                } ?>>General</option>
                <option value="obc" <?php if ($caste == "obc") {
                    echo "selected";
                } ?>>OBC</option>
                <option value="sc" <?php if ($caste == "sc") {
                    echo "selected";
                } ?>>SC</option>
                <option value="st" <?php if ($caste == "st") {
                    echo "selected";
                } ?>>ST</option>
                <option value="ews" <?php if ($caste == "ews") {
                    echo "selected";
                } ?>>EWS</option>
            </select>
        </div>
    </div>
    <div class="row">

        <div class="form-group" style="padding : 15px">
            <label for="adhar">Aadhar Card Number</label><span class="form_error_message">*</span>
            <input type="number" class="form-control" name="adhar" id="adhar" value="<?php echo $adhar_number; ?>">
        </div>

    </div>

    <!--  <p class="heading-p">Parent Details</p> -->
    <div class="row">
        <p class="heading-p">Parent Details</p>
        <hr>
    </div>

    <div class="row">

        <!--       <hr> -->
        <div class="form-group col-md-6">
            <label for="father">Father Name</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="father" id="father" value="<?php echo $father_name; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="mother">Mother Name</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="mother" id="mother" value="<?php echo $mother_name; ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="father_occupation">Father Occupation</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" id="father_occupation" name="father_occupation"
                value="<?php echo $father_occupation; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="mother_occupation">Mother Occupation</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="mother_occupation" id="mother_occupation"
                value="<?php echo $mother_occupation; ?>">
        </div>
    </div>
    <div class="row">

        <div class="form-group col-md-6">
            <label for="parents_number">Parent Mobile Number</label><span class="form_error_message">*</span>
            <input type="text" class="form-control" name="parents_number" id="parents_number"
                value="<?php echo $parent_mobile_number; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="parents_email">Parent Email</label><!-- <span class="form_error_message">*</span> -->
            <input type="email" class="form-control" name="parents_email" id="parents_email"
                value="<?php echo $parent_email_id; ?>">
        </div>

    </div>
    <div class="row">
        <p class="heading-p">Present Address</p>
        <hr>
    </div>

    <div class="row">

        <div class="form-group col-md-6">
            <label for="address">Address</label><span class="form_error_message">*</span>
            <input type="text" id="address" class="form-control" name="address" value="<?php echo $address; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="pincode">Pincode</label><span class="form_error_message">*</span>
            <input type="number" class="form-control" id="pincode" name="pincode" value="<?php echo $pincode; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="state">State</label><span class="form_error_message">*</span>
            <select onchange="print_city('city', this.selectedIndex);" id="state" name="state" class="form-control"
                required></select>
        </div>
        <div class="form-group col-md-6">
            <label for="city">City</label><span class="form_error_message">*</span>
            <select id="city" name="city" class="form-control" required></select>
            <script language="javascript">
            print_state("state");
            </script>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <input type="checkbox" name="is_same_addr" value="1" <?php if ($is_same_addr == 1)
                    echo "checked"; ?> class="form-check-input" id="is_same_addr"> Is permanent address being same
            address for communication? Yes, or No
        </div>

    </div>
    <!--  <p class="heading-p">Permanent Address</p> -->

    <div class="row">
        <p class="heading-p">Permanent Address</p>
        <hr>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="permanent_address">Address</label><span class="form_error_message">*</span>

            <input type="text" class="form-control" id="permanent_address" name="permanent_address"
                value="<?php echo $permanent_address; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="permanent_pincode">Pincode</label><span class="form_error_message">*</span>
            <input type="number" class="form-control" id="permanent_pincode" name="permanent_pincode"
                value="<?php echo $permanent_pincode; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="permanent_state">State</label><span class="form_error_message">*</span>
            <select onchange="print_city_2('permanent_city', this.selectedIndex);" id="permanent_state"
                name="permanent_state" class="form-control" required></select>
        </div>
        <div class="form-group col-md-6">
            <label for="city">City</label><span class="form_error_message">*</span>
            <select id="permanent_city" name="permanent_city" class="form-control" required></select>
            <script language="javascript">
            print_state_2("permanent_state");
            </script>
        </div>
    </div>
</form>