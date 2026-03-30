const btn = document.getElementById("copyPwd");
const pwd = document.getElementById("tempPwd");

if (btn && pwd) {
  btn.addEventListener("click", async () => {
    try {
      await navigator.clipboard.writeText(pwd.textContent.trim());
      btn.textContent = "Copié ✓";
      setTimeout(() => (btn.textContent = "Copier"), 1200);
    } catch (e) {
      alert("Copie impossible. Sélectionne et copie manuellement.");
    }
  });
}
