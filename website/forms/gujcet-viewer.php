<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUJCET Book Viewer</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

    <!-- Turn.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.0/turn.min.js"></script>

    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: white;
        }

        /* Header */
        h1 {
            margin-bottom: 10px;
        }

        /* Flipbook */
        #flipbook {
            width: 800px;
            height: 500px;
        }

        /* Canvas pages */
        .page {
            background: white;
        }

        canvas {
            width: 100%;
            height: 100%;
        }

        /* Controls */
        .controls {
            margin-top: 15px;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 6px;
            background: #dc2626;
            color: white;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <h1>📖 GUJCET Booklet</h1>

    <div id="flipbook"></div>

    <div class="controls">
        <button onclick="prevPage()">⬅ Prev</button>
        <button onclick="nextPage()">Next ➡</button>
        <button onclick="downloadPDF()">Download PDF</button>
    </div>

    <script>
        const url = "https://gmiu.edu.in/gmiu/website_admin/uploads/bitly_post/GUJCET.pdf";

        let pdfDoc = null;

        // Load PDF
        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            pdfDoc = pdf;

            const flipbook = document.getElementById("flipbook");

            for (let i = 1; i <= pdf.numPages; i++) {

                const pageDiv = document.createElement("div");
                pageDiv.className = "page";

                const canvas = document.createElement("canvas");
                pageDiv.appendChild(canvas);

                flipbook.appendChild(pageDiv);

                pdf.getPage(i).then(function(page) {
                    const context = canvas.getContext("2d");
                    const viewport = page.getViewport({
                        scale: 1.2
                    });

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                });
            }

            // Initialize flip
            setTimeout(() => {
                $("#flipbook").turn({
                    width: 800,
                    height: 500,
                    autoCenter: true
                });
            }, 1000);

        });

        // Controls
        function nextPage() {
            $("#flipbook").turn("next");
        }

        function prevPage() {
            $("#flipbook").turn("previous");
        }

        function downloadPDF() {
            window.open(url, "_blank");
        }
    </script>

</body>

</html>