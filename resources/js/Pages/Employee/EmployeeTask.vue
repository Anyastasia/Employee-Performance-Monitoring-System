<template>
    <EmployeeLayout>
        <template #content>
            <main class="px-3">
                <section>
                    <h1 class="my-2">{{task.task_title}}</h1>
                    <p v-if="task.submission_status === 'submitted'" class="italic">{{`Submitted at ${task.updated_at}`}}</p>
                    <div v-if="task.comment">
                        <p v-if="task.status === 'complete'" class="italic display-inline">Task Approved</p>
                        <p v-else class="italic display-inline">Task needs revision</p>
                        <TextButton @click="showCommentDialog">See comment</TextButton>
                    </div>
                    <h3 class="my-1">{{task.task_description}}</h3>
                </section>
                
                <a download :href="task.attachments">{{task.attachments}}</a>

                <form v-if="task.submission_status === 'submitted'" @submit.prevent="update">
                    <section class="task-submission-container">
                        <div>
                            <label for="attachments">Attachments</label>
                            <input disabled @change="uploadAttachments" type="file" name="attachments" ref="attachments" id="attachments">
                        </div>

                        <div>
                            <label for="notes">Notes (Optional)</label>
                            <textarea disabled v-model="submissionForm.notes" name="notes" id="notes" cols="50" rows="5"></textarea>
                        </div>
                    </section>
                    <PrimaryButton type="submit" v-if="task.submission_status === 'submitted'">Re-submit</PrimaryButton>
                </form>

                <form v-else-if="task.submission_status === 'resubmit'" @submit.prevent="resubmitTask">
                    <section class="task-submission-container">
                        <div>
                            <label for="attachments">Attachments</label>
                            <input @change="uploadAttachments" type="file" name="attachments" ref="attachments" id="attachments">
                        </div>

                        <div>
                            <label for="notes">Notes (Optional)</label>
                            <textarea v-model="submissionForm.notes" name="notes" id="notes" cols="50" rows="5"></textarea>
                        </div>
                    </section>
                    <PrimaryButton type="submit" v-if="task.submission_status === 'resubmit'">Submit Again</PrimaryButton>
                </form>


                <form v-else @submit.prevent="submitTask">
                    <section class="task-submission-container">
                        <div>
                            <label for="attachments">Attachments</label>
                            <input @change="uploadAttachments" type="file" name="attachments" ref="attachments" id="attachments">
                        </div>

                        <div>
                            <label for="notes">Notes (Optional)</label>
                            <textarea v-model="submissionForm.notes" name="notes" id="notes" cols="50" rows="5"></textarea>
                        </div>
                    </section>
                    <PrimaryButton type="submit">Submit</PrimaryButton>
                </form>

            </main>

            <Dialog :show="showComment" :exit="exitComment">
                <section>
                    <h2 class="h2 mb-1">Comment</h2>
                    <p>{{task.comment}}</p>
                </section>

                <div class="mt-1">
                    <PrimaryButton @click="closeCommentDialog">Close</PrimaryButton>
                </div>
            </Dialog>
        </template>
    </EmployeeLayout>
</template>


<script>

import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        TextButton,
        Dialog,
    },
    data() {
        return {
            submissionForm: useForm({
                task_id: '',
                attachments: '' || this.task.attachments,
                notes: '' || this.task.notes,
            }),
            showComment: false,
            exitComment: false,
        }
    },

    props: {
        task: Object,
        // submitted_task: Object,
    },

    methods: {
        submitTask() {
            this.submissionForm.task_id = this.task.id
            Inertia.post('/task/submit/store', this.submissionForm)
        },

        update() {
            this.submissionForm['id'] = this.task.id
            Inertia.post('/task/submit/update', this.submissionForm)
        },

        resubmitTask() {
            this.submissionForm['id'] = this.task.id
            Inertia.post('/task/submit/resubmit', this.submissionForm)
        },

        uploadAttachments() {
            this.submissionForm.attachments = this.$refs.attachments.files[0]
        },

        showCommentDialog() {
            this.showComment = !this.showComment
        },

        closeCommentDialog() {
            this.exitComment = !this.exitComment
        },
    },

    mounted() {
        console.log(this.task)
    }
}
</script>   



