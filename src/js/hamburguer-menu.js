

document.addEventListener('DOMContentLoaded', function () {
    initHamburguerMenu();
    initLinkers();
});

function initLinkers() {
    const linkers = document.querySelectorAll('.linker');
    // Add click event to all linkers, if the linker is clicked, the menu will be hidden
    // only if the window width is less than 768px
    linkers.forEach(linker => {
        linker.onclick = function () {
            if (window.innerWidth < 768) {
                document.querySelector('.controls-container').classList.remove('show');
            }
        };
    });
}

function initHamburguerMenu() {
    const menu = document.querySelector('.burger-menu');
    const menuList = document.querySelector('.controls-container');
    if (menu) {
        menu.onclick = function () {
            menuList.classList.toggle('show');

            if (menuList.classList.contains('show')) {
                //Set the class sticky to the header only if the header is not sticky and the window.scrollY is 0
                if (!document.querySelector('.nav').classList.contains('sticky') && window.scrollY == 0) {
                    document.querySelector('.nav').classList.add('sticky');
                    
                }
                // Block the scroll when the menu is open and the window width is less than 768px
                document.body.style.overflow = 'hidden';

            }
            else{
                //Remove the class sticky from the header only if the header is sticky and the window.scrollY is 0
                if (document.querySelector('.nav').classList.contains('sticky') && window.scrollY == 0) {
                    document.querySelector('.nav').classList.remove('sticky');
                }

                // Allow the scroll when the menu is closed
                document.body.style.overflow = 'auto';
            }
        };
    }

    // Function to handle window resize
    function handleResize() {
        let windowWidth = window.innerWidth;
        if (windowWidth >= 768) {
            menuList.classList.add('show');
        } else {
            menuList.classList.remove('show');
        }
    }

    // Initial check
    handleResize();

    // Add resize event listener
    window.addEventListener('resize', handleResize);
}