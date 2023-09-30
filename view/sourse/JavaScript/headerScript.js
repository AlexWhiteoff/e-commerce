// Modal blocks
const accountModalBlock = document.getElementById("modal-block-content-account");
const accountBackground = document.getElementById("modal-block-account-background");
const accountButton = Array.from(document.getElementsByClassName("account-modal-block"));

const cartModalBlock = document.getElementById("modal-block-content-cart");
const cartBackground = document.getElementById("modal-block-cart-background");
const cartButton = Array.from(document.getElementsByClassName("cart-modal-block"));

accountButton.forEach((button) => {
	button.addEventListener("click", () => {
		accountBackground.style.display = "block";
		accountModalBlock.style.display = "flex";

		accountBackground.addEventListener("click", () => {
			accountModalBlock.style.display = "none";
			accountBackground.style.display = "none";
		});
	});
});

cartButton.forEach((button) => {
	button.addEventListener("click", () => {
        if (document.body.contains(accountModalBlock)) {
		    accountModalBlock.style.display = "none";
		    accountBackground.style.display = "none";
        }
        if (document.body.contains(document.querySelector(".access-product-controls-section"))) {
            const deleteModalBlock = document.getElementById('modal-product-background'); 
            const deleteModalBlockBackground = document.getElementById('modal-content-product');
            deleteModalBlock.style.display = "none";
            deleteModalBlockBackground.style.display = "none";
        }
        cartModalBlock.style.display = "block";
		cartBackground.style.display = "block";

		cartBackground.addEventListener("click", () => {
            if (document.body.contains(accountModalBlock)) {
                accountBackground.style.display = "none";
                accountModalBlock.style.display = "none";
            }
			cartModalBlock.style.display = "none";
			cartBackground.style.display = "none";
		});
	});
});

if (document.body.contains(document.querySelector(".modal-block-content-cart__product-list"))){
    const cartProductQuantityInput = Array.from(document.querySelectorAll(".modal-block-content-cart__overlay-product-quantity-value"));
    const cartProductQuantityValue = cartProductQuantityInput.value;
    cartProductQuantityInput.forEach(input => {
        input.addEventListener('input', () => {
            const cartProductQuantityUpdateBtn = input.nextElementSibling;

            if (cartProductQuantityValue !== input.value)
                cartProductQuantityUpdateBtn.style.display = 'inline-flex';
            else
                cartProductQuantityUpdateBtn.style.display = 'none';
        });        
    });
}

//burger menu
const responsiveBlock = document.getElementById("responsive-nav-block");
const burgerMenu = document.getElementById("header-burder-menu");

if (burgerMenu !== null) {
    burgerMenu.addEventListener("click", () => {
        if (responsiveBlock.style.display === "flex")
            responsiveBlock.style.display = "none";
        else responsiveBlock.style.display = "flex";
    });
}
