const msgBox = document.querySelector(".msgBox");
const msgBoxClose = document.querySelector(".msgBox-close");

msgBoxClose.addEventListener("click", () => {
	msgBox.style.display = "none";
});

setInterval(() => (msgBox.style.display = "none"), 5000);
