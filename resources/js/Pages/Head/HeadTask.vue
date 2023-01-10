<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">
                <Link href="/head/employees" as="span">
                    <i class="bi bi-chevron-left h2"></i>
                </Link> 
                <h1 class="h1 mb-1 display-inline-block">Tasks</h1>
                
                <section class="table-container px-2 py-1">
                    <Table>
                        <template #table-header>
                            <TableRow>
                                <TableCell :isHeader="true">Title</TableCell>
                                <TableCell :isHeader="true">Submission Due Date</TableCell>
                                <TableCell :isHeader="true">Action</TableCell>
                            </TableRow>
                        </template>

                        <template #table-body>
                            <TableRow v-for="task in tasks" :key="task.id" >
                                <TableCell>{{task.task_title}}</TableCell>
                                <TableCell>{{formatDate(task.submission_due_date)}}</TableCell>
                                <TableCell>
                                    <TextButton @click="openEditForm(task)">
                                        Edit
                                    </TextButton>
                                </TableCell>
                            </TableRow>
                        </template>
                    </Table>

                    <Dialog :show="showEditForm" :exit="exitEditForm">
                
                        <form @submit.prevent="submitEditForm">
                        <section>
                            <h1 class="h1 mb-1">Edit Task</h1>

                            <section class="mb-1">
                                <Error v-if="errors.task_title" :message="errors.task_title"></Error>
                                <label class="mb--5 display-block required" for="taskTitle">Task Title</label>
                                <input v-model="editForm.task_title" type="text" name="taskTitle">
                            </section>
                            <section class="mb-1">
                                <h2 class="mb--5">Task description</h2>
                                <textarea v-model="editForm.task_description" name="taskDescription" id="" cols="70" rows="10"></textarea>
                            </section>

                            <section class="mb-1">
                                <h2 class="mb--5">Attachments</h2>
                                <input @change="uploadAttachments" ref="attachments" type="file" name="taskAttachments" id="">
                            </section>
                            
                            <section>
                                <div class="mb-1">
                                    <Error v-if="errors.submission_start_date" :message="errors.submission_start_date"></Error>
                                    <h3 class="mb--5 required">Start date</h3>
                                    <input v-model="editForm.submission_start_date" type="datetime-local" name="submission_start_date" id="">
                                </div>

                                <div class="mb-1">
                                    <Error v-if="errors.submission_due_date" :message="errors.submission_due_date"></Error>
                                    <h3 class="mb--5 required">Due date</h3>
                                    <input v-model="editForm.submission_due_date" type="datetime-local" name="submission_due_date" id="" >
                                </div>
                            </section>
                        </section>
                        <section class="flex mt-2">
                            <TextButton type='button' class="ml-auto" @click="closeEditForm">Cancel</TextButton>
                            <PrimaryButton type="submit" :disabled="editForm.processing">Save Changes</PrimaryButton>
                        </section>
                    </form>
                    </Dialog>
                </section>
            </main>
        </template>
    </EmployeeLayout>
</template>


<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import Table from '@/Components/Table/Table.vue';
import Error from '@/Components/Error.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import TableCell from '@/Components/Table/TableCell.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import LinkButton from '@/Components/Button/LinkButton.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        Table,
        TableCell,
        TableRow,
        LinkButton,
        TextButton,
        Error,
        Dialog,
        Link
    },
    props: [
        "employee",
        "tasks",
        "errors",
    ],
    data() {
        return {
            showEditForm: false,
            exitEditForm: false,
            editForm: useForm({
                id: '',
                task_title: '',
                task_description: '',
                submission_start_date: '',
                submission_due_date: '',
                attachments: '',
            }),
        }
    },

    methods: {
        openEditForm(task) {
            this.editForm.id = task.id
            this.editForm.task_title = task.task_title
            this.editForm.task_description = task.task_description
            this.editForm.submission_start_date = new Date(task.submission_start_date)
            // this.editForm.submission_due_date = new Date(task.submission_due_date).toISOString().slice(0,16)
            this.editForm.submission_due_date = new Date(task.submission_due_date)
            this.editForm.submission_start_date = `${this.editForm.submission_start_date.getFullYear()}-${this.editForm.submission_start_date.getMonth() + 1}-${this.editForm.submission_start_date.getDate()}T${this.editForm.submission_start_date.getHours()}:${this.editForm.submission_start_date.getMinutes()}`
            this.editForm.submission_due_date = `${this.editForm.submission_due_date.getFullYear()}-${this.editForm.submission_due_date.getMonth() + 1}-${this.editForm.submission_due_date.getDate()}T${this.editForm.submission_due_date.getHours()}:${this.editForm.submission_due_date.getMinutes()}`
            this.showEditForm= !this.showEditForm
        },
        formatDate(date) {
            const xdate = new Date(date)
            return xdate.toLocaleString()
        },
        closeEditForm() {
            this.exitEditForm = !this.exitEditForm
        },
        submitEditForm() {
            this.editForm.submission_start_date = new Date(this.editForm.submission_start_date).toISOString()
            this.editForm.submission_due_date = new Date(this.editForm.submission_due_date).toISOString()
            this.editForm.post('/assign/task/update', {
                onSuccess: ()=> {
                    this.exitEditForm = !this.exitEditForm
                }
            })
        }
    },
    mounted() {

    },
    watch: {
        // 'editForm.submission_due_date': function(){
        //     console.log(this.editForm.submission_due_date)
            
        // }
    }
 
}
</script>