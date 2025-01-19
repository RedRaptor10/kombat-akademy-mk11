let currentSlides = [];
let sliders = document.querySelectorAll('.slider');
if (sliders.length > 0) {
	sliders.forEach(() => { currentSlides.push(0); });
	createSliders();
}

function createSliders() {
    let sliders = document.querySelectorAll('.slider');

    for (let i = 0; i < sliders.length; i++) {
        let prevBtn = document.createElement('div');
        let nextBtn = document.createElement('div');
        prevBtn.classList.add('slider-prev-btn');
        nextBtn.classList.add('slider-next-btn');
        prevBtn.innerHTML = '&#10094';
        nextBtn.innerHTML = '&#10095';

        prevBtn.addEventListener('click', () => {
            switchSlide('prev', sliders[i], i);
        });
        nextBtn.addEventListener('click', () => {
            switchSlide('next', sliders[i], i);
        });

        sliders[i].append(prevBtn, nextBtn);
    }
}

function switchSlide(nav, slider, sliderIndex) {
    let slides = slider.querySelectorAll('.slide');
    let prevBtn = slider.querySelectorAll('.slider-prev-btn')[0];
    let nextBtn = slider.querySelectorAll('.slider-next-btn')[0];

    // Switch Slide
    if (nav == 'prev') {
        if (currentSlides[sliderIndex] > 0) {
            slides[currentSlides[sliderIndex]].style.left = '100%';
            slides[currentSlides[sliderIndex] - 1].style.left = '0';
            currentSlides[sliderIndex]--;
        }
    }
    else if (nav == 'next') {
        if (currentSlides[sliderIndex] < slides.length - 1) {
            slides[currentSlides[sliderIndex]].style.left = '-100%';
            slides[currentSlides[sliderIndex] + 1].style.left = '0';
            currentSlides[sliderIndex]++;
        }
    }

    // If Only 1 Slide or First or Last Slide, Hide Prev/Next Buttons
	if (slides.length == 1) {
		prevBtn.style.display = 'none';
		nextBtn.style.display = 'none';
	}
    else if (currentSlides[sliderIndex] == 0) { prevBtn.style.display = 'none'; }
    else if (currentSlides[sliderIndex] == slides.length - 1) { nextBtn.style.display = 'none'; }
    else {
        prevBtn.style.display = 'block';
        nextBtn.style.display = 'block';
    }
}