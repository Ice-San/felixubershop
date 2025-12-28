const profile = document.querySelector('.profile');
const productsContent = document.querySelectorAll(".user-content");

const closebtnArray = document.querySelectorAll('.close-img');
const popupcloseArray = document.querySelectorAll('.popup-close');
const popupArray = document.querySelectorAll(".popup");

const containersSelectors = [
    '.products-container',
    '.about',
    '.footer'
];
const containersSelectorsChilds = [
    'about-flex',
    'footer-flex'
];

function getActiveContainers() {
    return containersSelectors
        .map(selector => document.querySelector(selector))
        .filter(Boolean);
}

function togglePopup(show, elem, arrayNumber) {
    const popup = popupArray[arrayNumber];

    if(arrayNumber === 1 && elem) {
        const productName = elem.querySelector(".user-title > h3").innerText;
        const productPrice = elem.querySelector(".user-left-info > p > span").innerText;
        const productStock = elem.querySelector(".user-left-info > p:last-child > span").innerText;

        document.getElementById("product-name").value = productName;
        document.getElementById("product-price").value = productPrice;
        document.getElementById("product-stock").value = productStock;
    }
    
    if (show) {
        popup?.classList.remove('hide');
    } else {
        popup?.classList.add('hide');
    }

    getActiveContainers().forEach(container => {
        if (show) {
            container.classList.add('popup-on');
            
            if(!container.classList.contains("products-container")) {
                container.classList.add("hide");
            }
            
            containersSelectorsChilds.forEach(child => {
                container.classList.remove(child); 
            });
        } else {
            container.classList.remove('popup-on');
            
            if(!container.classList.contains("products-container")) {
                container.classList.remove("hide");
            }
            
            containersSelectorsChilds.forEach(child => {
                container.classList.add(child); 
            });
        }
    });
}

profile?.addEventListener('click', () => togglePopup(true, '', 0));
closebtnArray[0]?.addEventListener('click', () => togglePopup(false, '', 0));
popupcloseArray[0]?.addEventListener('click', () => togglePopup(false, '', 0));

productsContent?.forEach(product => product.addEventListener('click', () => togglePopup(true, product, 1)));
closebtnArray[1]?.addEventListener('click', () => togglePopup(false, '', 1));
popupcloseArray[1]?.addEventListener('click', () => togglePopup(false, '', 1));