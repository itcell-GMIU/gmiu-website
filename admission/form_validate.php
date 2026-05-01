<script>
    $(document).ready(function () {
        $("#payment_detail").validate({
            messages: {
                faculty_id: {
                    required: "Please Select Faculty",

                },
                level_id: {
                    required: "Please Select Level"
                },
                program_id: {
                    required: "Please Select Program"
                },
                payment_mode: {
                    required: "Please Select Payment Mode"
                },
            },
            rules: {
                faculty_id: { // compound rule
                    required: true,

                },

                level_id: { // compound rule
                    required: true,
                    // email: true,
                    //  minlength: 8000
                },
                program_id: { // compound rule
                    required: true,
                    // email: true,
                    //  minlength: 8000
                },
                payment_mode: {
                    required: true,
                },
            },
            highlight: function (element) {
                $(element).parent().addClass('form_error_message')
            },
            unhighlight: function (element) {
                $(element).parent().removeClass('form_error_message')
            }

        });
        $("#basic_detail").validate({
            messages: {
                first_name: {
                    required: "Please Enter First Name",
                },
                middle_name: {
                    required: "Please Enter Middle Name",

                },
                last_name: {
                    required: "Please Enter Last Name",

                },
                gender: {
                    required: "Please Select Gender",

                },
                mobile_number: {
                    required: "Please Enter Mobile Number",

                },
                email: {
                    required: "Please Enter Email",

                },
                dob: {
                    required: "Please Enter Date Of Birth",

                },
                blood_group: {
                    required: "Please Select Blood Group",

                },
                religion: {
                    required: "Please Select Religion",

                },
                caste: {
                    required: "Please Select Caste",

                },
                adhar: {
                    required: "Please Enter Adhar Card Number",
                    minlength: "Number should be 12 digits",
                    maxlength: "Number should be 12 digits",
                },
                father: {
                    required: "Please Enter Father Name",
                },
                mother: {
                    required: "Please Enter Mother Name",
                },
                father_occupation: {
                    required: "Please Enter Father Occupation",
                },
                mother_occupation: {
                    required: "Please Enter Mother Occupation",
                },
                parents_number: {
                    required: "Please Enter Mobile Number",
                },
                /*   parents_email: {
                      required: "Please Enter Email",
                  }, */
                address: {
                    required: "Please Enter Address",
                },
                pincode: {
                    required: "Please Enter Pincode Number",
                    minlength: "Number should be 6 digits",
                    maxlength: "Number should be 6 digits",
                },
                permanent_address: {
                    required: "Please Enter Permanent Address",
                },
                permanent_pincode: {
                    required: "Please Enter Permanent Pincode Number",
                    minlength: "Number should be 6 digits",
                    maxlength: "Number should be 6 digits",
                },
            },
            rules: {
                first_name: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                middle_name: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                last_name: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                gender: {
                    required: true,
                },
                mobile_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                email: {
                    required: true,
                    email: true
                },
                dob: {
                    required: true,

                },
                blood_group: {
                    required: true,

                },
                religion: {
                    required: true,

                },
                caste: {
                    required: true,

                },
                adhar: {
                    required: true,
                    digits: true,
                    minlength: 12,
                    maxlength: 12,
                },
                father: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                mother: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                father_occupation: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                mother_occupation: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                parents_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                /*      parents_email: {
                         required: true,
                         email: true
                     }, */
                address: {
                    required: true,
                },
                pincode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                },
                permanent_address: {
                    required: true,
                },
                permanent_pincode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                },
            },

            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

        });
        $("#education_detail").validate({
            messages: {
                ssc_boardname: {
                    required: "Please Select Board Name",
                },
                // ssc_schoolname: {
                //     required: "Please Enter School Name",

                // },
                ssc_percentage: {
                    required: "Please Enter Valid Percentage",

                },
                ssc_passingmonth: {
                    required: "Please Select Passing month",

                },
                ssc_passingyear: {
                    required: "Please Enter Passing year",

                },
                // hsc_stream: {
                //     required: "Please Enter Stream",

                // },
                hsc_boardseatnumber: {
                    required: "Please Enter Seat Number",

                },
                // hsc_schoolname: {
                //     required: "Please Enter School Name",

                // },
                hsc_percentage: {
                    required: "Please Enter Valid Percentage",
                },
                hsc_passingstatus: {
                    required: "Please Select Status",

                },
                hsc_passingmonth: {
                    required: "Please Select Passingmonth",

                },
                hsc_passingyear: {
                    required: "Please Select Passingyear",

                },
                hsc_passingboard: {
                    required: "Please Select Board Name",

                },
                gujcet_appear: {
                    required: "Please Select Option",

                },
                // gujcet_seatnumber: {
                //     required: "Please Enter Seat Number",

                // },
                // gujcet_applicationnumber: {
                //     required: "Please Enter Application Number",

                // },
                jee_appear: {
                    required: "Please Select Option",

                },
                // jee_seatnumber: {
                //     required: "Please Enter Seat Number",

                // },
                // jee_applicationnumber: {
                //     required: "Please Enter Application Number",

                // },
                neet_appear: {
                    required: "Please Select Option",

                },
                // neet_seatnumber: {
                //     required: "Please Enter Seat Number",

                // },
                // neet_applicationnumber: {
                //     required: "Please Enter Application Number",

                // },
                graduation_course: {
                    required: "Please Enter Course",

                },
                /*      graduation_university: {
                         required: "Please Select University",
    
                     }, */
                graduation_college_name: {
                    required: "Please Enter Valid College Name",

                },
                graduation_cpi: {
                    required: "Please Enter Valid CPI",

                },
                graduation_passing_status: {
                    required: "Please Select Status",

                },
                graduation_passing_month: {
                    required: "Please Select Passingmonth",

                },
                graduation_passing_year: {
                    required: "Please Select Passingyear",

                },
                gmcet_score: {
                    required: "Please Enter Valid Score",

                },
                cmat_score: {
                    required: "Please Enter Valid Score",

                },
            },
            rules: {

                ssc_boardname: {
                    required: true,

                },
                /*   ssc_schoolname: {
                      required: true,
    
                  }, */
                ssc_percentage: {
                    required: true,
                    range: [0, 100]
                },
                ssc_passingmonth: {
                    required: true,

                },
                ssc_passingyear: {
                    required: true,

                },
                // hsc_stream: {
                //     required: true,

                // },
                hsc_boardseatnumber: {
                    required: true,

                },
                // hsc_schoolname: {
                //     required: true,

                // },
                hsc_percentage: {
                    required: true,
                    range: [0, 100]
                },
                hsc_passingstatus: {
                    required: true,

                },
                hsc_passingmonth: {
                    required: true,

                },
                hsc_passingyear: {
                    required: true,

                },
                hsc_passingboard: {
                    required: true,

                },
                gujcet_appear: {
                    required: true,

                },
                // gujcet_seatnumber: {
                //     required: true,

                // },
                // gujcet_applicationnumber: {
                //     required: true,

                // },
                jee_appear: {
                    required: true,

                },
                // jee_seatnumber: {
                //     required: true,

                // },
                // jee_applicationnumber: {
                //     required: true,

                // },
                neet_appear: {
                    required: true,

                },
                // neet_seatnumber: {
                //     required: true,

                // },
                // neet_applicationnumber: {
                //     required: true,

                // },
                graduation_course: {
                    required: true,

                },
                /*    graduation_university: {
                       required: true,
                   }, */
                graduation_college_name: {
                    required: true,

                },
                /*  graduation_cpi: {
                     required: true,
                     range: [0, 100]
                 }, */
                graduation_passing_status: {
                    required: true,

                },
                graduation_passing_month: {
                    required: true,

                },
                graduation_passing_year: {
                    required: true,

                },
                gmcet_score: {
                    // required: true,
                    range: [0, 800]
                },
                cmat_score: {
                    // required: true,
                    range: [0, 400]
                },
            },

            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

        });
        $("#final_submit").validate({
            messages: {
                'accept_declaration1[]': {
                    required: "Please Accept the declaration",
                },

            },
            rules: {
                'accept_declaration1[]': {
                    required: true,

                },
            },

            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

        });
    });
</script>