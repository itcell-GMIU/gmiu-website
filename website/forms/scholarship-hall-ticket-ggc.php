<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Ticket | Admit Card | Gyanmanjari Innovative University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">

    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 20px;
        }

        /* MOBILE + DEFAULT VIEW */
        .a4-wrapper {
            overflow-x: auto;
            /* Scroll horizontally on phones */
            padding: 15px;
        }

        /* MOBILE + DEFAULT VIEW */
        /* SAME A4 LOOK ON MOBILE AND PC */
        .a4-page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            border: 1px solid #aaa;
            box-sizing: border-box;
        }


        /* DESKTOP VIEW: FIXED A4 SIZE */
        @media (min-width: 992px) {
            /*.a4-page {*/
            /*    width: 210mm;*/
            /*    min-height: 297mm;*/
            /*    margin: 0 auto;*/
                /* Center */
            /*    padding: 15mm;*/
                /* Realistic A4 inner padding */
            /*    border: 1px solid #000;*/
            /*    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);*/
            /*}*/

           .a4-wrapper {
                overflow-x: auto;
                padding: 10px;
            }
            body {
                background: #e8e8e8;
            }
        }

        /* FORCE TRUE A4 PRINTING */
        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            .d-print-none {
                display: none !important;
            }

            /* FIX: REMOVE BOOTSTRAP PADDING */
            .container {
                margin: 0 !important;
                padding: 0 !important;
                max-width: none !important;
                /* prevents width squeezing */
            }

            .a4-wrapper {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            .a4-page {
                width: 210mm !important;
                height: 297mm !important;
                padding: 12mm 15mm !important;
                border: 3px solid black !important;
                box-shadow: none !important;
                margin: 0 auto !important;
                page-break-after: always;
            }

            .print-none {
                display: none !important;
            }
        }
@media print {
    a {
        color: #000 !important;
        text-decoration: underline;
        word-break: break-all;
    }
}



        /* Photograph box */
        .photograph-box {
            width: 135px;
            height: 172px;
            flex-shrink: 0;
            font-size: 0.8em;
        }

        /* Table Border Fix */
        .table-bordered {
            border: 1px solid #000 !important;
        }

        .table-bordered td {
            border-color: #000 !important;
        }
    </style>

</head>

<body>

    <?php

    // Get mobile from GET
$mobile = trim($_GET['mobile'] ?? '');

if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
    $mobile = '';
}

   
 
    $students = [
    
        // -------- GIRLS COLLEGE DATA --------
    
        // "1234567891" => "MANSI M",
        // "7016115444" => "KHORAJIYA SUMAIYA SIDIKBHAI",
        // "7046638193" => "MALEK UMMESULEM",
        // "7046911081" => "VAGH MAMTA DHIRUBHAI",
        // "6354350300" => "AKHSA A MITHANI",
        // "9979193623" => "GOHIL KRISHNA SURESHBHAI",
        // "9574363635" => "ANSARI AFSANA KHATUN MAJHARBHAI",
        // "6354909087" => "MAKWANA MAHENUR IRFANBHAI",
        // "9638932225" => "GOHIL URVASHIBA VAJUBHAI",
        // "8128272780" => "SOLANKI JANVI DINESHBHAI",
        // "9904049495" => "BAMBHANIYA URVASHI MEHULBHAI",
        // "7984828466" => "MAKAWANA KUNJAN J.",
        // "8469468416" => "JETHAVA SEJALBEN BUDHABHAI",
        // "9725925838" => "GOHIL SONALBA VAKUBHAI",
        // "9714327254" => "MAKAWANA HINA VINODBHAI",
        // "6351853839" => "MAHETA AYUSHI KIRANKUMAR",
        // "7016358135" => "SARVAIYA SNEHA LAVJIBHAI",
        // "9428753466" => "DEGADA MAYURI RAJESHBHAI",
        // "8734940785" => "VAVADIYA KOMAL DHANJIBHAI",
        // "9173185785" => "VANKANI SURBHI CHIMANBHAI",
        // "8153848512" => "PARAKARA MIRALI SANJAYBHAI",
        // "9484490633" => "JOLIYA KARUA",
    
        // "9737903280" => "REKHABEN NAGAJIBHAI CHAUDHARY",
        // "9726880810" => "PRITIBEN HIMATABHAI BAMANIYA",
        // "9737645704" => "NEHABEN DHIRABHAI MER",
        // "9727285637" => "DHARATIBEN KHUSHALBHAI PARAMAR",
        // "9737062942" => "NIDHI LAVAJIBHAI SARESA",
        // "9737400962" => "VISHWA VIJAYBHAI DABHI",
        // "9727182138" => "KAVITA HARAKHJIBHAI DUMRALIYA",
        // "7383242943" => "PANDYA POOJA KANUBHAI",
        // "9714504044" => "VAGHELA SHRADDHA DILIPBHAI",
        // "6351597287" => "BAVALIYA MANISHA MAKABHAI",
        // "9265453983" => "GOHIL KINJAL MAGANBHAI",
        // "7572830936" => "SARVAIYA KOMAL PANCHABHAI",
        // "7623906373" => "KANTARIYA PRIYANKA VINUBHAI",
        // "9925273668" => "DHEMELIYA NIKITA M.",
        // "9023842127" => "KHASIYA DIVYA KALUBHAI",
        // "9924094832" => "GOHIL BHUMI LALABHAI",
        // "8000181772" => "BARAIYA HIRAL RATABHAI",
        // "9428058483" => "SOLANKI URVASHIBEN ANANDBHAI",
        // "9157703982" => "SHIYAL RUSHITA JIVANBHAI",
        // "9428856771" => "DAVE MITAL BATUKBHAI",
        // "9825837536" => "DHAPA PAYLA BUDHABHAI",
        // "9723048712" => "DHAPA KOMAL RAGHAVBHAI",
        // "9727055887" => "DIPIKABEN MAHESHBHAI CHAUHAN",
        // "9762238739" => "JIYA ANIL PITRODA",
        // "9737230675" => "SHIVANIBEN MAHESHBHAI VASAVA",
        // "9773226602" => "TANVI DHIRAJBHAI RATHOD",
        // "9726924550" => "BHAVYA ASHVINBHAI KANZARIYA",
        // "9737140103" => "KESHARBEN BHAGVANBHAI PARMAR",
        // "9770230069" => "SAVITA KAMLESHBHAI MOURY",
        // "9726821129" => "DIMPALBA JITENDRASINH PADHIYAR",
        // "9726847515" => "ANITA VAGHAJIBHAI KAMIJALIYA",
        // "9727511290" => "KRISHNA YAGNESHBHAI MAHETA",
        // "9727565285" => "MAHEK RAJESHBHAI PANSURIYA",
        // "9727391075" => "AKHAMBEN SOMABHAI DAMOR",
        // "9727414269" => "LAJINABANU MUSTAKKHAN PATHAN",
        // "9737382977" => "BHAGVATI MUKESHBHAI RAGHAVANI",
        // "9925965108" => "PRAJAPATI RIDHHI MAVAJIBHAI",
        // "9737960436" => "KOMALBEN ARJUNSINH MAHIDA",
        // "9727561099" => "ROSHANIBEN BABUBHAI BHABHOR",
        // "9727692281" => "DAKSHABEN PREMABEN DAMOR",
        // "9737538070" => "DIPALIBEN JITESHBHAI SARVAIYA",
        // "9737426321" => "GOPIBEN BHARATBHAI VAGHELA",
        // "9737239901" => "KHUSHI CHIRAGBHAI MODI",
        // "9727191019" => "KINJALBEN MADUBHAI MAVI",
        // "9724635918" => "RATHOD PUNAM RAJUBHAI",
        // "9537101713" => "PARMAR ANITA B.",
        // "9924968650" => "DABHI RENUKA RAJUBHAI",
        // "9737538849" => "MAKWANA VAISHALI NILESHBHAI",
        // "7043928502" => "SOLANKI ROSHNI JAGDISHBHAI",
        // "9714371947" => "CHAUHAN SHVETA SURESHBHAI",
        // "9033751818" => "SAKARIYA TULSI BATUKBHAI",
        // "9924874628" => "CHAVDA PRIYANKA JIVABHAI",
        // "8401838239" => "MAKWANA PRIYA MAGANBHAI",
        // "9601136967" => "MAKWANA TRUPATI DIPAKBHAI",
        // "9737411281" => "VAGHELA HETAL HIMATBHAI",
        // "9727865093" => "BANSHIBEN KISHOR KHETANI",
        // "9737474227" => "MUSKAN ASLAMBHAI LULANIYA",
        // "9727599260" => "KAVYA MANISHBHAI RAJPOPAT",
        // "8347495938" => "MAKAWANA DAYA MANJIBHAI",
        // "8674033160" => "BHALIYA PRIYANKA DHIRUBHAI",
        // "9724288978" => "JADAV CHANDANI HARESHBHAI",
        // "7874130279" => "BAMBHANIYA ASMITA NATUBHAI",
        // "9537183276" => "CHUDASAMA DAYA SHAILESHBHAI",
        // "9725508358" => "BHIL PAYAL B.",
        // "8128214801" => "CHAVADA PUJA RANCHOBHAI",
        // "9023942008" => "MAKWANA BHARATIBEN MANSUKHBHAI",
        // "9313214042" => "CHAUHAN VANITABEN VALAJIBHAI",
        // "9998333226" => "SHIYAL ALPA RAJUBHAI",
        // "9328292633" => "PARMAR NIRALI HARESHBHAI",
        // "9773208120" => "MIRALEE SANJAYBHAI PARAKARA",
        // "7383847133" => "BAMBHANIYA SHITAL ANANDBHAI",
        // "9574450046" => "MAKAWANA RUSHITA SURESHBHAI",
        // "7698181544" => "BAMBHANIYA SNEHA MUKESHBHAI",
        // "9974571618" => "RATHOD DHARMIKABA PRAVINBHAI",
        // "9925581029" => "BHALIYA BHUMIKABEN RAMESHBHAI",
        // "7567108992" => "MAKAWANA DHARA JIVANBHAI",
        // "9714340614" => "BAMBHANIYA AARTI JAYANTIBHAI",
        // "9727748358" => "JAGRUTI HIMATBHAI VEGAD",
        // "9724261915" => "CHAUHAN RINKAL TEJABHAI",
        
        //03-01-2026
        
         "9737903280" => "REKHABEN NAGAJIBHAI CHADHARY",
        "9726880810" => "PRITIBEN HIMATABHAI BAMANIYA",
        "9727285637" => "DHARATIBEN KHUSHALBHAI PARAMAR",
        "9737062942" => "NIDHI LAVAJIBHAI SARESA",
        "6351597287" => "BAVALIYA MANISHA MAKABHAI",
        "9265453983" => "GOHIL KINJAL MAGANBHAI",
        "7572830936" => "SARVAIYA KAMAL PANCHABHAI",
        "7623906373" => "KANTARIYA PRIYANKA VINUBHAI",
        "9925273668" => "DHEMELIYA NIKITA M",
        "9023842127" => "KHASIYA DIVYA KALUBHAI",
        "9428058483" => "SOLANKI URVASHIBEN ANANDBHAI",
        "9157703982" => "SHIYAL RUSHITA JIVANBHAI",
        "9723048712" => "DHAPA KOMAL RAGHAVBHAI",
        "9727055887" => "DIPIKABEN MAHESHBHAI CHAUHAN",
        "9726821129" => "DIMPALBA JITENDRASINH PADHIYAR",
        "9726847515" => "ANITA VAGHAJIBHAI KAMIJALIYA",
        "9727391075" => "AKHAMBEN SOMABHAI DAMOR",
        "9737382977" => "BHAGVATI MUKESHBHAI RAGHAVANI",
        "9737960436" => "KOMALBEN ARJUNSINH MAHIDA",
        "9727692281" => "DAKSHABEN PREMABEN DAMOR",
        "9737538070" => "DIPALIBEN JITESHBHAI SARVAIYA",
        "9737426321" => "GOPIBEN BHARATBHAI VAGHELA",
        "9727191019" => "KINJALBEN MADUBHAI MAVI",
        "9724635918" => "RATHOD PUNAM RAJUBHAI",
        "9537101713" => "PARMAR ANITA B.",
        "9924968650" => "DABHI RENUKA RAJUBHAI",
        "9737538849" => "MAKWANA VAISHALI NILESHBHAI",
        "9714371947" => "CHAUHAN SHVETA SURESHBHAI",
        "8401838239" => "MAKWANA PRIYA MAGANBHAI",
        "9601136967" => "MAKWANA TRUPATI DIPAKBHAI",
        "9737474227" => "MUSKAN ASLAMBHAI LULANIYA",
        "8674033160" => "BHALIYA PRIYANKA DHIRUBHAI",
        "9724288978" => "JADAV CHANDANI HARESHBHAI",
        "9537183276" => "CHUDASAMA DAYA SHAILESHBHAI",
        "9725508358" => "BHIL PAYAL B.",
        "8128214801" => "CHAVADA PUJA RANCHOBHAI",
        "9313214042" => "CHAUHAN VANITABEN VALAJIBHAI",
        "9998333226" => "SHIYAL ALPA RAJUBHAI",
        "7698181544" => "BAMBHANIYA SNEHA MUKESHBHAI",
        "9925581029" => "BHALIYA BHUMIKABEN RAMESHBHAI",
        "7567108992" => "MAKAWANA DHARA JIVANBHAI",
        "9714340614" => "BAMBHANIYA AARTI JAYANTIBHAI",
        "9727748358" => "JAGRUTI HIMATBHAI VEGAD",
        "9724261915" => "CHAUHAN RINKAL TEJABHAI",
        "9727075904" => "BHUMIBEN RAMESHBHAI VYASH",
        "9714676829" => "MAKAWANA DIPALI RAMESHBHAI",
        "9904748713" => "GOHIL DHARA KALUBHAI",
        "9773252592" => "HINABEN YOGESHBHAI PARMAR",
        "9727788814" => "JEEL VISHANUBHAI SHRIMALI",
        "9327665152" => "DIHORA VANDANA BABUBHAI",
        "9377735754" => "DIHORA URMILA LAKHABHAI",
        "6351303529" => "DIHORA KINJAL NARESHBHAI",
        "9328245122" => "VEGAD DHARMISTHA CHAKABHAI",
        "9727258216" => "POOJA BALU SOLANKI",
        "9016262631" => "GOHIL MAHESHVARIBA LAKHUBHA",
        "9054366089" => "PARMAR DHARMISHTHA BHARATBHAI",
        "9016911384" => "MAKWANA CHHAYA R.",
        "9328423736" => "BARAIYA NANDINI HASMUKHBHAI",
        "9904450215" => "KUBAVAT POOJA HASMUKHBHAI",
        "9664662102" => "AGRAVAT DEVIKA SATISHBHAI",
        "9726882424" => "DIPALIBEN SURESHBHAI KHAMAL",
        "8140415365" => "DAYA",
        "9099123483" => "PRATHA",
    
        "9737645704" => "NEHABEN DHIRABHAI MER",
        "9737400962" => "VISHWA VIJAYBHAI DABHI",
        "7383242943" => "PANDYA POOJA KANUBHAI",
        "9714504044" => "VAGHELA SHRADDHA DILIPBHAI",
        "8000181772" => "BARAIYA HIRAL RATABHAI",
        "9428856771" => "DAVE MITAL BATUKBHAI",
        "9825837536" => "DHAPA PAYLA BUDHABHAI",
        "9762238739" => "JIYA ANIL PITRODA",
        "9737230675" => "SHIVANIBEN MAHESHBHAI VASAVA",
        "9773226602" => "TANVI DHIRAJBHAI RATHOD",
        "9726924550" => "BHAVYA ASHVINBHAI KANZARIYA",
        "9737140103" => "KESHARBEN BHAGVANBHAI PARMAR",
        "9727511290" => "KRISHNA YAGNESHBHAI MAHETA",
        "9727565285" => "MAHEK RAJESHBHAI PANSURIYA",
        "9727414269" => "LAJINABANU MUSTAKKHAN PATHAN",
        "9737239901" => "KHUSHI CHIRAGBHAI MODI",
        "9727865093" => "BANSHIBEN KISHOR KHETANI",
        "9727599260" => "KAVYA MANISHBHAI RAJPOPAT",
        "8347495938" => "MAKAWANA DAYA MANJIBHAI",
        "9974571618" => "RATHOS DHARMIKABA PRAVINBHAI",
        "9727196515" => "KRISNABEN RAMESHBHAI JAMBUCHA",
        "9737649328" => "TANISHABEN ARVIDBHAI SHEKHLIYA",
        "9898270191" => "ULVA DAYA BHUPATBHAI",
        "9376926780" => "JOSHI MAHESHVARI PRAVINBHAI",
    
        "9727182138" => "KAVITA HARAKHJIBHAI DUMRALIYA",
        "9924094832" => "GOHIL BHUMI LALABHAI",
        "9770230069" => "SAVITA KAMLESHBHAI MOURY",
        "9925965108" => "PRAJAPATI RIDHHI MAVAJIBHAI",
        "9727561099" => "ROSHANIBEN BABUBHAI BHABHOR",
        "7043928502" => "SOLANKI ROSHNI JAGDISHBHAI",
        "9033751818" => "SAKARIYA TULSI BATUKBHAI",
        "9924874628" => "CHAVDA PRIYANKA JIVABHAI",
        "9737411281" => "VAGHELA HETAL HIMATBHAI",
        "9023942008" => "MAKWANA BHARATIBEN MANSUKHBHAI",
        "7383847133" => "BAMBHANIYA SHITAL ANANDBHAI",
        "9574450046" => "MAKWANA RUSHITA SURESHBHAI",
        "7046429770" => "MAHETA PRIYANKA JERAMBHAI",
        "6354061215" => "BHATVASIYA TANISHA DILIPBHAI",
        "9726932520" => "KINJALBEN RAVIDAS VASAVA",
        "9737525164" => "VAISHALI BHARATBHAI JAMBUKIYA",
        "9727874220" => "KOMALBEN HIRABHAI BHANGRA",
    
        "7046638193" => "MALEK UMMESULEM",
        "7046911081" => "VAGH MAMTA DHIRUBHAI",
        "9979193623" => "GOHIL KRISHNA SURESHBHAI",
        "6354909087" => "MAKWANA MAHENUR IRFANBHAI",
        "9638932225" => "GOHIL URVASHIBA VAJUBHA",
        "8128272780" => "SOLANKI JANVI DINESHBHAI",
        "9904049495" => "BAMBHANIYA URVASHI MEHULBHAI",
        "7984828466" => "MAKWANA KUNJAN J.",
        "8469468416" => "JETHAVA SEJALBEN BUDHABHAI",
        "9725925838" => "GOHIL SONALBA VAKUBHA",
        "9714327254" => "MAKWANA HINA VINODBHAI",
        "6351853839" => "MAHETA AYUSHI KIRANKUMAR",
        "7016358135" => "SARVAIYA SNEHA LAVJIBHAI",
        "8734940785" => "VAVADIYA KOMAL DHANJIBHAI",
        
        // DATE 17-1-2026 
          "9737903280" => "REKHABEN NAGAJIBHAI CHADHARY",
    "9726880810" => "PRITIBEN HIMATABHAI BAMANIYA",
    "9727285637" => "DHARATIBEN KHUSHALBHAI PARAMAR",
    "9737062942" => "NIDHI LAVAJIBHAI SARESA",
    "6351597287" => "BAVALIYA MANISHA MAKABHAI",
    "9265453983" => "GOHIL KINJAL MAGANBHAI",
    "7572830936" => "SARVAIYA KOMAL PANCHABHAI",
    "7623906373" => "KANTARIYA PRIYANKA VINUBHAI",
    "9925273668" => "DHEMELIYA NIKITA M",
    "9023842127" => "KHASIYA DIVYA KALUBHAI",
    "9428058483" => "SOLANKI URVASHIBEN ANANDBHAI",
    "9157703982" => "SHIYAL RUSHITA JIVANBHAI",
    "9723048712" => "DHAPA KOMAL RAGHAVBHAI",
    "9727055887" => "DIPIKABEN MAHESHBHAI CHAUHAN",
    "9727692281" => "DAKSHABEN PREMABEN DAMOR",
    "9737538070" => "DIPALIBEN JITESHBHAI SARVAIYA",
    "9737426321" => "GOPIBEN BHARATBHAI VAGHELA",
    "9727191019" => "KINJALBEN MADUBHAI MAVI",
    "9724635918" => "RATHOD PUNAM RAJUBHAI",
    "9537101713" => "PARMAR ANITA B",
    "9924968650" => "DABHI RENUKA RAJUBHAI",
    "9737538849" => "MAKWANA VAISHALI NILESHBHAI",
    "9714371947" => "CHAUHAN SHVETA SURESHBHAI",
    "8401838239" => "MAKWANA PRIYA MAGANBHAI",
    "9601136967" => "MAKWANA TRUPATI DIPAKBHAI",
    "9737474227" => "MUSKAN ASLAMBHAI LULANIYA",
    "8674033160" => "BHALIYA PRIYANKA DHIRUBHAI",
    "9724288978" => "JADAV CHANDANI HARESHBHAI",
    "9726882424" => "DIPALIBEN SURESHBHAI KHAMAL",
    "9725508358" => "BHIL PAYAL B",
    "8128214801" => "CHAVADA PUJA RANCHOBHAI",
    "9313214042" => "CHAUHAN VANITABEN VALAJIBHAI",
    "9998333226" => "SHIYAL ALPA RAJUBHAI",
    "7698181544" => "BAMBHANIYA SNEHA MUKESHBHAI",
    "9925581029" => "BHALIYA BHUMIKABEN RAMESHBHAI",
    "7567108992" => "MAKAWANA DHARA JIVANBHAI",
    "9714340614" => "BAMBHANIYA AARTI JAYANTIBHAI",
    "9727748358" => "JAGRUTI HIMATBHAI VEGAD",
    "9724261915" => "CHAUHAN RINKAL TEJABHAI",
    "9727075904" => "BHUMIBEN RAMESHBHAI VYASH",
    "9714676829" => "MAKAWANA DIPALI RAMESHBHAI",
    "9904748713" => "GOHIL DHARA KALUBHAI",
    "9773252592" => "HINABEN YOGESHBHAI PARMAR",
    "9727788814" => "JEEL VISHANUBHAI SHRIMALI",
    "9327665152" => "DIHORA VANDANA BABUBHAI",
    "9377735754" => "DIHORA URMILA LAKHABHAI",
    "6351303529" => "DIHORA KINJAL NARESHBHAI",
    "9328245122" => "VEGAD DHARMISTHA CHAKABHAI",
    "9727258216" => "POOJA BALU SOLANKI",
    "9016262631" => "GOHIL MAHESHVARIBA LAKHUBHAI",
    "9054366089" => "PARMAR DHARMISHTHA BHARATBHAI",
    "9016911384" => "MAKWANA CHHAYA R",
    "9328423736" => "BARAIYA NANDINI HASMUKHBHAI",
    "9664662102" => "AGRAVAT DEVIKA SATISHBHAI"
    ];
    // $totalStudents = count($students);
    // echo $totalStudents;
    // Check condition
    if (array_key_exists($mobile, $students)) {

        // FOUND
        $name = $students[$mobile];

        // } else {
    
        //     // NOT FOUND
        //     $name = "";
        //     $error = "Mobile number not found.";
        // }
    
        ?>


        <div class="container my-4">

            <div class="d-flex justify-content-evenly align-items-center mb-4 d-print-none">
                <div class="form-check form-switch me-2">
                    <input class="form-check-input" type="checkbox" id="langSwitch" onchange="toggleLanguage()">
                    <label class="form-check-label" for="langSwitch" id="langLabel">English</label>
                </div>
                <div class="form-check form-switch me-2">
                    <button class="btn btn-primary" onclick="location.href='scholarship-hall-ticket.php'">Reset</button>
                </div>
                <button class="btn btn-primary btn-lg" onclick="window.print()">
                    <i class="bi bi-printer-fill me-2"></i>
                    <span id="printText">Print This Hall Ticket</span>
                </button>
            </div>
            <div class="a4-wrapper">
                <div class="a4-page">

                    <header class="text-center mb-4">
                        <h2 class="text-primary fw-bold mb-1">GYANMANJARI INNOVATIVE UNIVERSITY</h2>
                        <!--<p class="mb-4">10<sup>th</sup>/12<sup>th</sup> Standard Scholarship Examination – 2025-26</p>-->
                        <p class="mb-4">12<sup>th</sup> Standard Scholarship Examination – 2025-26</p>
                        <h3 class="bg-light p-2 border-bottom border-top border-dark">HALL TICKET / ADMIT CARD</h3>
                    </header>

                    <div class="row align-items-start">
                        <div class="col-9">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" style="width: 30%;">Name of Student</td>
                                            <td><?php echo $name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">School Name</td>
                                            <td></td>
                                        </tr>
                                       <tr>
                                            <td class="fw-bold">Exam Centre</td>
                                            <td>
                                                Gyanmanjari Girls College,<br>
                                                Samved Building, Kailasdham Society,<br>
                                                Indraprastha Nagari, Kaliyabid,<br>
                                                Bhavnagar.<br>
                                                <strong>Map:</strong>
                                                <a href="https://maps.app.goo.gl/rKrXmGuj6am4V5Ae6" target="_blank">
                                                    https://maps.app.goo.gl/rKrXmGuj6am4V5Ae6
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Exam Date</td>
                                            <td>Sunday, 18th January 2026</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Exam Time</td>
                                            <td>10:00 AM to 12:00 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reporting Time</td>
                                            <td>09:30 AM</td>
                                        </tr>
                                        <!--<tr>-->
                                        <!--    <td class="fw-bold">Subjects</td>-->
                                        <!--    <td>Mathematics, Science, GK, IQ</td>-->
                                        <!--</tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <div
                                class="photograph-box border border-dark d-flex align-items-center justify-content-center text-secondary fw-bold">
                                PHOTOGRAPH
                            </div>
                        </div>
                    </div>

                    <div class="mt-4" id="instructionsBlock">
                        <p class="fw-bold text-decoration-underline" id="instTitle">
                            Important Instructions:
                        </p>
                        <ol class="ms-3" id="instList">
                            <li>Candidate must bring this Hall Ticket to the examination hall.</li>
                            <li>Entry will not be allowed without this Admit Card and valid School ID.</li>
                            <li>Candidates must reach the centre 45 minutes before the exam time.</li>
                            <li>Use of calculators, mobile phones, or any electronic gadgets is strictly prohibited.</li>
                            <li>Answers must be written only in the provided OMR sheet or answer booklet.</li>
                            <li>Any kind of malpractice will lead to disqualification.</li>
                            <li>Preserve this card for future reference or result verification.</li>
                        </ol>
                    </div>

                    <div class="row mt-5 pt-5 text-center">
                        <div class="col-6">
                            <div class="border-bottom border-dark mx-auto" style="width: 80%; height: 1px;"></div>
                            <p class="mt-2 fw-bold">Student signature</p>
                        </div>
                        <div class="col-6">
                            <div class="border-bottom border-dark mx-auto" style="width: 80%; height: 1px;"></div>
                            <p class="mt-2 fw-bold">Parents signature</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php } else {

        if (isset($_GET['mobile']) ? $_GET['mobile'] : '') {
            echo '<div class="container d-flex justify-content-center mt-4">
                    <div class="alert alert-danger text-center" role="alert">
                        Mobile number not found. Please try with the correct number.
                    </div>
                </div>';
        }
        ?>

        <div class="container d-flex justify-content-center print-none">
            <div class="shadow-lg bg-white p-5 border border-dark rounded my-5" style="max-width: 450px; width:100%;">
                <h4 class="text-center mb-4 fw-bold">Check Hall Ticket</h4>
                <form method="GET">
                    <div class="mb-3">
                        <label for="mobile" class="form-label fw-semibold">Mobile Number</label>
                        <input type="text" class="form-control form-control-lg" id="mobile" name="mobile" minlength="10"
                            maxlength="10" pattern="\d{10}" required placeholder="Enter 10-digit mobile number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <div class="form-text text-danger d-none" id="mobileError">
                            Please enter a valid 10-digit mobile number.
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleLanguage() {
            let isGujarati = document.getElementById("langSwitch").checked;

            if (isGujarati) {
                document.getElementById("langLabel").innerText = "ગુજરાતી";
                // Button
                document.getElementById("printText").innerText = "હોલ ટિકિટ પ્રિન્ટ કરો";

                // Title
                document.getElementById("instTitle").innerText = "મહત્વપૂર્ણ સૂચનાઓ:";

                // Gujarati Instructions
                document.getElementById("instList").innerHTML = `
                <li>ઉમેદવારે પરીક્ષા ખંડમાં આ હોલ ટિકિટ લાવવી આવશ્યક છે.</li>
                <li>આ પ્રવેશપત્ર અને માન્ય શાળા ઓળખપત્ર વિના પ્રવેશ આપવામાં આવશે નહીં.</li>
                <li>ઉમેદવારોએ પરીક્ષાના સમય કરતાં 30 મિનિટ પહેલાં કેન્દ્ર પર પહોંચવું આવશ્યક છે.</li>
                <li>કેલ્ક્યુલેટર, મોબાઇલ ફોન અથવા કોઈપણ ઇલેક્ટ્રોનિક ગેજેટ્સનો ઉપયોગ સખત પ્રતિબંધિત છે.</li>
                <li>જવાબો ફક્ત આપેલ OMR શીટ અથવા ઉત્તર પુસ્તિકામાં જ લખવાના રહેશે.</li>
                <li>કોઈપણ પ્રકારની ગેરરીતિ ગેરલાયક ઠેરવવામાં આવશે.</li>
                <li>ભવિષ્યના સંદર્ભ અથવા પરિણામ ચકાસણી માટે આ કાર્ડ સાચવો.</li>
                `;

            } else {
                document.getElementById("langLabel").innerText = "English";
                // Button
                document.getElementById("printText").innerText = "Print This Hall Ticket";

                // Title
                document.getElementById("instTitle").innerText = "Important Instructions:";

                // English Instructions
                document.getElementById("instList").innerHTML = `
                <li>Candidate must bring this Hall Ticket to the examination hall.</li>
                <li>Entry will not be allowed without this Admit Card and valid School ID.</li>
                <li>Candidates must reach the centre 45 minutes before the exam time.</li>
                <li>Use of calculators, mobile phones, or any electronic gadgets is strictly prohibited.</li>
                <li>Answers must be written only in the provided OMR sheet or answer booklet.</li>
                <li>Any kind of malpractice will lead to disqualification.</li>
                <li>Preserve this card for future reference or result verification.</li>
                `;
            }
        }
    </script>

   <script>
    const mobileInput = document.getElementById("mobile");
    if (mobileInput) {
        mobileInput.addEventListener("input", function () {
            const error = document.getElementById("mobileError");
            if (this.value.length === 10) {
                error.classList.add("d-none");
            } else {
                error.classList.remove("d-none");
            }
        });
    }
</script>


</body>

</html>