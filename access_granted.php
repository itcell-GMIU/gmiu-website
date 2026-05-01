<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Granted</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f4f8f4;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* full screen height */
    }
    

    .content {
      flex: 1; /* take remaining space */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center; /* center logos + text */
      text-align: center;
    }

    .logo-container {
      display: flex;
      flex-direction: column; /* stack logos */
      gap: 20px;
      align-items: center;
      margin-bottom: 30px;
    }

    .logo-container img {
      height: 120px;
      max-width: 90%;
      transition: transform 0.3s ease-in-out;
    }

    .logo-container img:hover {
      transform: scale(1.05);
    }

    h1 {
      color: #2ecc71;
      font-size: 3rem;
      margin: 20px 0 0;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    footer {
      text-align: center;
      padding: 15px 10px;
      font-size: 0.9rem;
      color: #555;
      background: transparent;
    }

    /* Mobile Responsive */
    @media (max-width: 600px) {
        body {
          max-height: 100vh; /* full screen height */
          overflow-y: hidden;
        }
      .logo-container {
        gap: 15px;
        margin-bottom: 20px;
      }

      .logo-container img {
        height: 80px;
      }

      h1 {
        font-size: 2rem;
      }

      footer {
        font-size: 0.8rem;
        margin-bottom: 50px;
        
      }
    }
  </style>
</head>
<body>
  <div class="content">
    <div class="logo-container">
      <!-- GyanManjari Logo -->
      <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="GyanManjari Logo">

      <!-- RaasManjari Logo -->
      <img src="https://gmiu.edu.in/gmiu/website_assets/images/logo-raas.png" alt="RaasManjari Logo">
    </div>

    <h1>Access Granted</h1>
  </div>

  <footer>
    © 2025 GMIU & रासManjari
  </footer>
</body>
</html>
