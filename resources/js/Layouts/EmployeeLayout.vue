<template>
    <MasterLayout>
        <template #header>
            <nav class="flex flex-right mt-1 mr-4">
                <DropdownContainer>
                    <template #dropdown-button>
                        <img src="../../../public/images/profile-placeholder.png" alt=""/>
                    </template>
                    
                    <template #dropdown-content>
                        <DropdownItem>Settings</DropdownItem>
                        <DropdownItem>
                            <Link method='post' href="/employee/logout" as="span">Log out</Link>
                        </DropdownItem>
                    </template>
                </DropdownContainer>
            </nav>
        </template>

        <template #sidebar>
            <SidebarItem icon="bi bi-bell" @click="openNotifications" :notLink="true">Notifications</SidebarItem>
            <SidebarItem icon="bi bi-person" href="/employee/profile">Profile</SidebarItem>
            <SidebarItem icon="bi bi-journal" href="/employee">Tasks</SidebarItem>
        </template>

        <template #main>
            <Notification :show="showNotifications">
                <NotificationItem description="lorem dolor wahahah" time="2 mins ago"/>
            </Notification>

            <slot name="content"></slot>
        </template>
        
    </MasterLayout>
</template>

<script>
    import MasterLayout from './MasterLayout.vue';
    import SidebarItem from '@/Components/Sidebar/SidebarItem.vue';
    import Notification from '@/Components/Notification/Notification.vue';
    import NotificationItem from '@/Components/Notification/NotificationItem.vue';
    import DropdownContainer from '@/Components/Dropdown/DropdownContainer.vue';
    import DropdownItem from '@/Components/Dropdown/DropdownItem.vue';
    import {Link} from '@inertiajs/inertia-vue3';

    export default {
        components: {
        MasterLayout,
        SidebarItem,
        DropdownContainer,
        DropdownItem,
        Notification,
        NotificationItem,
        Link,
},

        data() {
            return {
                showNotifications: false
            }
        },
        methods: {
            openNotifications() {
                this.showNotifications = !this.showNotifications
            }
        }

    }
</script>