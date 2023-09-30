// Expiration date
const cardexp = document.getElementById("card-expiry");
let expirationdate_mask = new IMask(cardexp, {
	mask: "MM {/} YY",
	blocks: {
		MM: {
			mask: IMask.MaskedRange,
			from: 0,
			to: 12,
			autofix: "pad",
		},
		YY: {
			mask: IMask.MaskedRange,
			from: 20,
			to: 99,
		},
	},
});

const CVV = document.getElementById('card-security-code');
let securityCode_mask = new IMask(CVV, {
	mask: "0000",
});

// Card number validation
const cardNumber = document.getElementById("card-number");

let cardNumber_mask = IMask(cardNumber, {
	mask: [
		{
			mask: "0000 0000 0000 0000",
			regex: "^4\\d*", // ^4\\d{13,15}
			cardtype: "visa",
		},
		{
			mask: "0000 0000 0000 0000",
			regex: "^5[1-5]\\d*", // ^5\\d{15}
			cardtype: "mastercard",
		},
		{
			mask: "0000 000000 00000",
			regex: "^3[47]\\d*", // ^3[47]\\d{13}
			cardtype: "amex",
		},
		{
			mask: "0000 0000 0000 0000",
			regex: "^(?:6011|65\\d{0,2}|64[4-9]\\d?)\\d*", // ^(?:6011|65\\d{0,2}|64[4-9]\\d?)\\d{0,12}
			cardtype: "discover",
		},
		{
			mask: "0000000000000000",
			cardtype: "unknown",
		},
	],
	dispatch: function (appended, dynamicMasked) {
		var number = (dynamicMasked.value + appended).replace(/\D/g, "");

		for (let i = 0; i < dynamicMasked.compiledMasks.length; i++) {
			let regexp = new RegExp(dynamicMasked.compiledMasks[i].regex);

			if (regexp.test(number)) {
				return dynamicMasked.compiledMasks[i];
			}
		}
	},
});

//example
console.log("^4\\d{13,15}\n^5\\d{15}\n^3[47]\\d{13}\n^(?:6011|65\\d{0,2}|64[4-9]\\d?)\\d{0,12}");

const visa = document.getElementById("visa");
const mastercard = document.getElementById("mastercard");
const americanExpress = document.getElementById("american-express");
const discover = document.getElementById("discover");

const cardList = [];
cardList.push(visa, mastercard, americanExpress, discover);

cardNumber_mask.on("accept", function () {
	switch (cardNumber_mask.masked.currentMask.cardtype) {
		case "visa":
			for (let i = 0; i < cardList.length; i++) {
				if (cardList[i].children[0].innerHTML === "Visa") {
					cardList[i].classList.remove("payment-icon--unknown");
					cardList[i].classList.add("payment-icon--known");
				} else {
					cardList[i].classList.remove("payment-icon--known");
					cardList[i].classList.add("payment-icon--unknown");
				}
			}
			break;
		case "mastercard":
			for (let i = 0; i < cardList.length; i++) {
				if (cardList[i].children[0].innerHTML === "Mastercard") {
					cardList[i].classList.remove("payment-icon--unknown");
					cardList[i].classList.add("payment-icon--known");
				} else {
					cardList[i].classList.remove("payment-icon--known");
					cardList[i].classList.add("payment-icon--unknown");
				}
			}
			break;
		case "amex":
			for (let i = 0; i < cardList.length; i++) {
				if (cardList[i].children[0].innerHTML === "American Express") {
					cardList[i].classList.remove("payment-icon--unknown");
					cardList[i].classList.add("payment-icon--known");
				} else {
					cardList[i].classList.remove("payment-icon--known");
					cardList[i].classList.add("payment-icon--unknown");
				}
			}
			break;
		case "discover":
			for (let i = 0; i < cardList.length; i++) {
				if (cardList[i].children[0].innerHTML === "Discover") {
					cardList[i].classList.remove("payment-icon--unknown");
					cardList[i].classList.add("payment-icon--known");
				} else {
					cardList[i].classList.remove("payment-icon--known");
					cardList[i].classList.add("payment-icon--unknown");
				}
			}
			break;
		default:
			for (let i = 0; i < cardList.length; i++) {
				cardList[i].classList.remove("payment-icon--known");
				cardList[i].classList.remove("payment-icon--unknown");
			}
			break;
	}
});

const differentBillingAddressRadio = document.getElementById("radio-different-billing-address");
const sameBillingAddressRadio = document.getElementById("radio-same-billing-address");

differentBillingAddressRadio.addEventListener('change', () => {
    const differentBillingAddressBlock = document.getElementById("different-billing-address");
    const sideBlock = document.querySelector('.order-summary');
    if (differentBillingAddressRadio.checked) {
        differentBillingAddressBlock.style.display = 'block';
        sideBlock.style.height = '150vh';
    }
});

sameBillingAddressRadio.addEventListener('change', () => {
    const differentBillingAddressBlock = document.getElementById("different-billing-address");
    const sideBlock = document.querySelector('.order-summary');
    
    if (sameBillingAddressRadio.checked) {
        differentBillingAddressBlock.style.display = 'none';
        sideBlock.style.height = '100vh';
    }
});