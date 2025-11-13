const swup = new Swup({
    plugins: [new SwupHeadPlugin(),new SwupSlideTheme()],
    containers: [ 'nav.main', '#swup'],

});

let tl = gsap.timeline({paused:true});

let heroHome = document.querySelector('.hero-home');
let lastMouseX = 0;
let lastMouseY = 0;
const sensitivity = 0.03;
const maxImages = 5;
const slideshowMobile = 4000;
const imagesArray = [];
let scaleFactor = 6;

function init() {
    //console.log('hello');


    //video loading
    const videos = document.querySelectorAll("video");
    videos.forEach((video) => {
        video.load();
    });



    //scrollspy
    let footer = document.getElementById("fm");
    var section = document.querySelectorAll("footer");
    var sections = {};
    var i = 0;

    Array.prototype.forEach.call(section, function(e) {
        sections[e.id] = e.offsetTop;
    });
    window.onscroll = function() {
        var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

        for (i in sections) {
            if (sections[i] <= scrollPosition + 500) {
                footer.classList.add('footer-expand')
            }
        }
    };



    //btn animation

    /*
    let buttons = document.querySelectorAll('.btn-main');
    buttons.forEach((button) => {
        let tween = gsap.to(button, {
            scale: 1.1,
            ease: 'none',
            paused: true,
        });

        button.addEventListener('mouseenter', () => {
            gsap.to(tween, {
                duration: 2,
                time: tween.duration(),
                ease: 'elastic.out(0.2, 0.3)'
            });
        });
        button.addEventListener('mouseleave', () => {
            gsap.to(tween, {duration: 0.1, time: 0, ease: 'none', overwrite: true});
        });
    });
     */

    //home gallery




    if (document.querySelector('.hero-home')) {
        heroHome = document.querySelector('.hero-home');

        const isMobile = /Mobi|Android/i.test(navigator.userAgent);
        if (isMobile) {
            /*
            scaleFactor = 8;
            setInterval(() => {
                let randomX = Math.random() * (heroHome.clientWidth / 1.2 ) ;
                let randomY = Math.random() * (heroHome.clientHeight / 2) + 200;

                if (randomX - 100 >= heroHome.clientWidth) {
                    randomX = randomX - 300;
                }
                createImageElement(randomX, randomY - 100);
            }, slideshowMobile);
             */
        } else {
            heroHome.addEventListener('mousemove', function(e) {
                const rect = heroHome.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;

                const diffX = Math.abs(mouseX - lastMouseX);
                const diffY = Math.abs(mouseY - lastMouseY);

                const moveThresholdX = rect.width * sensitivity;
                const moveThresholdY = rect.height * sensitivity;

                if (diffX > moveThresholdX || diffY > moveThresholdY) {
                    lastMouseX = mouseX;
                    lastMouseY = mouseY;
                    createImageElement(mouseX, mouseY);
                }
            });
        }
    }







}

//page LOAD
if (document.readyState === 'complete') {
    init();
} else {
    document.addEventListener('DOMContentLoaded', () => init());
}

swup.hooks.on('page:view', () => init());



//page saying bye
swup.hooks.on('link:click', () => {
    //vorrei far sparire le immagini

    /*
    let pageTL = gsap.timeline({});

    $('img').each(function(i, el) {
        let tel = $(el);
        pageTL.to(tel, {
            duration: 1,
            opacity: 0,
        }, '>-0.5')
    });
     */

    closeMenu();

});





function fadeIn(target) {
    gsap.to(target, {
        duration: 0.8,
        opacity: 1,
        delay: 0.5,
        stagger: 2,
    });
}

function parallaxIt(target, movementX, movementY, w) {
    gsap.to(target, {
        duration: 0.2,
        //x: (mouse.x - rect.width / 2) / rect.width * movementX,
        //y: (mouse.y - rect.height / 2) / rect.height * movementY,
        x: movementX * 90,
        y: movementY * 90,
        width: w,
    });
}


function createImageElement(x, y) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/ajax/home-imgs', true);
    xhr.onload = function() {
        if (this.status === 200) {
            const image = new Image();
            let baseURL = window.location.href;
            if (baseURL.includes('/index.php')) {
                baseURL = baseURL.replace('/index.php', '');
            }
            if (baseURL.endsWith('/')) {
                baseURL = baseURL.slice(0, -1);
            }
            const imagePath = this.responseText.startsWith('/') ? this.responseText.slice(1) : this.responseText;
            image.src = `${baseURL}/${imagePath}`;

            image.onload = function() {
                // Crea un contenitore per l'immagine
                const container = document.createElement('div');
                container.style.position = 'absolute';
                container.style.overflow = 'hidden';
                container.style.width = (image.naturalWidth / scaleFactor) + 'px';
                container.style.height = (image.naturalHeight / scaleFactor) + 'px';
                image.style.zIndex = '1';

                // Posiziona il contenitore centrato rispetto al cursore
                const centerX = x - (image.naturalWidth / scaleFactor / 2);
                const centerY = y - (image.naturalHeight / scaleFactor / 2);
                container.style.left = centerX + 'px';
                container.style.top = centerY + 'px';

                // Posiziona l'immagine fuori dal contenitore (sulla sinistra)
                image.style.position = 'relative';
                image.style.opacity = '0.8';
                //image.classList.add('img-home');
                image.style.left = '-' + (image.naturalWidth / scaleFactor) + 'px'; // Fuori dal contenitore, a sinistra
                image.style.width = (image.naturalWidth / scaleFactor) + 'px'; // Ridimensiona larghezza
                image.style.height = (image.naturalHeight / scaleFactor) + 'px'; // Ridimensiona altezza
                image.style.transition = 'left 0.5s ease'; // Transizione per spostare l'immagine verso destra

                // Aggiunge l'immagine al contenitore e il contenitore al div .hero-home
                container.appendChild(image);
                heroHome.appendChild(container);

                // Attiva l'animazione di entrata dopo il rendering
                setTimeout(() => {
                    image.style.left = '0'; // Sposta l'immagine verso il centro all'interno del contenitore
                }, 15); // Breve timeout per consentire il rendering

                // Aggiungi il contenitore all'array e controlla il numero massimo di immagini
                imagesArray.push(container);
                if (imagesArray.length > maxImages) {
                    const oldContainer = imagesArray.shift(); // Rimuovi il contenitore più vecchio
                    removeImageWithAnimation(oldContainer); // Rimuovi il contenitore dal DOM
                }
            };
        }
    };
    xhr.send();
}

function removeImageWithAnimation(container) {
    const image = container.querySelector('img');

    // Animazione di uscita (sposta l'immagine fuori dal contenitore, verso destra)
    image.style.left = (image.naturalWidth / scaleFactor) + 'px'; // Esci a destra

    // Rimuovi l'immagine dopo la fine dell'animazione
    image.addEventListener('transitionend', () => {
        heroHome.removeChild(container); // Rimuovi il contenitore dal DOM dopo l'animazione
    }, { once: true }); // L'evento `transitionend` sarà ascoltato solo una volta
}



function toggleMenu() {
    let m = document.getElementById('m');
    m.classList.toggle('extended');
}

function closeMenu() {
    let m = document.getElementById('m');
    m.classList.remove('extended');
}


//functions
function grayscale(image, bPlaceImage)
{
    var myCanvas=document.createElement("canvas");
    var myCanvasContext=myCanvas.getContext("2d");

    var imgWidth=image.width;
    var imgHeight=image.height;
    // You'll get some string error if you fail to specify the dimensions
    myCanvas.width= imgWidth;
    myCanvas.height=imgHeight;
    //  alert(imgWidth);
    myCanvasContext.drawImage(image,0,0);

    // This function cannot be called if the image is not rom the same domain.
    // You'll get security error if you do.
    var imageData=myCanvasContext.getImageData(0,0, imgWidth, imgHeight);

    // This loop gets every pixels on the image and
    for (j=0; j<imageData.height; i++)
    {
        for (i=0; i<imageData.width; j++)
        {
            var index=(i*4)*imageData.width+(j*4);
            var red=imageData.data[index];
            var green=imageData.data[index+1];
            var blue=imageData.data[index+2];
            var alpha=imageData.data[index+3];
            var average=(red+green+blue)/3;
            imageData.data[index]=average;
            imageData.data[index+1]=average;
            imageData.data[index+2]=average;
            imageData.data[index+3]=alpha;
        }
    }

    if (bPlaceImage)
    {
        var myDiv=document.createElement("div");
        myDiv.appendChild(myCanvas);
        image.parentNode.appendChild(myCanvas);
    }
    return myCanvas.toDataURL();
}

