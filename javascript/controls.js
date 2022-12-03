const controlBtn = document.querySelector(".control-btn");
const controlContainer = document.querySelector(".control-mb");

controlBtn.addEventListener("click", () => {
	if (controlContainer.style.height == "2.1em") {
		controlContainer.style.height = "100%";
		controlBtn.innerHTML = "Close";
	} else {
		controlContainer.style.height = "2.1em";
		controlBtn.innerHTML = "Controls";
	}
});
