const clrButtons = document.querySelectorAll("#clr-btn");
const clrButtons_mb = document.querySelectorAll("#clr-btn_mb");
const clrBg = document.querySelectorAll(".clr-bg-color");
const form = document.querySelector(".form-container");

clrButtons_mb.forEach((btn) => {
	if (btn.style.backgroundColor === form.style.background) {
		btn.setAttribute("checked", true);
	}

	btn.addEventListener("click", () => {
		const color = btn.style.backgroundColor;
		form.style.background = `${color}`;
	});
});

clrButtons.forEach((btn) => {
	if (btn.style.backgroundColor === form.style.background) {
		btn.setAttribute("checked", true);
	}

	btn.addEventListener("click", () => {
		const color = btn.style.backgroundColor;
		form.style.background = `${color}`;
	});
});
