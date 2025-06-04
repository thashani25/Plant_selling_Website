const header = document.querySelector('header');
function fixedNavbar() {
    header.classList.toggle('scroll', window.pageYOffset > 0)
}
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

menu.addEventListener('click', function () {
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
});
userBtn.addEventListener('click', function () {
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
});


const leftArrow = document.querySelector(".left-arrow");
const rightArrow = document.querySelector(".right-arrow");
let currentIndex = 0;
let slideInterval = setInterval(nextSlide, 5000); // Auto-slide every 5 seconds

function showSlide(index) {
    (document.querySelectorAll(".slider-slider")).forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) {
            slide.classList.add("active");
        }
    });
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % (document.querySelectorAll(".slider-slider")).length;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + (document.querySelectorAll(".slider-slider")).length) % (document.querySelectorAll(".slider-slider")).length;
    showSlide(currentIndex);
}

// Event listeners for arrows
rightArrow.addEventListener("click", () => {
    nextSlide();
    resetInterval();
});

leftArrow.addEventListener("click", () => {
    prevSlide();
    resetInterval();
});

// Reset interval on manual slide
function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

// Initial display
showSlide(currentIndex);

/*----testimonial slider-----*/

let slides = document.querySelectorAll('.testimonial-item');
let index = 0;

function nextSlide() {
    (document.querySelectorAll(".slider-slider"))[index].classList.remove('active');
    index = (index + 1) % (document.querySelectorAll(".slider-slider")).length;
    (document.querySelectorAll(".slider-slider"))[index].classList.add('active');
}

function prevSlide() {
    (document.querySelectorAll(".slider-slider"))[index].classList.remove('active');
    index = (index - 1 + (document.querySelectorAll(".slider-slider")).length) % (document.querySelectorAll(".slider-slider")).length;
    (document.querySelectorAll(".slider-slider"))[index].classList.add('active');
}

///    tag \\

// Wait until DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    const successMsg = document.querySelector('.success-message');
    if (successMsg) {
        // Hide message after 3 seconds (3000 ms)
        setTimeout(() => {
            // Fade out effect
            successMsg.style.transition = 'opacity 0.5s ease';
            successMsg.style.opacity = '0';
            // Remove from DOM after fade out
            setTimeout(() => successMsg.remove(), 500);
        }, 3000);
    }
});



