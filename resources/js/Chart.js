import Axios from "axios";

if (document.getElementById("orders")) {
    var ctx = document.getElementById("orders").getContext("2d");
    let orders = null;
    let labels = null;

    Axios.get("/api/statistics/orders")
        .then(response => {
            orders = Object.values(response.data);
            labels = Object.keys(response.data);

            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: "line",

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Porudžbine u toku godine",
                            backgroundColor: "rgb(255, 99, 132)",
                            borderColor: "rgb(255, 99, 132)",
                            data: orders
                        }
                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(
                                        label,
                                        index,
                                        labels
                                    ) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }
                        ]
                    }
                }
            });
        })
        .catch(e => console.log(e));
}
