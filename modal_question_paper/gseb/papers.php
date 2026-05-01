<?php
session_start();
if (isset($_SESSION['subject'])) {
    $subject = $_SESSION['subject'];
} else {
    echo "<script> window.location = './'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gujcet Model Paperset</title>
    <script src="./jquery-3.6.0.min.js"></script>
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
            position: relative;
            background-color: #fff;
            padding: 50px 80px;
            border-radius: 20px;
            box-shadow: 6px 5px 20px 0px #000000b0;
            margin: 20px;
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s;
        }

        .btnDiv table {
            width: 100%;
        }

        button {
            background: #ff9933;
            border: none;
            padding: 10px;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            margin: 5px 0;
        }

        .back {
            position: absolute;
            top: 10px;
            left: 10px;
            width: unset;
            margin: 0;
            padding: 10px;
        }

        .cont {
            text-align: center;
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
                padding: 20px;
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
        <button class="back">Back</button>
        <div class="ldiv">
            <div class="cont">
                <h1>Gujarat Board Model Paperset <br> <?php echo $subject ?></h1>
                <div class="btnDiv">
                    <table>
                        <?php if ($subject == "Gujarat Board 12th SCI.") {
                        ?> <tr>
                                <td>Gujarati Paperset Group A</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_a_guj"><button>Download</button></a></td>
                            </tr>
                            <tr>
                                <td>English Paperset Group A</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_a_eng"><button>Download</button></a></td>
                            </tr>
                            <tr>
                                <td>Gujarati Paperset Group B</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_b_guj"><button>Download</button></a></td>
                            </tr>
                            <tr>
                                <td>English Paperset Group B</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_b_eng"><button>Download</button></a></td>
                            </tr><?php
                                } else { ?>
                            <tr>
                                <td>Gujarati Paperset</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_guj"><button>Download</button></a></td>
                            </tr>
                            <tr>
                                <td>English Paperset</td>
                                <td><a href="file.php?file=<?php echo $subject ?>_eng"><button>Download</button></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <?php
                include("./blinks.php");
                ?>
            </div>
        </div>
    </div>
    <script>
        // $("button").each((i, ele) => {
        //     if (i !== 0) {
        //         $(ele).on('click', () => {
        //             $.post("file.php", {
        //                 file: `<?php echo $subject ?>_${i==1?'guj':i==2?'eng':''}`
        //             }, function(data, status) {
        //                 if (data === 'File does not exist.') {
        //                     alert(data)
        //                 }
        //             });
        //         })
        //     }
        // })
        document.getElementsByClassName("back")[0].onclick = (e) => {
            window.location = './'
        };
    </script>
</body>

</html>