<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main>
                <Alert class="my-1 mx-3" type="alert-info" :message="$page.props.flash.info" v-show="showAssignedTaskSuccess" @click="showAssignedTaskSuccess = false"></Alert>
                <Alert class="my-1 mx-3" type="alert-success" :message="$page.props.flash.success" v-show="showEvaluateEmployeeSuccess" @click="showEvaluateEmployeeSuccess = false"></Alert>
                <h1 class="mx-3 my-1">Employee List</h1>
                <div class="mx-3 my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <!-- <PrimaryButton @click="toggleAssignTasks('open')">
                            <i class="bi bi-plus mr--5"></i>
                            Assign Task
                        </PrimaryButton> -->
                        <PrimaryButton @click="openOutputForm">
                            Set Evaluation Form
                        </PrimaryButton>
                        <LinkButton href="/head/tasks">
                            View Tasks
                        </LinkButton>

                        <!-- <TextButton >
                            aaa
                        </TextButton> -->
                    </div>
                    
                    <Dialog :show="showOutputForm" :exit="exitOutputForm">
                        <section>
                            <form @submit.prevent="submitOutputForm">
                            
                            <article>
                                <span>Assign to: </span>
                                
                                <select v-model="evaluateFormAssignToMode">
                                    <option value="all">All</option>
                                    <option value="selected">Selected</option>
                                </select>

                                <span class="mx-1" v-show='evaluateFormAssignToMode === "selected"'> 
                                    <select v-model="evaluateFormAssignTo">
                                        <option v-for="xemployee in employees" :key="xemployee.id" :value="xemployee.id">
                                            {{ `${xemployee.first_name} ${xemployee.last_name}` }}
                                        </option>
                                    </select>
                                </span>
                            </article>
<!-- 
                            <article>
                                <label for="startDate">From</label>
                                <input type="date">
                                <label for="enmdDate">To</label>
                                <input type="date">
                            </article> -->

                            <Table>
                                <template #table-header>
                                    <TableRow>
                                        <TableCell :isHeader="true">
                                            Output
                                        </TableCell >
                                        <TableCell :isHeader="true">
                                            Success Indicators
                                        </TableCell>
                                        <TableCell :isHeader="true">
                                            Rating
                                        </TableCell>
                                        <TableCell :isHeader="true"></TableCell>
                                    </TableRow>
                                </template>
                                <template #table-body>
                                    <TableRow v-for="(ev, index) in evaluationForm" :key="index" v-show="ev.status === 'active'">
                                        <TableCell>
                                            <div class="flex justify-content-center">
                                                <textarea rows="5" v-model="ev.output"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div class="flex">
                                                <textarea rows="5" v-model="ev.success_indicators"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <Table>
                                                <template #table-header>
                                                    <TableRow>
                                                        <TableCell :isHeader="true">Quality</TableCell>
                                                        <TableCell :isHeader="true">Efficiency</TableCell>
                                                        <TableCell :isHeader="true">Timeliness</TableCell>
                                                    </TableRow>
                                                </template>
                                                <template #table-body>
                                                    <TableRow>
                                                        <TableCell>
                                                            <textarea v-model="ev.quality_indicators"></textarea>
                                                        </TableCell>

                                                        <TableCell>
                                                            <textarea v-model="ev.efficiency_indicators"></textarea>
                                                        </TableCell>

                                                        <TableCell>
                                                            <textarea v-model="ev.timeliness_indicators"></textarea>
                                                        </TableCell>
                                                    </TableRow>
                                                </template>
                                            </Table>
                                        </TableCell>
                                        <TableCell>
                                            <div class='flex align-items-center justify-content-center'>
                                                <TextButton type='button' @click="deleteRow(index)">Delete</TextButton>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </Table>

                            <!-- <article>

                                <p>Total Average Rating: {{totalAverageRating }}</p>
                                <p>Final Average Rating: {{ finalAverageRating }}</p>
                                <p>Adjectival Rating: {{adjectivalRating}}</p>
                            </article> -->

                            <PrimaryButton type="button" class="my-1" @click="addRow">Add Row</PrimaryButton>
                            <div class="mt-1 flex g--75">
                                    <TextButton type="button" @click="closeOutputForm" class="m-inline-start-auto">Close</TextButton>
                                    <PrimaryButton type="submit" class="mr-1" >Save Changes</PrimaryButton>
                            </div>
                            </form>
                        </section>
                    </Dialog>


                    <Dialog :show="showEvaluateEmployee" :exit="exitEvaluateEmployee">
                        <section>
                            <h1 class="h1">Evaluate Employee</h1>
                            <form @submit.prevent="submitEvaluationForm">
                                
                            <article class="mt-3">
                                <div class="mb-1">
                                    <Error v-if="errors.start_date" :message="errors.start_date"></Error>
                                    <label for="startDate" class="display-block mb-1 required">From</label>
                                    <input v-model="evaluation.start_date" class="px--5 py--5" type="date" required>
                                </div>
                                <div class="mb-1">
                                    <Error v-if="errors.end_date" :message="errors.start_date"></Error>
                                    <label for="endDate" class="display-block mb-1 required" >To</label>
                                    <input v-model="evaluation.end_date" class="px--5 py--5" type="date" required>
                                </div>

                            </article>

                            <Table>
                                <template #table-header>
                                    <TableRow>
                                        <TableCell :isHeader="true">
                                            Output
                                        </TableCell >
                                        <TableCell :isHeader="true">
                                            Success Indicators
                                        </TableCell>
                                        <TableCell :isHeader="true">
                                            Rating
                                        </TableCell>
                                    </TableRow>
                                </template>
                                <template #table-body>
                                    <TableRow v-for="(ev, evIndex) in yevaluationForm" :key="evIndex" v-show="ev.status === 'active'">
                                        <TableCell>
                                            <div class="flex justify-content-center">
                                                <textarea rows="5" disabled v-model="ev.output"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div class="flex">
                                                <textarea rows="5"  disabled v-model="ev.success_indicators"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <Table class="mx-auto my-auto">
                                                <template #table-header>
                                                    <TableRow>
                                                        <TableCell :isHeader="true">Quality</TableCell>
                                                        <TableCell :isHeader="true">Efficiency</TableCell>
                                                        <TableCell :isHeader="true">Timeliness</TableCell>
                                                        <TableCell :isHeader="true">Average</TableCell>
                                                    </TableRow>
                                                </template>
                                                <template #table-body>
                                                    <TableRow>
                                                        <TableCell>
                                                            <textarea disabled v-model="ev.quality_indicators"></textarea>
                                                            <select v-model="ev.quality">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>

                                                        <TableCell >
                                                            <textarea disabled v-model="ev.efficiency_indicators"></textarea>
                                                            <select v-model="ev.efficiency">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>

                                                        <TableCell>
                                                            <textarea disabled v-model="ev.timeliness_indicators"></textarea>
                                                            <select  v-model="ev.timeliness">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>
                                                        <TableCell>
                                                            {{getAverage(evIndex, ev.quality, ev.efficiency, ev.timeliness)}}
                                                        </TableCell>
                                                    </TableRow>
                                                </template>
                                            </Table>
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </Table>

                            <Error v-if="errors.rating_required" :message="errors.rating_required"></Error>
                            <article class="my-1">
                                <p class="mb-1">Total Average Rating: {{ getSumOfAverages() }}</p>
                                <p class="mb-1">Final Average Rating: {{ getFinalAverageRating() }}</p>
                                <p class="mb-1">Adjectival Rating: {{ getAdjectivalRating()}}</p>
                            </article>


                                <div class="flex mt-2">
                                    <TextButton type="button" @click="closeEvaluateEmployee">Close</TextButton>
                                    <PrimaryButton type="submit">Submit</PrimaryButton>
                                </div>
                            </form>
                        </section>
                    </Dialog>

                    <Dialog :show="showAssignTasks" :exit="closeAssignTasks" class="my-3">
                        
                        <!-- <p>Assign to: {{ this.employees[this.assignTo].first_name }}</p> -->
                        <form @submit.prevent="submitAssignedTask">
                        
                        <section>
                            <h1 class="h1 mb-1">Assign Task</h1>
                            <div class="flex flex-row g-1">
                                <div class="left">
                                    <section class="mb-1">
                                <Error v-if="errors.task_title" :message="errors.task_title"></Error>
                                <label class="mb--5 display-block required" for="taskTitle">Output</label>
                                <!-- <input v-model="taskForm.task_title" type="text" name="taskTitle"> --> 

                                <select v-model="taskForm.task_title">
                                    <option v-for="ev in xevaluationForm" :key="ev.id" :value="ev.output">
                                        {{ev.output}}
                                    </option>
                                </select>

                            </section>
                            <section class="mb-1">
                                <h2 class="mb--5">Task description</h2>
                                <textarea v-model="taskForm.task_description" name="taskDescription" id="" cols="70" rows="10"></textarea>
                            </section>

                            <section class="mb-1">
                                <h2 class="mb--5">Attachments</h2>
                                <input @change="uploadAttachmen1ts" ref="attachments" type="file" name="taskAttachments" id="">
                            </section>
                            
                            <section>
                                <div class="mb-1">
                                    <Error v-if="errors.submission_start_date" :message="errors.submission_start_date"></Error>
                                    <h3 class="mb--5 required">Start date</h3>
                                    <input v-model="taskForm.submission_start_date" type="datetime-local" name="submission_start_date" id="">
                                </div>

                                <div class="mb-1">
                                    <Error v-if="errors.submission_due_date" :message="errors.submission_due_date"></Error>
                                    <h3 class="mb--5 required">Due date</h3>
                                    <input v-model="taskForm.submission_due_date" type="datetime-local" name="submission_due_date" id="" >
                                </div>

                            </section>
                        
                            </div>
                        </div>
                        </section>

                            <!-- 
                             <section class="mb-1">
                                <label for="assignTo" class="mr-1 required">Assign to</label>
                                <select name="assignTo" id="assignTo" v-model="assignTo">
                                    <option value="all">All</option>
                                    <option value="selected">Selected</option>
                                </select>
                            </section> 
                                </div>
                                <div class="right px-1">
                                    <section v-show="assignTo === 'selected'">
                                <h2>Select Employee</h2>
                                <div class="scrollable-y assign-employee">
                                    <Table class="assign-to">
                                        <template #table-header>
                                            <TableRow>
                                                  <TableCell :isHeader="true">
                                                    <input type="checkbox" v-model="all" name="" id="" @click="triggerAll">
                                                    Allfal
                                                </TableCelcontainer>  
                                                <TableCell :isHeader="true"> </TableCell>
                                                <TableCell :isHeader="true">Employee</TableCell>
                                            </TableRow>

                                        </template>
                                        
                                        <template #table-body>
                                            
                                            <TableRow v-for="employee in employees"  :key="employee.id">
                                                <TableCell>
                                                    <input v-model="taskForm.employee_id" type="checkbox" name="checkbox" ref="xitems" :value="employee.id">
                                                </TableCell>
                                                <TableCell>
                                                    <span>{{employee.first_name + ' ' + employee.last_name}}</span>
                                                </TableCell>
                                            </TableRow>

                                        </template>
                                    </Table> 
                                </div>
                            </section>
                                </div>
                            </div> 
                        
                        </section> -->
                        <section class="flex mt-2">
                            <TextButton type='button' class="ml-auto" @click="toggleAssignTasks('close')">Cancel</TextButton>
                            <PrimaryButton type="submit" :disabled="taskForm.processing">Assign</PrimaryButton>
                        </section>
                    </form>
                    </Dialog>
                    <!-- <section class="py-1">
                        <label for="search-employee">Search Employee</label>
                        <input type="search" name="search-employee" id="search-employee">
                    </section> -->

                    <section>
                        <Table>
                            <template #table-header> 
                                <TableRow>
                                    <TableCell :isHeader="true">First Name</TableCell>
                                    <TableCell :isHeader="true">Last Name</TableCell>
                                    <TableCell :isHeader="true">Email</TableCell>
                                    <TableCell :isHeader="true">Division</TableCell>
                                    <TableCell :isHeader="true">Position</TableCell>
                                    <TableCell :isHeader="true">Action</TableCell>
                                </TableRow>

                            </template>
                            
                            <template #table-body> 
                                <TableRow v-for="xemployee in employees" :key="xemployee.id">
                                    <TableCell>{{xemployee.first_name}}</TableCell>
                                    <TableCell>{{xemployee.last_name}}</TableCell>
                                    <TableCell>{{xemployee.email}}</TableCell>
                                    <TableCell>
                                        <!-- employee.division_id == division[division_id] -->
                                        {{divisions.name}}
                                    </TableCell>
                                    <TableCell>{{xemployee.position}}</TableCell>
                                    <TableCell>
                                        <div class="flex justify-content-center">
                                            <PrimaryButton @click="toggleAssignTasks('open', xemployee.id)">
                                                <i class="bi bi-plus mr--5"></i>
                                                Assign Task
                                            </PrimaryButton>
                                            <PrimaryButton @click="openEvaluateEmployee(xemployee.id)">Evaluate</PrimaryButton>
                                            <LinkButton :href="`/head/employee/${xemployee.id}`">View</LinkButton>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </Table>
                    </section>
                </div>
            </main>
        </template>
    </EmployeeLayout>
</template>

<script>
    import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
    import OutlineButton from '@/Components/Button/OutlineButton.vue'
    import Link from '@inertiajs/inertia-vue3'
    import LinkButton from '@/Components/Button/LinkButton.vue';
    import TextButton from '@/Components/Button/TextButton.vue';
    import Table from '@/Components/Table/Table.vue';
    import TableCell from '@/Components/Table/TableCell.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import Dialog from '@/Components/Dialog/CustomDialog.vue';
    import Error from '@/Components/Error.vue';
    import {Inertia} from '@inertiajs/inertia';1
    import { useForm } from '@inertiajs/inertia-vue3';
    import Alert from '@/Components/Alert/Alert.vue'
    export default {
        components: {
            EmployeeLayout,
            Table,
            Link,
            TableRow,
            TableCell,
            TextButton,
            LinkButton,
            PrimaryButton,
            OutlineButton,
            Dialog,
            Error,
            Alert,
        },

        props: {
            employees: Object,
            divisions: Object,
            errors: Object,
            employee: Object,
            xevaluationForm: Object,
        },

        data() {
            return {
                show: false,
                close: false,
                showAssignTasks: false,
                closeAssignTasks: false,
                showEvaluateEmployee: false,
                exitEvaluateEmployee: false,
                showOutputForm: false,
                exitOutputForm: false,
                outputForm: useForm({
                    output: '',
                    target: '',
                }),
                
                quality: [1,2,3,4,5],
                zero: 0,
                efficiency: [1,2,3,4,5],
                timeliness: [1,2,3,4,5],
                showEvaluationForm: false,
                exitEvaluationForm: false,
                evaluateFormAssignTo: this.employees[0].employee_id,
                evaluateFormAssignToIndex: 0,
                evaluateFormAssignToMode: 'all',
                evaluateFormAssignToAll: [],
                evaluationForm: [
                    {
                        id: '',
                        output: '',
                        success_indicators: '',
                        quality_indicators: '', 
                        efficiency_indicators: '', 
                        timeliness_indicators: '',
                        status: 'active', 
                    }
                ],
                yevaluationForm: [],
                evaluation: useForm({
                    employee_id: '',
                    start_date: '',
                    end_date: '',
                    totalAverageRating: 0,
                    finalAverageRating: 0,
                    adjectivalRating: '',
                }),
                // evaluationForm: [],
                adjRating: [
                    "Poor",
                    "Unsatisfactory",
                    "Satisfactory",
                    "Very Satisfactory",
                    "Outstanding",
                ],
                scores: [5,4,3,2,1],
                totalAverageRating: 0,
                finalAverageRating: 0,
                adjectivalRating: '',
                assignTo: 'all',
                all: false,
                filterDivision: 0,
                showEvaluateEmployeeSuccess: false,
                showAssignedTaskSuccess: false,
                showEditAssignedTaskSuccess: false,
                taskForm: useForm({
                    'employee_id': '',
                    'head_id': this.employee.id,
                    'task_title': '',
                    'task_description': '',
                    'attachments': '',
                    'submission_start_date': '',
                    'submission_due_date': '',
                }),
            }
        },

        methods: {
            toggleDialog() {
                this.show = !this.show
            },

            closeDialog(){
                this.close = !this.close
            },
            openEvaluateEmployee(id) {
                this.yevaluationForm.length = 0
                this.xevaluationForm.forEach(ev => {
                    if (ev.employee_id === id) {
                        this.yevaluationForm.push({
                            id: ev.id,
                            employee_id: ev.employee_id,
                            output: ev.output,
                            success_indicators: ev.success_indicators,
                            quality_indicators: ev.quality_indicators,
                            efficiency_indicators: ev.efficiency_indicators,
                            timeliness_indicators: ev.timeliness_indicators,
                            status: ev.status,
                            quality: 0,
                            efficiency: 0,
                            timeliness: 0,
                            average: 0,
                        })
                    }
                })
                this.evaluation.employee_id = id
                this.showEvaluateEmployee = !this.showEvaluateEmployee
            },
            closeEvaluateEmployee(){
                this.exitEvaluateEmployee = !this.exitEvaluateEmployee
            },
            openOutputForm() {
                // if (this.xevaluationForm.length > 1) {
                //     this.xevaluationForm.forEach((ev) => {
                //         this.evaluationForm.push({
                //             output: ev.output,
                //             success_indicators: ev.success_indicators,
                //             quality_indicators: ev.quality_indicators,
                //             efficiency_indicators: ev.efficiency_indicators,
                //             timeliness_indicators: ev.timeliness_indicators,
                //         })
                //     });
                // } 
                //         this.evaluationForm[0].output =this.xevaluationForm[0].output
                //         this.evaluationForm[0].success_indicators = this.xevaluationForm[0].success_indicators
                //         this.evaluationForm[0].quality_indicators = this.xevaluationForm[0].quality_indicators
                //         this.evaluationForm[0].efficiency_indicators = this.xevaluationForm[0].efficiency_indicators
                //         this.evaluationForm[0].timeliness_indicators = this.xevaluationForm[0].timeliness_indicators
        
                this.showOutputForm = !this.showOutputForm
            },
            closeOutputForm(){
                this.exitOutputForm = !this.exitOutputForm
            },
            uploadAttachments() {
                this.taskForm.attachments = this.$refs.attachments.files
            },
            toggleAssignTasks(flag, id) {
                this.assignTo = id
                if (flag == 'open')
                    this.showAssignTasks = !this.showAssignTasks
                else {
                    this.closeAssignTasks = !this.closeAssignTasks
                }
            },
            addRow() {
                    this.evaluationForm.push(
                        {
                            id: '',
                            output: '',
                            success_indicators: '',
                            quality_indicators: '', 
                            efficiency_indicators: '', 
                            timeliness_indicators: '',
                            status: 'active' 
                        }
                    )
                },
                deleteRow(index) {
                    
                    // this.evaluationFormReal.push(this.evaluationForm[index])
                    this.evaluationForm[index].status = 'inactive'
                    // this.evaluationForm.splice(index, 1)
                
                },

                getAverage(ev, ...params){
                    let a = 0
                    let l = 0
                    let ave = 0
                    params.forEach(p => {
                        if (p > 0) {
                            a += p
                            l += 1
                        } 
                    })
                    
                    ave = l <= 0 ? 0 : (a / l).toFixed(2)
                    this.yevaluationForm[ev].average = (a / l)
                    return ave
                },
                getFinalAverageRating() {
                    return this.evaluation.finalAverageRating
                },
                getAdjectivalRating() {
                    this.evaluation.adjectivalRating = this.adjRating[Math.floor(this.evaluation.finalAverageRating) - 1]
                    return this.adjRating[Math.floor(this.evaluation.finalAverageRating) - 1]
                },
                getSumOfAverages() {
                    let ave = 0
                    this.yevaluationForm.forEach(a => {
                        ave += a.average
                    })

                    this.evaluation.totalAverageRating = ave
                    this.evaluation.finalAverageRating = (isNaN(ave)) ? 0 : (ave / this.yevaluationForm.length).toFixed(2)

                    return (isNaN(ave)) ? 0 : ave
                },
                total(){

                },
                getEvaluationForm() {
                    Inertia.visit('/head/employees', {
                        only: ['xxemployee', 'evaluation_form'],
                    })
                },

            submitAssignedTask() {
                this.taskForm.submission_start_date = new Date(this.taskForm.submission_start_date).toISOString()
                this.taskForm.submission_due_date = new Date(this.taskForm.submission_due_date).toISOString()
                this.taskForm.employee_id = this.assignTo
                // if (this.assignTo === 'all') {
                //     this.employees.forEach((employee) => {
                //         this.taskForm.employee_id.push(employee.id)
                //     })
                // } 

                Inertia.post('/assign/task/store', this.taskForm, {
                    onSuccess: ()=> {
                        this.taskForm.reset()
                        this.toggleAssignTasks('close')
                        this.showAssignedTaskSuccess = true
                    } 
                })
            },

            submitOutputForm(){
                
                this.employees.forEach(e => {
                    this.evaluateFormAssignToAll.push({id: e.id})
                })
                Inertia.post('/head/evaluationForm/store', {'evaluation_form': this.evaluationForm, 'employee_id':this.evaluateFormAssignTo, 'division_id':this.divisions.id, 'mode': this.evaluateFormAssignToMode, 'employees': this.evaluateFormAssignToAll}, {
                    onSuccess: () => {
                        this.exitOutputForm = !this.exitOutputForm
                    }
                })
            },

            submitEvaluationForm() {
                this.evaluation.post('/head/evaluate', {
                    onSuccess: () => {
                        console.log('x')
                        this.exitEvaluateEmployee = !this.exitEvaluateEmployee
                        this.showEvaluateEmployeeSuccess = true
                    }
                })
            }

        },
        watch: {
            // all() {
            //     if (this.all === true) {
            //         this.$refs.xitems.forEach(item => {
            //             item.checked = true
            //             this.taskForm.employee_id.push(item)
            //         });
            //     } else {
            //         this.$refs.xitems.forEach(item => {
            //             item.checked = false
            //             this.taskForm.employee_id.pop()
            //         });
            //     }
            // },

            showAssignedTaskSuccess() {
                setTimeout(() => {
                    this.showAssignedTaskSuccess = false
                }, 3000);
            },
            showEvaluateEmployeeSuccess() {
                setTimeout(() => {
                    this.showEvaluateSuccess = false
                }, 1000);
            },
            evaluateFormAssignTo() {
                this.evaluationForm.length = 0
                this.xevaluationForm.forEach(ev => {
                    if (ev.employee_id === this.evaluateFormAssignTo) {
                        this.evaluationForm.push({
                            id: ev.id,
                            employee_id: ev.employee_id,
                            output: ev.output,
                            success_indicators: ev.success_indicators,
                            quality_indicators: ev.quality_indicators,
                            efficiency_indicators: ev.efficiency_indicators,
                            timeliness_indicators: ev.timeliness_indicators,
                            status: ev.status,
                        })
                    }
                })
            },
            evaluateFormAssignToMode() {
                if (this.evaluateFormAssignToMode === 'all') {
                    
                    this.evaluationForm.length = 0
                }
            },

        },  
        
        mounted() {
        }
    }
</script>