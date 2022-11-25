const loadingAnimation = () => {
	setInterval(
		() => document.querySelector(".loader-container").classList.add("fade-out"),
		2000
	);
};
window.onload = loadingAnimation;
