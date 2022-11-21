<template>
    <EmployeeLayout>
        <template #content>
            <main class="px-3">
                <section>
                    <h1 class="my-2">{{task.task_title}}</h1>
                    <h3 class="my-1">{{task.task_description}}</h3>
                </section>

                <a download :href="task.attachments">{{task.attachments}}</a>
                <form v-if="submissionForm.status === 'active'" @submit.prevent="submitTask">
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
                 <PrimaryButton type="submit" v-if="submissionForm.status === 'active'">Submit</PrimaryButton>
                 
                </form>

                <form v-else @submit.prevent="resubmitTask">
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

                    <PrimaryButton type="submit">Re-submit</PrimaryButton>
                </form>
            </main>
        </template>
    </EmployeeLayout>
</template>


<script>

import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        TextButton,
    },
    data() {
        return {
            submissionForm: {
                task_id: '',
                attachments: '' || this.task.attachments,
                notes: '' || this.task.notes,
                status: this.task.status,
            },
        }
    },

    props: {
        task: Object,
        // submitted_task: Object,
    },

    methods: {
        submitTask() {
            this.submissionForm.task_id = this.task.task_id
            this.submissionForm.status = 'submitted'
            Inertia.post('/task/submit/store', this.submissionForm)
        },

        resubmitTask() {
            this.submissionForm['id'] = this.task.id
            this.submissionForm.status = 'active'
            Inertia.post('/task/submit/update', this.submissionForm)
        },

        uploadAttachments() {
            this.submissionForm.attachments = this.$refs.attachments.files[0]
        }
    },

    // mounted() {
    //     console.log(this.task)
    // },

}
</script>   



