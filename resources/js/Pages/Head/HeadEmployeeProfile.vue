<template>
    <EmployeeLayout :employee="user">
        <template #content>
            <main>
                <section class="mx-3">
                    Employee name: {{employee.first_name + ' ' + employee.last_name}}
                </section>

                <section class="my-3 table-container mx-3 px-1 py-1">
                    <Table>
                        <template #table-header>
                            <TableRow>
                                <TableCell :isHeader="true">Task</TableCell>
                                <TableCell :isHeader="true">Submission Due Date</TableCell>
                                <TableCell :isHeader="true" >Status</TableCell>
                                <TableCell :isHeader="true">Action</TableCell>
                            </TableRow>
                        </template>

                        <template #table-body>
                            <TableRow v-for="task in assigned_tasks" :key="task.id" :id="task.id" >
                                <TableCell>
                                    {{task.task_title}}
                                </TableCell>

                                <TableCell>
                                    {{formatDate(task.submission_due_date)}}
                                </TableCell>

                                <TableCell>
                                    {{task.status.charAt(0).toUpperCase().concat(task.status.substring(1, task.status.length))}}
                                </TableCell>
                                
            
                                <TableCell>
                                    <div class="flex g--75 justify-content-center">
                                        <PrimaryButton :disabled="checkStatus(task.status)" @click="openDialog(task.id)">Evaluate</PrimaryButton>
                                        <span v-if="task.status == 'active'">
                                            <LinkButton :href="`/head/task/${task.id}`">View</LinkButton>
                                        </span>
                                        <span v-else>
                                            <LinkButton :href="`/head/view/task/${task.id}`">View</LinkButton>
                                        </span>
                                    </div> 
                                </TableCell>
                            </TableRow>
                        </template>

                    </Table>
                </section>

                <Dialog :show="dialogOpen" :exit="dialogClose" class="px-2">

                    <section>
                        <form @submit.prevent="submitEvaluationForm">
                            <article>
                                
                                <h2 class="h2">Efficiency</h2>      
                                <input v-model="evaluationForm.efficiency" v-for="(xefficiency, index) in efficiency" :key="index" type="radio" name="productivity" :value="xefficiency" id="">
                            </article>

                            <article>
                                
                                <h2 class="h2">Quality</h2>
                                <input v-model="evaluationForm.quality" v-for="(xquality, index) in quality"  :key="index" type="radio" name="quality" :value="xquality" id="">
                            </article>

                            <article>
                                <h2 class="h2">Timeliness</h2>
                                <input v-model="evaluationForm.timeliness" v-for="(xtimeliness, index) in timeliness" :key="index" type="radio" name="timeliness" :value="xtimeliness" id="">
                            </article>


                            <div class="flex mt-2">
                                <TextButton type="button" @click="closeDialog">Close</TextButton>
                                <PrimaryButton type="submit">Submit</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </Dialog>
            </main>
        </template>
    </EmployeeLayout>
</template>


<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import LinkButton from '@/Components/Button/LinkButton.vue'
import Table from '@/Components/Table/Table.vue'
import TableCell from '@/Components/Table/TableCell.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import {useForm} from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        TextButton,
        LinkButton,
        Table,
        TableCell,
        TableRow,
        Dialog,
    },

    props: ['employee', 'assigned_tasks', 'xtask', 'user'],

    data(){
        return {
            dialogOpen: false,
            dialogClose: false,
            quality: [1,2,3,4,5],
            efficiency: [1,2,3,4,5],
            timeliness: [1,2,3,4,5],
            evaluationForm: useForm({
                employee_id: '',
                task_id: '',
                quality: '',
                efficiency: '',
                timeliness: '',
            }),
        }
    },

    methods: {
        openDialog(id) {
            this.evaluationForm.task_id = id
            this.evaluationForm.employee_id = this.employee.id
            this.dialogOpen = !this.dialogOpen
        },

        closeDialog(){
            this.dialogClose = !this.dialogClose
            this.evaluationForm.reset()
        },
        
        checkStatus(status) {
            return (status === 'complete') ? false : true
        },

        formatDate(date) {
            const xdate = new Date(date)
            return `${xdate.toLocaleString()}`
       },

        submitEvaluationForm() {
            Inertia.post('/evaluate', this.evaluationForm)
            this.dialogClose = true
        },
    },
}
</script>