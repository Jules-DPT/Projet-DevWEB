const menuHamburger = document.querySelector(".menu-hamburger")
        const navLinks = document.querySelector(".nav-links")
 
        menuHamburger.addEventListener('click',()=>{
        navLinks.classList.toggle('mobile-menu')
        document.body.classList.toggle('no-scroll');
        })
const themeToggle = document.getElementById("theme-toggle");

themeToggle.addEventListener("click", () => {
document.body.classList.toggle("dark-mode");

if(document.body.classList.contains("dark-mode")){
localStorage.setItem("theme","dark");
themeToggle.textContent="☀️";
}else{
localStorage.setItem("theme","light");
themeToggle.textContent="🌙";
}
});

window.addEventListener("DOMContentLoaded", () => {
const savedTheme = localStorage.getItem("theme");

if(savedTheme === "dark"){
document.body.classList.add("dark-mode");
themeToggle.textContent="☀️";
}
});