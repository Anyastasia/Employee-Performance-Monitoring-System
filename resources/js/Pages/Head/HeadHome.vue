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
                                        <option :value="0" disabled>Select Employee</option>
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
                                    <PrimaryButton v-if="evaluateFormAssignTo === 0 && evaluateFormAssignToMode === 'selected'" disabled type="submit" class="mr-1" >Save Changes</PrimaryButton>
                                    <PrimaryButton v-else type="submit" class="mr-1" >Save Changes</PrimaryButton>
                            </div>
                            </form>
                        </section>
                    </Dialog>


                    <Dialog :show="showEvaluateEmployee" :exit="exitEvaluateEmployee">
                        <section>
                            <h1 class="h1">Evaluate Employee</h1>
                            <form @submit.prevent="submitEvaluationForm">
                                
                            <article class="mt-3">
                                <div class="flex">
                                    <div class="left">
                                        <div>
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
                                        </div>
                                        
                                        <div>
                                            <label for="select-dates-from">
                                                Previous Rating(s):
                                            </label>

                                            <select name="select-dates-from" v-model="previousRating">
                                                <option :value="0">Select Date</option>
                                                <option v-for="ev in evaluations"  :value="ev.id" :key="ev.index">{{ `${ev.start_date} - ${ev.end_date}` }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="right ml-2">
                                        <div class="mb-1">
                                            <span>Employee Self Rating(s): </span>
                                            <select v-model="self_evaluation_id">
                                                <option disabled :value="0">Select Date</option>
                                                <option v-for="(self_ev, index) in self_evaluations" :key="index" :value="self_ev.id">{{ `${self_ev.start_date} - ${self_ev.end_date}` }}</option>
                                            </select>
                                        </div>

                                        <div v-if="self_evaluation_id !== 0">
                                            <p class="mb-1">Final Average Rating: {{ self_evaluation.rating }}</p>
                                            <p class="mb-1">Adjectival Rating: {{ self_evaluation.adjectival_rating}}</p>
                                        </div>
                                    </div>
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
                                            Actual Accomplishments
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
                                            <div class="flex">
                                                <textarea rows="5" v-model="ev.actual_accomplishments"></textarea>
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
                                    <option v-for="(output, index) in outputs" :key="index" :value="output">
                                        {{ output }}
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

                            
                             <!-- <section class="mb-1">
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
                                                    All
                                                </TableCell>  
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
                                        <div class="flex justify-content-center mr-auto">
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
    import {Inertia} from '@inertiajs/inertia';
    import { useForm, router } from '@inertiajs/inertia-vue3';
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
            evaluations: Object,
            evaluation_scores: Object,
            self_evaluations: Object,
            self_evaluation: Object,
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
                self_evaluation_id: 0,
                previousRating: 0,
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
                        actual_accomplishments: '',
                        quality_indicators: '', 
                        efficiency_indicators: '', 
                        timeliness_indicators: '',
                        status: 'active', 
                    }
                ],
                yevaluationForm: [],
                evaluation: useForm({
                    employee_id: '',
                    evaluated_by: this.employee.id,
                    start_date: '',
                    end_date: '',
                    self: false,
                    totalAverageRating: 0,
                    finalAverageRating: 0,
                    adjectivalRating: '',
                    scores: [],
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
                outputs: [],
                employee_id: '',
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
                this.employee_id = id
                this.evaluation.employee_id = id
                Inertia.reload({
                    only: ['xevaluationForm', 'evaluations', 'self_evaluations'],
                    data: {
                        employee_id: id
                    },
                    onSuccess: () => {
                        console.log(this.self_evaluations)
                        this.showEvaluateEmployee = !this.showEvaluateEmployee
                        this.yevaluationForm.length = 0
                        this.xevaluationForm.forEach(ev => {
                            if (ev.employee_id === id) {
                                this.yevaluationForm.push({
                                    id: ev.id,
                                    employee_id: ev.employee_id,
                                    output: ev.output,
                                    success_indicators: ev.success_indicators,
                                    actual_accomplishments: ev.actual_accomplishments,
                                    quality_indicators: ev.quality_indicators,
                                    efficiency_indicators: ev.efficiency_indicators,
                                    timeliness_indicators: ev.timeliness_indicators,
                                    status: ev.status,
                                    quality: Number(0),
                                    efficiency: Number(0),
                                    timeliness: Number(0),
                                    average: Number(0),
                                })
                            }
                        })
                    }
                })
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
                if (flag == 'open') {
                    Inertia.reload({
                        only: ['xevaluationForm'],
                        data: {
                            employee_id: id
                        },
                        onSuccess: ()=> {
                            this.showAssignTasks = !this.showAssignTasks
                            this.outputs.length = 0
                            this.xevaluationForm.forEach(ev => {
                                this.outputs.push(ev.output)
                            })
                        }
                    })


                }
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
                            a = a + p
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
                        this.evaluationForm.length = 0
                    }
                })
            },

            submitEvaluationForm() {
                this.yevaluationForm.forEach(ev => {
                    this.evaluation.scores.push({
                        evaluation_form_id: ev.id,
                        quality_average: ev.quality,
                        efficiency_average: ev.efficiency,
                        timeliness_average: ev.timeliness,
                        
                    })
                })
                this.evaluation.post('/head/evaluate', {
                    onSuccess: () => {
                        this.exitEvaluateEmployee = !this.exitEvaluateEmployee
                        this.showEvaluateEmployeeSuccess = true
                    }
                })

                // Inertia.post('/head/evaluate',{
                //     evaluation: this.evaluation,
                //     evaluation_scores: this.yevaluationForm
                // }, {
                //     onSuccess: () => {
                //         console.log('x')
                //         this.exitEvaluateEmployee = !this.exitEvaluateEmployee
                //         this.showEvaluateEmployeeSuccess = true
                //     }
                // })
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

            self_evaluation_id() {
                Inertia.reload({
                    only: ['self_evaluation'],
                    data: {
                        evaluation_id: this.self_evaluation_id
                    },
                })
            },
            previousRating() {
                    Inertia.reload({
                        only: ['evaluation_scores', 'xevaluationForm'],
                        data: {
                            employee_id: this.employee_id,
                            evaluation_id: this.previousRating
                        },
                        onSuccess: ()=>{
                            this.yevaluationForm.length = 0
                            this.xevaluationForm.forEach((ev, index) => {
                                    this.yevaluationForm.push({
                                        id: ev.id,
                                        employee_id: ev.employee_id,
                                        output: ev.output,
                                        success_indicators: ev.success_indicators,
                                        actual_accomplishments: ev.actual_accomplishments,
                                        quality_indicators: ev.quality_indicators,
                                        efficiency_indicators: ev.efficiency_indicators,
                                        timeliness_indicators: ev.timeliness_indicators,
                                        status: ev.status,
                                        quality: this.evaluation_scores[index].quality_average,
                                        efficiency: this.evaluation_scores[index].efficiency_average,
                                        timeliness: this.evaluation_scores[index].timeliness_average,
                                    })  
                            })
                            this.openEvaluateEmployee = !this.openEvaluateEmployee
                        }
                    })

                    // this.xevaluationForm.forEach(ev => {
                    //     this.yevaluationForm.push({
                    //         id: ev.id,
                    //         employee_id: ev.employee_id,
                    //         output: ev.output,
                    //         success_indicators: ev.success_indicators,
                    //         actual_accomplishments: ev.actual_accomplishments,
                    //         quality_indicators: ev.quality_indicators,
                    //         efficiency_indicators: ev.efficiency_indicators,
                    //         timeliness_indicators: ev.timeliness_indicators,
                    //         status: ev.status,
                    //         quality: 2,
                    //         efficiency: 2,
                    //         timeliness: 3,
                    //         average: 4,
                    //     })    
                    // })
            },
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
                Inertia.reload({
                    only: ['xevaluationForm'],
                    data: {
                        employee_id: this.evaluateFormAssignTo,
                    },
                    onSuccess: ()=>{
                        console.log('reload success')
                        this.evaluationForm.length = 0
                        if (this.evaluateFormAssignTo === 0) {
                            this.evaluationForm.push({
                                id: '',
                                output: '',
                                success_indicators: '',
                                actual_accomplishments: '',
                                quality_indicators: '', 
                                efficiency_indicators: '', 
                                timeliness_indicators: '',
                                status: 'active', 
                            })
                        } else {
                            this.xevaluationForm.forEach(ev => {
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
                            })
                        }

                    }
                })
            },
            evaluateFormAssignToMode() {
                // Inertia.reload()
                this.evaluationForm.length = 0
                this.evaluateFormAssignTo = 0
                this.evaluationForm.push({
                    id: '',
                    output: '',
                    success_indicators: '',
                    actual_accomplishments: '',
                    quality_indicators: '', 
                    efficiency_indicators: '', 
                    timeliness_indicators: '',
                    status: 'active', 
                })
                
            },

        },  
        
        mounted() {
            
        }
    }
</script>