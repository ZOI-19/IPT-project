const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themetoggler = document.querySelector(".theme-toggler")

//open sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})

//close sidebar
closeBtn.addEventListener('click', ()=> {
    sideMenu.style.display = 'none'
})

//change theme
themetoggler = addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');

    themetoggler.querySelector('span:nth-child(1)');classList.toggle('active');
    themetoggler.querySelector('span:nth-child(2)');classList.toggle('active');
});

document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.querySelector('.sidebar');
    const closeBtn = document.getElementById('close-btn');

    // Toggle sidebar on menu button click
    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });

    // Close sidebar on close button click
    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active');
    });
});
