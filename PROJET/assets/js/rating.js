const ratingInputs = document.querySelectorAll('.rating-system .rating input[type="radio"]');
const displayValue = document.getElementById('rating-value');

ratingInputs.forEach(input => {
    input.addEventListener('change', (e) => {
        const value = e.target.value;
        if (displayValue) {
            displayValue.innerText = `${value}/5`;
        }
        console.log("Note sélectionnée pour PHP :", value);
    });
});