//total sales chart
if (document.body.contains(document.querySelector(".overview"))) {
	const TotalSalesCanvas = document.getElementById("total-sales-chart");

	const Months = [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec",
	];

	const date = new Date();
	const prevMonth = date.getMonth() - 1;
	const daysInPrevMonth =
		32 - new Date(date.getFullYear(), date.getMonth() - 1, 32).getDate();

	const Days = [...Array(daysInPrevMonth).keys()].map((x) => ++x);

	const labels = [];

	Days.forEach((day) => {
		labels.push(Months[prevMonth] + " " + day);
	});

	const TotalSalesChart_data = {
		labels: labels,
		datasets: [
			{
				label: " Total sales per day",
				data: totalSalesPhpArray,
				fill: true,
				backgroundColor: "rgb(154,168,177, 0.1)",
				borderColor: "rgb(154,168,177)",
				tension: 0.1,
			},
		],
	};

	const totalSalesChart = new Chart(TotalSalesCanvas, {
		type: "line",
		data: TotalSalesChart_data,
		options: {
			interaction: {
				intersect: false,
				mode: "index",
			},
			plugins: {
				legend: { display: false },
			},
			scales: {
				y: {
					display: false,
					suggestedMin: 0,
					suggestedMax: Math.max.apply(null, totalSalesPhpArray) + 2,
				},
				x: {
					ticks: { display: false },
				},
			},
		},
	});
}

// quantity of sales by categories.
if (document.body.contains(document.querySelector(".product-section"))) {
	const productCanvas = document.getElementById("product-chart");

	const productChart_data = {
		labels: categoryList,
		datasets: [
			{
				data: quantitySalesByCategories,
				backgroundColor: chartBackgroundColor,
				hoverOffset: 4,
				cutout: "80%",
			},
		],
	};

	const productChart = new Chart(productCanvas, {
		type: "doughnut",
		data: productChart_data,
		options: {
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false,
				},
			},
		},
	});
}

// editing error snackbar
if (document.body.contains(document.querySelector(".snackbar"))) {
	const snackbarInnerText = document.querySelector(".snackbar__text");
	const snackbarDropDownBtn = document.getElementById("dropdown-btn");

	snackbarDropDownBtn.addEventListener("click", () => {
		const dropdownArrow = document.getElementById(
			"snackbar-dropdown-arrow"
		);

		if (dropdownArrow.classList.contains("fa-chevron-right")) {
			snackbarInnerText.innerHTML = messageText;
			dropdownArrow.classList.remove("fa-chevron-right");
			dropdownArrow.classList.add("fa-chevron-down");
		} else {
			snackbarInnerText.innerHTML = "";
			dropdownArrow.classList.remove("fa-chevron-down");
			dropdownArrow.classList.add("fa-chevron-right");
		}
	});
}
