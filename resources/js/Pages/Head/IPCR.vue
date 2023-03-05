<template>
    <section class="px-2">
        <article class="flex flex-col justify-content-center align-items-center px-3 mb-2 mt-2">
            <p>CITY GOVERNMENT OF MUNTINLUPA</p>
            <p>Strategic Performance Management System</p>
            <p>INDIVIDUAL PERFORMANCE COMMITTMENT AND REVIEW (ICPR)</p>
        </article>

        <article class="mb-1">
            <p>I, {{`${employee.first_name} ${employee.last_name}`}}, {{employee.position }}, of the {{ division.name }} DIVISION of the BUSINESS PERMITS AND LICENSING OFFICE commit to deliver and agree to be rated on the attainment of the following targets in accordance wioth the indicated measures for the period {{evaluation.start_date}} to {{evaluation.end_date}} </p>
        </article>

        <article>
            <div>
                <table class="ipcr">
                    <tr>
                        <th rowspan="5">Rating Scale
                            <td class="px-1 py--5">5 - Outstanding</td>
                        </th>
                    </tr>
                    <tr>
                        <td class="px-1 py--5">4 - Very Satisfactory</td>
                    </tr>
                    <tr>
                        <td class="px-1 py--5">3 - Satisfactory</td>
                    </tr>
                    <tr>
                        <td class="px-1 py--5">2 - Unsatisfactory</td>
                    </tr>
                    <tr>
                        <td class="px-1 py--5">1 - Poor</td>
                    </tr>

                </table>
            </div>
            
            <div>

            </div>
        </article>

        <article class="flex flex-col justify-content-center align-items-center mt-4">
            <table class="ipcr w-100">
                <thead>
                    <tr>
                        <td>Received by</td>
                        <td>Date</td>
                        <td>Appproved by</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td >
                            
                            <p>{{`${head.first_name} ${head.last_name}`}}</p>
                            <p class="mt-1">Immediate Supervisor</p>
                        </td>
                        <td > {{evaluation.end_date}} </td>
                        <td >
                            <p>{{`${head.first_name} ${head.last_name}`}}</p>
                            <p class="mt-1">Head of Department Office</p>
                        </td>
                        <td >{{evaluation.end_date}}</td>
                    </tr>
                </tbody>
            </table>
        </article>

        <article class="flex flex-col justify-content-center align-items-center mt-1">
            <table class="ipcr w-100">
                <thead>
                    <tr>
                        <th>Output</th>
                        <th>Success Indicators</th>
                        <th>Actual Accomplishments</th>
                        <th>
                            Rating
                            <table class="ipcr w-100">
                                <thead>
                                    <tr>
                                        <th>Quality</th>
                                        <th>Efficiency</th>
                                        <th>Timeliness</th>
                                        <th>Average</th>
                                    </tr>
                                </thead>
                            </table>
                        </th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ev, index) in evaluationForm" :key="ev.id">
                        <td>{{ ev.outputs }}</td>
                        <td>{{ev.success_indicators}}</td>
                        <td>{{ev.actual_indicators}}</td>
                        <td class="p-0">
                            <table class="ipcr w-100">
                                <tbody>
                                    <td>{{evaluationScores[index].quality_average}}</td>
                                    <td>{{evaluationScores[index].efficiency_average}}</td>
                                    <td>{{evaluationScores[index].timeliness_average}}</td>
                                    <td>Average</td>
                                </tbody>
                            </table>
                        </td>
                        <td>Remarks</td>
                    </tr>
                    <tr>
                           <th colspan='4'>
                            Total Average Rating
                           </th> 
                           <td>{{ evaluation.total_average_rating }}</td>
                    </tr>
                    <tr>
                           <th colspan='4'>
                            Final Average Rating
                           </th> 
                           <td>{{ evaluation.rating}}</td>
                    </tr>
                    <tr>
                           <th colspan='4'>
                            Adjectival Rating
                           </th> 
                           <td>{{ evaluation.adjectival_rating }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">
                            Comments
                        </th>
                    </tr>
                </tbody>
            </table>

            <table class="my-1 ipcr w-100">
                <thead>
                    <tr>
                        <th>Discussed with</th>
                        <th>Date</th>
                        <th>Assessed by</th>
                        <th>Date</th>
                        <th>Final Rating by</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class='px-1 py-2'>{{`${employee.first_name} ${employee.last_name}`}}
                            <p>Employee</p>
                        </td>
                        <td>{{evaluation.end_date}}</td>
                        <td>
                            <p class="mb-1">I certify that I discussed my assessment of the performanmce with the employees</p>
                            <p>{{`${head.first_name} ${head.last_name}`}}</p>
                            <p>Supervisor</p>
                        </td>
                        <td>{{evaluation.end_date}}</td>
                        <td class="px-1 py-2">
                            <p>{{`${head.first_name} ${head.last_name}`}}</p>
                            <p>Head of Deparment/Office</p>
                        </td>
                        <td>{{evaluation.end_date}}</td>
                    </tr>
                </tbody>
            </table>
        </article>
    </section>
</template>

<script>

export default {
    props: ['employee', 'evaluations', 'head', 'division', 'evaluationForm', 'evaluation', 'evaluationScores'], 
}
</script>