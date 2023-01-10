<template>
    <canvas width="1" height="1" ref="lineChart" id="lineChart"></canvas>
</template>

<script>
    import Chart from 'chart.js/auto';
    export default {

        props: ['config', 'data', 'id'],
        computed: {
            evaluateData() {
                const xdata = []
                this.data.forEach(categories => {
                    if (categories === null)
                        xdata.push(0)
                    else
                        xdata.push(categories)
                })  
                return xdata
            }
        },
        mounted() {
            const ctx = this.$refs.pieChart
            const xchart = this.myChart  = new Chart(this.$refs.lineChart, {
                type: this.config.type,
                data: {
                    labels: this.config.data.labels,
                    datasets: [{
                        label: this.config.data.datasets[0].label,
                        data: this.evaluateData,
                        backgroundColor: this.config.data.datasets[0].backgroundColor,
                        borderColor: this.config.data.datasets[0].borderColor,
                        borderWidth: this.config.data.datasets[0].borderWidth,
                    }]
                },
                options: this.config.options
            });
        },

        watch: {
            id: {
                    handler(){
                        // this.myChart.data.datasets[0].data.complete = this.complete
                        // this.myChart.data.datasets[0].data.active = this.active
                        // this.myChart.data.datasets[0].data.priority = this.priority
                        this.myChart.data.datasets[0].data = this.data
                        this.myChart.update()
                    },
                },
        }
    }
</script>