const click = document.querySelector('.profile');
const closebtn = document.querySelector('.close-img');
const popupclose = document.querySelector('.popup-close');

click.addEventListener('click', () => {
    document.querySelector(".popup").classList.remove('hide');
    document.querySelector(".products-container").classList.add('popup-on');
});

closebtn.addEventListener('click', () =>{
    document.querySelector(".popup").classList.add('hide');
    document.querySelector(".products-container").classList.remove('popup-on');
});

popupclose.addEventListener('click', () =>{
    document.querySelector(".popup").classList.add('hide');
    document.querySelector(".products-container").classList.remove('popup-on');
});