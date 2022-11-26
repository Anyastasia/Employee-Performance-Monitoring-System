<template>
    <HeadLayout>
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
                                    {{task.submission_due_date + ' ' + task.submission_due_time}}
                                </TableCell>

                                <TableCell>
                                    {{task.status.charAt(0).toUpperCase().concat(task.status.substring(1, task.status.length))}}
                                </TableCell>
                                
            
                                <TableCell>
                                    <div class="flex g--75 justify-content-center">
                                        <PrimaryButton :disabled="checkStatus(task.status)" @click="openDialog">Evaluate</PrimaryButton>
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
                        <form action="">
                            <article>
                                
                                <h2 class="h2">Productivity</h2>
                                
                                <input v-model="evaluationForm.productivity" type="radio" name="productivity" value="1" id="">
                                <input v-model="evaluationForm.productivity" type="radio" name="productivity" value="2" id="">
                                <input v-model="evaluationForm.productivity" type="radio" name="productivity" value="3" id="">
                                <input v-model="evaluationForm.productivity" type="radio" name="productivity" value="4" id="">
                                <input v-model="evaluationForm.productivity" type="radio" name="productivity" value="5" id="">
                            </article>

                            <article>
                                
                                <h2 class="h2">Quality</h2>
                               
                                <input v-model="evaluationForm.quality" type="radio" name="quality" value="1" id="">
                                <input v-model="evaluationForm.quality" type="radio" name="quality" value="2" id="">
                                <input v-model="evaluationForm.quality" type="radio" name="quality" value="3" id="">
                                <input v-model="evaluationForm.quality" type="radio" name="quality" value="4" id="">
                                <input v-model="evaluationForm.quality" type="radio" name="quality" value="5" id="">
                                
                            </article>

                            <article>
                                <h2 class="h2">Timeliness</h2>
                                <input v-model="evaluationForm.timeliness" type="radio" name="timeliness" value="1" id="">
                                <input v-model="evaluationForm.timeliness" type="radio" name="timeliness" value="2" id="">
                                <input v-model="evaluationForm.timeliness" type="radio" name="timeliness" value="3" id="">
                                <input v-model="evaluationForm.timeliness" type="radio" name="timeliness" value="4" id="">
                                <input v-model="evaluationForm.timeliness" type="radio" name="timeliness" value="5" id="">
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
    </HeadLayout>
</template>


<script>
import HeadLayout from '@/Layouts/HeadLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import LinkButton from '@/Components/Button/LinkButton.vue'
import Table from '@/Components/Table/Table.vue'
import TableCell from '@/Components/Table/TableCell.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';

export default {
    components: {
        HeadLayout,
        PrimaryButton,
        TextButton,
        LinkButton,
        Table,
        TableCell,
        TableRow,
        Dialog,
    },

    props: ['employee', 'assigned_tasks', 'xtask'],

    data(){
        return {
            dialogOpen: false,
            dialogClose: false,
            evaluationForm: {
                quality: '',
                productivity: '',
                timeliness: '',
            },
        }
    },

    methods: {
        openDialog() {
            this.dialogOpen = !this.dialogOpen
        },

        closeDialog(){
            this.dialogClose = !this.dialogClose
        },
        checkStatus(status) {
            return (status === 'active') ? true : false
        }
    },

    mounted() {
        console.log(this.assigned_tasks)
    },


}
</script>