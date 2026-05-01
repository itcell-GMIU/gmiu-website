<?php

session_start();
if (isset($_SESSION['isLogin']) && isset($_POST['subject'])) {
  $subject = htmlspecialchars($_POST['subject']);
  $_SESSION['subject'] = $subject;
  echo "<script> window.location = 'papers.php' </script>";
}
if (isset($_POST['Name']) && isset($_POST['Mobile']) && $_POST['ParentMobile'] && $_POST['Medium']) {
  include '../gseb_admin/database/connect.php';

  // Create connection
  $conn = mysqli_connect($host, $dbuser, $dbpass, $db);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $Name = mysqli_real_escape_string($conn, $_POST['Name']);
  $Name = htmlspecialchars($Name);
  $Mobile = mysqli_real_escape_string($conn, $_POST['Mobile']);
  $Mobile = htmlspecialchars($Mobile);
  $ParentMobile = mysqli_real_escape_string($conn, $_POST['ParentMobile']);
  $ParentMobile = htmlspecialchars($ParentMobile);
  $Medium = mysqli_real_escape_string($conn, $_POST['Medium']);
  $Medium = htmlspecialchars($Medium);
  $std = mysqli_real_escape_string($conn, $_POST['std']);
  $std = htmlspecialchars($std);
  $BoardSeat = mysqli_real_escape_string($conn, isset($_POST['BoardSeat']) ? $_POST['BoardSeat'] : '');
  $BoardSeat = htmlspecialchars($BoardSeat);
  $School = mysqli_real_escape_string($conn, isset($_POST['School'])) ? $_POST['School'] : '';
  $School = htmlspecialchars($School);

  $sql = "CREATE TABLE IF NOT EXISTS student_data1 (
    id int NOT NULL AUTO_INCREMENT, 
    Name varchar(255), 
    Mobile varchar(20), 
    ParentMobile varchar(20), 
    Medium varchar(255),
    std varchar(255), 
    BoardSeat varchar(255),  
    School varchar(255), 
    PRIMARY KEY (id)
  )";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  $sql = "INSERT INTO `student_data1`(`Name`, `Mobile`, `ParentMobile`, `Medium`,`std`, `BoardSeat`,  `School`) VALUES ('$Name','$Mobile','$ParentMobile','$Medium','$std','$BoardSeat','$School')";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  $_SESSION['isLogin'] = 'true';

  $conn->close();
  if ($result) {
    echo "<script> window.location = 'papers.php' </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Download free GSEB & GUJCET model papers from GMIU, Bhavnagar—practice with updated question sets to enhance your exam preparation." />
  <meta name="keywords" content="GSEB model papers, GUJCET paperset, Gujarat board question paper, GMIU Bhavnagar, GSEB exam preparation, GUJCET mock test, GSEB 12th paper, Gyanmanjari Innovative University" />

  <title>Gujcet Model Paperset | Gyanmanjari Innovative University | Bhavnagar</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Montserrat", sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: url("hero.webp");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }

    h1 {
      margin-bottom: 15px;
    }

    p {
      margin: 10px 0;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100%;
      background-color: black;
      z-index: -1;
      opacity: 0.7;
    }

    .mainDiv {
      background-color: #fff;
      padding: 20px 70px;
      border-radius: 20px;
      box-shadow: 6px 5px 20px 0px #000000b0;
      margin: 15px;
      opacity: 0;
      pointer-events: none;
      transition: all 0.5s;
    }

    button {
      background: #ff9933;
      border: none;
      padding: 20px;
      /* width: 100px; */
      text-wrap: nowrap;
      border-radius: 10px;
      color: white;
      cursor: pointer;
      margin: 10px;
    }

    .cont {
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .btnDiv form {
      display: inline-block;
    }

    input,
    select {
      margin: 5px 0;
      border-radius: 50px;
      padding: 10px 15px;
      font-size: 14px;
      border: 2px solid #999999;
    }

    input[type="submit"] {
      background-color: #ff9933;
      color: white;
      border: none;
      cursor: pointer;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type="number"] {
      -moz-appearance: textfield;
    }

    .form {
      position: absolute;
    }

    .back {
      position: absolute;
      top: 10px;
      left: 10px;
      width: unset;
      margin: 0;
      padding: 10px;
    }

    .active {
      opacity: 1;
      pointer-events: all;
    }

    .err {
      color: red;
    }

    a {
      color: black;
      font-size: 18px;
    }

    @media only screen and (max-width: 440px) {
      .mainDiv {
        padding: 15px;
      }

      h1 {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>
  <div class="overlay"></div>
  
  <div class="mainDiv active" id="subjDiv">
    <div class="ldiv">
      <div class="cont">
      <img src="../../website_assets/images/logo3.png" alt="Board Model Paperset" style=" width: 340px; height:auto;">
        <h1>Board Model Paperset</h1>
        <div class="btnDiv">
          <?php if (isset($_SESSION['isLogin'])) { ?>
            <form action="" method="post">
              <div class="btnDiv">
                <button name="subject" type="submit" value="Gujarat Board 10th" class="">Gujarat Board <br> 10th</button>
                <button name="subject" type="submit" value="Gujarat Board 12th SCI.">Gujarat Board <br>  12th SCI.</button>
              </div>
              <div class="btnDiv">
                <button name="subject" type="submit" value="Gujarat Board 12th ARTS">Gujarat Board <br> 12th ARTS</button>
                <button name="subject" type="submit" value="Gujarat Board 12th COM.">Gujarat Board <br> 12th COM.</button>
              
              </div>
            </form>
          <?php } else { ?>
            <div class="btnDiv">
              <button id="Gujarat Board 10th">Gujarat Board <br> 10th</button>
              <button id="Gujarat Board 12th SCI.">Gujarat Board <br> 12th SCI.</button>
            </div>
            <div class="btnDiv">
              <button id="Gujarat Board 12th ARTS">Gujarat Board <br>  12th ARTS</button>
              <button id="Gujarat Board 12th COM.">Gujarat Board <br> 12th COM.</button>
              
            </div>
          <?php } ?>
        </div>
        <?php
        include("./blinks.php");
        ?>
      </div>
    </div>
  </div>
  <div class="mainDiv form" id="formDiv">
    <button class="back">Back</button>
    <div class="rdiv">
      <div class="cont">
        <form action="" name="StuDetail" id="StuDetail" method="post">
          <input type="text" placeholder="Student Name *" name="Name" required />
          <input type="number" placeholder="Mobile Number *" pattern="[6789][0-9]{9}" name="Mobile" required />
          <input type="number" required placeholder="Parent's Number *" pattern="[6789][0-9]{9}" name="ParentMobile" />
          <select name="Medium">
            <option value="" disabled selected>Select Medium</option>
            <option value="gujarati">Gujarati</option>
            <option value="english">English</option>
          </select>
          <select name="std">
            <option value="" disabled selected>Select Standard</option>
            <option value="10">10</option>
            <option value="12 SCI.(A)">12 SCI.(A)</option>
            <option value="12 SCI.(B)">12 SCI.(B)</option>
            <option value="12 Com.">12 Com.</option>
            <option value="12 Arts">12 Arts</option>
            

          </select>
          <!-- <input type="number" placeholder="Gujcet Seat Number" name="BoardSeat" /> -->
          <input type="text" placeholder="School Name *" name="School" required />
          <input type="hidden" name="subject" />
          <input type="submit" value="Submit" />
          <p class="err" id="err">*Form is Required For Download Document</p>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.getElementById("Gujarat Board 10th").onclick = (e) => {
      document.getElementById("subjDiv").classList.remove("active");
      document.getElementById("formDiv").classList.add("active");
      document.getElementsByName("subject")[0].value = "Gujarat Board 10th";
    };
    
    document.getElementById("Gujarat Board 12th ARTS").onclick = (e) => {
      document.getElementById("subjDiv").classList.remove("active");
      document.getElementById("formDiv").classList.add("active");
      document.getElementsByName("subject")[0].value = "Gujarat Board 12th ARTS";
    };
    document.getElementById("Gujarat Board 12th COM.").onclick = (e) => {
      document.getElementById("subjDiv").classList.remove("active");
      document.getElementById("formDiv").classList.add("active");
      document.getElementsByName("subject")[0].value = "Gujarat Board 12th COM.";
    };
    document.getElementById("Gujarat Board 12th SCI.").onclick = (e) => {
      document.getElementById("subjDiv").classList.remove("active");
      document.getElementById("formDiv").classList.add("active");
      document.getElementsByName("subject")[0].value = "Gujarat Board 12th SCI.";
    };
    document.getElementsByClassName("back")[0].onclick = (e) => {
      document.getElementById("subjDiv").classList.add("active");
      document.getElementById("formDiv").classList.remove("active");
      document.getElementsByName("subject")[0].value = "";
    };

    document.getElementById("StuDetail").onsubmit = (e) => {
      const form = document.forms["StuDetail"];
      if (form["Name"].value.trim() === "") {
        alert("Name must be filled out");
        return false;
      }
      if (form["Mobile"].value.length < 10) {
        alert("Please Enter a valid Mobile Number");
        return false;
      }
      if (form["ParentMobile"].value.length < 10) {
        alert("Please Enter a valid Parent's Mobile Number");
        return false;
      }
      if (form["Medium"].value === "") {
        alert("Please Select a Medium");
        return false;
      }
      if (form["std"].value === "") {
        alert("Please Select a Medium");
        return false;
      }
      if (form["School"].value === "") {
        alert("Please Enter a School Name");
        return false;
      }
      
      // if (/[a-dA-D]-[0-9]{7}$/.test(form["BoardSeat"].value)) {
      //   alert("Please Enter a valid Gujcet Seat Number");
      //   return false;
      // }
    };
  </script>
</body>

</html>