<?php

function send_mail($to, $subject, $message)
{
    $from = "admissions@gmiu.edu.in";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $check = mail($to, $subject, $message, $headers);

    if ($check) {
        return true;
    } else {
        $error = error_get_last();
        $error_message = $error['message'];
        //echo "An error occurred while sending the email: $error_message";
        return $error_message;
    }
}
function generate_password()
{
    $str = "abcdefghijklmnopqrstuvwxyz1234567890123456789";
    $random_str = str_shuffle($str);
    $ran_three = substr($random_str, 0, 3);
    $pass = "gmiu@" . $ran_three;
    return $pass;
}
function generate_gr_number($stu_faculty_shortname, $student_id)
{
    $year = date("Y");
    $gr_number = $year . "$stu_faculty_shortname" . "$student_id";
    return $gr_number;
}
function send_sms($mobile_number, $message)
{

    // $customercontact = "9429641564";

    $username = urlencode('gmitbvn');
    $password = urlencode('Gmit@123');
    $number = urlencode($mobile_number);
    $messagesms = rawurlencode($message);
    $gsmid = urlencode('GMITCE');

    $data = 'UserID=' . $username . '&UserPass=' . $password . "&Message=" . $messagesms . "&MobileNo=" . $number .
        "&GSMID=" . $gsmid;
    $ch = curl_init('https://onlysms.co.in/api/sms.aspx?' . $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response1 = curl_exec($ch);

    curl_close($ch);
}

// convert number to words
function convertNumber($number)
{
    list($integerrs, $fraction) = explode(".", (string) $number);

    $output = "";

    $integerrs = str_pad($integerrs, 36, "0", STR_PAD_LEFT);
    $group   = rtrim(chunk_split($integerrs, 3, " "), " ");
    $groups  = explode(" ", $group);

    $groups2 = array();
    foreach ($groups as $g) {
        $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
    }

    for ($z = 0; $z < count($groups2); $z++) {
        if ($groups2[$z] != "") {
            $output .= $groups2[$z] . convertGroup(11 - $z) . ($z < 11
                && !array_search('', array_slice($groups2, $z + 1, -1))
                && $groups2[11] != ''
                && $groups[11][0] == '0'
                ? " and "
                : ", "
            );
        }
    }

    $output = rtrim($output, ", ");


    if ($fraction > 0) {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++) {
            $output .= " " . convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index) {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
        return "";
    }

    if ($digit1 != "0") {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0") {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0") {
        $buffer .= convertTwoDigit($digit2, $digit3);
    } else if ($digit3 != "0") {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0") {
        switch ($digit1) {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1") {
        switch ($digit2) {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else {
        $temp = convertDigit($digit2);
        switch ($digit1) {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit) {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}

function upload_multiple_files($files_array, $target_directory, $validation_check)
{
    $date = date('Y-m-d');
    $uploaded_images = array();
    
    if (is_array($files_array)) {
        
        foreach ($files_array['tmp_name'] as $key => $tmp_name) {
            $image_name = $files_array['name'][$key];
            $image_size = $files_array['size'][$key];
            $image_tmp = $files_array['tmp_name'][$key];
            $image_type = $files_array['type'][$key];
            
            $new_file_name = generate_new_file_name($date, $image_name);
            
            if ($validation_check == 1) {
                $validation_result = validate_image($image_type, $image_size);
                
                if ($validation_result['status'] == 200) {
                    create_directory($target_directory);
                    
                    $upload_result = move_uploaded_file($image_tmp, $target_directory . $new_file_name);
                    
                    if ($upload_result) {
                        $uploaded_images[] = array(
                            "name" => $new_file_name,
                        );
                    }
                } else {
                    return $validation_result;
                }
            } else {
                create_directory($target_directory);
                
                $upload_result = move_uploaded_file($image_tmp, $target_directory . $new_file_name);
                
                if ($upload_result) {
                    $uploaded_images[] = array(
                        "name" => $new_file_name,
                    );
                }
            }
        }
        
        if (!empty($uploaded_images)) {
            $response = [
                'status' => 200,
                'message' => $uploaded_images,
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'No files uploaded successfully',
            ];
        }
    } else {
        $response = [
            'status' => 400,
            'message' => 'No Data Found',
        ];
    }
    
    return $response;
}
//new

function upload_multiple_filess($files_array, $target_directory, $validation_check)
{
    $date = date('Y-m-d');
    $uploaded_images = array();
    
    if (count($files_array) === 0) {
        $response = [
            'status' => 400,
            'message' => 'No Data Found',
        ];
    } else {
        if ($validation_check == 1) {
            foreach ($files_array['tmp_name'] as $key => $tmp_name) {
                $image_name = $files_array['name'][$key];
                $image_size = $files_array['size'][$key];
                $image_tmp = $files_array['tmp_name'][$key];
                $image_type = $files_array['type'][$key];
                $validation_result = validate_image($image_type, $image_size);

  
                if ($validation_result['status'] == 200) {
                    $new_file_name = generate_new_file_name($date, $image_name);
                    create_directory($target_directory);
                    
                    $upload_result = move_uploaded_file($image_tmp, $target_directory . $new_file_name);
                    
                    if ($upload_result) {
                        array_push($uploaded_images,$new_file_name);
                    }
                } else {
                    return $validation_result;
                }
                
            }
        }
        else
        {
            foreach ($files_array['tmp_name'] as $key => $tmp_name) {
                $image_name = $files_array['name'][$key];
                $image_size = $files_array['size'][$key];
                $image_tmp = $files_array['tmp_name'][$key];
                $image_type = $files_array['type'][$key];
               
                    $new_file_name = generate_new_file_name($date, $image_name);
                    create_directory($target_directory);
                    
                    $upload_result = move_uploaded_file($image_tmp, $target_directory . $new_file_name);
                    
                    if ($upload_result) {
                        array_push($uploaded_images,$new_file_name);
                    }
               
                
            }
        }
    }
    
    return $response;
}


function generate_new_file_name($date, $image_name)
{
    $number=rand(10,100);
    return $date . '-' . $number . '-' .$image_name;
}

function validate_image($image_type, $image_size)
{
    if ($image_type == "image/png" || $image_type == "image/jpg" || $image_type == "image/jpeg" || $image_type == "image/webp") {
        if ($image_size < 5242880) {
            $response = [
                'status' => 200,
                'message' => 'Image is valid',
            ];
        } else {
            $response = [
                'status' => 400,
                'message' => 'File Size must be Smaller Than 5 MB.',
            ];
        }
    } else {
        $response = [
            'status' => 400,
            'message' => 'Selected Files is Not an Image.',
        ];
    }
    
    return $response;
}

function create_directory($directory)
{
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
}


function upload_single_file($file, $target_directory, $validation_check)
{
    // read the image files array
    $date = date('Y-m-d');
    if (isset($file)) {
        $image_name = $file['name'];
        $image_size = $file['size'];
        $image_tmp = $file['tmp_name'];
        $image_type = $file['type'];

        // rename of file 
        $number=rand(10,100);
        $new_file_name = $date . '-' . $number . '-' .$image_name;
        // check file type 
        if ($validation_check == 1) {
        if ($image_type == "image/png" || $image_type == "image/jpg" || $image_type == "image/jpeg" || $image_type == "image/webp") {
            // check image size
            if ($image_size < 5242880){
                if (!file_exists($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }
                // File is an image, move it to the uploads directory
                if (move_uploaded_file($image_tmp, $target_directory . $new_file_name)) {
                    // File was successfully uploaded, add its details to the array of uploaded images
                    $response = [
                        'status' => 200,
                        'message' => $new_file_name,
                    ];
                    return $response;
                    
                } else {
                    $response = [
                        'status' => 400,
                        'message' => 'File is not uploaded',

                    ];
                    return $response;
                }
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'File Size must be Smaller Than 5 MB.',
                ];
                return $response;
            }
        } else {
            $response = [
                'status' => 400,
                'message' => 'Selected Files is Not an Image....',
            ];
            return $response;
        }
        } else {
            if (!file_exists($target_directory)) {
                mkdir($target_directory, 0777, true);
            }
            // File is an image, move it to the uploads directory
            if (move_uploaded_file($image_tmp, $target_directory . $new_file_name)) {
                // File was successfully uploaded, add its details to the array of uploaded images
                $response = [
                    'status' => 200,
                    'message' => $new_file_name,
                ];
                return $response;
             
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'File is not uploaded',
                ];
                return $response;
            }
        }
    } else {
        $response = [
            'status' => 400,
            'message' => 'No Data Found',
        ];
        return $response;
    }
}

function upload_image_file($file, $target_directory, $validation_check, $custom_name)
{
    // Check if the file array is set
    if (isset($file)) {
        $image_name = $file['name'];          // Original file name
        $image_size = $file['size'];          // File size
        $image_tmp = $file['tmp_name'];       // Temporary file name in PHP
        $image_type = $file['type'];          // File type

        // Get file extension
        $file_extension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Rename the file using the custom name provided
        $new_file_name = $custom_name . '.' . $file_extension;

        // Validate the file type if validation_check is set
        if ($validation_check == 1) {
            // Check if the file type is allowed
            if ($image_type == "image/png" || $image_type == "image/jpg" || $image_type == "image/jpeg" || $image_type == "image/webp" || $image_type == "application/pdf") {
                // Check if the file size is within the limit (5MB in this case)
                if ($image_size < 5242880) {
                    // Check if the target directory exists, create it if not
                    if (!file_exists($target_directory)) {
                        mkdir($target_directory, 0777, true);
                    }
                    // Move the uploaded file to the target directory with the new name
                    if (move_uploaded_file($image_tmp, $target_directory . $new_file_name)) {
                        // Return success response
                        $response = [
                            'status' => 200,
                            'message' => $new_file_name,
                        ];
                        return $response;
                    } else {
                        // Return failure response if the file is not moved
                        $response = [
                            'status' => 400,
                            'message' => 'File is not uploaded',
                        ];
                        return $response;
                    }
                } else {
                    // Return failure response if the file size is too large
                    $response = [
                        'status' => 400,
                        'message' => 'File Size must be Smaller Than 5 MB.',
                    ];
                    return $response;
                }
            } else {
                // Return failure response if the file type is not allowed
                $response = [
                    'status' => 400,
                    'message' => 'Selected File is Not an Allowed Type (PNG, JPG, JPEG, WEBP, PDF).',
                ];
                return $response;
            }
        } else {
            // If validation_check is not set, just move the file without checking its type
            if (!file_exists($target_directory)) {
                mkdir($target_directory, 0777, true);
            }
            if (move_uploaded_file($image_tmp, $target_directory . $new_file_name)) {
                $response = [
                    'status' => 200,
                    'message' => $new_file_name,
                ];
                return $response;
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'File is not uploaded',
                ];
                return $response;
            }
        }
    } else {
        // Return failure response if no file data is found
        $response = [
            'status' => 400,
            'message' => 'No Data Found',
        ];
        return $response;
    }
}

function delete_file($filename, $target_directory)
{
    $filePath = $target_directory . '/' . $filename;
    
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    } else {
       return false;
}
}