if (
	document.body.contains(document.getElementById("add-product")) ||
	document.body.contains(document.getElementById("edit-product"))
) {
	//add user page categories item
	const subcategoryRow = document.getElementById("subcategory-row");
	subcategoryRow.style.display = "none";
	const subcategorySelect = document.getElementById("subcategory");
	const categorySelect = document.getElementById("category");

	categorySelect.addEventListener("change", () => {
		const categoryOption = categorySelect.value;
		subcategoryRow.style.display = "table-row";
		subcategorySelect.innerHTML =
			'<option value="undefined" disabled selected>Select a subcategory</option>';

		for (let index = 0; index < subcategories.length; index++) {
			if (subcategories[index]["categoryID"] === categoryOption)
				subcategorySelect.innerHTML += `<option value="${subcategories[index]["subcategoryName"]}">${subcategories[index]["subcategoryName"]}</option>`;
		}
	});

	// Change photo
	const imageWrapper = document.querySelector(".image__wrapper");
	const newFile = document.getElementById("image");
	const imageButtonText = document.querySelector(".image__upload");
	const previewRow = document.getElementById("previewRow");


	const loadImage = () => {
		const allowedTypes = ["image/jpeg", "image/png"];
		if (newFile.files.length > 0 && allowedTypes.includes(newFile.files[0].type)) {
			//changing button text
			if (newFile.files.length > 0) {
				previewRow.style.display = 'table-row';
				imageButtonText.innerHTML = `<i class="fas fa-upload"></i>&nbsp;Selected ${newFile.files.length} file`;
			} else {
				previewRow.style.display = 'none';
				imageButtonText.innerHTML = `<i class="fas fa-upload"></i>&nbsp;Select a file`;
			}

			//adding preview image
			if (
				document.body.contains(
					document.querySelector(".image__img")
				)
			) {
				const image = document.querySelector(".image__img");
				image.src = URL.createObjectURL(newFile.files[0]);
			} else {
				const image = document.createElement("img");
				image.classList.add("image__img");
				image.src = URL.createObjectURL(newFile.files[0]);
				console.log(image);
				imageWrapper.appendChild(image);
			}
		}
	};

	window.addEventListener("load", () => {
		console.log(newFile.files);
		loadImage();
	});

	newFile.addEventListener("change", () => {
		loadImage();
	});
}

//error block while editing/adding new product
if (document.body.contains(document.querySelector(".error-alert-block__header.action_clck"))) {
	const errSnackbar = document.querySelector(".error-alert-block");
	const dropdownButton = document.querySelector(".action_clck");
	const dropdownArrow = document.querySelector("#error-dropdown-arrow");
	const curHeight = "55px";

	dropdownButton.addEventListener("click", () => {
		if (dropdownArrow.classList.contains('fa-chevron-right')) {
			dropdownArrow.classList.remove('fa-chevron-right');
			dropdownArrow.classList.add('fa-chevron-down');
			errSnackbar.style.height = 'fit-content';
		} else {
			dropdownArrow.classList.remove('fa-chevron-down');
			dropdownArrow.classList.add('fa-chevron-right');
			errSnackbar.style.height = curHeight;
		}
	});
}

//controls block(delete/edit) hiding/showing
if (
	document.body.contains(
		document.querySelector(".access-product-controls-section")
	)
) {
	const controlsBlock = document.getElementById("access-product-controls");
	const controlsBlockDropdownArrow = document.querySelector(
		".access-product-controls-section__dropdown-arrow"
	);

	controlsBlockDropdownArrow.addEventListener("click", () => {
		if (
			controlsBlockDropdownArrow.children[0].classList.contains(
				"fa-chevron-up"
			)
		) {
			controlsBlock.style.height = 0;
			controlsBlockDropdownArrow.style.top = 75 + "px";
			controlsBlockDropdownArrow.children[0].classList.remove(
				"fa-chevron-up"
			);
			controlsBlockDropdownArrow.children[0].classList.add(
				"fa-chevron-down"
			);
		} else {
			controlsBlock.style.height = 70 + "px";
			controlsBlockDropdownArrow.style.top = 144 + "px";
			controlsBlockDropdownArrow.children[0].classList.remove(
				"fa-chevron-down"
			);
			controlsBlockDropdownArrow.children[0].classList.add(
				"fa-chevron-up"
			);
		}
	});

	//delete confirm modal block
	const deleteButton = document.getElementById(
		"product-delete-modal-block-button"
	);
	const deleteModalBlock = document.getElementById("modal-content-product");
	const deleteModalBlockBackground = document.getElementById(
		"modal-product-background"
	);

	deleteButton.addEventListener("click", () => {
		deleteModalBlockBackground.style.display = "block";
		deleteModalBlock.style.display = "block";

		deleteModalBlockBackground.addEventListener("click", () => {
			deleteModalBlock.style.display = "none";
			deleteModalBlockBackground.style.display = "none";
		});

		const cancelButton = document.querySelector(
			".access-product-controls-section__modal-content-cancel"
		);
		cancelButton.addEventListener("click", () => {
			deleteModalBlock.style.display = "none";
			deleteModalBlockBackground.style.display = "none";
		});
	});
}
