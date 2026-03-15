const toggle = document.getElementById("togglePwd");
const pwd = document.getElementById("password");

if (toggle && pwd) {
  toggle.addEventListener("click", () => {
    const isHidden = pwd.type === "password";
    pwd.type = isHidden ? "text" : "password";
    toggle.setAttribute("aria-label", isHidden ? "Masquer le mot de passe" : "Afficher le mot de passe");
  });
}
