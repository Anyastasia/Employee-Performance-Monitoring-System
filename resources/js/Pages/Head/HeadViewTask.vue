<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-2 py-2">
                <section>
                    <h1 class="my-2 h1">{{task.task_title}}</h1>
                    <p v-if="task.submission_status === 'submitted'" class="italic">{{`Submitted at ${formatDate(task.updated_at)}`}}</p>
                    <p v-if="task.status === 'completed'" class="italic">{{`Approved at ${task.updated_at}`}}</p>
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

                <section v-if="task.comment">
                    <h2 v-if="task.status === 'complete'" class="h2">Approval Notes</h2>
                    <h2 v-else class="h2">Revision Notes</h2>
                    <p>{{task.comment}}</p>
                </section>


                <section v-if="task.status === 'submitted'" class="mb-2">
                    <form @submit.prevent="approveTask(task.id)">
                        <div class="mb-1">
                            <label for="comment" class="display-block mb-1">Comment</label>
                            <textarea  v-model="form.comment" name="comment" id="comment" cols="50" rows="5"></textarea>
                        </div>

                        <div class="flex g--75">
                            <PrimaryButton type="submit" @click="form.status = 'complete'" value="complete">Approve</PrimaryButton>
                            <OutlineButton type="submit" @click="form.status = 'revise'" value="revise">Revise</OutlineButton>
                        </div>
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
    </EmployeeLayout>
</template>

<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import OutlineButton from '@/Components/Button/OutlineButton.vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        OutlineButton,
    },

    props: ['task', 'employee'],
    data() {
        return {
            form: useForm({
                comment: '',
                status: '',
            })
        }
    },
    methods: {
        approveTask(id) {
            Inertia.post(`/head/task/approve/${id}`, this.form)
        },
        
        formatDate(date) {
            const xdate = new Date(date)
            return `${xdate.toDateString()} ${xdate.toLocaleTimeString()}`
        }
    },

    mounted(){
        const t = new Date(this.task.submission_start_date)
        console.log(t.toDateString())
    }
}
</script>