<template>
    
    <EmployeeLayout>
        <template #content>
            <main class="px-3">

                <h1 class="my-2">Tasks</h1>
                <section class="pb-1">
                    <div>
                        <TextButton>Active</TextButton> 
                        <TextButton>Completed</TextButton>                        
                    </div>
                </section>

                <section>
                    <Task>
                        <TaskItem v-for="(item, index) in items" href="/task/id" :key="item.id" :title="item.title" :dueDate="item.dueDate"/>
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
    import Task from '@/Components/Task/Task.vue';
    import TaskItem from '@/Components/Task/TaskItem.vue';
    export default {
        components: {
            EmployeeLayout,
            TextButton,
            Task,
            TaskItem,
        },

        data() {
            return {
                items: [{
                    id: 1,
                    title: "Task 1",
                    dueDate: "September 17, 2021"
                },
                {
                    id: 2,
                    title: "Task 2",
                    dueDate: "September 17, 2021"
                },
                {
                    id: 3,
                    title: "Task 3",
                    dueDate: "September 17, 2021"
                }
                ]
            }
        }
    }
</script>