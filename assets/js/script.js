let btn_menu = document.querySelector('#btn_menu');
let sidebar = document.getElementById("mySidebar");
let main = document.getElementById("main");
let dropdown = document.querySelector('.dropdown-btn');
let droptown_menu = document.querySelector('.droptown_menu')
let droptown_menu2 = document.querySelector('.droptown_menu2')
function openNav() {
    let droptown_nav = document.querySelector('.droptown_nav');
    let droptown_nav2 = document.querySelector('.droptown_nav2');
    if (droptown_nav.classList.contains('active')) {
        droptown_nav.classList.toggle('active');
    }
    if (droptown_nav2.classList.contains('active')) {
        droptown_nav2.classList.toggle('active');
    }

    sidebar.classList.toggle('active');
    if (sidebar.classList.contains('active')) {
        sidebar.style.width = "180px";
        main.style.marginLeft = "180px";
        sidebar.querySelectorAll('span').forEach((e) => {
            e.style.display= 'block';
        });
        sidebar.querySelectorAll('.icon_down').forEach((e) => {
            e.style.display= 'block';

        })
        
        

    } 
    else {
        sidebar.style.width = "60px";
        main.style.marginLeft = "60px";
        sidebar.querySelectorAll('span').forEach((e) => {
            e.style.display= 'none';

        });
        sidebar.querySelectorAll('.icon_down').forEach((e) => {
            e.style.display= 'none';

        })
        // sidebar.querySelector('.icon_down').style.display='none'
    }
}

btn_menu.addEventListener("click", function () {
    openNav();
});
droptown_menu.addEventListener("click", function () {
    let droptown_nav = document.querySelector('.droptown_nav');
    droptown_nav.classList.toggle('active');
});
droptown_menu2.addEventListener("click", function () {
    let droptown_nav2 = document.querySelector('.droptown_nav2');
    droptown_nav2.classList.toggle('active');
});