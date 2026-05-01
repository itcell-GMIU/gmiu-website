  
       

        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const mobile = document.getElementById('mobile').value.trim();

            // Validate name
            if (name.length < 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Name',
                    text: 'Please enter a valid name with at least 2 characters.',
                    confirmButtonColor: '#dc2626',
                });
                return false;
            }

            // Validate email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address.',
                    confirmButtonColor: '#dc2626',
                });
                return false;
            }

            // Validate mobile number (Indian format)
            const mobilePattern = /^[6-9]\d{9}$/;
            if (!mobilePattern.test(mobile)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Mobile Number',
                    text: 'Please enter a valid 10-digit mobile number.',
                    confirmButtonColor: '#dc2626',
                });
                return false;
            }

            return true;
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add interactive hover effects for cards
        document.querySelectorAll('.interactive-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                if (window.innerWidth > 768) { // Only on desktop
                    this.style.transform = 'perspective(1000px) rotateY(5deg) translateZ(50px)';
                }
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateY(0deg) translateZ(0px)';
            });
        });

        // Lazy loading for iframes
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const iframe = entry.target.querySelector('iframe');
                    if (iframe && !iframe.src) {
                        iframe.src = iframe.dataset.src;
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.video-card').forEach(card => {
            observer.observe(card);
        });

        // Image error handling with retry
        function retryImageLoad(img, retries = 3) {
            if (retries > 0) {
                setTimeout(() => {
                    img.src = img.src; // Retry loading
                    retries--;
                }, 1000);
            }
        }

        // Enhanced image loading
        document.addEventListener('DOMContentLoaded', function() {
            const heroImage = document.querySelector('.compact-image');
            if (heroImage) {
                heroImage.addEventListener('error', function() {
                    retryImageLoad(this, 2);
                });

                heroImage.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            }
        });

        // Add loading animation for form submission
        document.getElementById('popupForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
            submitBtn.disabled = true;

            // Re-enable button after 3 seconds in case of error
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Keyboard accessibility for modal
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('myModal');
            if (e.key === 'Escape' && modal.style.display === 'block') {
                modal.style.display = 'none';
            }
        });

        // Performance optimization: Preload critical resources
        function preloadResources() {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'script';
            link.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            document.head.appendChild(link);
        }

        // Call preload after page load
        window.addEventListener('load', preloadResources);

        // Add animation to floating shapes based on scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.floating-shape');
            shapes.forEach((shape, index) => {
                const speed = 0.5 + (index * 0.1);
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Add entrance animation for content sections
        const animateOnScroll = () => {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (sectionTop < windowHeight - 100) {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }
            });
        };

        // Initialize sections with hidden state
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
