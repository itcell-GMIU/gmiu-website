<style>
    /* ===============================
       Floating Alert – Mobile Tweaks
       =============================== */
    @media (max-width: 768px) {

        #floatingAlert {
            width: 180px !important;
            bottom: 80px !important;
            right: 12px !important;
            border-radius: 5px !important;
        }

        #floatingAlert .alert-header {
            padding: 6px 10px !important;
        }

        #floatingAlert .alert-title {
            font-size: 14px !important;
        }

        #floatingAlert .alert-body {
            padding: 8px !important;
        }

        #alertTab {
            width: 40px !important;
            height: 40px !important;
            bottom: 110px !important;
            right: 12px !important;
            font-size: 18px !important;
        }
    }
</style>

<!-- Floating Alert Widget -->
<div id="floatingAlert" style="
    position: fixed;
    bottom: 110px;
    right: 20px;
    width: 240px;
    background: #ffffff;
    border-radius: 6px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.18);
    font-family: Arial, sans-serif;
    z-index: 9999;
    transition: all 0.3s ease;
">

    <!-- Header -->
    <div class="alert-header" style="
        padding: 10px 14px;
        background: #dc3545;
        color: #fff;
        border-radius: 6px 6px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    ">
        <span class="alert-title" style="font-size: 18px; font-weight: 600;">
            GIMCA 2026
        </span>

        <span onclick="toggleAlert()" style="
            cursor: pointer;
            font-size: 18px;
        ">&times;</span>
    </div>

    <!-- Body (Clickable) -->
    <a href="https://gimca.gmiu.edu.in/" target="_blank" class="alert-body"
        style="display:block; padding:14px; text-decoration:none;">

        <img id="alertImage" src="https://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/1.png" style="
                width: 100%;
                aspect-ratio: 1 / 1;
                object-fit: cover;
                border-radius: 8px;
                transition: opacity 0.8s ease;
             ">
    </a>
</div>

<!-- Collapsed Tab -->
<div id="alertTab" onclick="toggleAlert()" style="
    position: fixed;
    bottom: 110px;
    right: 20px;
    width: 48px;
    height: 48px;
    background: #dc3545;
    color: #fff;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    z-index: 9999;
">
    🔔
</div>

<script>
    /* ===============================
       Image Slider (Fade)
       =============================== */
    const images = [
        "http://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/1.png",
        "http://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/2.png",
        "http://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/3.png",
        "http://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/4.png",
        "http://gmiu.edu.in/gmiu/website_assets/images/gimca_alert/5.png"
    ];

    let imgIndex = 0;
    const imgEl = document.getElementById("alertImage");

    setInterval(() => {
        imgEl.style.opacity = "0";
        setTimeout(() => {
            imgIndex = (imgIndex + 1) % images.length;
            imgEl.src = images[imgIndex];
            imgEl.style.opacity = "1";
        }, 400);
    }, 3000);

    /* ===============================
       Toggle Alert
       =============================== */
    function toggleAlert() {
        const alertBox = document.getElementById("floatingAlert");
        const alertTab = document.getElementById("alertTab");

        if (alertBox.style.display === "none") {
            alertBox.style.display = "block";
            alertTab.style.display = "none";
        } else {
            alertBox.style.display = "none";
            alertTab.style.display = "flex";
        }
    }

    /* ===============================
       Auto-close on Scroll
       =============================== */
    let closedOnScroll = false;
    const closeAfterScroll = 1000; // px

    window.addEventListener("scroll", () => {
        if (!closedOnScroll && window.scrollY > closeAfterScroll) {
            document.getElementById("floatingAlert").style.display = "none";
            document.getElementById("alertTab").style.display = "flex";
            closedOnScroll = true;
        }
    });
</script>