<template>

    <AdminLayout>
        <template #content>
            <main class="px-3">
                <h1 class="h1">Division Heads</h1>
                <div class="my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <PrimaryButton @click="toggleDialog">
                            <i class="bi bi-plus mr--5"></i>
                            Add Division Head
                        </PrimaryButton>
                    </div>

                    <Dialog :show="show" :exit="close" class="my-3">
                        <section>
                            <form @submit.prevent="submitAddHead" class="add-staff">
                                <h1 class="my-1 h1">Add head</h1>
                                <h6 class="my-1 h6">
                                    <em>All fields required</em>
                                </h6>
                                <div class="add-staff-name">
                                    <div>
                                        <label for="first_name" class="required">First Name</label>
                                        <input type="text" id="firstname" v-model="addHeadForm.first_name" name="first_name" required>
                                    </div>

                                    <div>
                                        <label for="first_name" class="required">Last Name</label>
                                        <input type="text" id="lastname" v-model="addHeadForm.last_name" name="last_name" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="required">Email</label>
                                    <input type="email" name="email" v-model="addHeadForm.email" id="email" required>
                                </div>

                                <div>
                                    <label for="positon" class="required">Position</label>
                                    <input type="text" name="position" v-model="addHeadForm.position" id="position" required>
                                </div>

                                <div>
                                    <label for="division" class="required">Division</label>
                                    <select v-model="addHeadForm.division_id" name="division" id="division" required>
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
                        <label for="search-head">Search head</label>
                        <input type="search" name="search-head" id="search-head">

                        <select v-model="addHeadForm.division_id" name="filter-division" id="filter-division">
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
                                <TableRow v-for="head in heads" :key="head.id">
                                    <TableCell>{{head.first_name}}</TableCell>
                                    <TableCell>{{head.last_name}}</TableCell>
                                    <TableCell>{{head.email}}</TableCell>
                                    <TableCell>{{divisions[head.division_id - 1].name}}</TableCell>
                                    <TableCell>{{head.position}}</TableCell>
                                    <TableCell>
                                        <div class="flex justify-content-center">
                                            <LinkButton>Edit</LinkButton>
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
import TextButton from '../../Components/Button/TextButton.vue';
import LinkButton from '../../Components/Button/LinkButton.vue';
import Dialog from '../../Components/Dialog/CustomDialog.vue';

export default {
    components: {
        AdminLayout,
        Table, 
        TableRow,   
        TableCell,
        PrimaryButton,
        TextButton,
        LinkButton,
        Dialog,
    },

    props: {
        heads: Object,
        divisions: Object,
    },

    data() {
        return {
            show: false,
            close: false,
            filterDivision: 0,
            selectDivision: 0,
            addHeadForm: {
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

        submitAddHead() {
            Inertia.post('/register/head/store', this.addHeadForm)
        }
    }
}
</script>