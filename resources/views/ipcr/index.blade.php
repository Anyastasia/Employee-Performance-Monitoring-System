<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>

* {
    box-sizing: border-box;
}

table {
	border-collapse: collapse;
	border-spacing: 0;
}

.px-1 {
    padding-inline: 1rem;
}

.px-2 {
    padding-inline: 2rem;
}
.px-3 {
    padding-inline: 3rem;
}

.mx-1 {
    margin-inline: 1rem;
}

.mx-2 {
    margin-inline: 2rem;
}

.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.justify-content-center {
    justify-content: center;
}

.align-items-center {
    align-items: center;
}

.ipcr td {
    text-align: center;
    vertical-align: middle;
    border: solid 1px black;
}

.ipcr th {
    text-align: center;
    vertical-align: middle;
    border: solid 1px black;

}

.mr-1 {
    margin-right: 1em;
}
.mr-2 {
    margin-right: 2em;
}
.mr-3 {
    margin-right: 3em;
}
.mr-4 {
    margin-right: 4em;
}
.mr-5 {
    margin-right: 5em;
}

.ml-1 {
    margin-left: 1em;
}
.ml-2 {
    margin-left: 2em;
}
.ml-3 {
    margin-left: 3em;
}
.ml-4 {
    margin-left: 4em;
}
.ml-5 {
    margin-left: 5em;
}

.mt--5 {
    margin-top: .5em;
}
.mt-1 {
    margin-top: 1em;
}
.mt-2 {
    margin-top: 2em;
}
.mt-3 {
    margin-top: 3em;
}
.mt-4 {
    margin-top: 4em;
}
.mt-5 {
    margin-top: 5em;
}


.mb--5 {
    margin-bottom: .5em;
}
.mb-1 {
    margin-bottom: 1em;
}
.mb-2 {
    margin-bottom: 2em;
}
.mb-3 {
    margin-bottom: 3em;
}
.mb-4 {
    margin-bottom: 4em;
}
.mb-5 {
    margin-bottom: 5em;
}

.mx-auto {
    margin-inline: auto;
}
.mx-1 {
    margin-left: 1rem;
    margin-right: 1rem;
}
.mx-2 {
    margin-left: 2rem;
    margin-right: 2rem;
}
.mx-3 {
    margin-left: 3rem;
    margin-right: 3rem;
}
.mx-4 {
    margin-left: 4rem;
    margin-right: 4rem;
}
.mx-5 {
    margin-left: 5rem;
    margin-right: 5rem;
}

.my--5 {
    margin-top: .5rem;
    margin-bottom: .5rem;
}

.my--75 {
    margin-top: .75rem;
    margin-bottom: .75rem;
}

.my-auto {
    margin-block: auto;
}

.my-1 {
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.my-2 {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
.my-3 {
    margin-top: 3rem;
    margin-bottom: 3rem;
}
.my-4 {
    margin-top: 4rem;
    margin-bottom: 4rem;
}
.my-5 {
    margin-top: 5rem;
    margin-bottom: 5rem;
}

.p-0 {
    padding: 0;
}
.pl-1 {
    padding-inline-start: 1rem;
}

.pl-2 {
    padding-inline-start: 2rem;
}

.pl-3 {
    padding-inline-start: 3rem;
}

.pl-4 {
    padding-inline-start: 4rem;
}

.pl-5 {
    padding-inline-start: 5rem;
}

.pr-1 {
    padding-inline-end: 1rem;
}

.pr-2 {
    padding-inline-end: 2rem;
}

.pr-3 {
    padding-inline-end: 3rem;
}

.pr-4 {
    padding-inline-end: 4rem;
}

.pr-5 {
    padding-inline-end: 5rem;
}

.pt-1 {
    padding-block-start: 1rem;
}

.pt-2 {
    padding-block-start: 2rem;
}

.pt-3 {
    padding-block-start: 3rem;
}

.pt-4 {
    padding-block-start: 4rem;
}

.pt-5 {
    padding-block-start: 5rem;
}

.pb-1 {
    padding-block-end: 1rem;
}

.pb-2 {
    padding-block-end: 2rem;
}

.pb-3 {
    padding-block-end: 3rem;
}

.pb-4 {
    padding-block-end: 4rem;
}

.pb-5 {
    padding-block-end: 5rem;
}

.py--5 {
    padding-top: .5rem;
    padding-bottom: .5rem;
}
.py--75 {
    padding-top: .75rem;
    padding-bottom: .75rem;
}
.py-1 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}
.py-2 {
    padding-top: 2rem;
    padding-bottom: 2rem;
}
.py-3 {
    padding-top: 3rem;
    padding-bottom: 3rem;
}
.py-4 {
    padding-top: 4rem;
    padding-bottom: 4rem;
}
.py-5 {
    padding-top: 5rem;
    padding-bottom: 5rem;
}

.px--5 {
    padding-left: .5rem;
    padding-right: .5rem;
}
.px--75 {
    padding-left: .75rem;
    padding-right: .75rem;
}
.px-1 {
    padding-left: 1rem;
    padding-right: 1rem;
}
.px-2 {
    padding-left: 2rem;
    padding-right: 2rem;
}
.px-3 {
    padding-left: 3rem;
    padding-right: 3rem;
}
.px-4 {
    padding-left: 4rem;
    padding-right: 4rem;
}
.px-5 {
    padding-left: 5rem;
    padding-right: 5rem;
}

.text-align-center {
    text-align: center;
}
.w-100 {
    width: 100%;
}

.m-bottom-1 {
    margin-bottom: 1rem; 
}


</style>
<body>
    <section class="px-2">
        <article class="text-align-center px-3 mb-2 mt-2">
            <p>CITY GOVERNMENT OF MUNTINLUPA</p>
            <p>Strategic Performance Management System</p>
            <p>INDIVIDUAL PERFORMANCE COMMITTMENT AND REVIEW (ICPR)</p>
        </article>

        <article class="mb-1">
            <p>I, {{$employee->first_name}} {{$employee->last_name}}, {{$employee->position }}, of the {{ $division->name }} DIVISION of the BUSINESS PERMITS AND LICENSING OFFICE commit to deliver and agree to be rated on the attainment of the following targets in accordance wioth the indicated measures for the period {{$evaluation->start_date}} to {{$evaluation->end_date}} </p>
        </article>

        <article class='mb-1'>
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
        </article>

        <article class="text-align-center mt-3">
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
                            
                            <p>{{$head->first_name}} {{$head->last_name}}</p>
                            <p class="mt-1">Immediate Supervisor</p>
                        </td>
                        <td > {{$evaluation->end_date}} </td>
                        <td >
                            <p>Engr. Allan A. Cachuela</p>
                            <p class="mt-1">Head of Department Office</p>
                        </td>
                        <td >{{$evaluation->end_date}}</td>
                    </tr>
                </tbody>
            </table>
        </article>

        <article class="mt-1 mb-2">
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
                    @foreach($evaluationForm as $ev)
                    <tr>
                        <td>{{ $ev->output }}</td>
                        <td>{{ $ev->success_indicators}}</td>
                        <td>{{ $evaluationScores[$loop->index]->actual_accomplishments}}</td>
                        <td class="p-0">
                            <table class="ipcr w-100">
                                <tbody>
                                    <td>{{$evaluationScores[$loop->index]->quality_average}}</td>
                                    <td>{{$evaluationScores[$loop->index]->efficiency_average}}</td>
                                    <td>{{$evaluationScores[$loop->index]->timeliness_average}}</td>
                                    <td> {{ round(($evaluationScores[$loop->index]->quality_average + $evaluationScores[$loop->index]->efficiency_average + $evaluationScores[$loop->index]->timeliness_average) / 3, 2)}}</td>
                                </tbody>
                            </table>
                        </td>
                        <td>{{$evaluationScores[$loop->index]->remarks}}</td>
                    </tr>
                    @endforeach
                    <tr>
                           <th colspan='4'>
                            Total Average Rating
                           </th> 
                           <td>{{ $evaluation->total_average_rating }}</td>
                    </tr>
                    <tr>
                           <th colspan='4'>
                            Final Average Rating
                           </th> 
                           <td>{{ $evaluation->rating}}</td>
                    </tr>
                    <tr>
                           <th colspan='4'>
                            Adjectival Rating
                           </th> 
                           <td>{{ $evaluation->adjectival_rating }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">
                            <p>Comments</p>
                            {{$evaluation->comments}}
                        </th>
                    </tr>
                </tbody>
            </table>
            ->first_name}} {{$head->last_name}}
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
                        <td class='px-1 py-2'>{{$employee->first_name}} {{$employee->last_name}}
                            <p>Employee</p>
                        </td>
                        <td>{{$evaluation->end_date}}</td>
                        <td>
                            <p class="mb-1">I certify that I discussed my assessment of the performanmce with the employees</p>
                            <p>{{$head->first_name}} {{$head->last_name}}</p>
                            <p>Supervisor</p>
                        </td>
                        <td>{{$evaluation->end_date}}</td>
                        <td class="px-1 py-2">
                            <p>Engr. Allan A. Cochuela</p>
                            <p>Head of Deparment/Office</p>
                        </td>
                        <td>{{$evaluation->end_date}}</td>
                    </tr>
                </tbody>
            </table>
        </article>
    </section>
</body>
</html>