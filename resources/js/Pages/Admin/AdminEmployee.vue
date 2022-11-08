<template>

    <AdminLayout>
        <template #content>
            <main class="px-3">
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
                                    <p v-if="errors.email">Invalid Email</p>
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


                    <section class="py-1">
                        <label for="search-employee">Search Employee</label>
                        <input type="search" name="search-employee" id="search-employee">

                        <select name="employee-status" id="employee-status" v-model="addEmployeeForm.division_id">
                            <option disabled value="0">All</option>
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
                                            <TextButton>Edit</TextButton>
                                            <LinkButton>Delete</LinkButton>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </Table>
                    </section>
                </div>
            </main>
        </template>
    </AdminLayout>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import AdminLayout from '../../Layouts/AdminLayout.vue'
import Table from '../../Components/Table/Table.vue';
import TableRow from '../../Components/Table/TableRow.vue';
import TableCell from '../../Components/Table/TableCell.vue';
import PrimaryButton from '../../Components/Button/PrimaryButton.vue';
import LinkButton from '../../Components/Button/LinkButton.vue';
import TextButton from '../../Components/Button/TextButton.vue';
import Dialog from '../../Components/Dialog/CustomDialog.vue';
export default {
    components: {
        AdminLayout,
        Table, 
        TableRow,   
        TableCell,
        PrimaryButton,
        LinkButton,
        TextButton,
        Dialog,
        Inertia,
    },

    props: ['employees', 'divisions', 'errors'],

    data() {
        return {

            show: false,
            close: false,
            filterDivision: 0,
            selectDivision: 0,
            addEmployeeForm: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    avatar_path: '',
                    division_id: 0,
                    position: '',
                    password: 'aaa',
                },
        }
    },

    methods: {
        toggleDialog() {
            this.show = !this.show
        },

        closeDialog(){
            this.close = !this.close
        },

        submitAddEmployee() {

            Inertia.post('/register/employee/store', this.addEmployeeForm)
        }
    }
}
</script>