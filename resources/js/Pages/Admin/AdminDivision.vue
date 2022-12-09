<template>

    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">
                <h1 class="h1">Divisions</h1>
                <div class="my-1 table-container px-2 py-1">
                    <div class="flex g-1 my-1">
                        <PrimaryButton @click="toggleDialog">
                            <i class="bi bi-plus mr--5"></i>
                            Add Division
                        </PrimaryButton>
                    </div>

                    <Dialog :show="show" :exit="close" class="my-3">
                        <section>
                            <form @submit.prevent="addDivisionForm.post('/register/division/store')" class="add-staff">
                                <h1 class="my-1 h1">Add Division</h1>
                                <h6 class="my-1 h6">
                                    <em>All fields required</em>
                                </h6>

                                <div>
                                    <label for="email" class="required">Division</label>
                                    <input type="text" name="name" v-model="addDivisionForm.name" id="name" required>
                                </div>
                                
                                <div class="mt-1 flex g--75">
                                    <TextButton type="button" @click="closeDialog" class="m-inline-start-auto">Close</TextButton>
                                    <PrimaryButton type="submit" class="mr-1" :disabled="addDivisionForm.processing">Submit</PrimaryButton>
                                </div>

                            </form>
                        </section>
                    </Dialog>


                    <section class="py-1">
                        <label for="search-Division">Search Division</label>
                        <input type="search" name="search-division" id="search-division">

                        <select name="division-status" id="division-status" v-model="filterDivision">
                            <option value="0">All</option>
                            <option v-for="division in divisions" :key="division.id" :value="division.id">{{division.name}}</option>
                        </select>
                    </section>

                    <section>
                        <Table>
                            <template #table-header> 
                                <TableRow>
                                    <TableCell :isHeader="true">ID</TableCell>
                                    <TableCell :isHeader="true">Name</TableCell>
                                    <TableCell :isHeader="true">Action</TableCell>
                                </TableRow>

                            </template>
                            


                            <template #table-body> 
                                <TableRow v-for="division in divisions" :key="division.id">
                                    <TableCell>{{division.id}}</TableCell>
                                    <TableCell>{{division.name}}</TableCell>
                                    <TableCell>
                                        <div class="flex justify-content-center">
                                            <TextButton>Edit</TextButton>
                                            <LinkButton method="post" :href="`/admin/delete/division/${division.id}`">Delete</LinkButton>
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
import {useForm} from '@inertiajs/inertia-vue3';
import EmployeeLayout from '../../Layouts/EmployeeLayout.vue'
import Table from '../../Components/Table/Table.vue';
import TableRow from '../../Components/Table/TableRow.vue';
import TableCell from '../../Components/Table/TableCell.vue';
import PrimaryButton from '../../Components/Button/PrimaryButton.vue';
import LinkButton from '../../Components/Button/LinkButton.vue';
import TextButton from '../../Components/Button/TextButton.vue';
import Dialog from '../../Components/Dialog/CustomDialog.vue';

export default {
    components: {
        EmployeeLayout,
        Table, 
        TableRow,   
        TableCell,
        PrimaryButton,
        LinkButton,
        TextButton,
        Dialog,
    },

    props: ['divisions', 'employee'],

    data() {
        return {

            show: false,
            close: false,
            filterDivision: 0,
            addDivisionForm: useForm({
                    name: '',
            }),
        }
    },

    methods: {
        toggleDialog() {
            this.show = !this.show
        },

        closeDialog(){
            this.close = !this.close
            this.addDivisionForm.cancel();
        },

        submitAddDivision() {
            Inertia.post('/register/division/store', this.addDivisionForm)
        }
    }
}
</script>