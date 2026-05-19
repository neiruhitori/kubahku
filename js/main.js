/* ============================================
   SIKUBAH - Main JavaScript
   Navigation and Interactivity
   ============================================ */

// Carousel Class
class ImageCarousel {
  constructor(container, autoPlayInterval = 5000) {
    this.container = container;
    this.wrapper = container.querySelector('.carousel-wrapper');
    this.slides = container.querySelectorAll('.carousel-slide');
    this.dots = container.querySelectorAll('.carousel-dot');
    this.prevBtn = container.querySelector('.carousel-btn.prev');
    this.nextBtn = container.querySelector('.carousel-btn.next');
    this.currentIndex = 0;
    this.autoPlayInterval = autoPlayInterval;
    this.autoPlayTimer = null;

    this.init();
  }

  init() {
    // Event listeners for prev/next buttons
    if (this.prevBtn) {
      this.prevBtn.addEventListener('click', () => this.prevSlide());
    }
    if (this.nextBtn) {
      this.nextBtn.addEventListener('click', () => this.nextSlide());
    }

    // Event listeners for dots
    this.dots.forEach((dot, index) => {
      dot.addEventListener('click', () => this.goToSlide(index));
    });

    // Start auto-play
    this.startAutoPlay();

    // Pause on hover
    this.container.addEventListener('mouseenter', () => this.stopAutoPlay());
    this.container.addEventListener('mouseleave', () => this.startAutoPlay());

    // Touch support for mobile
    this.addTouchSupport();
  }

  updateSlide() {
    // Update wrapper transform
    const offset = -this.currentIndex * 100;
    this.wrapper.style.transform = `translateX(${offset}%)`;

    // Update dots
    this.dots.forEach((dot, index) => {
      if (index === this.currentIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  nextSlide() {
    this.currentIndex = (this.currentIndex + 1) % this.slides.length;
    this.updateSlide();
    this.resetAutoPlay();
  }

  prevSlide() {
    this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
    this.updateSlide();
    this.resetAutoPlay();
  }

  goToSlide(index) {
    this.currentIndex = index;
    this.updateSlide();
    this.resetAutoPlay();
  }

  startAutoPlay() {
    if (this.slides.length > 1) {
      this.autoPlayTimer = setInterval(() => this.nextSlide(), this.autoPlayInterval);
    }
  }

  stopAutoPlay() {
    if (this.autoPlayTimer) {
      clearInterval(this.autoPlayTimer);
      this.autoPlayTimer = null;
    }
  }

  resetAutoPlay() {
    this.stopAutoPlay();
    this.startAutoPlay();
  }

  addTouchSupport() {
    let touchStartX = 0;
    let touchEndX = 0;

    this.wrapper.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, false);

    this.wrapper.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      this.handleSwipe();
    }, false);

    const handleSwipe = () => {
      if (touchEndX < touchStartX - 50) {
        this.nextSlide();
      } else if (touchEndX > touchStartX + 50) {
        this.prevSlide();
      }
    };

    this.handleSwipe = handleSwipe;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Initialize all carousels
  const carouselContainers = document.querySelectorAll('.carousel-container');
  carouselContainers.forEach(container => {
    new ImageCarousel(container, 6000); // 6 second auto-play
  });

  // Mobile Menu Toggle
  const navToggle = document.querySelector('.navbar-toggle');
  const navMenu = document.getElementById('nav-menu');
  
  if (navToggle) {
    navToggle.addEventListener('click', function() {
      navMenu.classList.toggle('active');
    });
  }
  
  // Close menu when clicking on a link
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      navMenu.classList.remove('active');
    });
  });
  
  // Close menu when clicking outside
  document.addEventListener('click', function(event) {
    const navbar = document.querySelector('.navbar');
    if (navbar && !navbar.contains(event.target)) {
      navMenu.classList.remove('active');
    }
  });
  
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});

// Add scroll effect to header
window.addEventListener('scroll', function() {
  const header = document.querySelector('.header');
  if (header) {
    if (window.scrollY > 10) {
      header.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
    } else {
      header.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
    }
  }
});

