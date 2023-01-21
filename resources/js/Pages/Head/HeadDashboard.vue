<template>
    <EmployeeLayout :employee="employee">
        <template #content>
                <h1 class="mx-3 my-1">Dashboard</h1>
 
                <!-- <p v-show="show">{{employees[selected].fir}}</p> -->            
                <div class="flex">
                    <section>

                        <h3 class="mx-3 mb-2 h2">Options</h3>
                        
                         <!-- <select v-model="xxemployee">
                            <option v-for="xemployee in employees" :key="xemployee.id" :value="xemployee.id">{{`${xemployee.first_name} ${xemployee.last_name}`}}</option>
                        </select>  -->
                        <div class="px-3">
                        <h3 class="h3 mb--5">Employee</h3>
                        <CustomSelect class="mb-1" v-model='selected' :default_message="`${employees[selected].first_name} ${employees[selected].last_name}`" :selected="`${employees[selected].first_name} ${employees[selected].last_name}`">
                            <template #options>
                                <CustomSelectOption v-for="(xxemployee, index) in employees" :key="xxemployee.id" :id="xxemployee.id" @click="getEmployee(index)" >{{`${xxemployee.first_name} ${xxemployee.last_name}`}}</CustomSelectOption>
                            </template>
                        </CustomSelect> 



                        <div class="flex flex-col g-1">

                            <div v-if="ratings.length > 0">
                                <h3 class="h3 mb--5">Rating</h3>
                                <CustomSelect :default_message="`${rating.start_date} - ${rating.end_date}`" v-model="optionsForm.evaluation_id" :selected="`${rating.start_date} - ${rating.end_date}`">
                                    <template #options>
                                        <CustomSelectOption v-for="(rating, index) in ratings" :key="index" :id="index" @click="optionsForm.evaluation_id = rating.id">{{`${rating.start_date} - ${rating.end_date}`}}</CustomSelectOption>
                                    </template>
                                </CustomSelect>
                            </div>

                            <div v-if="self_ratings.length > 0">
                                <h3 class="h3 mb--5">Self Rating</h3>
                                <CustomSelect :default_message="`${self_rating.start_date} - ${self_rating.end_date}`" v-model="optionsForm.self_evaluation_id" :selected="`${self_rating.start_date} - ${self_rating.end_date}`">
                                    <template #options>
                                        <CustomSelectOption v-for="(self_rating, index) in self_ratings" :key="index" :id="index" @click="optionsForm.self_evaluation_id = self_rating.id">{{`${self_rating.start_date} - ${self_rating.end_date}`}}</CustomSelectOption>
                                    </template>
                                </CustomSelect> 
                            </div>


                            <!-- <CustomSelect v-model='form.mode' :default_message="modesArray[form.mode]" :selected="capitalize(modesArray[form.mode])">
                                <template #options>
                                    <CustomSelectOption v-for="(mode, index) in modesArray" :key="index" :id="index" @click="form.mode = index" >{{`${capitalize(mode)}`}}</CustomSelectOption>
                                </template>
                            </CustomSelect>

                            <div class="flex g-1">
                                <CustomSelect v-show="form.mode === 1" :default_message="monthsArray[form.month]" :selected="monthsArray[form.month]">
                                    <template #options>
                                        <CustomSelectOption v-for="(xmonth, index) in monthsArray" :key="xmonth.id" :id="xmonth.id" @click="getMonth(index)" >{{`${capitalize(xmonth)}`}}</CustomSelectOption>
                                    </template>
                                </CustomSelect>

                                <CustomSelect v-show="form.mode === 1 || form.mode === 2 || form.mode === 3 || form.mode === 4" :default_message="form.year" :selected="form.year">
                                    <template #options>
                                        <CustomSelectOption v-for="(xyear, index) in xemployee.years" :key="index" :id="index" @click="getYear(xyear)">{{xyear}}</CustomSelectOption>
                                    </template>
                                </CustomSelect> 

                                <CustomSelect v-show="form.mode === 1 || form.mode === 2 || form.mode === 3 || form.mode === 4" :default_message="form.year" :selected="form.year">
                                    <template #options>
                                        <CustomSelectOption v-for="(xyear, index) in xemployee.years" :key="index" :id="index" @click="getYear(xyear)">{{xyear}}</CustomSelectOption>
                                    </template>
                                </CustomSelect> 
                            </div> -->

                            </div> 
                        </div>
                    </section>

                    <section class="">
                    

                    <div class="flex g-1">
                    <!-- <div class="card-base px-1 py-1 my-2">
                        <h3 class="h3">{{`${xemployee.first_name} ${xemployee.last_name}`}}</h3>
                        <h5 class="h5">{{division.name}} Division</h5>
                        <div style="border-block-start: solid 1px black;" class="mt-2">
                            <span class="flex-inline flex-column align-items-center my-1">
                                <h3 class="h3 mb-1">{{employees.length}}</h3>
                                <h6 class="h6">Employees</h6>
                            </span>
                        </div>
                    </div> -->

                    <div class="card-base px-1 py-1 my-2 bg-success white">
                        <h2 class="h2 mb-1">{{tasks.completed}}</h2>
                        <p>Completed Task</p>    
                    </div>

                    <div class="card-base px-1 py-1 my-2 bg-info white">
                        <h2 class="h2 mb-1">{{tasks.active}}</h2>
                        <p>Ongoing Task</p>    
                    </div>

                    <div class="card-base px-1 py-1 propspy-1 my-2 bg-error white">
                        <h2 class="h2 mb-1">{{tasks.priority}}</h2>
                        <p>Priority Task</p>    
                    </div>

                    <div class="card-base px-1 py-1 propspy-1 my-2 bg-leave white">
                        <h2 class="h2 mb-1">{{leaves.totalLeaves}}</h2>
                        <p>Leave</p>    
                    </div>

                    <div class="card-base progress-bar-container my-2 white flex-2" :style="{backgroundColor: '#8a2be2'}">
                        <div ref="progressBar" class="progession-bar" :style="{backgroundColor: '#6f1abd', width: `${attendanceMonthly}%`}">
                                <div class="px-1 py-1">
                                    <h2 class="h2 mb-1">{{`${attendanceMonthly}%`}}</h2>
                                    <p class="">Attendance</p> 
                                </div>
                        </div>
                    </div>

                    <!-- <ProgressBar height="5vh" borderRadius="10px" :progress="`${attendanceMonthly}%`" :colors="['#8a2be2', '#6f1abd', 'white']" :content="`${attendanceMonthly}%`">

                    </ProgressBar> -->
                    </div>

                    <div class="flex">
                        <section class="">
                            <h2 class="mb-2 h2 ">Performance Report</h2>
                            <div class="flex flex-row g-2">
                            <div class="chart-holder px-1 py-1 mb-2">
                                <LineChart :id="selected" :config="performanceConfig" :data="[rating.rating, self_rating.rating]"></LineChart>
                            </div>

                            <div class="chart-holder px-1 py-1 mb-2">
                                <PieChart :id="selected" :data="[tasks.priority, tasks.active, tasks.completed]"></PieChart>
                            </div>
                            </div>
                        </section>

                        <!-- <section>
                            <h2 class="mx-3 mb-2 h2">Attendance Report</h2>
                            <div class="chart-holder px-1 py-1 mx-3 mb-2">
                                <LineChart :id="selected" :config="thisWeekAttendanceChartConfig" :data="[attendanceWeekly, attendanceMonthly]"></LineChart>
                                <LineChart :id="selected" :config="thisMonthAttendanceChartConfig" :data="[attendanceMonthly]"></LineChart>
                            </div>


                            <div></div>
                        </section> -->

                    </div>

                        <!-- <h2 class="mx-3 mb-2 h2 ">Attendance Report</h2>
                         <div class="chart-holder px-1 py-1 mx-3 mb-2">
                            <LineChart></LineChart>
                        </div>  -->
                    </section>
                </div> 
         
        </template>
    </EmployeeLayout>
</template>


<script>
    // import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import LineChart from '@/Components/Chart/LineChart.vue';
    import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
    import PieChart from '@/Components/Chart/PieChart.vue'
    import CustomSelect from '@/Components/CustomInput/CustomSelect/CustomSelect.vue'
    import CustomSelectOption from '@/Components/CustomInput/CustomSelect/CustomSelectOption.vue'    
    import Dropdown from '@/Components/Dropdown/DropdownContainer.vue'
    import DropdownItem from '@/Components/Dropdown/DropdownItem.vue'
    import {Inertia} from '@inertiajs/inertia'
    import ProgressBar from '@/Components/ProgressBar/ProgressBar.vue'
    import { useForm } from '@inertiajs/inertia-vue3';
    export default {
        components: {
            EmployeeLayout,
            LineChart,
            PrimaryButton,
            PieChart,
            CustomSelect,
            CustomSelectOption,
            Dropdown,
            DropdownItem,
            ProgressBar,
        },
        computed: {
            returnData() {
                let arr = []
                if (this.mode === 'MODE_ALL') {
                    arr = [this.employees.efficiency, this.employees[this.selected].quality, this.employees[this.selected].timeliness]
                    return arr
                }

                if (this.mode === 'MODE_MONTHLY') {
                    arr = [this.employees.performanceMonthly.efficiency]
                }
                return arr
            }
        },
        data() {
            return { 
                form: useForm({
                    id: Number(this.options.index),
                    mode: Number(this.options.mode),
                    year: Number(this.options.year),
                    month: Number(this.options.month) - 1,
                }),
                optionsForm: useForm({
                    evaluation_id: this.evaluation_id,
                    self_evaluation_id: this.self_evaluation_id  
                }),
                // selected: this.employees.findIndex((id) => id === this.options.index),
                selected: this.employees.findIndex(e => e.id === this.xemployee.id),
                // selected: 0,
                currentMode: 0,
                modes: {
                    all: 'MODE_ALL',
                    month:'MODE_MONTHLY',
                    year:'MODE_YEARLY',
                    first_half:'MODE_FIRST_HALF',
                    second_half:'MODE_SECOND_HALF',
                },
                modesArray: ['All', 'Month', 'Yearly', 'First Half', 'Second Half'],
                performanceConfig: {
                    type: 'bar',
                    data: {
                        labels: ['Rating', 'Self-Rating'],
                        datasets: [{
                            label: 'Performance',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255, 206, 86, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                // 'rgba(255, 206, 86, 1)',
                            ],
                            borderWidth: 1
                            }]
                    },
                    options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 5,
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    }
                },
                thisWeekAttendanceChartConfig: {
                    type: 'bar',
                    data: {
                        labels: ['This Week'],
                        datasets: [{
                            axis: 'y',
                            label: 'This Week',
                            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                            borderColor: ['rgba(255, 99, 132, 1)'],
                            borderWidth: 1,
                            borderSkipped: false,
                            borderRadius: 5,
                            barPercentage: 0.1,
                            categoryPercentage: 0.8,

                        }],
                    },
                    options: {
                            indexAxis: 'y',
                            plugins: {
                                legend: {
                                    display: false,
                                }
                            },
                            scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,

                                },
                                ticks: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                min: 0,
                                max: 2400,
                                grid: {
                                    display: false,
                                    drawBorder: false,

                                },
                                ticks: {
                                    display: false
                                }
                            }
                        },
                            responsive: true,
                            maintainAspectRatio: false,
                    }
                },
                thisMonthAttendanceChartConfig: {
                    type: 'bar',
                    data: {
                        labels: ['This Month'],
                        datasets: [{
                            axis: 'y',
                            label: 'This Month',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1                          
                        }],
                    },
                    options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            grid: {
                                display: false,
                            }
                    }
                },
                show: false,
                month: 1,
                selectedYear: 0,
                xxemployee: '',
                months: {
                    1: 'january',
                    2: 'february',
                    3: 'march',
                    4: 'april',
                    5: 'may',
                    6: 'june',
                    7: 'july',
                    8: 'august',
                    9: 'september',
                    10: 'october',
                    11: 'november',
                    12: 'december',
                },
                monthsArray: [
                    'January', 'February', 'March', 'April', 'May', "June", 'July', 'August', 'September', 'October', 'November', 'December'
                ],

            }
        },
        props: ['employee', 'xemployee', 'employees', 'division', 'data', 'performance', 'options', 'currentYear', 'attendance', 'attendanceWeekly', 'attendanceMonthly', 'leaves', 'tasks', 'rating', 'self_rating', 'ratings', 'self_ratings'],
        created() {
            // this.selected = Number(this.options.index)
        },
        methods: {
            getEmployee(index) {
                this.form.id = this.employees[index].id
               
                this.form.get('/head/dashboard',{
                    only: ['xemployee', 'performance', 'options', 'attendanceMonthly', 'tasks', 'rating', 'self_rating', 'ratings', 'self_ratings'],
                })
            },
            getPerformance() {
                this.form.get(`/head/dashboard`, {
                    only: ['performance', 'options'],
                    preserveScroll: true,
                })
            },

            getMonth(index) {
                this.form.month = index
            },
            getYear(year) {
                this.form.year = year
            },
            capitalize(string) {
                return string.charAt(0).toUpperCase() + string.slice(1, string.length)
            }
        },
        watch: {
            // selected() {
            //     this.form.id = this.employees[this.selected].id
            //     // this.form.mode = this.currentMode
            //     // this.form.year = this.xemployee.years[this.selectedYear]
            //     // this.form.month = this.month
             
            //     this.form.get('/head/dashboard', {
            //         only: ['xemployee', 'performance'],
            //     })
            // },
            selectedYear(){
                this.form.id = this.employees[this.selected].id
                // this.form.mode = this.currentMode
                // this.form.year = this.xemployee.years[this.selectedYear]
                // this.form.month = this.month
                this.form.get('/head/dashboard',{
                    only: ['xemployee','performance'],
                })
            },

            'optionsForm.evaluation_id'() {
                console.log(this.optionsForm)
                this.optionsForm.get('/head/dashboard',{
                    only: ['rating', 'self_rating'],
                    data: this.optionsForm,
                })
            },
            'optionsForm.self_evaluation_id'() {
                console.log(this.optionsForm)
                this.optionsForm.get('/head/dashboard',{
                    only: ['rating', 'self_rating'],
                    data: this.optionsForm,
                })
            }
        },
        mounted() {
            // this.$refs['progressBar'].style = '50%'
            console.log(this.rating)
        }

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