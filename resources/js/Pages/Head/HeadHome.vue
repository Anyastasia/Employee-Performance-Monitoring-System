<template>
    <HeadLayout>
        <template #content>
            <main>
                <h1 class="mx-3 my-1">Employee List</h1>
                <div class="mx-3 my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <PrimaryButton @click="toggleDialog">
                            <i class="bi bi-plus mr--5"></i>
                            Add Employee
                        </PrimaryButton>

                        <TextButton @click="toggleAssignTasks('open')">
                            Assign Task
                        </TextButton>
                    </div>
                    
                    <Dialog :show="show" :exit="close" class="my-3">
                        <section>
                            <form @submit.prevent="" class="add-staff">
                                <h1 class="my-1 h1">Add Employee</h1>
                                <h6 class="my-1 h6">
                                    <em>All fields required</em>
                                </h6>
                                <div class="add-staff-name">
                                    <div>
                                        <label for="first_name" class="required">First Name</label>
                                        <input type="text" id="firstname" v-model="addEmployeeForm.first_name" name="first_name" required>
                                    </div>

                                    <div>
                                        <label for="first_name" class="required">Last Name</label>
                                        <input type="text" id="lastname" v-model="addEmployeeForm.last_name" name="last_name" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="required">Email</label>
                                    <input type="email" name="email" v-model="addEmployeeForm.email" id="email" required>
                                </div>



                                <div>
                                    <label for="positon" class="required">Position</label>
                                    <input type="text" name="position" v-model="addEmployeeForm.position" id="position" required>
                                </div>

                                <div>
                                    <label for="division" class="required">Division</label>
                                    <select v-model="addEmployeeForm.division_id" name="division" id="division" required>
                                        <option disabled value="0">Select Division</option>
                                        <option v-for="division in divisions" :key="division.id" :value="division.id">{{division.name}}</option>
                                    </select>
                                </div>
                                
                                <div class="flex g--75">
                                    <TextButton type="button" @click="closeDialog" class="m-inline-start-auto">Close</TextButton>
                                    <PrimaryButton type="submit" class="mr-1">Submit</PrimaryButton>
                                </div>

                            </form>
                        </section>
                    </Dialog>


                    <Dialog :show="showAssignTasks" :exit="closeAssignTasks" class="my-3">
                        <form @submit.prevent="submitAssignedTask">
                        <section>
                            <h1 class="h1 mb-1">Assign Task</h1>
                            <section class="mb-1">
                                <label class="mb--5 display-block" for="taskTitle">Task Title</label>
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
                                    <h3 class="mb--5">Start date</h3>
                                    <input v-model="taskForm.submission_start_date" type="date" name="" id="">
                                    <input v-model="taskForm.submission_start_time" type="time" name="" id="">
                                </div>

                                <div class="mb-1">
                                    <h3 class="mb--5">Due date</h3>
                                    <input v-model="taskForm.submission_due_date" type="date" name="" id="">
                                    <input v-model="taskForm.submission_due_time" type="time" name="" id="">
                                </div>

                            </section>

                            <section class="mb-1">
                                <label for="assignTo" class="mr-1">Assign to</label>
                                <select name="assignTo" id="assignTo" v-model="assignTo">
                                    <option value="all">All</option>
                                    <option value="selected">Selected</option>
                                </select>
                            </section>

                            <section v-show="assignTo === 'selected'">
                                <h2>Select Employee</h2>
                                <div class="scrollable-y assign-employee">
                                    <Table>
                                        <template #table-header>
                                            <TableRow>
                                                <TableCell :isHeader="true">
                                                    <input type="checkbox" v-model="all" name="" id="" @click="triggerAll">
                                                    All
                                                </TableCell>
                                                <TableCell :isHeader="true">Employee</TableCell>
                                            </TableRow>

                                        </template>
                                        
                                        <template #table-body>
                                            
                                            
                                            <TableRow v-for="employee in employees"  :key="employee.id">
                                                <TableCell>
                                                    <input v-model="taskForm.employees" type="checkbox" name="checkbox" ref="xitems" :value="employee.id">
                                                </TableCell>
                                                <TableCell>
                                                    <span>{{employee.first_name + ' ' + employee.last_name}}</span>
                                                </TableCell>
                                            </TableRow>

                                        </template>
                                    </Table>
                                </div>
                            </section>
                        </section>
                        <section class="flex mt-2">
                            <TextButton class="ml-auto" @click="toggleAssignTasks('close')">Cancel</TextButton>
                            <PrimaryButton type="submit">Assign</PrimaryButton>
                        </section>
                    </form>
                    </Dialog>
                    <section class="py-1">
                        <label for="search-employee">Search Employee</label>
                        <input type="search" name="search-employee" id="search-employee">

                        <select v-model="filterDivision" name="filter-division" id="filter-division">
                            <option value="0">All</option>
                            <option v-for="division in divisions" :key="division.id" :value="division.id">{{division.name}}</option>
                        </select>
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
                                <TableRow v-for="employee in employees" :key="employee.id">
                                    <TableCell>{{employee.first_name}}</TableCell>
                                    <TableCell>{{employee.last_name}}</TableCell>
                                    <TableCell>{{employee.email}}</TableCell>
                                    <TableCell>
                                        <!-- employee.division_id == division[division_id] -->
                                        {{divisions[employee.division_id - 1].name}}
                                    </TableCell>
                                    <TableCell>{{employee.position}}</TableCell>
                                    <TableCell>
                                        <div class="flex justify-content-center">
                                            <TextButton>Assign Task</TextButton>
                                            <LinkButton>View</LinkButton>
                                            <LinkButton>Evaluate</LinkButton>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </Table>
                    </section>
                </div>
            </main>
        </template>
    </HeadLayout>
</template>

<script>
    import HeadLayout from '@/Layouts/HeadLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import LinkButton from '@/Components/Button/LinkButton.vue';
    import TextButton from '@/Components/Button/TextButton.vue';
    import Table from '@/Components/Table/Table.vue';
    import TableCell from '@/Components/Table/TableCell.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import Dialog from '@/Components/Dialog/CustomDialog.vue';
    import {Inertia} from '@inertiajs/inertia';
    
    export default {
        components: {
            HeadLayout,
            Table,
            TableRow,
            TableCell,
            TextButton,
            LinkButton,
            PrimaryButton,
            Dialog,
        },

        props: {
            employees: Object,
            divisions: Object,
            head: Number,
        },

        data() {
            return {
                show: false,
                close: false,
                showAssignTasks: false,
                closeAssignTasks: false,
                assignTo: 'all',
                all: false,
                items: ['Marisa Kirisame', 'Alice Margatroid', 'Reisin Inaba'],
                filterDivision: 0,

                addEmployeeForm: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    avatar_path: '',
                    division_id: 0,
                    position: '',
                    password: '',
                },

                taskForm: {
                    'employees': [],
                    'head_id': this.head,
                    'task_title': '',
                    'task_description': '',
                    'attachments': '',
                    'submission_start_date': '',
                    'submission_start_time': '',
                    'submission_due_date': '',
                    'submission_due_time': '',
                }
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
                console.log(this.taskForm)
                Inertia.post('/assign/task/store', this.taskForm)
            },

        },

        watch: {
            all() {
                if (this.all === true) {
                    this.$refs.xitems.forEach(item => {
                        item.checked = true
                        this.taskForm.employees.concat(item)
                    });
                } else {
                    this.$refs.xitems.forEach(item => {
                        item.checked = false
                    });
                }
            },
        },
    }
</script>