const clrButtons = document.querySelectorAll("#clr-btn");
const clrBg = document.querySelectorAll(".clr-bg-color");
const form = document.querySelector(".form-container");

clrButtons.forEach((btn) => {
	if (btn.style.backgroundColor === form.style.background) {
		btn.setAttribute("checked", true);
	}
	btn.addEventListener("click", () => {
		const color = btn.style.backgroundColor;
		form.style.background = `${color}`;
	});
});
