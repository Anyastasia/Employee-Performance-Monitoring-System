<template>
    <HeadLayout>
        <template #content>
            <main class="px-2 py-2">
                <section>
                    <h1 class="my-2 h1">{{task.task_title}}</h1>
                    <h3 class="my-1 h3">{{task.task_description}}</h3>
                </section>

                
                <section class="mb-2">
                    <h2 class="h2">Attachments</h2>
                    <a download :href="task.attachments">{{task.attachments}}</a>
                </section>

                <section class="mb-2">
                    <h2 class="h2">Notes</h2>
                    <p>{{task.notes}}</p>
                </section>

                <section class="mb-2">
                    <form @submit.prevent="approveTask">
                        <PrimaryButton type="submit">Approve</PrimaryButton>
                    </form>
                </section>



                <!-- <form @submit.prevent="submitTask">
                <section class="task-submission-container">
                    <div>
                        <label for="attachments">Attachments</label>
                        <input @change="uploadAttachments" type="file" name="attachments" ref="attachments" id="attachments">
                    </div>

                    <div>
                        <label for="notes">Notes (Optional)</label>
                        <textarea v-model="task.notes" name="notes" id="notes" cols="50" rows="5"></textarea>
                    </div>
                 </section>
                 <PrimaryButton type="submit" v-if="task.status === 'active'">Submit</PrimaryButton>
                 <PrimaryButton type="submit" v-else>Approve</PrimaryButton>
                </form> -->
            </main>
        </template>
    </HeadLayout>
</template>

<script>
import HeadLayout from '@/Layouts/HeadLayout.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        HeadLayout,
        PrimaryButton,
        TextButton
    },

    props: ['task'],

    methods: {
        submitTask(id) {
            Inertia.post(`/head/task/approve/${id}`)
        },
    },
}
</script>