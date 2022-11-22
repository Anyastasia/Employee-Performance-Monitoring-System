<template>

    <MasterLayout>
        <template #header>
            <nav class="flex flex-right mt-1 mr-4">
                <DropdownContainer>
                    <template #dropdown-button>
                        <TextButton>
                            Admin
                            <i class="bi bi-caret-down"></i>
                        </TextButton>
                    </template>
                    
                    <template #dropdown-content>
                        <DropdownItem>
                            <Link href="/admin/logout" method="post" as="span">Log out</Link>
                        </DropdownItem>
                    </template>
                </DropdownContainer>
            </nav>
        </template>

        <template #sidebar>
            <SidebarItem icon="bi bi-person" href="/admin/employees">Employees</SidebarItem>
            <SidebarItem icon="bi bi-person-check" href="/admin/heads">Division Heads</SidebarItem>
            <SidebarItem icon="bi bi-building" href="/admin/divisions">Divisions</SidebarItem>
        </template>

        <template #main>
            <slot name="content"></slot>
        </template>
    </MasterLayout>
</template>

<script>

import MasterLayout from './MasterLayout.vue';
import OutlineButton from '../Components/Button/OutlineButton.vue';
import SidebarItem from '../Components/Sidebar/SidebarItem.vue';
import DropdownContainer from '../Components/Dropdown/DropdownContainer.vue';
import DropdownItem from '../Components/Dropdown/DropdownItem.vue';
import TextButton from '../Components/Button/TextButton.vue'
import {Link} from '@inertiajs/inertia-vue3';
export default {
    components: {
        MasterLayout,
        SidebarItem,
        DropdownContainer,
        DropdownItem,
        TextButton,
        Link,
    }
}
</script>