<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Path Ways | Gyanmanjari Innovative University</title>
    <link rel="shortcut icon" href="https://gmiu.edu.in/gmiu/website_assets/images/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Background Animation */
        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
        }

        /* Image Handling */
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .blur-effect {
            filter: blur(15px);
            transition: filter 0.5s ease;
        }

        .clear-effect {
            filter: blur(0);
        }

/* Mobile: Fullscreen Vertical View for Landscape Image */
@media (max-width: 768px) {
    .image-wrapper {
        width: 100%;
        height: max-content;      /* Use full viewport height */
        overflow-y: auto;   /* Enable vertical scrolling */
        overflow-x: hidden;
        padding: 0 !important;
        display: block;
    }

    .image-container {
        /* This manually creates the 'height' needed for the scrollbar */
        /* We set it to 250% of the width to accommodate the long roadmap */
        height: 250vw; 
        width: 100vw;
        position: relative;
        background: white;
    }

    #mainImage {
        /* The image 'width' becomes the 'scroll height' */
        width: 250vw; 
        /* The image 'height' becomes the 'phone width' */
        height: 100vw; 
        
        position: absolute;
        top: 0;
        left: 0;

        /* Rotate and move it back into view */
        transform: rotate(90deg) translateY(-100vw);
        transform-origin: top left;
        
        object-fit: fill;
        max-width: none !important; /* Prevent other CSS from shrinking it */
    }
}

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }
    </style>
</head>

<body class="p-6">

    <div class="fixed top-4 left-4 z-10">
        <img src="https://gmiu.edu.in/gmiu/website_assets/images/gmiulogo.png" alt="Logo"
            class="h-12 w-auto bg-white p-2 rounded-lg shadow-md">
    </div>

    <main class="max-w-4xl mx-auto text-center mt-20">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-8 drop-shadow-lg">
            Career Path Ways
        </h1>

        <!--<div class="image-wrapper bg-black/20 rounded-2xl p-4 inline-block">-->
        <!--    <div class="image-container bg-white">-->
        <!--        <img id="mainImage" src="./img/thumbnail-techmanjari-img-b.jpg" alt="Career Roadmap"-->
        <!--            class="blur-effect">-->
        <!--    </div>-->
        <!--</div>-->
        
        <?php
// if (isset($_GET['file'])) {
//     // $filePath = './img/thumbnail-techmanjari-img.jpg'; // Path to your images folder
//     $filePath = './img/' . basename($_GET['file']);

//     if (file_exists($filePath)) {
//         // Define headers to force download
//         header('Content-Description: File Transfer');
//         header('Content-Type: image/jpg'); // Change to image/png if needed
//         header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($filePath));
        
//         // Clear buffer and read the actual file
//         flush(); 
//         readfile($filePath);
//         exit;
//     } else {
//         echo "File not found.";
//     }
// }
?>
        
<div class="image-wrapper bg-black/20 rounded-2xl p-4">
    <div class="image-container rounded-xl">
        <img id="mainImage" src="./img/thumbnail-techmanjari-img-b.jpg" 
             alt="Career Roadmap" 
             class="blur-effect">
    </div>
</div>

        <div class="mt-8">
            <button id="actionBtn" onclick="handleButtonClick()"
                class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-full shadow-xl hover:scale-105 transition-transform">
                Download Image
            </button>
            
            <a id="originalImg" href="download.php?file=CareerChart_F.jpg" class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-full shadow-xl hover:scale-105 transition-transform hidden">
               Download Original Roadmap
            </a>
        </div>
    </main>

    <div id="formModal" class="modal px-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md relative">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Unlock Career Roadmap</h2>
            <p class="text-gray-600 mb-6">Please provide your details to download the high-resolution image.</p>

            <form id="promotionalForm">
                <div class="space-y-4 text-left">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                        <input type="tel" name="mobile" required
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <button type="submit"
                    class="w-full mt-6 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                    Get Access Now
                </button>
            </form>
            <button onclick="toggleModal(false)" class="mt-4 text-gray-400 text-sm hover:underline">Close</button>
        </div>
    </div>

    <script>
        const STORAGE_KEY = 'career_form_submitted';
        const mainImage = document.getElementById('mainImage');
        const modal = document.getElementById('formModal');
        const actionBtn = document.getElementById('actionBtn');
        const clearImageUrl = './img/thumbnail-techmanjari-img.jpg'; // Actual image link

        // 1. Initial Check on Page Load
        window.onload = () => {
            if (localStorage.getItem(STORAGE_KEY)) {
                unlockImage();
            }
        };

        function toggleModal(show) {
            modal.classList.toggle('active', show);
        }

        function handleButtonClick() {
            if (localStorage.getItem(STORAGE_KEY)) {
                triggerDownload();
            } else {
                toggleModal(true);
            }
        }

        function unlockImage() {
            mainImage.src = clearImageUrl;
            mainImage.classList.remove('blur-effect');
            mainImage.classList.add('clear-effect');
            actionBtn.innerText = "Download Image";
            document.getElementById('originalImg').classList.remove('hidden');
        }

        function triggerDownload() {
            const link = document.createElement('a');
            link.href = clearImageUrl;
            link.download = './img/thumbnail-techmanjari-img.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // 2. Form Submission Logic
        document.getElementById('promotionalForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('career-path-way-api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                console.log(response);
                console.log(response.body);
                const result = await response.json();
                console.log(result);

                if (result.status === "success") {
                    // Update storage and UI
                    localStorage.setItem(STORAGE_KEY, 'true');
                    toggleModal(false);
                    unlockImage();

                    alert("Thank you! You can now download the clear image.");
                    triggerDownload();
                } else {
                    alert(result.message || "Submission failed.");
                }

            } catch (error) {
                console.error("Error:", error);
                alert("Connection error. Please try again.");
            }
        });
    </script>
</body>

</html>