<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <?php include '../include/importcss.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
           
            padding: 0;
          
        }
        
        html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

main {
    flex: 1;
}

footer {
    background-color: #ba2a21; /* Footer background color */
    color: #fff;
    padding: 20px;
    text-align: center;
}

        header, footer {
            background-color: #ba2a21; /* Header and Footer background color */
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .hero {
            background: url('https://gmiu.edu.in/gmiu/website_assets/images/clg%20bg%20new.webp') no-repeat center center/cover;
            height: 300px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .card {
            /*margin: 20px;*/
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
            text-align: center;
        }
        .card-link {
            text-decoration: none;
            color: #ba2a21; /* Card link color */
        }
        .card-link:hover {
            color: #007BFF; /* Hover color */
        }
        .card i {
            font-size: 40px;
            color: #ba2a21; /* Icon color */
        }
        footer {
            position: relative;
            bottom: 0;
            /*width: 100%;*/
        }
    </style>
    <title>360 Virtual Tour</title>
</head>
<body>
    <header>
        <h1>Gyanmanajari Innovative University</h1>
        <nav>
            <!-- Navigation links -->
        </nav>
    </header>

    <!--<div class="hero">-->
    <!--    <h1>Explore Our Campus</h1>-->
    <!--    <p>Take a virtual tour and discover our facilities.</p>-->
    <!--</div>-->

    <main>
       <!--<div class="container">-->
       <!--     <?php  //include '../post/tkm2k5.php'; ?>-->
       <!--</div>-->
        <div class="card">
            <a href="https://gmiu.edu.in/gmiu/website/campus/360_virtual_tour.php" class="card-link">
                <i class="fa fa-street-view"></i>
                <h2>360 Virtual Tour</h2>
                <p>Explore our campus in 360 degrees.</p>
            </a>
        </div>
        <div class="card">
            <a href="#" class="card-link">
                <i class="fa fa-app"></i>
                <h2>Our App</h2>
                <p>Download our app for more features.</p>
            </a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 GMIU. All rights reserved.</p>
    </footer>
</body>
</html>
