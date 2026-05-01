// ==================
// news slider js 
// ==================
            //popup modal news slide js
            function onClick(element) {
                document.getElementById("img01").src = element.src;
                document.getElementById("modal01").style.display = "block";
            }


// ==================
// YT slider js 
// ==================
// Get the DOM elements for the image carousel
const wrapper = document.querySelector(".wrapper"),
    carousel = document.querySelector(".carousel"),
    images = document.querySelectorAll("iframe"),
    buttons = document.querySelectorAll(".button");

let imageIndex = 0,
    intervalId;

// Define function to start automatic image slider
const autoSlide = () => {
    // Start the slideshow by calling slideImage() every 2 seconds
    intervalId = setInterval(() => slideImage(++imageIndex), 2000);
};
// Call autoSlide function on page load
autoSlide();

// A function that updates the carousel display to show the specified image
const slideImage = () => {
    // Calculate the updated image index
    imageIndex = imageIndex === images.length ? 0 : imageIndex < 0 ? images.length - 1 : imageIndex;
    // Update the carousel display to show the specified image
    carousel.style.transform = `translate(-${imageIndex * 85}%)`;
};

// A function that updates the carousel display to show the next or previous image
const updateClick = (e) => {
    // Stop the automatic slideshow
    clearInterval(intervalId);
    // Calculate the updated image index based on the button clicked
    imageIndex += e.target.id === "next" ? 1 : -1;
    slideImage(imageIndex);
    // Restart the automatic slideshow
    autoSlide();
};

// Add event listeners to the navigation buttons
buttons.forEach((button) => button.addEventListener("click", updateClick));

// Add mouseover event listener to wrapper element to stop auto sliding
wrapper.addEventListener("mouseover", () => clearInterval(intervalId));
// Add mouseleave event listener to wrapper element to start auto sliding again
wrapper.addEventListener("mouseleave", autoSlide);


// ====================
// testimonial slider js 
// =======================
// Initialize the slider
const slider = document.querySelector('.slider-test');
let isDown = false;
let startX;
let scrollLeft;

// Set the auto slide duration
const autoSlideDuration = 1000; // in milliseconds

// Function to slide to the next testimonial
function slideNext() {
    const currentTestimonial = slider.querySelector('.testimonial-test.active');
    const nextTestimonial = currentTestimonial.nextElementSibling || slider.firstElementChild;
    currentTestimonial.classList.remove('active');
    nextTestimonial.classList.add('active');
    slider.scrollLeft += nextTestimonial.getBoundingClientRect().left - slider.getBoundingClientRect().left;
}

// Set up the auto slide interval
let autoSlideInterval = setInterval(slideNext, autoSlideDuration);

// Event listeners for mouse/touch interaction
slider.addEventListener('mousedown', (e) => {
    clearInterval(autoSlideInterval);
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
});

slider.addEventListener('touchstart', (e) => {
    clearInterval(autoSlideInterval);
    isDown = true;
    startX = e.touches[0].pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseup', () => {
    autoSlideInterval = setInterval(slideNext, autoSlideDuration);
    isDown = false;
});

slider.addEventListener('touchend', () => {
    autoSlideInterval = setInterval(slideNext, autoSlideDuration);
    isDown = false;
});

slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2;
    slider.scrollLeft = scrollLeft - walk;
});

slider.addEventListener('touchmove', (e) => {
    if (!isDown) return;
    const x = e.touches[0].pageX - slider.offsetLeft;
    const walk = (x - startX) * 2;
    slider.scrollLeft = scrollLeft - walk;
});



$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }
        }]
    });
});


// head slider 
// ===========

var responsiveSlider = function() {

    var slider = document.getElementById("slider-head");
    var sliderWidth = slider.offsetWidth;
    var slideList = document.getElementById("slideWrap-head");
    var count = 1;
    var items = slideList.querySelectorAll("li").length;
    var prev = document.getElementById("prev-head");
    var next = document.getElementById("next-head");

    window.addEventListener('resize', function() {
        sliderWidth = slider.offsetWidth;
    });

    var prevSlide = function() {
        if (count > 1) {
            count = count - 2;
            slideList.style.left = "-" + count * sliderWidth + "px";
            count++;
        } else if (count = 1) {
            count = items - 1;
            slideList.style.left = "-" + count * sliderWidth + "px";
            count++;
        }
    };

    var nextSlide = function() {
        if (count < items) {
            slideList.style.left = "-" + count * sliderWidth + "px";
            count++;
        } else if (count = items) {
            slideList.style.left = "0px";
            count = 1;
        }
    };

    next.addEventListener("click", function() {
        nextSlide();
    });

    prev.addEventListener("click", function() {
        prevSlide();
    });

    setInterval(function() {
        nextSlide()
    }, 5000);

};

window.onload = function() {
    responsiveSlider();
}


// plc 
