<template>
    <canvas width="1" height="1" ref="pieChart" id="pieChart"></canvas>
</template>

<script>
    import Chart from 'chart.js/auto';
    export default {

        props: [
            'complete', 'active', 'priority', 'id', 'data'
        ],

        mounted() {
            const ctx = this.$refs.pieChart
            const xchart = this.myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                labels: [
                    'Priority Tasks',
                    'Ongoing  Tasks',
                    'Completed Tasks'
                ],
                datasets: [{
                        label: 'My First Dataset',
                        data: this.data,
                        backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // console.log(this.myChart.data.datasets[0].data)
        },
        // beforeUpdate() {
        //                     this.myChart.data.datasets[0].data = [this.priority, this.active, this.complete]
        //         this.myChart.update()
        //     console.log(this.myChart.data.datasets)
        //     // this.myChart = this.$refs.pieChart
        //     // this.$nextTick(() => {
        //     //     this.myChart.data.datasets[0].data = [this.priority, this.active, this.complete]
        //     //     this.myChart.update()
        //     // })

        // },
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
              
                // console.log(this.myChart)
                // this.$refs.pieChart.data.datasets[0].data = [this.priority, this.active, this.complete]
                // // this.myChart.update()
                // this.$nextTick(()=> {
                //     this.$refs.pieChart.update()
                // })
            
        },
        updated() {
            // this.myChart.update()
            // this.$nextTick(()=>this.myChart.update())
        }
    }
</script>