import { onMounted, ref } from "vue";

let affichage = "en cours...";

document.querySelector("#affichage").textContent = affichage;

let canvas, ctx;
const cellSizex = 10;
const cellSizey = 10;

const WIDTH = 25;
const HEIGHT = 25;

let grille = [];
let serpent = [];
let direction = null; // au départ, pas de mouvement
let jeu = true;

const vitesse = 200; // vitesse du serpent en ms entre chaque mouvement

// fonction pour générer un nombre aléatoire
function rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

// initialisation du jeu
function init() {
    grille = [];
    serpent = [];
    direction = null; // toujours null au départ
    jeu = true;

    for (let x = 0; x < WIDTH; x++) {
        grille[x] = [];
        for (let y = 0; y < HEIGHT; y++) {
            grille[x][y] = 0;
        }
    }

    // serpent au centre
    let sx = Math.floor(WIDTH / 2);
    let sy = Math.floor(HEIGHT / 2);
    grille[sx][sy] = 1;
    serpent.push([sx, sy]);

    ajouterPomme();
}

// ajouter une pomme (valeur 2) sur une case vide
function ajouterPomme() {
    let x, y;
    do {
        x = rand(0, WIDTH - 1);
        y = rand(0, HEIGHT - 1);
    } while (grille[x][y] !== 0);

    grille[x][y] = 2;
}

// dessiner le canvas
function dessiner() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let x = 0; x < WIDTH; x++) {
        for (let y = 0; y < HEIGHT; y++) {
            if (grille[x][y] === 1) {
                ctx.fillStyle = "green";
                ctx.fillRect(x * cellSizex, y * cellSizey, cellSizex, cellSizey);
            } else if (grille[x][y] === 2) {
                ctx.fillStyle = "red";
                ctx.fillRect(x * cellSizex, y * cellSizey, cellSizex, cellSizey);
            }
        }
    }
}

// mettre à jour la position du serpent
function update() {
    if (!direction) return; // ne bouge pas tant qu'aucune touche

    let head = serpent[serpent.length - 1];
    let nx = head[0];
    let ny = head[1];

    if (direction === "UP") ny--;
    if (direction === "DOWN") ny++;
    if (direction === "LEFT") nx--;
    if (direction === "RIGHT") nx++;

    // collision mur
    if (nx < 0 || nx >= WIDTH || ny < 0 || ny >= HEIGHT) {
        jeu = false;
        return;
    }

    // collision avec le serpent
    if (grille[nx][ny] === 1) {
        jeu = false;
        return;
    }

    if (grille[nx][ny] === 2) {
        // manger la pomme
        serpent.push([nx, ny]);
        grille[nx][ny] = 1;
        ajouterPomme();
    } else {
        // avancer
        let queue = serpent.shift();
        grille[queue[0]][queue[1]] = 0;

        serpent.push([nx, ny]);
        grille[nx][ny] = 1;
    }
}

// gestion des touches
document.addEventListener("keydown", (e) => {
    if (direction === null) {
        if (e.key === "ArrowUp") direction = "UP";
        if (e.key === "ArrowDown") direction = "DOWN";
        if (e.key === "ArrowLeft") direction = "LEFT";
        if (e.key === "ArrowRight") direction = "RIGHT";
        return;
    }

    if (e.key === "ArrowUp" && direction !== "DOWN") direction = "UP";
    if (e.key === "ArrowDown" && direction !== "UP") direction = "DOWN";
    if (e.key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
    if (e.key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
});

// boucle du jeu avec vitesse contrôlée
async function gameLoop() {
    while (jeu) {
        update();
        dessiner();
        await new Promise(resolve => setTimeout(resolve, vitesse)); // pause entre chaque frame
    }
    affichage.value = "PERDU...";
    document.querySelector("#affichage").textContent = affichage;
}

document.addEventListener("DOMContentLoaded", () => {
    canvas = document.getElementById("myCanvas");
    ctx = canvas.getContext("2d");
    init();
    gameLoop();
});
