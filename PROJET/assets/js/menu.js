const menuHamburger = document.querySelector(".menu-hamburger")
        const navLinks = document.querySelector(".nav-links")
 
        menuHamburger.addEventListener('click',()=>{
        navLinks.classList.toggle('mobile-menu')
        document.body.classList.toggle('no-scroll');
        })
// Gestion du bouton de retour en haut de page
window.onscroll = function() {
    scrollFunction();
};

// Fonction pour afficher ou cacher le bouton de retour en haut
function scrollFunction() {
    const btn = document.getElementById("BtnToTop");
    // Affiche le bouton si l'utilisateur a défilé de plus de 100 pixels
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        btn.style.display = "block";
    } else {
        btn.style.display = "none";
    }
}

// Lorsque l'utilisateur clique sur le bouton, la page remonte en haut
document.getElementById("BtnToTop").addEventListener("click", function() {
    document.body.scrollTop = 0; // Pour Safari
    document.documentElement.scrollTop = 0; // Pour Chrome, Firefox, IE et Opera
});

