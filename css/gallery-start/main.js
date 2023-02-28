const displayedImage = document.querySelector('.displayed-img');
const thumbBar = document.querySelector('.thumb-bar');

const btn = document.querySelector('button');
const overlay = document.querySelector('.overlay');

/* Declaring the array of image filenames */

/* Declaring the alternative text for each image file */

/* Looping through images */
const imageList  = [
    './images/pic1.jpg',
    './images/pic2.jpg',
    './images/pic3.jpg',
    './images/pic4.jpg',
    './images/pic5.jpg'
];

imageList.forEach(element => {
    
    const newImage = document.createElement('img');
    newImage.setAttribute('src', element);
    newImage.setAttribute('alt', '');
    thumbBar.appendChild(newImage);
});

thumbBar.addEventListener('click',(e)=>{
    displayedImage.src = e.target.src
});

/* Wiring up the Darken/Lighten button */

btn.addEventListener('click',(e)=>{
    let className = e.target.getAttribute('class');
    if (className == 'dark') {
        e.target.setAttribute('class','Lighten');
        overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
    }else{
        e.target.setAttribute('class','dark');
        overlay.style.backgroundColor = 'rgba(0,0,0,0)';

    }
})
