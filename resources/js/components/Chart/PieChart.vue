<script>
import { Pie, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;
export default {
    extends: Pie,
    mixins: [reactiveProp],
    props: {
        chartData: {
            type: Array | Object,
            required: false
        },
        chartLabels: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            options: {
                showScale: true,
                animation: {
                    easing: "easeInQuad"
                },
                tooltips: {
                    backgroundColor: "#4F5565",
                    titleFontStyle: "normal",
                    titleFontSize: 18,
                    bodyFontFamily: "'Proxima Nova', sans-serif",
                    cornerRadius: 3,
                    bodyFontSize: 14,
                    xPadding: 14,
                    yPadding: 14,
                    displayColors: false,
                    mode: "index",
                    intersect: false,
                    callbacks: {
                        title: tooltipItem => {
                            return `${tooltipItem[0].xLabel}`;
                        },
                        label: (tooltipItem, data) => {
                            let dataset =
                                data.datasets[tooltipItem.datasetIndex];
                            let currentValue = dataset.data[tooltipItem.index];
                            return `${currentValue.toLocaleString()} ${
                                currentValue ? "patients" : "patient"
                            }`;
                        }
                    }
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    methods: {
        formatNumber(num) {
            let numString = Math.round(num).toString();
            let numberFormatMapping = [
                [6, "m"],
                [3, "k"]
            ];
            for (let [numberOfDigits, replacement] of numberFormatMapping) {
                if (numString.length > numberOfDigits) {
                    let decimal = "";
                    if (numString[numString.length - numberOfDigits] !== "0") {
                        decimal =
                            "." + numString[numString.length - numberOfDigits];
                    }
                    numString =
                        numString.substr(0, numString.length - numberOfDigits) +
                        decimal +
                        replacement;
                    break;
                }
            }
            return numString;
        }
    },
    mounted() {
        this.renderChart(this.chartData, this.options);
    }
};
</script>
