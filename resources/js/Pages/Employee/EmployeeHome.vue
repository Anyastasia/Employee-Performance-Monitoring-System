<template>
    
    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">

                <h1 class="my-2">Tasks</h1>
                <section class="pb-1">
                    <div> 
                        <TextButton :showBadge="employee.new_task_given" @click="active()">
                            Active 
                        </TextButton> 
                        <TextButton :showBadge="employee.priority_task_given" @click="priority()">
                            Priority
                        </TextButton>
                        <TextButton>
                            <Link method="get" href="/completed" as="span">Completed</Link>  
                        </TextButton>
                    </div>
                </section>

                <section>
                    <Task>
                        <TaskItem v-for="(item, index) in items" :href="`/task/${item.id}`" :key="item.id" :title="item.task_title" :dueDate="item.submission_due_date" :isPriority="item.is_priority" :isApproved="item.status === 'complete'" :isRejected="item.status === 'revise'"/>
                        <!-- <TaskItem href="/task/id" title="Task 1" dueDate="September 17, 2021"/>
                        <TaskItem title="Task 1" dueDate="September 17, 2021"/>
                        <TaskItem title="Task 1" dueDate="September 17, 2021"/> -->
                    </Task>
                </section>

            </main>
        </template>
    </EmployeeLayout>
</template>


<script>
    import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
    import TextButton from '@/Components/Button/TextButton.vue';
    import Alert from '@/Components/Alert/Alert.vue'
    import Task from '@/Components/Task/Task.vue';
    import TaskItem from '@/Components/Task/TaskItem.vue';
    import {Link} from '@inertiajs/inertia-vue3';
    import LinkButton from '@/Components/Button/LinkButton.vue'
    import { useForm } from '@inertiajs/inertia-vue3';
    export default {
        components: {
            EmployeeLayout,
            TextButton,
            Task,
            TaskItem,
            LinkButton,
            Link,
            Alert,
        },
        data() {
            return {
                form: useForm({
                    new_task_given: this.employee.new_task_given,
                    priority_task_given: this.employee.priority_task_given,
                })    
            }
        },
        methods: {
            active(){
                this.form.new_task_given = false
                this.form.get('/active')
            },
            priority(){
                this.form.priority_task_given = false
                this.form.get('/priority')
            },
            
        },
        // props: {
        //     id: Number,
        //     items: Object,
        // },
        props: ['items', 'employee'],
        mounted(){
            console.log(this.form)
        }        
    }
    
</script>