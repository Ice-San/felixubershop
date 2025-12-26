const click = document.querySelector('.profile');
const closebtn = document.querySelector('.close-img');
const popupclose = document.querySelector('.popup-close');

const popup = document.querySelector(".popup");
const containersSelectors = [
    '.products-container',
    '.about',
    '.footer'
];
const containersSelectorsChilds = [
    'about-flex',
    'footer-flex'
]

function getActiveContainers() {
    return containersSelectors
        .map(selector => document.querySelector(selector))
        .filter(Boolean);
}

click?.addEventListener('click', () => {
    popup?.classList.remove('hide');

    console.table(getActiveContainers());

    getActiveContainers().forEach(container => {
        container.classList.add('popup-on');

        if(!container.classList.contains(".products-container")) {
            container.classList.add("hide");
        }

        containersSelectorsChilds.forEach(child => {
           container.classList.remove(child); 
        });
    });
});

closebtn?.addEventListener('click', () =>{
    popup?.classList.add('hide');
    getActiveContainers().forEach(container => {
        container.classList.remove('popup-on');

        if(!container.classList.contains(".products-container")) {
            container.classList.remove("hide");
        }

        containersSelectorsChilds.forEach(child => {
           container.classList.add(child); 
        });
    });
});

popupclose?.addEventListener('click', () =>{
    popup?.classList.add('hide');
    getActiveContainers().forEach(container => {
        container.classList.remove('popup-on');

        if(!container.classList.contains(".products-container")) {
            container.classList.remove("hide");
        }

        containersSelectorsChilds.forEach(child => {
           container.classList.add(child); 
        });
    });
});