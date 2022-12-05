<template>
    <HeadLayout>
        <template #content>
            <main class="px-3">
                <h1 class="h1 my-2">Attendance</h1>
                <div clas="table-container">
                    <PrimaryButton @click="openAttendanceForm">Add New</PrimaryButton>
                    
                    <section class="mt-1">
                        <Table>
                            
                            <template #table-header>
                                <TableRow>
                                    <TableCell :isHeader="true">
                                        Date
                                    </TableCell>
                                    <TableCell :isHeader="true">
                                        Time in
                                    </TableCell>
                                    <TableCell :isHeader="true">
                                        Time out
                                    </TableCell>
                                </TableRow>
                            </template>

                            <template #table-body>
                                <TableRow>
                                    <TableCell>11/11/2022</TableCell>
                                    <TableCell> 11:00:00</TableCell>
                                    <TableCell>12:00:00</TableCell>
                                </TableRow>
                            </template>
                        </Table>
                    </section>
                </div>
                <Dialog :show="showAttendanceForm" :exit="exitAttendanceForm">
                    <form @submit.prevent="submitAttendanceForm">
                        <div class="mb-1">
                            <h2 class="h2">Time</h2>
                            <p>{{dateToday.toLocaleTimeString()}}</p>
                        </div>

                        <div class="mb-1">
                            <h2 class="h2">Date</h2>  
                            <p>{{dateToday.toLocaleDateString()}}</p>
                        </div>

                        <div class="mb-1">
                            <label for="mode">Select</label>
                            <select v-model="attendanceForm.mode" name="mode" class="display-block">
                                <option :value="modes[0]">Time-in</option>
                                <option :value="modes[1]">Time-out</option>
                            </select>
                        </div>


                        <TextButton type="button" @click="closeAttendanceForm">Cancel</TextButton>
                        <PrimaryButton type="submit">Submit</PrimaryButton>
                    </form>
                </Dialog>
            </main>
        </template>    
    </HeadLayout>
</template>


<script>
import HeadLayout from '@/Layouts/HeadLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import OutlineButton from '@/Components/Button/OutlineButton.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableCell from '@/Components/Table/TableCell.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
export default {
    components: {
        HeadLayout,
        PrimaryButton,
        OutlineButton,
        TextButton,
        Dialog,
        Table,
        TableRow,
        TableCell,
    }, 

    data() {
        return {
            attendanceForm: useForm({
                date: new Date(),
                mode: '',
                type: 'TYPE_HEAD',
            }),
            dateToday: new Date(),
            modes: ['time-in', 'time_out'],
            showAttendanceForm: false,
            exitAttendanceForm: false,
        }
    },

    methods: {
        openAttendanceForm: function(){
            this.showAttendanceForm = !this.showAttendanceForm
        },
        closeAttendanceForm: function(){
            this.exitAttendanceForm = !this.exitAttendanceForm
        },

        submitAttendanceForm: function() {
            // this.attendanceForm.shift_date = this.dateToday.toDateString()
            this.attendanceForm.shift_date = this.dateToday.toISOString()                   
            // this.attendanceForm.shift_date = this.attendanceForm.shift_date.getUTCDate
            // this.attendanceForm.time = Date(this.timeToday.getTime())

            if (this.attendanceForm.mode === 'time-out') {
                Inertia.post('/head/attendance/time-out')
            } else
                Inertia.post('/head/attendance/time-in')
        }
    },

    watch: {

    }
}
</script>