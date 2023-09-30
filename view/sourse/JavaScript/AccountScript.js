//error snackbar
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

// password view
const passwordView = () => {
	const viewButtonArray = Array.from(
		document.querySelectorAll(".see-password")
	);
	viewButtonArray.forEach((viewButton) => {
		viewButton.addEventListener("click", () => {
			const password = viewButton.previousSibling.previousSibling;

			if (password.type === "password") {
				password.type = "text";
				viewButton.classList.remove("fa-eye");
				viewButton.classList.add("fa-eye-slash");
			} else {
				password.type = "password";
				viewButton.classList.remove("fa-eye-slash");
				viewButton.classList.add("fa-eye");
			}
		});
	});
};

// if it's user auth page
if (document.body.contains(document.getElementById("account-registration"))) {
	// password check
	const passwordError = document.getElementById("password-error");
	const password = document.getElementById("input-password");
	const repeatPassword = document.getElementById("input-repeat-password");
	const submitBtn = document.getElementById("submit-button");

	repeatPassword.addEventListener("change", () => {
		if (password.value.length >= 6 && password.value.length <= 16) {
			if (password.value != repeatPassword.value) {
				passwordError.innerHTML =
					'<i class="fas fa-times"></i> Passwords must match';
				submitBtn.disabled = true;
			} else {
				passwordError.innerHTML = "";
				submitBtn.disabled = false;
			}
		} else {
			passwordError.innerHTML =
				'<i class="fas fa-times"></i> Password must contain between 6 and 16 digits.';
			submitBtn.disabled = true;
		}
	});
	password.addEventListener("change", () => {
		if (password.value.length >= 6 && password.value.length <= 16) {
			if (
				password.value != repeatPassword.value &&
				repeatPassword.value != ""
			) {
				passwordError.innerHTML =
					'<i class="fas fa-times"></i> Passwords must match';
				submitBtn.disabled = true;
			} else {
				passwordError.innerHTML = "";
				submitBtn.disabled = false;
			}
		} else {
			passwordError.innerHTML =
				'<i class="fas fa-times"></i> Password must contain between 6 and 16 digits.';
			submitBtn.disabled = true;
		}
	});

	//password view
	passwordView();
}

if (document.body.contains(document.getElementById("account-login"))) {
	passwordView();
}

//if it's user personal info page
if (document.body.contains(document.getElementById("personal-account"))) {
	const UserInfoChange = document.getElementById("user-info-button-change");
	const SaveChanges = document.getElementById(
		"user-info-button-save-changes"
	);
	const CancelChanges = document.getElementById(
		"user-info-button-cancel-changes"
	);

	let elementsValue = [];

	UserInfoChange.addEventListener("click", () => {
		let userInfoArray = Array.from(
			document.getElementsByClassName("userInfoBlock__infoInput")
		);
		userInfoArray.forEach((block) => {
			const elementName = block.getAttribute("name");
			const elementType = block.getAttribute("type");
			const elementPlaceholder = block.getAttribute("placeholder");

			let elementValue = "";

			if (!block.innerHTML.includes("Not specified")) {
				elementValue = block.innerHTML;
				elementValue = elementValue.replace(/^\s+|\s+$/gm, "");

				elementsValue.push(elementValue);
			} else elementsValue.push("Not specified");

			if (elementName !== "gender")
				block.outerHTML = `<input type="${elementType}" placeholder="${elementPlaceholder}" id="${block.id}" name="${elementName}" class="${block.classList}" value="${elementValue}">`;
			else
				block.outerHTML = `<select class="${block.classList}", id="${block.id}" type="${elementType}" placeholder="${elementPlaceholder}" name="${elementName}"><option>Male</option><option>Female</option></select>`;
		});

		SaveChanges.style.display = "block";
		SaveChanges.disabled = true;
		CancelChanges.style.display = "block";
		UserInfoChange.style.display = "none";

		userInfoArray = Array.from(
			document.getElementsByClassName("userInfoBlock__infoInput")
		);

		let userInfoArrayOld = [];
		userInfoArray.forEach((input) => {
			userInfoArrayOld.push(input.value);
		});

		for (let i = 0; i < userInfoArray.length; i++) {
			userInfoArray[i].addEventListener("input", () => {
				let isDisabled = true;
				for (let j = 0; j < userInfoArray.length; j++) {
					if (userInfoArray[j].value !== userInfoArrayOld[j]) {
						isDisabled = false;
						break;
					}
				}
				SaveChanges.disabled = isDisabled;
			});
		}
	});

	CancelChanges.addEventListener("click", () => {
		let userInfoArray = Array.from(
			document.getElementsByClassName("userInfoBlock__infoInput")
		);

		for (let i = 0; i < userInfoArray.length; i++) {
			let block = userInfoArray[i];

			const elementName = block.getAttribute("name");
			const elementType = block.getAttribute("type");
			const elementPlaceholder = block.getAttribute("placeholder");
			block.outerHTML = `<div type="${elementType}" placeholder="${elementPlaceholder}" id="${block.id}" name="${elementName}" class="${block.classList}">${elementsValue[i]}</div>`;
		}

		SaveChanges.disabled = true;
		SaveChanges.style.display = "none";
		CancelChanges.style.display = "none";
		UserInfoChange.style.display = "block";
	});

	//Changing address info
	const address_ChangeButton = document.querySelector(
		"#user-address-button-change-info"
	);
	address_ChangeButton.addEventListener("click", () => {
		const address_ViewBlock = document.querySelector(
			".user-address-section__block"
		);
		const address_ChangeBlock = document.querySelector(
			".user-address-section__change-block"
		);
		const address_saveButton = document.querySelector(
			"#user-address-button-save-changes"
		);
		const address_cancelButton = document.querySelector(
			"#user-address-button-cancel-changes"
		);
		address_saveButton.disabled = true;
		address_ViewBlock.style.display = "none";
		address_ChangeButton.style.display = "none";
		address_ChangeBlock.style.display = "block";

		const inputs = Array.from(
			document.querySelectorAll(".user-address-section__input")
		);

		console.log(addressArray);
		for (let i = 0; i < inputs.length; i++) {
			inputs[i].addEventListener("input", () => {
				let isDisabled = true;
				for (let j = 0; j < inputs.length; j++) {
					if (inputs[j].value != addressArray[j]) {
						isDisabled = false;
						break;
					}
				}
				address_saveButton.disabled = isDisabled;
			});
		}

		address_cancelButton.addEventListener("click", () => {
			address_ViewBlock.style.display = "block";
			address_ChangeButton.style.display = "block";
			address_ChangeBlock.style.display = "none";
		});
	});

	//delete user account
	const deleteButton = document.querySelector(
		".account-control__user-delete"
	);
	const deleteModalBlock = document.getElementById("modal-block-content");
	const deleteModalBlockBackground = document.getElementById(
		"modal-block-background"
	);

	deleteButton.addEventListener("click", () => {
		deleteModalBlockBackground.style.display = "block";
		deleteModalBlock.style.display = "block";

		deleteModalBlockBackground.addEventListener("click", () => {
			deleteModalBlock.style.display = "none";
			deleteModalBlockBackground.style.display = "none";
		});

		const cancelButton = document.querySelector(
			".account-control__modal-content-cancel"
		);
		cancelButton.addEventListener("click", () => {
			deleteModalBlock.style.display = "none";
			deleteModalBlockBackground.style.display = "none";
		});
	});
}
