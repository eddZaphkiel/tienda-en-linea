

// Take the toogle button from the DOM, and if its checked, set the theme to dark, otherwise set it to light
// The theme is switched by adding the class 'light' to the element .animated-background
// and removing it when the theme is dark, also i will be adding another classes
// in the future for the configuration of the theme

const switchTheme = () => {
    const toggle = document.getElementById('theme-toggle');
    const body = document.querySelector('body');
    const animatedBackground = document.querySelector('.animated-background');
    
    toggle.addEventListener('change', () => {
        if (toggle.checked) {
            animatedBackground.style.transition = 'clip-path 1s ease-in-out';
            animatedBackground.classList.add('light');
            body.classList.add('light-mode');
        } else {
            animatedBackground.style.transition = 'clip-path 1s ease-in-out';
            animatedBackground.classList.remove('light');
            body.classList.remove('light-mode');
        }
    });
}

// Set the theme based on the user preferences
const setTheme = () => {
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: light)');
    const toggle = document.getElementById('theme-toggle');
    const body = document.querySelector('body');
    const animatedBackground = document.querySelector('.animated-background');
    // Remove the time transition for the animated background
    animatedBackground.style.transition = 'none';

    if (prefersDarkScheme.matches) {
        animatedBackground.classList.add('light');
        body.classList.add('light-mode');
        toggle.checked = true;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    setTheme();
    switchTheme();
});