<template>
    <EmployeeLayout>
        <template #content>
            <main class="px-3">
                <section>
                    <h1 class="my-2">{{task.title}}</h1>
                    <h3 class="my-1">{{task.description}}</h3>
                </section>

                <section class="task-submission-container">
                    <div>
                        <label for="attachments">Attachments</label>
                        <input type="file" name="attachments" id="attachments">
                    </div>

                    <div>
                        <label for="notes">Notes (Optional)</label>
                        <textarea name="notes" id="notes" cols="50" rows="5"></textarea>
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


export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        TextButton,
    },

    data() {
        return {
            task: {
                id: 1,
                title: 'Task 1',
                description: 'Lorem dolor ipsum wahahha',
            }
        }
    }
}
</script>   



