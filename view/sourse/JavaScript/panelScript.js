// Total sales chart
if (document.body.contains(document.querySelector(".overview"))) {
    const TotalSalesCanvas = document.getElementById("total-sales-chart");

    const formatDate = (date) => {
        const day = date.getDate();
        const month = date.toLocaleString("default", { month: "short" });
        return `${month} ${day}`;
    };

    const today = new Date(); // Поточна дата
    const startDate = new Date(); // Дата 28 днів тому
    startDate.setDate(today.getDate() - 27);

    // Генерація міток для графіка
    const labels = [];
    const daysCount = 28;

    for (let i = 0; i < daysCount; i++) {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);
        labels.push(formatDate(date));
    }

    // Налаштування даних для графіка
    const TotalSalesChart_data = {
        labels: labels,
        datasets: [
            {
                label: "Total sales per day",
                data: totalSalesPhpArray, // Данні з PHP
                fill: true,
                backgroundColor: "rgba(154, 168, 177, 0.1)",
                borderColor: "rgb(130, 179, 126)",
                tension: 0.1,
            },
        ],
    };

    // Ініціалізація графіка
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
                    display: true,
                    suggestedMin: 0,
                    suggestedMax: Math.max(...totalSalesPhpArray) + 2,
                },
                x: {
                    ticks: { display: false }, // Показувати дати на осі X
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
        const dropdownArrow = document.getElementById("snackbar-dropdown-arrow");

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
