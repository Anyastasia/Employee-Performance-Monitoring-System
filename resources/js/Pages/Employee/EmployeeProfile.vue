<template>
    <EmployeeLayout>
        <template #content>
            <main class="px-3"> 
                <h1 class="my-2">Profile</h1>
                <section class="profile-container">
                    <div class="profile-img-container">
                        <img src="../../../../public/images/profile-placeholder.png" alt=""/>
                        <article class="display-inline-block">
                            <h2 class="h2">employee_name</h2>
                            <p>employee_position | email@email.com</p>
                        </article>
                    </div>
                </section>
            </main> 
        </template>
    </EmployeeLayout>
</template>

<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';


export default {
    components: {
        EmployeeLayout,
    }
}
</script>