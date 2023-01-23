<template>
    <EmployeeLayout :employee="employee">
        <template #content>
            <main class="px-3">
                <h1 class='h1 my-2'>Self Evaluation</h1>

                <section>
                    <article class="mb-1">
                        <PrimaryButton @click="openEvaluateEmployee">
                            Add Evaluation
                        </PrimaryButton>
                    </article>


                    <Dialog :show="showViewEvaluation" :exit="exitViewEvaluation">
                        <section>
                            <h2 class="h2">View Evaluation</h2>
                           
                                
                                <article class="mt-3">
                                    <div class="mb-1">
                                        <span>Start Date: </span>
                                        <span>{{ viewEvaluation.start_date }}</span>
                                        <!-- <Error v-if="errors.start_date" :message="errors.start_date"></Error>
                                        <label for="startDate" class="display-block mb-1 required">From</label>
                                        <input v-model="evaluation.start_date" class="px--5 py--5" type="date" required> -->
                                    </div>
                                    <div class="mb-1">
                                        <span>End Date: </span>
                                        <span>{{ viewEvaluation.end_date }}</span>
                                        <!-- <Error v-if="errors.end_date" :message="errors.start_date"></Error>
                                        <label for="endDate" class="display-block mb-1 required" >To</label>
                                        <input v-model="evaluation.end_date" class="px--5 py--5" type="date" required> -->
                                    </div>
    
                                </article>
    
                                <Table>
                                    <template #table-header>
                                        <TableRow>
                                            <TableCell :isHeader="true">
                                                Output
                                            </TableCell >
                                            <TableCell :isHeader="true">
                                                Success Indicators
                                            </TableCell>
                                            <TableCell :isHeader="true">
                                                Actual Accomplishments
                                            </TableCell>
                                            <TableCell :isHeader="true">
                                                Rating
                                            </TableCell>
                                        </TableRow>
                                    </template>
                                    <template #table-body>
                                        <TableRow v-for="(ev, evIndex) in xevaluationForm" :key="evIndex">
                                            <TableCell>
                                                <div class="flex justify-content-center">
                                                    <textarea rows="5" disabled v-model="ev.output"></textarea>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div class="flex">
                                                    <textarea rows="5"  disabled v-model="ev.success_indicators"></textarea>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div class="flex">
                                                    <textarea rows="5"  disabled v-model="ev.actual_accomplishments"></textarea>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <Table class="mx-auto my-auto">
                                                    <template #table-header>
                                                        <TableRow>
                                                            <TableCell :isHeader="true">Quality</TableCell>
                                                            <TableCell :isHeader="true">Efficiency</TableCell>
                                                            <TableCell :isHeader="true">Timeliness</TableCell>
                                                        </TableRow>
                                                    </template>
                                                    <template #table-body>
                                                        <TableRow>
                                                            <TableCell>
                                                                <textarea disabled v-model="ev.quality_indicators"></textarea>
                                                            </TableCell>
    
                                                            <TableCell >
                                                                <textarea disabled v-model="ev.efficiency_indicators"></textarea>
                                                            </TableCell>
    
                                                            <TableCell>
                                                                <textarea disabled v-model="ev.timeliness_indicators"></textarea>
                                                            </TableCell>
                                                            <TableCell>
                                                                <!-- {{getAverage(evIndex, ev.quality, ev.efficiency, ev.timeliness)}} -->
                                                            </TableCell>
                                                        </TableRow>
                                                    </template>
                                                </Table>
                                            </TableCell>
                                        </TableRow>
                                    </template>

                                    
                                </Table>
    
                                <Error v-if="errors.rating_required" :message="errors.rating_required"></Error>
                                <article class="my-1">
                                    <!-- <p class="mb-1">Total Average Rating: {{ evaluations[evIndex].tot }}</p> -->
                                    <p class="mb-1">Self Evaluated Final Average Rating: {{ viewEvaluation.rating }}</p>
                                    <p class="mb-1">Self Evaluated Adjectival Rating: {{ viewEvaluation.adjectivalRating}}</p>

                                    <p class="mb-1">Division Head Final Average Rating: {{ viewEvaluation.division_head_rating }}</p>
                                    <p class="mb-1">Division Head Adjectival Rating: {{ viewEvaluation.division_head_adjectivalRating}}</p>
                                </article>
    
    
                                    <div class="flex mt-2">
                                        <PrimaryButton @click="closeViewEvaluation">Close</PrimaryButton>
                                    </div>
                        </section>
                    </Dialog>

                    <Dialog :show="showEvaluateEmployee" :exit="exitEvaluateEmployee">
                        <section>
                            <h1 class="h1">My Employee</h1>
                            <form @submit.prevent="submitEvaluationForm">
                                
                            <article class="mt-3">
                                <div class="mb-1">
                                    <Error v-if="errors.start_date" :message="errors.start_date"></Error>
                                    <label for="startDate" class="display-block mb-1 required">From</label>
                                    <input v-model="evaluation.start_date" class="px--5 py--5" type="date" required>
                                </div>
                                <div class="mb-1">
                                    <Error v-if="errors.end_date" :message="errors.start_date"></Error>
                                    <label for="endDate" class="display-block mb-1 required" >To</label>
                                    <input v-model="evaluation.end_date" class="px--5 py--5" type="date" required>
                                </div>

                            </article>

                            <Table>
                                <template #table-header>
                                    <TableRow>
                                        <TableCell :isHeader="true">
                                            Output
                                        </TableCell >
                                        <TableCell :isHeader="true">
                                            Success Indicators
                                        </TableCell>
                                        <TableCell :isHeader="true">
                                            Actual Accomplishments
                                        </TableCell>
                                        <TableCell :isHeader="true">
                                            Rating
                                        </TableCell>
                                    </TableRow>
                                </template>
                                <template #table-body>
                                    <TableRow v-for="(ev, evIndex) in yevaluationForm" :key="evIndex">
                                        <TableCell>
                                            <div class="flex justify-content-center">
                                                <textarea rows="5" disabled v-model="ev.output"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div class="flex">
                                                <textarea rows="5"  disabled v-model="ev.success_indicators"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div class="flex">
                                                <textarea rows="5"  v-model="ev.actual_accomplishments"></textarea>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <Table class="mx-auto my-auto">
                                                <template #table-header>
                                                    <TableRow>
                                                        <TableCell :isHeader="true">Quality</TableCell>
                                                        <TableCell :isHeader="true">Efficiency</TableCell>
                                                        <TableCell :isHeader="true">Timeliness</TableCell>
                                                        <TableCell :isHeader="true">Average</TableCell>
                                                    </TableRow>
                                                </template>
                                                <template #table-body>
                                                    <TableRow>
                                                        <TableCell>
                                                            <textarea disabled v-model="ev.quality_indicators"></textarea>
                                                            <select v-model="ev.quality">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>

                                                        <TableCell >
                                                            <textarea disabled v-model="ev.efficiency_indicators"></textarea>
                                                            <select v-model="ev.efficiency">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>

                                                        <TableCell>
                                                            <textarea disabled v-model="ev.timeliness_indicators"></textarea>
                                                            <select  v-model="ev.timeliness">
                                                                <option v-for="(score, index) in scores" :key="index" :value="score">
                                                                    {{score}}
                                                                </option>
                                                                <option value="0">N/A</option>
                                                            </select>
                                                        </TableCell>
                                                        <TableCell>
                                                            {{getAverage(evIndex, ev.quality, ev.efficiency, ev.timeliness)}}
                                                        </TableCell>
                                                    </TableRow>
                                                </template>
                                            </Table>
                                        </TableCell>
                                    </TableRow>
                                </template>
                            </Table>

                            <Error v-if="errors.rating_required" :message="errors.rating_required"></Error>
                            <article class="my-1">
                                <p class="mb-1">Total Average Rating: {{ getSumOfAverages() }}</p>
                                <p class="mb-1">Final Average Rating: {{ getFinalAverageRating() }}</p>
                                <p class="mb-1">Adjectival Rating: {{ getAdjectivalRating()}}</p>
                            </article>


                                <div class="flex mt-2">
                                    <TextButton type="button" @click="closeEvaluateEmployee">Close</TextButton>
                                    <PrimaryButton type="submit">Submit</PrimaryButton>
                                </div>
                                </form>
                        </section>
                    </Dialog>
                    <div class="table-container px-2 py-1">
                        <Table>
                            <template #table-header>
                                <TableRow>
                                    <TableCell :isHeader="true">ID</TableCell>
                                    <TableCell :isHeader="true">Date</TableCell>
                                    <TableCell :isHeader="true">Action</TableCell>
                                </TableRow>
                            </template>
                            <template #table-body>
                                <TableRow v-for="(ev, index) in evaluations" :key="ev.index">
                                    <TableCell> {{ ev.id }} </TableCell>
                                    <TableCell> {{ ev.created_at }} </TableCell>
                                    <TableCell>
                                        <div>
                                            <PrimaryButton @click="openViewEvaluation(ev.id)">View</PrimaryButton>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </Table>
                    </div>
                </section>
            </main>
        </template>
    </EmployeeLayout>
</template>

<script>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import TextButton from '@/Components/Button/TextButton.vue';
import Table from '@/Components/Table/Table.vue'
import TableRow from '@/Components/Table/TableRow.vue';
import TableCell from '@/Components/Table/TableCell.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import Error from '@/Components/Error.vue';
import {useForm} from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
export default {
    components: {
        EmployeeLayout,
        PrimaryButton,
        TextButton,
        Table,
        TableRow,
        TableCell,
        Dialog,
        Error
    },
    data(){
        return {
            showEvaluateEmployee: false,
            exitEvaluateEmployee: false,
            showViewEvaluation: false,
            exitViewEvaluation: false,
            evaluation: useForm({
                employee_id: '',
                evaluated_by: this.employee.id,
                start_date: '',
                end_date: '',
                self: true,
                totalAverageRating: 0,
                finalAverageRating: 0,
                adjectivalRating: '',
                scores: [],
            }),
            viewEvaluation: {
                rating: '',
                start_date: '',
                end_date: '',
                division_head_rating: '',
                division_head_adjectivalRating: '',
                adjectivalRating: '',
            },
            yevaluationForm: [],
            evaluationForm: [
                    {
                        id: '',
                        output: '',
                        success_indicators: '',
                        actual_accomplishments: '',
                        quality_indicators: '', 
                        efficiency_indicators: '', 
                        timeliness_indicators: '',
                        status: 'active', 
                    }
            ],
            adjRating: [
                "Poor",
                "Unsatisfactory",
                "Satisfactory",
                "Very Satisfactory",
                "Outstanding",
            ],
            scores: [5,4,3,2,1],
        }
    },
    props: ['employee', 'errors', 'evaluations', 'xevaluationForm', 'xevaluation'],
    methods: {
            openEvaluateEmployee(){
                // this.evaluationForm.forEach(ev => {
                //     this.yevaluationForm.push({
                //         id: ev.id,
                //         employee_id: ev.employee_id,
                //         output: ev.output,
                //         success_indicators: ev.success_indicators,
                //         actual_accomplishments: ev.actual_accomplishments,
                //         quality_indicators: ev.quality_indicators,
                //         efficiency_indicators: ev.efficiency_indicators,
                //         timeliness_indicators: ev.timeliness_indicators,
                //         status: ev.status,
                //         quality: 0,
                //         efficiency: 0,
                //         timeliness: 0,
                //         average: 0,
                //     })
                // })

                this.showEvaluateEmployee = !this.showEvaluateEmployee
            },
            closeEvaluateEmployee(){
                this.exitEvaluateEmployee = !this.exitEvaluateEmployee
            },
            openViewEvaluation(id){
                // this.viewEvaluation.rating = this.evaluations[index].rating
                // this.viewEvaluation.start_date = new Date(this.evaluations[index].start_date).toDateString()
                // this.viewEvaluation.end_date = new Date(this.evaluations[index].end_date).toDateString()
                // this.viewEvaluation.adjectivalRating = this.evaluations[index].adjectival_rating
                Inertia.reload({
                    data: {
                        self_evaluation_id: id
                    },
                    only: ['xevaluation'],
                    onSuccess: ()=> {
                        console.log(this.xevaluation)
                        
                        this.viewEvaluation.rating = this.xevaluation.self_evaluation.rating
                        this.viewEvaluation.start_date = new Date(this.xevaluation.self_evaluation.start_date).toDateString()
                        this.viewEvaluation.end_date = new Date(this.xevaluation.self_evaluation.end_date).toDateString()
                        this.viewEvaluation.adjectivalRating = this.xevaluation.self_evaluation.adjectival_rating
                        this.viewEvaluation.division_head_rating = this.xevaluation.division_head.rating,
                        this.viewEvaluation.division_head_adjectivalRating = this.xevaluation.division_head.adjectival_rating
                        this.showViewEvaluation = !this.showViewEvaluation
                        console.log(this.viewEvaluation)
                    }
                })
            },
            closeViewEvaluation(){
                this.exitViewEvaluation = !this.exitViewEvaluation
            },
            getAverage(ev, ...params){
                let a = 0
                let l = 0
                let ave = 0
                
                params.forEach(p => {
                    if (p > 0) {
                        a += p
                        l += 1
                    } 
                })
                
                ave = l <= 0 ? 0 : (a / l).toFixed(2)
                this.yevaluationForm[ev].average = (a / l)
                return ave
            },
            getFinalAverageRating() {
                return this.evaluation.finalAverageRating
            },
            getAdjectivalRating() {
                this.evaluation.adjectivalRating = this.adjRating[Math.floor(this.evaluation.finalAverageRating) - 1]
                return this.adjRating[Math.floor(this.evaluation.finalAverageRating) - 1]
            },
            getSumOfAverages() {
                let ave = 0
                
                this.yevaluationForm.forEach(a => {
                    ave += a.average
                })

                this.evaluation.totalAverageRating = ave
                this.evaluation.finalAverageRating = (isNaN(ave)) ? 0 : (ave / this.yevaluationForm.length).toFixed(2)


                return (isNaN(ave)) ? 0 : ave
            },
            submitEvaluationForm() {
                this.evaluation.employee_id = this.employee.id
                // this.getAdjectivalRating()
                // this.getFinalAverageRating()
                // this.getSumOfAverages()
                this.yevaluationForm.forEach(ev => {
                    this.evaluation.scores.push({
                        quality_average: ev.quality,
                        efficiency_average: ev.efficiency,
                        timeliness_average: ev.timeliness,
                    })
                })

                this.evaluation.post('/evaluate', {
                    onSuccess: ()=>{
                        this.exitEvaluateEmployee = !this.exitEvaluateEmployee
                    }
                })
            }

    },
    mounted() {
        this.xevaluationForm.forEach(ev => {
            this.yevaluationForm.push({
                id: ev.id,
                output: ev.output,
                success_indicators: ev.success_indicators,
                actual_accomplishments: ev.actual_accomplishments,
                quality_indicators: ev.quality_indicators,
                efficiency_indicators: ev.efficiency_indicators,
                timeliness_indicators: ev.timeliness_indicators,
                status: ev.status,
                quality: 0,
                efficiency: 0,
                timeliness: 0,
                average: 0,
            })
        })
    },
    watch: {

    }
}


</script>