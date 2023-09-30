//changing images
const imgGridArray = Array.from(
	document.getElementById("grovemade-team").children
);

imgGridArray.forEach((image) => {
	let url = "";

	image.addEventListener("mouseover", () => {
		url = image.src;
		let newURL = url.slice(0, -4) + "_hover.jpg";
		image.src = newURL;
	});

	image.addEventListener("mouseout", () => {
		image.src = url;
	});
});
