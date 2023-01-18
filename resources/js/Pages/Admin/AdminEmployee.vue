<template>

    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">
                <Alert class="my-1" v-show="showSuccessAlertAddEmployeeForm" @click="showSuccessAlertAddEmployeeForm = !showSuccessAlertAddEmployeeForm" :message="$page.props.flash.success" type="alert-success"></Alert>
                <Alert class="my-1" v-show="showAlertEditEmployeeForm" @click="showAlertEditEmployeeForm = !showAlertEditEmployeeForm" :message="$page.props.flash.info" type="alert-info"></Alert>
                <Alert class="my-1" v-show="showAlertDeleteEmployee" @click="showAlertDeleteEmployee = !showAlertDeleteEmployee" :message="$page.props.flash.info" type="alert-info"></Alert>
                <h1 class="h1">Employees</h1>
                <div class="my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <PrimaryButton @click="toggleDialog">
                            <i class="bi bi-plus mr--5"></i>
                            Add Employee
                        </PrimaryButton>
                    </div>

                    <Dialog :show="show" :exit="close" class="my-3">
                        <section>
                            <form @submit.prevent="submitAddEmployee" class="add-staff">
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
                                    <Error v-if="errors.email" :message="errors.email">Invalid Email</Error>
                                    <label for="text" class="required">Email</label>
                                    <input type="text" name="email" v-model="addEmployeeForm.email" id="email" required>
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

                    <Dialog :show="showEditEmployeeForm" :exit="exitEditEmployeeForm">
                        <form @submit.prevent="submitEditEmployeeForm">
                            <section>
                                <h2 class="h2 mb-1" >Edit</h2>
                                <div>
                                    <div class="mb-1">
                                        <label  for="first_name" class="display-block mb--5">Name</label>
                                         <input class="px--75 py--5" v-model='editEmployeeForm.first_name' type="text" name="name" id="">
                                    </div>

                                    <div class="mb-1">
                                        <label  for="last_name" class='display-block mb--5'>Last Name</label>
                                         <input class="px--75 py--5" v-model='editEmployeeForm.last_name' type="text" name="name" id="">
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label for="new_position" class="display-block mb--5">Position</label>
                                    <input class="px--75 py--5" v-model="editEmployeeForm.position" type="text">
                                </div>

                                <div class="mb-1">
                                    <label for="" >Promote to Division Head</label>
                                    <input v-model="editEmployeeForm.is_division_head" type="checkbox" name="promote_checkbox">
                                </div>                                                                  
                                
                                <div v-if="editEmployeeForm.is_division_head === true" class="mb-1">
                                    <label for="new_position" class="display-block mb--5">Previous Division Head Position</label>
                                    <input class="px--75 py--5" v-model="editEmployeeForm.previous_head_position" type="text">
                                </div>
                                
                            </section>

                            <section>
                                <TextButton type="button" @click="closeEditEmployeeForm">Close</TextButton>                                
                                <PrimaryButton type="submit">Save Changes</PrimaryButton>
                            </section>
                        </form>
                    </Dialog>


                    <section class="py-1">
                        <!-- <label for="search-employee">Search Employee</label>
                        <input type="search" name="search-employee" id="search-employee"> -->

                        <select name="employee-status" id="employee-status" v-model="selectDivision">
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
                                    <TableCell>{{divisions[employee.division_id - 1].name}}</TableCell>
                                    <TableCell>{{employee.position}}</TableCell>
                                    <TableCell>
                                        <div class="flex justify-content-center">
                                            <TextButton @click="openEditEmployeeForm(employee)">Edit</TextButton>
                                            <LinkButton  @click="deleteEmployee(employee.id)" :only="['employees']">Delete</LinkButton>
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
import {Inertia} from '@inertiajs/inertia';
import Alert from '@/Components/Alert/Alert.vue';
import EmployeeLayout from '../../Layouts/EmployeeLayout.vue'
import Table from '../../Components/Table/Table.vue';
import TableRow from '../../Components/Table/TableRow.vue';
import TableCell from '../../Components/Table/TableCell.vue';
import Error from '@/Components/Error.vue'
import PrimaryButton from '../../Components/Button/PrimaryButton.vue';
import LinkButton from '../../Components/Button/LinkButton.vue';
import TextButton from '../../Components/Button/TextButton.vue';
import Dialog from '../../Components/Dialog/CustomDialog.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    components: {
        EmployeeLayout,
        Alert,
        Table, 
        TableRow,   
        TableCell,
        PrimaryButton,
        LinkButton,
        TextButton,
        Error,
        Dialog,
        Inertia,
    },

    props: ['employees', 'divisions', 'errors', 'employee', 'division_id'],

    data() {
        return {

            show: false,
            close: false,
            showEditEmployeeForm: false,
            exitEditEmployeeForm: false,
            filterDivision: 0,
            selectDivision: this.division_id,
            showSuccessAlertAddEmployeeForm: false,
            showAlertEditEmployeeForm: false,
            showAlertDeleteEmployee: false,
            showErrorAlert: false,
            addEmployeeForm: useForm({
                    first_name: '',
                    last_name: '',
                    email: '',
                    avatar_path: '',
                    division_id: 0,
                    position: '',
                    password: 'aaa',
                }),
            editEmployeeForm: useForm({
                id: '',
                first_name: '',
                last_name: '',
                position: '',
                division_id: '',
                is_division_head: false,
                previous_head_position: '',
            }),
            deleteEmployeeForm: useForm({
                employee_id: '',
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

        openEditEmployeeForm(employee) {
            this.editEmployeeForm.id = employee.id
            this.editEmployeeForm.first_name = employee.first_name
            this.editEmployeeForm.last_name = employee.last_name
            this.editEmployeeForm.position = employee.position
            this.showEditEmployeeForm = !this.showEditEmployeeForm
        },

        closeEditEmployeeForm() {
            this.exitEditEmployeeForm = !this.exitEditEmployeeForm
            this.exitEditEmployeeForm.reset()
        },

        submitEditEmployeeForm() {
            this.editEmployeeForm.post("/employee/profile/changeEmployeeDetails", {
                onSuccess: ()=> {this.showAlertEditEmployeeForm = true; this.exitEditEmployeeForm = !this.exitEditEmployeeForm
                }
            })
        },
        deleteEmployee(id) {
            this.deleteEmployeeForm.id = id
            this.deleteEmployeeForm.post(`/admin/delete/employee/${id}`, {
                onSuccess: () => {this.showAlertDeleteEmployee = true}
            })
        },
        submitAddEmployee() {

            // Inertia.post('/register/employee/store', this.addEmployeeForm)
            this.addEmployeeForm.post('/register/employee/store', {
                onSuccess: () => {
                    this.showSuccessAlertAddEmployeeForm = true
                    this.close = !this.close
                }
            })
        },

    },

    watch: {
        selectDivision(){
            console.log(this.selectDivision)
            Inertia.get(`/admin/employees/${this.selectDivision}`)
        },
        showSuccessAlertAddEmployeeForm() {
            setTimeout(() => {
                this.showSuccessAlertAddEmployeeForm = false
            }, 3000);
        },

        showAlertDeleteEmployee() {
            setTimeout(() => {
                this.showAlertDeleteEmployee = false
            }, 3000);
        },

        showAlertEditEmployeeForm() {
            setTimeout(() => {
                this.showAlertEditEmployeeForm = false
            }, 3000);
        }
    },


}
</script>