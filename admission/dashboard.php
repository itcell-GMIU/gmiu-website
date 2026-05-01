<?php
include 'include/checklogin.php';
if ($stu_admission_status == "rejected" || $stu_admission_status == "submitted" || $stu_cluster_status == "approved" || $stu_admission_status == "approved" ) {
    header("Location:" . $base_url_admission. "application_status.php");
}

// Fetch all biannual program IDs
$biannualPrograms = [];
$result = $con->query("SELECT program_id FROM tbl_biannual_programs WHERE is_active = 1 and admission_year = '2026-27_jan' ");
while ($row = $result->fetch_assoc()) {
    $biannualPrograms[] = $row['program_id'];
}
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
    <!-- dashboard css link  -->
    <link rel="stylesheet" href="../website_assets/css/dashboard.css" type="text/css" />
    <script src="../website_assets/js/cities.js"></script>
    <style>
    .form_error_message {
        color: red;
    }

    span.error {
        color: #a94442;
        padding: 10px;
    }

    .square {
        height: auto;
        width: auto;
        border: 0.3px solid #727272;
        padding: 10px;
        border-radius: 5px;
    }

    .box-title .caption span {
        /* color: black; */
        /* text-decoration: underline; */
        font-size: 21px;
        padding: 0 0 10px;
        font-family: "Open Sans", sans-serif;
        color: #727272;
        line-height: 24px;
    }
     

    /* .box-form .form-body {
        padding: 20px !important;
    } */
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script>

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <?php include 'include/importheader.php';
    ?>
    <section class="multi_step_form Welcome-area">

        <!-- <form id="msform"> -->
        <section class="signup-step-container">
            <!-- <div class="container"> -->
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <?php
                            if ($payment_status == "success") { ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active presentation">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                        aria-expanded="true"><span class="round-tab" id="res">1 </span>
                                        <i>Payment</i></a>
                                </li>
                                <li role="presentation" class=" presentation">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                        aria-expanded="false"><span class="round-tab" id="res">2</span> <i>Basic
                                            Details</i></a>
                                </li>
                                <li role="presentation" class=" presentation">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span
                                            class="round-tab" id="res">3</span> <i>Education Details</i></a>
                                </li>
                                <li role="presentation" class=" presentation">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span
                                            class="round-tab" id="res">4</span> <i>Upload Documents</i></a>
                                </li>

                            </ul>
                            <?php  } else {
                            ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active presentation">
                                    <a aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"
                                            id="res">1 </span>
                                        <i>Payment</i></a>
                                </li>
                                <li role="presentation" class="disabled presentation">
                                    <a aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"
                                            id="res">2</span> <i>Basic
                                            Details</i></a>
                                </li>
                                <li role="presentation" class="disabled presentation">
                                    <a aria-controls="step3" role="tab"><span class="round-tab" id="res">3</span>
                                        <i>Education Details</i></a>
                                </li>
                                <li role="presentation" class="disabled presentation">
                                    <a aria-controls="step4" role="tab"><span class="round-tab" id="res">4</span>
                                        <i>Upload Documents</i></a>
                                </li>
                            </ul>
                            <?php   }
                            ?>
                        </div>


                        <div class="tab-content" id="main_form">
                            <!--PAYMENT FORM START-->
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Payment</h4>
                                <div class="row">
                                    <?php include 'payment_detail.php' ?>

                                </div>
                                <?php if ($payment_status == "success") { ?>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn next-step">Continue to next
                                            step</button></li>
                                </ul>
                                <?php
                                }
                                ?>
                            </div>
                            <!--PAYMENT FORM END-->

                            <!--BASIC DETAIL FORM START-->
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Basic Details</h4>

                                <div class="row">
                                    <?php include 'basic_detail.php'; ?>

                                </div>

                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li> -->
                                    <li><button type="submit" class="default-btn next-step"
                                            data-form_name="basic_detail">Save and Continue</button></li>

                                </ul>


                            </div>
                            <!--BASIC DETAIL FORM END-->

                            <!--Education detail form start-->
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h4 class="text-center">Education Details</h4>
                                <div class="row">
                                    <?php include 'education_detail.php'; ?>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li> -->
                                    <li><button type="button" data-form_name="education_detail"
                                            class="default-btn next-step">Save and Continue</button>
                                    </li>
                                </ul>
                            </div>
                            <!--education form end-->
                            <!--Education detail form start-->
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Upload Document</h4>
                                <div class="row">
                                    <?php include 'upload_document.php';  ?>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" id="final_review_next_btn"
                                            class="default-btn next-step">Next</button></li>
                                    <!-- <li><button type="button" class="default-btn next-step skip-btn">Skip</button></li> -->
                                    <!--  <li><button type="button" class="default-btn next-step">Continue</button></li> -->
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- </div> -->
        </section>

        <!-- </div> -->
    </section>



    <!-- END Multiform HTML -->



    <!-- ./ End Instraction Area section -->

    <!-- Footer Area section -->
    <?php include 'include/importfooter.php'; ?>
    <!-- ./ End Footer Area-->



    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>

    <script>
    function hideRegularIfNeeded() {
        var faculty_id = $("select#faculty_id").val();
        var level_id = $("select#level_id").val();
    //  var program_id = $('#program_id').val();
     
        var selectBox = document.getElementById("admission_year");
        var regularOption = selectBox.querySelector('option[value="2025-26_july"]');
    
        if (!regularOption) return;
    
        faculty_id = parseInt(faculty_id);
        level_id = parseInt(level_id);
    
        // Conditions
        if (
            (faculty_id === 1 && [1, 2, 5, 9].includes(level_id)) ||
            (faculty_id === 5 && level_id === 2) ||
            (faculty_id === 8 && level_id === 2) 
            // || (faculty_id === 3 && level_id === 2 && program_id === 322)
        ) {
            // If need to hide the 2025-26_july option then uncomment this
            // regularOption.style.display = "none";
            // if (regularOption.selected) {
            //     selectBox.value = "";
            // }
        } else {
            regularOption.style.display = "block";
        }
    }
    
    // ✅ Run only when #level_id changes
    $("#level_id").on("change", function() {
        hideRegularIfNeeded();
    });
    
    
    var biannualPrograms = <?php echo json_encode($biannualPrograms); ?>.map(Number);
    
    function toggleBiannualOption() {
        var program_id = parseInt($("#program_id").val());
    
        var selectBox = document.getElementById("admission_year");
        var biannualOption = selectBox.querySelector('option[value="2026-27_jan"]');
    
        if (!biannualOption) return;
    
        if (biannualPrograms.includes(program_id)) {
            biannualOption.style.display = "block";
        } else {
            biannualOption.style.display = "none";
            if (biannualOption.selected) {
                selectBox.value = "";
            }
        }
    }
    
    // ✅ Run when program changes
    $("#program_id").on("change", function() {
        // toggleBiannualOption();
    });
    
    // ✅ Run once on page load
    $(document).ready(function() {
        // toggleBiannualOption();
       
    });
    
    </script>
    <script>
    $(document).ready(function() {
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

            var target = $(e.target);

            if (target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function(e) {

            //ajaxcall of all forms
            // e.preventDefault();
            var form_name = $(this).data("form_name");
            //  basic detail update form call
            if (form_name == "basic_detail") {
                e.preventDefault();

                var valid_status = $("#basic_detail").valid();

                if (valid_status) {
                    $('#preloader').show();
                    var path = '<?php echo "$base_url_api"; ?>';
                    var api_for = "add_basic_detail";

                    var formData = new FormData(document.getElementById("basic_detail"));
                    formData.append('api_for', api_for);
                    $.ajax({
                        type: "POST",
                        url: path + 'api.php',
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            //  alert(data.status);
                            $('#preloader').hide();
                            if (data.status == 200) {

                                Swal.fire('Basic Detail Updated Successfully', 'success');
                                var active = $('.wizard .nav-tabs li.active');
                                active.next().removeClass('disabled');
                                nextTab(active);
                            } else {
                                Swal.fire('Something Went Wrong', 'error');
                            }

                        }
                    });
                }

            }
            //ajax call for education detail form
            else if (form_name == "education_detail") {
                e.preventDefault();
                var valid_status = $("#education_detail").valid();

                if (valid_status) {
                    $('#preloader').show();
                    var path = '<?php echo "$base_url_api"; ?>';
                    var api_for = "add_update_education_detail";

                    var formData = new FormData(document.getElementById("education_detail"));
                    formData.append('api_for', api_for);
                    $.ajax({
                        type: "POST",
                        url: path + 'api.php',
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#preloader').hide();
                            if (data.status == 200) {

                                Swal.fire('Education Detail Updated Successfully',
                                    'success');
                                var active = $('.wizard .nav-tabs li.active');
                                active.next().removeClass('disabled');
                                nextTab(active);
                            } else {
                                Swal.fire('Something Went Wrong', 'error');
                            }

                        }
                    });
                }
                //alert(form_name);
            } else {
                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);
            }



        });
        $(".prev-step").click(function(e) {
            //alert("hii");
            var active = $('.wizard .nav-tabs li.active');
            prevTab(active);

        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }
    </script>
    <!-- ============================
    JavaScript Files
    ============================= -->
    <?php include 'include/importjs.php'; ?>
    <?php include 'form_validate.php' ?>
</body>

<script type="text/javascript">
$(document).ready(function() {

    //call for listing the dropdown and select by default
    load_level();
    load_program();
    load_token();
    load_education_document();
    
    

});
$('#faculty_id').on('change', function() {
    $('#program_id').prop('selectedIndex', 0);
    var path = '<?php echo "$base_url_api"; ?>';
    var faculty_id = this.value;
    var api_type="admission";
    // alert("hii");
    $.ajax({
        url: path + 'level.php',
        type: "POST",
        data: {
            faculty_data: faculty_id,
            api_type:api_type
        },
        success: function(result) {
            $('#level_id').html(result);

            // console.log(result);
        }
    })
});
$('#level_id').on('change', function() {

    var path = '<?php echo "$base_url_api"; ?>';
    var level_id = this.value;
    // alert(level_id);
    var faculty_id = $("select#faculty_id option:checked").val();

    // console.log(level_id);
    $.ajax({
        url: path + 'program.php',
        type: "POST",
        data: {
            level_data: level_id,
            faculty_data: faculty_id
        },
        cache: false,
        success: function(data) {
            $('#program_id').html(data);
            // console.log(data);
        }
    })
});


function load_level() {
    var path = '<?php echo "$base_url_api"; ?>';
    var faculty_id = <?php echo "$stu_faculty_id"; ?>;
    var level_id = <?php echo "$stu_level_id"; ?>;
    var api_for = "dashboard";
    var api_type = "admission";

    // alert(level_id);

    $.ajax({
        url: path + 'level.php',
        type: "POST",
        data: {
            faculty_data: faculty_id,
            api_for: api_for,
            level_id: level_id,
            api_type:api_type
        },
        success: function(result) {
            $('#level_id').html(result);
                hideRegularIfNeeded();
            // console.log(result);
        }
    });
}

function load_program() {
    var path = '<?php echo "$base_url_api"; ?>';
    var faculty_id = <?php echo "$stu_faculty_id"; ?>;
    var level_id = <?php echo "$stu_level_id"; ?>;
    var program_id = <?php echo "$stu_program_id"; ?>;
    var api_for = "dashboard";
    // console.log(level_id);
    $.ajax({
        url: path + 'program.php',
        type: "POST",
        data: {
            level_data: level_id,
            faculty_data: faculty_id,
            api_for: api_for,
            program_id: program_id
        },
        cache: false,
        success: function(data) {
            $('#program_id').html(data);
            //   toggleBiannualOption();
            // console.log(data);
             // ----- Pay Now Button Logic -----
             
             
            // const payNowBtn = document.getElementById("ebz-checkout-btn");
            // if (payNowBtn) {
            //     if (program_id && program_id != 119) {
            //         payNowBtn.style.display = "inline-block";
            //         payNowBtn.disabled = false;
            //     } else {
            //         payNowBtn.style.display = "none";
            //         payNowBtn.disabled = true;
            //     }
            // }
        }
    });
     
}

function load_token() {
    var path = '<?php echo "$base_url_api"; ?>';
    var program_id = <?php echo "$stu_program_id"; ?>;
    var selected_mode = $('#admission_mode').find(":selected").val();
    // alert(selected_mode);
    var api_for = "token_fee";
    // console.log(level_id);
    $.ajax({
        url: path + 'api.php',
        type: "POST",
        data: {
            api_for: api_for,
            program_id: program_id,
            admission_mode: selected_mode
        },
        cache: false,
        success: function(data) {
            var response = JSON.parse(data);
            //  console.log(response);
            $('#token_amount').val(response.token);
            if (response.genius_mode_status == "no") {
            //    $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='genius']").hide();
            } else {
             //   $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='genius']").show();

            }
            if (response.minor_mode_status == "no") {
              //  $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='minor']").hide();


            } else {
              //  $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='minor']").show();

            }
            var semFeesHtml = "<table class='table table-bordered'>";
            var headerRow = "<tr>";
            var feeRow = "<tr>";
            var hasAnyFee = false;
            
            for (var i = 1; i <= 8; i++) {
                var fee = response['sem' + i];
                if (fee && fee != "0") {
                    hasAnyFee = true;
                    headerRow += `<th>Semester ${i}${i === 1 ? " (Remaining Fee)" : ""}</th>`;
                    feeRow += `<td>₹${fee}</td>`;
                }
            }

            
            headerRow += "</tr>";
            feeRow += "</tr>";
            semFeesHtml += headerRow + feeRow + "</table>";
            
            if (hasAnyFee) {
                $('#semester_fees').html(semFeesHtml);
                $('#semester_fee_container').css('display', 'table-row');
            } else {
                $('#semester_fees').html('');
                $('#semester_fee_container').hide();
            }

        }
    });

}

$('#program_id').on('change', function() {
    // alert("hii");
    var path = '<?php echo "$base_url_api"; ?>';
    var selected_mode = "regular";
    var program_id = this.value;
    var api_for = "token_fee";
    // alert(program_id);
    $.ajax({
        url: path + 'api.php',
        type: "POST",
        data: {
            program_id: program_id,
            api_for: api_for,
            admission_mode: selected_mode
        },
        cache: false,
        success: function(data) {
            // alert(data);\
            
            var response = JSON.parse(data);
            // console.log(response);
            $('#token_amount').val(response.token);
            if (response.genius_mode_status == "no") {
                $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='genius']").hide();


            } else {
                $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='genius']").show();

            }
            if (response.minor_mode_status == "no") {
                $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='minor']").hide();


            } else {
                $('#admission_mode').prop('selectedIndex', 0);
                $("#admission_mode option[value='minor']").show();

            }
            var semFeesHtml = "<div class='table-responsive'><table class='table table-bordered'>";
            var headerRow = "<tr>";
            var feeRow = "<tr>";
            var hasAnyFee = false;
            
            for (var i = 1; i <= 8; i++) {
                var fee = response['sem' + i];
                if (fee && fee != "0") {
                    hasAnyFee = true;
                    headerRow += `<th>Semester ${i}${i === 1 ? " (Remaining Fee)" : ""}</th>`;
                    feeRow += `<td>₹${fee}</td>`;
                }
            }

            
            headerRow += "</tr>";
            feeRow += "</tr>";
            semFeesHtml += headerRow + feeRow + "</table></div>";
            
            if (hasAnyFee) {
                $('#semester_fees').html(semFeesHtml);
                $('#semester_fee_container').css('display', 'table-row');
            } else {
                $('#semester_fees').html('');
                $('#semester_fee_container').hide();
            }
            // ----- Pay Now Button Logic -----
            
            // const payNowBtn = document.getElementById("ebz-checkout-btn");
            // if (payNowBtn) {
            //     if (program_id && program_id !== "119") {
            //         payNowBtn.style.display = "inline-block";
            //         payNowBtn.disabled = false;
            //     } else {
            //         payNowBtn.style.display = "none";
            //         payNowBtn.disabled = true;
            //     }
            // }

        }
    })
});

$('#admission_mode').on('change', function() {
    var path = '<?php echo "$base_url_api"; ?>';
    var selected_mode = $('#admission_mode').find(":selected").val();
    var program_id = $('#program_id').find(":selected").val();
    var api_for = "token_fee";
    /*  alert(selected_mode); */

    // alert(program_id);
    $.ajax({
        url: path + 'api.php',
        type: "POST",
        data: {
            program_id: program_id,
            api_for: api_for,
            admission_mode: selected_mode
        },
        cache: false,
        success: function(data) {
            //alert(data);
            var response = JSON.parse(data);
            // console.log(response);
            $('#token_amount').val(response.token);
        }
    })
});

//online payment ajax call
$('#ebz-checkout-btn').on('click', function(e) {
    $('#preloader').show();
    var formData = new FormData(document.getElementById("payment_detail"));
    $valid_status = $("#payment_detail").valid();
    if ($valid_status) {
        e.preventDefault();
        var path = '<?php echo "$base_url_api"; ?>';
        $.ajax({
            url: path + 'pay.php',
            type: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {

                $('#preloader').show();
                 var easebuzzCheckout = new EasebuzzCheckout(
                    'CRGPBR3D4U', 'prod'); 
                   /*  var easebuzzCheckout = new EasebuzzCheckout(
                      '10PBP71ABZ2', 'test');  */

                var access_key = JSON.parse(data.data).access_key;
                // console.log(access_key);
                var options = {
                    access_key: access_key,
                    onResponse: (response) => {
                        $('#preloader').hide();
                        var response = response;
                        $.ajax({
                            url: path + 'checkout.php',
                            type: 'post',
                            data: {
                                "response": response
                            },
                            success: function(data) {

                                location.reload();
                                $('#preloader').hide();

                            },
                            fail: function(xhr, textStatus, errorThrown) {
                                alert('request failed');
                            }
                        });
                    },
                    theme: "#ba2a21"
                }
                easebuzzCheckout.initiatePayment(options);
            }
           


        });
    }
    /*  alert("hii"); */

});

//offline payment mode ajax call
$('#offline-submit-btn').on('click', function(e) {
    $('#preloader').show();
    var formData = new FormData(document.getElementById("payment_detail"));
    $valid_status = $("#payment_detail").valid();
    if ($valid_status) {
        e.preventDefault();
        var path = '<?php echo "$base_url_api"; ?>';
        $.ajax({
            url: path + 'offline_payment.php',
            type: 'post',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#preloader').hide();
                if (data.status == 200) {
                    Swal.fire('Request Submitted Successfully');
                    location.reload();

                } else {
                    Swal.fire('Something Went Wrong', 'error');
                }
            },
            error: function(e) {
                $("#err").html(e).fadeIn();
                Swal.fire('Invalid', 'error');
            }
        });
    }
});

//autofill the address on check box click
$(document).ready(function() {
    $("#is_same_addr").on("click", function() {
        if (this.checked) {
            var address = $("#address").val();
            var pincode = $("#pincode").val();
            var city = $("#city").val();
            var state = $("#state").val();
            $("#permanent_address").val(address);
            $("#permanent_pincode").val(pincode);

            //  $("#permanent_address").attr("disabled", "disabled");
            // $("#permanent_pincode").attr("disabled", "disabled");

        } else {
            $("#permanent_address").val("");
            $("#permanent_pincode").val("");
            $("#permanent_state option[value='" + permanent_state + "']").attr("selected", "selected");
            //  $('#permanent_address').prop("disabled", false);
            //  $('#permanent_pincode').prop("disabled", false);

            // $("#permanent_pincode").attr("disabled", "disabled");
        }
    });
    var state = '<?php echo "$state"; ?>';
    var city = '<?php echo "$city"; ?>';
    var permanent_state = '<?php echo "$permanent_state"; ?>';
    var permanent_city = '<?php echo "$permanent_city"; ?>';

    $("#state option[value='" + state + "']").attr("selected", "selected");
    $("#permanent_state option[value='" + permanent_state + "']").attr("selected", "selected");

    var selected_state = $("#state")[0].selectedIndex;

    print_city('city', selected_state);


    var selected_permanent_state = $("#permanent_state")[0].selectedIndex;
    // alert(selected_permanent_state);
    print_city_2('permanent_city', selected_permanent_state);

    jQuery(window).load(function() {
        $("#city option[value='" + city + "']").attr("selected", "selected");
        $("#permanent_city option[value='" + permanent_city + "']").attr("selected", "selected");

    });

});
</script>


<!---upload docuemnt-->
<script>
/*  load all document ajax  call */
function load_education_document(col_name, dl) {
    var path = '<?php echo "$base_url_api"; ?>';
    var student_id = <?php echo $student_id; ?>;
    var upload_document_url = "<?php echo $upload_document_url; ?>";
    $.ajax({
        type: "POST",
        url: path + "ajaxgetdocument.php",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.status == 200) {
                var photo = data.data.photo;
                var aadharcard = data.data.aadharcard;
                var parent_aadharcard = data.data.parent_aadharcard;
                var school_leaving = data.data.school_leaving;
                var ssc_marksheet = data.data.ssc_marksheet;
                var hsc_marksheet = data.data.hsc_marksheet;
                var caste_certificate = data.data.caste_certificate;
                var gujcet_result = data.data.gujcet_result;
                var jee_result = data.data.jee_result;
                var neet_result = data.data.neet_result;
                var graduation_marksheet = data.data.graduation_marksheet;
                var migration_certificate = data.data.migration_certificate;
                var other_documents = data.data.other_documents;

                if (photo != null && photo != "") {
                    $(".view_photo").show();
                    $("#rm1").show();
                    $("#btn1").hide();

                    $("#view_photo").attr("href", upload_document_url + student_id + "/" + photo);
                } else {
                    $(".view_photo").hide();
                    $("#rm1").hide();
                    $("#btn1").show();
                }

                if (aadharcard != null && aadharcard != "") {

                    $(".view_aadharcard").show();
                    $("#rm2").show();
                    $("#btn2").hide();

                    $("#view_aadharcard").attr("href", upload_document_url + student_id + "/" + aadharcard);
                } else {
                    $(".view_aadharcard").hide();
                    $("#rm2").hide();
                    $("#btn2").show();
                }

                if (parent_aadharcard != null && parent_aadharcard != "") {

                    $(".view_parent_aadharcard").show();
                    $("#rm3").show();
                    $("#btn3").hide();

                    $("#view_parent_aadharcard").attr("href", upload_document_url + student_id + "/" +
                        parent_aadharcard);
                } else {
                    $(".view_parent_aadharcard").hide();
                    $("#rm3").hide();
                    $("#btn3").show();
                }

                if (school_leaving != null && school_leaving != "") {

                    $(".view_school_leaving").show();
                    $("#rm4").show();
                    $("#btn4").hide();

                    $("#view_school_leaving").attr("href", upload_document_url + student_id + "/" +
                        school_leaving);
                } else {
                    $(".view_school_leaving").hide();
                    $("#rm4").hide();
                    $("#btn4").show();
                }

                if (ssc_marksheet != null && ssc_marksheet != "") {

                    $(".view_ssc_marksheet").show();
                    $("#rm5").show();
                    $("#btn5").hide();

                    $("#view_ssc_marksheet").attr("href", upload_document_url + student_id + "/" +
                        ssc_marksheet);
                } else {
                    $(".view_ssc_marksheet").hide();
                    $("#rm5").hide();
                    $("#btn5").show();
                }

                if (hsc_marksheet != null && hsc_marksheet != "") {

                    $(".view_hsc_marksheet").show();
                    $("#rm6").show();
                    $("#btn6").hide();

                    $("#view_hsc_marksheet").attr("href", upload_document_url + student_id + "/" +
                        hsc_marksheet);
                } else {
                    $(".view_hsc_marksheet").hide();
                    $("#rm6").hide();
                    $("#btn6").show();

                }
                if (graduation_marksheet != null && graduation_marksheet != "") {

                    $(".view_graduation_marksheet").show();
                    $("#rm7").show();
                    $("#btn7").hide();

                    $("#view_graduation_marksheet").attr("href", upload_document_url + student_id + "/" +
                        graduation_marksheet);
                } else {
                    $(".view_graduation_marksheet").hide();
                    $("#rm7").hide();
                    $("#btn7").show();
                }

                if (gujcet_result != null && gujcet_result != "") {

                    $(".view_gujcet_result").show();
                    $("#rm8").show();
                    $("#btn8").hide();

                    $("#view_gujcet_result").attr("href", upload_document_url + student_id + "/" +
                        gujcet_result);
                } else {
                    $(".view_gujcet_result").hide();
                    $("#rm8").hide();
                    $("#btn8").show();
                }
                if (jee_result != null && jee_result != "") {

                    $(".view_jee_result").show();
                    $("#rm9").show();
                    $("#btn9").hide();

                    $("#view_jee_result").attr("href", upload_document_url + student_id + "/" +
                        jee_result);
                } else {
                    $(".view_jee_result").hide();
                    $("#rm9").hide();
                    $("#btn9").show();
                }
                if (neet_result != null && neet_result != "") {

                    $(".view_neet_result").show();
                    $("#rm10").show();
                    $("#btn10").hide();

                    $("#view_neet_result").attr("href", upload_document_url + student_id + "/" +
                        neet_result);
                } else {

                    $(".view_neet_result").hide();
                    $("#rm10").hide();
                    $("#btn10").show();
                }

                if (migration_certificate != null && migration_certificate != "") {

                    $(".view_migration_certificate").show();
                    $("#rm11").show();
                    $("#btn11").hide();

                    $("#view_migration_certificate").attr("href", upload_document_url + student_id + "/" +
                        migration_certificate);
                } else {
                    $(".view_migration_certificate").hide();
                    $("#rm11").hide();
                    $("#btn11").show();
                }

                if (caste_certificate != null && caste_certificate != "") {

                    $(".view_caste_certificate").show();
                    $("#rm12").show();
                    $("#btn12").hide();

                    $("#view_caste_certificate").attr("href", upload_document_url + student_id + "/" +
                        caste_certificate);
                } else {
                    $(".view_caste_certificate").hide();
                    $("#rm12").hide();
                    $("#btn12").show();
                }
                if (other_documents != null && other_documents != "") {

                    $(".view_other_documents").show();
                    $("#rm13").show();
                    $("#btn13").hide();

                    $("#view_other_documents").attr("href", upload_document_url + student_id + "/" +
                        other_documents);
                } else {
                    $(".view_other_documents").hide();
                    $("#rm13").hide();
                    $("#btn13").show();
                }
            }
        },
        error: function(e) {
            $("#err").html(e).fadeIn();
            Swal.fire('Invalid', 'error');
        }

    });

}
</script>
<script>
/* Remove Document Ajax Call */
$(".remove_document").on('click', function(event) {
    var col_name = $(this).data("col_name");
    var path = '<?php echo "$base_url_api"; ?>';

    var formData = new FormData(document.getElementById("remove_document_form"));
    formData.append('col_name', col_name);
    /*     alert(col_name); */
    $.ajax({
        type: "POST",
        url: path + 'ajaxremovedocument.php',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            //  alert(data.status);
            if (data.status == 200) {
                Swal.fire('Removed Successfully');
                load_education_document();
            } else {
                Swal.fire('Something Went Wrong', 'error');
            }

        }
    });

    //(... rest of your JS code)
});
</script>
<script>
/* upload document ajax function */
function rmAndDl(form, rm, dl, btn, name_file, file_name) {


    $(document).ready(function(e) {

        $(form).on('submit', (function(e) {
            var path = '<?php echo "$base_url_api"; ?>';
            e.preventDefault();
            $.ajax({
                url: path + "ajaxupload.php",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#err").fadeOut();
                },
                success: function(data) {
                    if (data.status == 200) {

                        load_education_document();

                        $("#preview").html(data).fadeIn();
                        $(form)[0].reset();
                        Swal.fire(name_file + ' Updated Successfully!',
                            'File Uploaded Successfully');
                        //}
                    } else if (data.status == 400) {
                        Swal.fire('Invalid File Size!',
                            'Please look at the above mentioned Instructions for File upload '
                        );
                    } else if (data.status == 300) {
                        Swal.fire('Something Went Wrong!',
                            'Please look at the above mentioned Instructions for File upload'
                        );
                    } else if (data.status == 500) {
                        Swal.fire('Invalid File  Format !',
                            'Please look at the above mentioned Instructions for File upload'
                        );
                    }


                },

            });
        }));
    });

}

rmAndDl("#form", "#rm1", "#dl1", "#btn1", "Photo", "photo");
rmAndDl("#form2", "#rm2", "#dl2", "#btn2", "Aadhar Card", "aadharcard");
rmAndDl("#form3", "#rm3", "#dl3", "#btn3", "Parent Aadhar Card", "parent_aadharcard");
rmAndDl("#form4", "#rm4", "#dl4", "#btn4", "School Leaving Certificate", "school_leaving");
rmAndDl("#form5", "#rm5", "#dl5", "#btn5", "SSC Marksheet", "ssc_marksheet");
rmAndDl("#form6", "#rm6", "#dl6", "#btn6", "HSC Marksheet", "hsc_marksheet");
rmAndDl("#form7", "#rm7", "#dl7", "#btn7", "Graduation Marksheet", "graduation_marksheet");
rmAndDl("#form8", "#rm8", "#dl8", "#btn8", "Gujcet result", "gujcet_result");
rmAndDl("#form9", "#rm9", "#dl9", "#btn9", "JEE Result", "jee_result");
rmAndDl("#form10", "#rm10", "#dl10", "#btn10", "NEET Result", "neet_result");
rmAndDl("#form11", "#rm11", "#dl11", "#btn11", "Migration Certificate", "migration_certificate");
rmAndDl("#form12", "#rm12", "#dl12", "#btn12", "Cast Certificate", "caste_certificate");
rmAndDl("#form13", "#rm13", "#dl13", "#btn13", "Other Documents", "other_documents");
</script>
<!--end -->
<script>
/* Check All Step Completed or not */
$("#final_review_next_btn").on('click', function(event) {
    var path = '<?php echo "$base_url_api"; ?>';

    var formData = new FormData(document.getElementById("remove_document_form"));
    formData.append('api_for', "check_all_step_complete");
    $.ajax({
        type: "POST",
        url: path + 'api.php',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            //alert(data.status);
            if (data.status == 200) {
                location.href = "final_review.php";
            } else {
                Swal.fire('Incomplete Steps', data.message);
            }

        }
    });
});
</script>
<script>
//code for changing payment mode and hide show tr respectively
$("#payment_mode").change(function() {
    var payment_mode = this.value;
    if (payment_mode == "offline") {
        $('.offline_mode_tr').show();
        $('.online_mode_tr').hide();

    } else {
        $('.offline_mode_tr').hide();
        $('.online_mode_tr').show();

    }
});
</script>

</html>