  <style>
    #workshop-popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        max-width: 90%;
        background: #fff;
        padding: 15px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        /* shadow-md */
        border-radius: 8px;
        text-align: center;
        z-index: 9999;
    }

    #workshop-popup img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
    }

    #workshop-popup p {
        font-size: 14px;
        margin-top: 10px;
    }

    #workshop-popup button {
        border: none;
        background: #f44336;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 8px;
    }
     /* Popup container */
    #fdp-popup {
        /* display: none;  */
        /* Initially hidden */
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 320px;
        max-width: 90%;
        background: linear-gradient(135deg, #ba2a21, #e6392b);
        /* red gradient matching your site */
        /* Attractive gradient */
        color: #fff !important;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        text-align: center;
        z-index: 9999;
        font-family: 'Arial', sans-serif;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.5s ease;
    }

    /* Popup visible state */
    #fdp-popup.show {
        transform: translateY(0);
        opacity: 1;
    }

    #fdp-popup p {
        font-size: 15px;
        margin: 0 0 10px 0;
        color: #fff;
    }

    #fdp-popup a.cta-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #fff;
        /* white button */
        color: #ba2a21;
        /* red text */
        font-weight: bold;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #fdp-popup a.cta-btn:hover {
        background: #f2f2f2;
        transform: scale(1.05);
    }

    #fdp-popup button {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 16px;
        position: absolute;
        top: 8px;
        right: 10px;
        cursor: pointer;
        font-weight: bold;
    }
    </style>

<script>
    function showFdpPopup() {
        const popup = document.getElementById("fdp-popup");
        if (popup) popup.classList.add("show");
    }

    function hideFdpPopup() {
        const popup = document.getElementById("fdp-popup");
        if (popup) popup.classList.remove("show");
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Show popup after 2 seconds
        setTimeout(showFdpPopup, 2000);
    });
    </script>
    
      <script>
    function showPopup() {
        let popup = document.getElementById("workshop-popup");
        if (popup) {
            popup.style.display = "block";
        }
    }

    function hidePopup() {
        let popup = document.getElementById("workshop-popup");
        if (popup) {
            popup.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // setTimeout(showPopup, 5000); // Show popup after 5 seconds automatically

        // Add event listener to Show Popup button
        document.getElementById("show-popup-btn").addEventListener("click", showPopup);
    });
    </script>


