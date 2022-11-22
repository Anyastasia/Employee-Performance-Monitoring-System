<template>
    <HeadLayout>
        <template #content>
            <main class="px-3"> 
                <h1 class="my-2">Profile</h1>
                <section class="profile-container">
                    <div class="profile-img-container">
                        <img src="../../../../public/images/profile-placeholder.png" alt=""/>
                        <article class="display-inline-block">
                            <h2 class="h2">{{`${head.first_name} ${head.last_name}`}}</h2>
                            <p>{{`${head.position} | ${head.email}`}}</p>
                        </article>
                    </div>
                </section>
            </main> 
        </template>
    </HeadLayout>
</template>

<script>
import HeadLayout from '@/Layouts/HeadLayout.vue';

export default {
    components: {
        HeadLayout,
    },

    props: ['head'],
    mounted(){
        console.log(this.head)
    }
}
</script>