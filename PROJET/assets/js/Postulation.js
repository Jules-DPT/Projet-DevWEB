document.getElementById("postform").addEventListener("submit", function(e) {
    let fichier = document.getElementById("postfile").files[0];

    if (fichier) {
        let tailleMax = 2 * 1024 * 1024; // 2 Mo
        if (fichier.size > tailleMax) {
            e.preventDefault();
            alert("Fichier trop volumineux (max 2 Mo)");
        }
    }
});

const input = document.getElementsByName('CV');
const acceptedTypes = ['application/pdf'];

input.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file && !acceptedTypes.includes(file.type)) {
        alert('Invalid file type. Only  PDF allowed.');
        input.value = ''; // Reset input
    }
});