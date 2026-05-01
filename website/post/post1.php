<style>
    .swiper-pagination-bullet {
        background-color: #ba2a21;
    }

    html,
    body {
        scroll-behavior: smooth;
        padding-top: 20px;
        /* Adjust as needed */
        padding-bottom: 20px;
        /* Adjust as needed */

    }

    .see-more{
         padding: 10px 35px;
         background-color: #3572EF;
         color: #fff;
         border-radius: 30px;
    }
    .section-header h2 {
        font-size: 30px;
    }

    .unclickable {
        pointer-events: none;
    }

    #img-set {
        background-color: white;
    }

    #pad-remove {
        margin-top: 10px !important;
    }

    .reel-wrapper {
        display: flex;
        /* Allows for a horizontal layout */
        justify-content: center;
        /* Centers the videos horizontally */
        gap: 20px;
        /* Adds space between the videos */
        flex-wrap: wrap;
        /* Allows videos to wrap to the next line if needed */
    }

    .gmiu-img {
        display: block;
        margin: 0 auto;
        /* Centers the image horizontally */
        width: 90%;
        /* Adjust the percentage to your desired size */
    }

    .trausted-stu-area {
        display: flex;
        /* Use flexbox for centering */
        /*   justify-content: center; /* Center the content horizontally */
        /*  width: 100%; /* Full width for the section */
    }

    .trausted-stu-area .row {
        margin: 0 auto;
        width: 95%;
    }


    .links-card {
        display: flex;
        /* Use Flexbox for horizontal layout of cards */
        justify-content: center;
        /* Center the cards-container horizontally */
        align-items: center;
        /* Center the cards-container vertically */
        width: 100%;
        /* Set the width of the links-card to 50% */
        padding: 20px;
        /* Optional: Add padding around the section */

        background-color: #f9f9f9;
        /* Optional: Add background color to the section */
    }

    .card {

        width: 1026px;
        /* Increase the width of the card */
        height: 150px;
        /* Increase the height of the card */
    }

    /* Responsive adjustments */

    @media (max-width: 767px) {
        .card {

            width: 550px;
            /* Increase the width of the card */
            height: 150px;
            /* Increase the height of the card */
        }
    }


    @media (max-width: 480px) {

        .cards-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));

            /* Full width of the container with some padding */
        }

        .card {
            width: 100%;
            /* Full width of the container on very small screens */
            height: auto;
            /* Allow height to adjust based on content */
        }
    }

    /* Define the blinking animation */
    @keyframes blink {
        0% {
            border-color: transparent;
        }

        50% {
            border-color: red;
        }

        100% {
            border-color: transparent;
        }
    }

    /* Apply the animation to the card container */
    .blink-border {
        border: 2px solid red;
        /* Initial border settings */
        animation: blink 1s infinite;
        /* Animation settings */
    }

    /* Define the blinking shadow animation */
    @keyframes blink-shadow {
        0% {
            box-shadow: 0 0 0px black;
        }

        50% {
            box-shadow: 0 0 10px 5px black;
        }

        100% {
            box-shadow: 0 0 0px black;
        }
    }

    /* Apply the animation to the image */
    .blink-shadow {
        animation: blink-shadow 1s infinite;
    }

    @media (max-width: 768px) {
        .brochure-container {
            flex-direction: column;
            align-items: center;
        }

        .brochure-card-gmiu {
            flex: 1 1 100%;
            margin: 10px 0;
        }

        .brochure-card-gmiu .brochure-card-gmiu-content img {

            height: 250px;
            width: 250px;
        }
    }   

    .brochure-container {
        display: flex;
        justify-content: center;
        /* Adjust spacing between cards */
        align-items: center;
        /* Center vertically */
        flex-wrap: nowrap;
        /* Prevent wrapping of cards */
        width: 100%;
        /* Ensure the container is wide enough */
           }
.brochure-card-gmiu .brochure-card-gmiu-content h4 {
    height:65px;
}
    .brochure-card-gmiu .brochure-card-gmiu-content h5 {
    font-size: 15px;
    background-color: #333333;
    padding: 15px;
    display: flex;
    justify-content: center;
    color: white;
    border-radius: 0 0 10px 10px;
    margin: 0;
}
    .brochure-card-gmiu {
        display: flex;
        justify-content: center;
        /* Center content within each card */
        align-items: center;
        width: auto;
        /* Allow cards to take up necessary width */
        margin: 10px;
        /* Add some space between cards */
    }

    .brochure-card-gmiu-content {
        text-align: center;
        /* Center content horizontally */
    }

    .brochure-card-gmiu-content img {
        max-width: 100%;
        /* Ensure the image doesn't exceed the container width */
        height: auto;
        /* Maintain aspect ratio */
    }
   
</style>