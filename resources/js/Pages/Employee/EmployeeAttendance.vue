<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">
                <h1 class="h1 my-2">Attendance</h1>
                <div clas="table-container">
                    <div class="flex g-1">
                        <PrimaryButton @click="openAttendanceForm">Add New</PrimaryButton>
                        <OutlineButton v-if="employee.is_division_head" @click="openLeaveForm">File Leave</OutlineButton>
                    </div>
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
                                        Time Out
                                    </TableCell>
                                    <TableCell :isHeader="true">
                                        Status
                                    </TableCell>
                                </TableRow>
                            </template>

                            <template #table-body>
                                <TableRow v-for="(item, index) in attendance" :key="index">
                                    <TableCell>{{item.shift_date}}</TableCell>
                                    <TableCell>{{formatShiftTime(item.shift_date, item.time_in)}}</TableCell>
                                    <TableCell>{{formatShiftTime(item.shift_date, item.time_out)}}</TableCell>
                                    <TableCell>
                                        <p v-if="item.isLate">Late</p>
                                    </TableCell>
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

                        <div v-if="attendanceForm.mode === modes[1]" class="mb-1">
                            <Error v-if="lastTimeInIsToday === false || time_ins === null" message="Make sure you've timed in first."></Error>
                            <p>Last Time in: {{`${formatDate(time_ins.shift_date , time_ins.time_in)}`}}</p>
                        </div>

                        <div class="my-1" v-if="checkTime() && attendanceForm.mode === modes[1]">
                            <label for="early-time-out" class="required display-block mb--5">Reason for Early Time out</label>
                            <input v-model="attendanceForm.early_time_out_reason" name="early-time-out" required>
                            <PrimaryButton class="ml-1" type="submit" :disabled="attendanceForm.processing">Time-out Early</PrimaryButton>
                        </div>

                        <TextButton type="button" @click="closeAttendanceForm">Cancel</TextButton>
                        <PrimaryButton type="submit" :disabled="attendanceForm.processing || (checkTime() && attendanceForm.mode === modes[1])">Submit</PrimaryButton>
                    </form>
                </Dialog>

                <Dialog :show="showLeaveForm" :exit="exitLeaveForm">
                    <h2 class="h2 mb-1">File Leave</h2>
                    <form @submit.prevent="submitLeaveForm">
                        <div class="mb-1" >
                            <label for="leave_start_date" class="required display-block">Start Date</label>
                            <input v-model="leaveForm.leave_date_start" type="date" name="leave_start_date">
                        </div>

                        <div class="mb-1">
                            <label for="leave_due_date" class="required display-block">Until</label>
                            <input v-model="leaveForm.leave_date_due" type="date" name="leave_start_date">

                        </div>

                        <div class="mb-1">
                            <label for="employee" class="required display-block">Employee</label>
                            <select v-model="leaveForm.employee_id" name="employee">
                                <option v-for="xemployee in employees" :key="xemployee.id" :value="xemployee.id">{{`${xemployee.first_name} ${xemployee.last_name}`}}</option>
                            </select>
                        </div>

                        <div class="mb-1">
                            <label for="reason" class="required display-block">Reason</label>
                            <input v-model="leaveForm.reason" type="text" name="reason">
                        </div>

                        <div class="flex g--75">
                            <TextButton class="ml-auto" type="button" @click="closeLeaveForm">Close</TextButton>
                            <PrimaryButton type="submit" :disabled="leaveForm.processing">File</PrimaryButton>
                        </div>

                    </form>
                </Dialog>
            </main>
        </template>    
    </EmployeeLayout>
</template>


<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import OutlineButton from '@/Components/Button/OutlineButton.vue'
import TextButton from '@/Components/Button/TextButton.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableCell from '@/Components/Table/TableCell.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import Error from '@/Components/Error.vue';
import { Inertia } from '@inertiajs/inertia';
export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        OutlineButton,
        TextButton,
        Dialog,
        Table,
        TableRow,
        TableCell,
        Error,
    }, 
    props: {attendance: Object, employee: Object, employees: Object, time_ins: {type: Object, defaullt: null, required: false}},
    data() {
        return {
            attendanceForm: useForm({
                shift_date: '',
                time_in_id: '', // for time-out only
                mode: '',
                type: 'TYPE_EMPLOYEE',
                early_time_out_reason: '',
            }),
            remarks: ['Time In', 'Time out'],
            dateToday: new Date(),
            modes: ['time_in', 'time_out'],
            showAttendanceForm: false,
            exitAttendanceForm: false,
            showLeaveForm: false,
            exitLeaveForm: false,
            leaveForm: useForm({
                employee_id: '',
                leave_date_start: '',
                leave_date_due: '',
                reason: '',
            }),
            lastTimeInIsToday: true,
        }
    },

    methods: {
        checkTime: function(){
            const date = new Date()
            let currentTime = date.getHours() * 100 + date.getMinutes();
            console.log(currentTime)
            return (currentTime < 1730)
        },  
        openAttendanceForm: function(){
            this.showAttendanceForm = !this.showAttendanceForm
        },
        closeAttendanceForm: function(){
            this.exitAttendanceForm = !this.exitAttendanceForm
        },
        openLeaveForm: function(){
            this.showLeaveForm = !this.showLeaveForm
        },
        closeLeaveForm: function() {
            this.exitLeaveForm = !this.exitLeaveForm
            this.leaveForm.reset()
        },
        submitAttendanceForm: function() {
            // this.attendanceForm.shift_date = this.dateToday.toDateString()
            this.attendanceForm.shift_date = this.dateToday.toISOString()                  
            // this.attendanceForm.shift_date = this.attendanceForm.shift_date.getUTCDate
            // this.attendanceForm.time = Date(this.timeToday.getTime())
            if (this.attendanceForm.mode === this.modes[1]) {
                this.attendanceForm.time_in_id = this.time_ins.id
                this.attendanceForm.post(`/time-out/store/${this.employee['id']}`, {
                    onSuccess: ()=> {
                        this.attendanceForm.reset() 
                        this.exitAttendanceForm = !this.exitAttendanceForm
                    }})
            }
                // Inertia.post(`/time-out/store/${this.employee['id']}`, this.attendanceForm)
            else
                this.attendanceForm.post(`/time-in/store/${this.employee['id']}`, {onSuccess: () => this.exitAttendanceForm = !this.exitAttendanceForm})
        },

        submitLeaveForm: function() {
            this.exitLeaveForm = true
            // Inertia.post('/leave', this.leaveForm)
            // if (this.leaveForm.onSuccess)
            //     this.leaveForm.reset()

            this.leaveForm.post('/leave', {
                onSuccess: ()=> {
                    this.leaveForm.reset()
                    this.exitLeaveForm = !this.exitLeaveForm
                }
            })
        },


        formatShiftTime(date, time) {
            const xdate = new Date(`${date}T${time}Z`)
            return `${xdate.toLocaleTimeString()}`
        },
        formatDate(date, time) {
            const xdate = new Date(`${date}T${time}Z`)
            const now = new Date()
            if (xdate.toDateString() !== now.toDateString()) {
                this.lastTimeInIsToday = false
            } else
                this.lastTimeInIsToday = true 
            return `${xdate.toLocaleString()}`
        },

        evaluateTimeIn() {
            if (this.time_ins === null)
                return false
            else
                return true
        }
    },

    mounted() {
    }
}
</script>