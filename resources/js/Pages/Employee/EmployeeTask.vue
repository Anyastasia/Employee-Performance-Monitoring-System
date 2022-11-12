<template>
    <EmployeeLayout>
        <template #content>
            <main class="px-3">
                <section>
                    <h1 class="my-2">{{task.task_title}}</h1>
                    <h3 class="my-1">{{task.task_description}}</h3>
                </section>

                <a download :href="task.attachments">{{task.attachments}}</a>
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
                attachments: '',
                notes: '',
            },
            url: 'http://localhost:8000/',
        }
    },

    props: {
        task: Object,
    },

    methods: {
        submitTask() {
            Inertia.post('/task/submit', this.submissionForm)
        },

        uploadAttachments() {
            this.submissionForm.attachments = this.$refs.attachments.files
        }
    }

}
</script>   



