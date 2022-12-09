<template>
    <EmployeeLayout :employee="employee">
        <template #content>
                <h1 class="mx-3 my-1">Dashboard</h1>
                <div class="card-base px-1 py-1 my-2 mx-3">
                    <h3 class="h3">{{`${employee.first_name} ${employee.last_name}`}}</h3>
                    <h5 class="h5">{{division.name}} Division</h5>
                    <div style="border-block-start: solid 1px black;" class="mt-2">
                        <span class="flex-inline flex-column align-items-center my-1">
                            <h3 class="h3 mb-1">{{employees.length}}</h3>
                            <h6 class="h6">Employees</h6>
                        </span>
                    </div>
                </div>
                
                <h2 class="mx-3 mb-2 h2 ">Performance Report</h2>
                <div class="chart-holder px-1 py-1 mx-3 mb-2">
                    <LineChart></LineChart>
                </div>

                <h2 class="mx-3 mb-2 h2 ">Attendance Report</h2>
                <div class="chart-holder px-1 py-1 mx-3 mb-2">
                    <LineChart></LineChart>
                </div>

        </template>
    </EmployeeLayout>
</template>

<script>
    // import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import LineChart from '@/Components/Chart/LineChart.vue';
    import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
    export default {
        components: {
            EmployeeLayout,
            LineChart,
            PrimaryButton,
        },
        props: ['employee', 'employees', 'division',],
    }
</script>

<style>

.chart-holder {
    width: 20vw;
    height: 40vh;
    background-color: white;
    border-radius: var(--corner-radius);
}
</style>