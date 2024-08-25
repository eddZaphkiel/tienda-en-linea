let list = document.querySelector('.slider .slider_slides');
let items = document.querySelectorAll('.slider .slider_slides .slide');
let dots = document.querySelectorAll('.slider .slider_dots li');
let prev = document.getElementById('prev');
let next = document.getElementById('next');

let active = 0;
let lengthItems = items.length -1;

next.onclick = ()=>{
    if(active + 1 > lengthItems){
        active = 0;
    }
    else{
        active++;
    }
    reloadSlider();
}

prev.onclick = ()=>{
    if(active - 1 < 0){
        active = lengthItems;
    }
    else{
        active--;
    }
    reloadSlider();
}

let refreshSlider = setInterval(()=>{
    next.click();
}, '6000');

function reloadSlider(){
    let checkLeft = items[active].offsetLeft;
    list.style.left = -checkLeft + 'px';

    let lastActiveDot = document.querySelector('.slider .slider_dots li.active');
    lastActiveDot.classList.remove('active');
    dots[active].classList.add('active');
    clearInterval(refreshSlider);
    refreshSlider = setInterval(()=>{
        next.click();
    }, '6000');
}

dots.forEach((li, key) =>{
    li.addEventListener('click', 
        ()=>{
            active = key;
            reloadSlider();
        }
    )
});