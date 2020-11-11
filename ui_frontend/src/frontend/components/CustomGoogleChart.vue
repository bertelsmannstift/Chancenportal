<template>
    <div class="chart__wrapper" :loading="isLoading">
        <div v-if="isLoading" class="chart__loader">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
              viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#000" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                  <animateTransform
                     attributeName="transform"
                     attributeType="XML"
                     type="rotate"
                     dur="1s"
                     from="0 50 50"
                     to="360 50 50"
                     repeatCount="indefinite" />
              </path>
            </svg>
        </div>
        <div class="chart" ref="chart">

            <div v-if="rowData && rowData.length > 0" ref="google_chart">

            </div>
            <div v-else><strong v-if="noEntries">{{noEntries}}</strong></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            labels: {
                type: String,
                default: null
            },
            data: {
                type: String,
                default: null
            },
            noEntries: {
                type: String,
                default: null
            },
            currentKw: {
                type: String,
                default: null
            }
        },
        name: "CustomGoogleChart",
        data() {
            return {
                isLoading: true,
                labelData: [],
                rowData: [],
            }
        },
        methods: {
            drawChart() {

                let data = google.visualization.arrayToDataTable([
                    this.labelData,
                    ...this.rowData,
                ]);

                let minWidth = this.rowData.length * 28;

                // Set chart options
                let options = {
                    'height': 400,
                    'width': minWidth < 769 ? 769 : minWidth,

                    vAxis: {
                        format: '0',
                        minValue: 0,
                        viewWindow: {
                            //max: 1000,
                            min: 0
                        }
                    },
                    chartArea: {
                        left: 60,
                        right: 60,
                        bottom: 50,
                        top: 50,
                        width: '80%',
                        height: '70%',
                    },
                    legend: {position: "none"}
                };

                // Instantiate and draw our chart, passing in some options.
                let chart = new google.visualization.ColumnChart(this.$refs.google_chart);
                chart.draw(data, options);

                if (this.currentKw && minWidth > 769) {

                    setTimeout(() => {
                        $(this.$refs.chart).stop().animate({
                            'scrollLeft': $(this.$refs.chart).find('rect[fill="#f9b000"]').offset().left - $(this.$refs.chart).offset().left - $(this.$refs.chart).width() / 2
                        }, 300);
                    }, 500)
                }
                this.isLoading = false;
            },
            initChart() {
                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(this.drawChart);
            }
        },
        mounted() {
            this.$nextTick(() => {
                try {
                    $(this.$el).parents('form').submit(() => {
                        this.isLoading = true;
                        this.$forceUpdate();
                    });
                    this.labelData = JSON.parse(this.labels);
                    this.rowData = JSON.parse(this.data);

                    if (this.rowData.length && this.labelData.length) {
                        this.initChart();
                    } else {
                        this.isLoading = false;
                    }
                } catch (e) {
                    this.isLoading = false;
                }
            });
        }
    }
</script>

<style lang="scss">
    custom-google-chart {
        display: block;
        width: 100%;
    }

    .chart__wrapper {
        position: relative;
    }

    .chart {
        position: relative;
        min-height: 50px;
        overflow-x: auto;
        overflow-y: hidden;
        width: 100%;
    }

    .chart__loader {
        min-height: 100px;
        padding: 20px;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        svg {
            height: 80px;
            width: 80px;
        }
    }
</style>
