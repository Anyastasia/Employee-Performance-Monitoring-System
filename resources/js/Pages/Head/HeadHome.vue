<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main>
                <h1 class="mx-3 my-1">Employee List</h1>
                <div class="mx-3 my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <PrimaryButton @click="toggleAssignTasks('open')">
                            <i class="bi bi-plus mr--5"></i>
                            Assign Task
                        </PrimaryButton>

                        <!-- <TextButton >
                            aaa
                        </TextButton> -->
                    </div>
                    
                    <Dialog :show="showAssignTasks" :exit="closeAssignTasks" class="my-3">
                        <form @submit.prevent="submitAssignedTask">
                        
                        <section>
                            <h1 class="h1 mb-1">Assign Task</h1>
                            <div class="flex flex-row g-1">
                                <div class="left">
                                    <section class="mb-1">
                                <Error v-if="errors.task_title" :message="errors.task_title"></Error>
                                <label class="mb--5 display-block required" for="taskTitle">Task Title</label>
                                <input v-model="taskForm.task_title" type="text" name="taskTitle">
                            </section>
                            <section class="mb-1">
                                <h2 class="mb--5">Task description</h2>
                                <textarea v-model="taskForm.task_description" name="taskDescription" id="" cols="70" rows="10"></textarea>
                            </section>

                            <section class="mb-1">
                                <h2 class="mb--5">Attachments</h2>
                                <input @change="uploadAttachments" ref="attachments" type="file" name="taskAttachments" id="">
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
                                                <!-- <TableCell :isHeader="true">
                                                    <input type="checkbox" v-model="all" name="" id="" @click="triggerAll">
                                                    Allfalse
                                                </TableCelcontainerl> -->
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
                                                    <span>{
                        <select v-model="filterDivision" name="filter-division" id="filter-division">
                            <option value="0">All</option>
                            <option v-for="division in divisions" :key="division.id" :value="division.id">{{division.name}}</option>
                        </select>{employee.first_name + ' ' + employee.last_name}}</span>
                                                </TableCell>
                                            </TableRow>

                                        </template>
                                    </Table>
                                </div>
                            </section>
                                </div>
                            </div>
                        
                        </section>
                        <section class="flex mt-2">
                            <TextButton type='button' class="ml-auto" @click="toggleAssignTasks('close')">Cancel</TextButton>
                            <PrimaryButton type="submit" :disabled="taskForm.processing">Assign</PrimaryButton>
                        </section>
                    </form>
                    </Dialog>
                    <section class="py-1">
                        <label for="search-employee">Search Employee</label>
                        <input type="search" name="search-employee" id="search-employee">
                    </section>

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
                                            <LinkButton :href="`/view/employee/${xemployee.id}`">View</LinkButton>
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
    import LinkButton from '@/Components/Button/LinkButton.vue';
    import TextButton from '@/Components/Button/TextButton.vue';
    import Table from '@/Components/Table/Table.vue';
    import TableCell from '@/Components/Table/TableCell.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import Dialog from '@/Components/Dialog/CustomDialog.vue';
    import Error from '@/Components/Error.vue';
    import {Inertia} from '@inertiajs/inertia';
    import { useForm } from '@inertiajs/inertia-vue3';
    
    export default {
        components: {
            EmployeeLayout,
            Table,
            TableRow,
            TableCell,
            TextButton,
            LinkButton,
            PrimaryButton,
            Dialog,
            Error
        },

        props: {
            employees: Object,
            divisions: Object,
            errors: Object,
            employee: Object,
        },

        data() {
            return {
                show: false,
                close: false,
                showAssignTasks: false,
                closeAssignTasks: false,
                assignTo: 'all',
                all: false,
                filterDivision: 0,

                taskForm: useForm({
                    'employee_id': [],
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

            uploadAttachments() {
                this.taskForm.attachments = this.$refs.attachments.files
            },
            toggleAssignTasks(flag) {

                if (flag == 'open')
                    this.showAssignTasks = !this.showAssignTasks
                else {
                    this.closeAssignTasks = !this.closeAssignTasks
                }
            },

            submitAddEmployee() {
                // console.log(this.addEmployeeForm)
                Inertia.post('/register/employee/store', this.addEmployeeForm)
            },

            submitAssignedTask() {


                // this.taskForm.submission_start_date = new Date(this.taskForm.submission_start_date).toISOString()
                // this.taskForm.submission_due_date = new Date(this.taskForm.submission_due_date).toISOString()

                if (this.assignTo === 'all') {
                    this.employees.forEach((employee) => {
                        this.taskForm.employee_id.push(employee.id)
                    })
                } 

                Inertia.post('/assign/task/store', this.taskForm, {
                    onSuccess: ()=> {
                        this.taskForm.reset()
                        this.toggleAssignTasks('close')
                    } 
                })
            },

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

            
        },  
        
        mounted() {
            console.log(this.employees)
        }
    }
</script>