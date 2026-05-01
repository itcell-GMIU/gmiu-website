<?php
include "include/checklogin.php";
$valid_extensions = ["pdf", "jpeg", "jpg", "png"]; // valid extensions
$student_id = $_POST["student_id"];
if (!file_exists("../admission/uploads/". $student_id)) {
    mkdir("../admission/uploads/". $student_id, 0777, true);
  
}

$path = "../admission/uploads/".$student_id."/";
if (!empty($_POST["fileno"]) || $_FILES["image"]) {
    $img = $_FILES["image"]["name"];
    $tmp = $_FILES["image"]["tmp_name"];
    $size = $_FILES["image"]["size"];

    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
   
    // can upload same image using rand function
    $final_image = $student_id."_" .$_POST["fileno"].".".$ext;
    $final_image = strtolower($final_image);

    // check's valid format
    if (in_array($ext, $valid_extensions)) {
        $path = $path . $final_image;
/* echo $path;
exit(); */
        if ($size < 5242880) {//size in bytes equivalent to 5 mb
            if (move_uploaded_file($tmp, $path)) {
                $name = $_POST["fileno"];

                //check entry is there or not
                $smt = $con->prepare("SELECT
                        `student_id` FROM `tbl_student_document` WHERE student_id = ? ");
                $smt->bind_param("i", $student_id);
                $smt->execute();
                $ex = $smt->get_result();
                if ($ex->num_rows == 0) {
                    $insert = $con->prepare(
                        "INSERT tbl_student_document (student_id) VALUES (?)"
                    );
                    $insert->bind_param("i", $student_id);
                    $result = $insert->execute();
                    if ($result) {
                        //update data
                        if ($name == "Photo") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET photo = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Aadhar_card") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET aadharcard = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Parent_Aadhar_card") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET parent_aadharcard = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "school_leaving_certificate") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET school_leaving = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "SSC_Marksheet") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET ssc_marksheet = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                //error in adding new entry
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "HSC_Marksheet") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET hsc_marksheet = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Graduation_Marksheet") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET graduation_marksheet = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Gujcet_Result") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET gujcet_result = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "JEE_Result") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET jee_result = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "NEET_Result") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET neet_result = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Migration_Certificate") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET migration_certificate = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Cast_Certificate") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET caste_certificate = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        } elseif ($name == "Other_Documents") {
                            $update = $con->prepare(
                                "UPDATE tbl_student_document SET other_documents = ? WHERE student_id = ?"
                            );
                            $update->bind_param(
                                "si",
                                $final_image,
                                $student_id
                            );
                            $result = $update->execute();
                            if ($result) {
                                $response = [
                                    "status" => 200,
                                    "message" => "Record Updated Successfully!",
                                ];
                            } else {
                                $response = [
                                    "status" => 400,
                                    "message" => $con->error,
                                ];
                            }
                        }
                    } else {
                        $response = [
                            "status" => 400,
                            "message" => $con->error,
                        ];
                    }
                } else {
                    if ($name == "Photo") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET photo = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Aadhar_card") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET aadharcard = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Parent_Aadhar_card") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET parent_aadharcard = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "school_leaving_certificate") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET school_leaving = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "SSC_Marksheet") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET ssc_marksheet = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "HSC_Marksheet") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET hsc_marksheet = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Graduation_Marksheet") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET graduation_marksheet = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Gujcet_Result") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET gujcet_result = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "JEE_Result") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET jee_result = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "NEET_Result") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET neet_result = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Migration_Certificate") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET migration_certificate = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Cast_Certificate") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET caste_certificate = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    } elseif ($name == "Other_Documents") {
                        $update = $con->prepare(
                            "UPDATE tbl_student_document SET other_documents = ? WHERE student_id = ?"
                        );
                        $update->bind_param("si", $final_image, $student_id);
                        $result = $update->execute();
                        if ($result) {
                            $response = [
                                "status" => 200,
                                "message" => "Record Updated Successfully!",
                            ];
                        } else {
                            $response = [
                                "status" => 400,
                                "message" => $con->error,
                            ];
                        }
                    }
                }
            } else {
                $response = [
                    "status" => 300,
                    "message" => "Something Went Wrong",
                ];
            }
        } else {
            $response = [
                "status" => 400,
                "message" => "Invalid File Size",
            ];
        }
       
    }
    else
    {
        $response = [
            "status" => 500,
            "message" => "Invalid File type",
        ];
    }
    echo json_encode($response);
}