function chargerPage(page) {
    let i=0;
    fetch("assets/php/Postscontroller.php?page=" + page)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById("affichage_posts").innerHTML="";
            data.aff.forEach(post=>{
                console.log("ici",i);
                console.log(post[i]);
                const box = document.createElement("div");
                box.className = "box-simple";
                box.dataset.id = post.id;
                box.addEventListener('click',function (){
                    chargerPost(post.id);
                });

                const titre = document.createElement("p");
                titre.textContent = post.titre;

                const desc = document.createElement("p");
                desc.textContent = post.description;

                const rem = document.createElement("p");
                rem.textContent = "rémunération: " + post.remuneration;

                const nb = document.createElement("p");
                nb.textContent = "nb_postulants: " + post.nb_postulants;

                box.appendChild(titre);
                box.appendChild(desc);
                box.appendChild(rem);
                box.appendChild(nb);


                document.getElementById("affichage_posts").appendChild(box);
                i=i+1;
            });
            //document.getElementById("pagination").innerHTML=data.pagination;
        });
}
function chargerPost(indi) {
    window.location.href = "post.html?ind=" + encodeURIComponent(indi);
}

function chargerPost_rand(){
    fetch("/assets/php/Postscontroller.php?page=1")
        .then(response => response.json())
        .then(data => {
            const p = data.total ;
            chargerPost(Math.floor(Math.random() * p));
        });
}

function radio(){
    const selectedValue = document.querySelector('input[name="type"]:checked')?.value;
}

document.addEventListener("DOMContentLoaded", function() {


});