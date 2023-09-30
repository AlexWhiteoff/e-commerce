// Go to top button
function scrollToTop() {
	var position =
		document.body.scrollTop || document.documentElement.scrollTop;
	if (position) {
		window.scrollBy(0, -Math.max(10, Math.floor(position / 10)));
		scrollAnimation = setTimeout("scrollToTop()", 10);
	} else clearTimeout(scrollAnimation);
}

if (document.body.contains(document.querySelector("#go-up-button"))) {
	let goUpBtn = document.querySelector("#go-up-button");

	goUpBtn.addEventListener("click", scrollToTop);
}
