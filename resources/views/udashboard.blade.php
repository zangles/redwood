<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de ') . $user->name  }}
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
            <div class="flex flex-col mt-10">
                <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                        Listado de puntos obtenidos
                    </h2>
                    <table id="example" class="stripe hover mt-4" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                        <tr>
                            <th data-priority="1">Periodo</th>
                            <th data-priority="1">Fecha</th>
                            <th data-priority="2">Descripcion</th>
                            <th data-priority="3">Puntos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->points as $point)
                            <tr>
                                <td>
                                    <div class="text-sm text-gray-900">
                                        @php
                                        $start = \App\Models\Period::find($point->pivot->period_id)->start_date;
                                        $end = \App\Models\Period::find($point->pivot->period_id)->end_date
                                        @endphp
                                        {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} - @if(is_null($end)) actualidad @else {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }} @endif

                                    </div>
                                    <div class="text-sm text-gray-500"></div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($point->pivot->created_at)->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500"></div>
                                </td>
                                <td>
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $point->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $point->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <h2 class="font-black text-2xl text-gray-800 leading-tight mb-4
                                    @if($point->point > 0) text-green-500 @else text-red-500 @endif
                                    ">
                                        {{ $point->point }}
                                    </h2>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>

        /*Overrides for Tailwind CSS */

        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568; 			/*text-gray-700*/
            padding-left: 1rem; 		/*pl-4*/
            padding-right: 1rem; 		/*pl-4*/
            padding-top: .5rem; 		/*pl-2*/
            padding-bottom: .5rem; 		/*pl-2*/
            line-height: 1.25; 			/*leading-tight*/
            border-width: 2px; 			/*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7; 		/*border-gray-200*/
            background-color: #edf2f7; 	/*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;	/*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button		{
            font-weight: 700;				/*font-bold*/
            border-radius: .25rem;			/*rounded*/
            border: 1px solid transparent;	/*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current	{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important; /*bg-indigo-500*/
        }

    </style>
    <script>

        window.onload = function () {
            var table = $('#example').DataTable( {
                responsive: true
            } )
                .columns.adjust()
                .responsive.recalc();

            CanvasJS.addColorSet("flatShades",
                [//colorSet Array
                    "#3498db",
                    "#1abc9c",
                    "#2ecc71",
                    "#3498db",
                    "#9b59b6",
                    "#34495e"
                ]);

            var chart = new CanvasJS.Chart("chartContainer", {
                colorSet: "flatShades",
                animationEnabled: true,
                title:{
                    text: "Puntaje obtenido en el periodo actual"
                },
                axisX: {
                    // valueFormatString: "DD MMM",
                    interval:1,
                    intervalType: "day"
                },
                axisY: {
                    title: "Puntos",
                    suffix: " "
                },
                legend:{
                    cursor: "pointer",
                    fontSize: 16,
                    itemclick: toggleDataSeries
                },
                toolTip:{
                    shared: true
                },
                data: [{
                    name: "Puntos",
                    type: "spline",
                    yValueFormatString: "##",
                    showInLegend: true,
                    dataPoints: [
                        @foreach($chart as $cha)
                            @php
                                list($year, $month, $day) =explode("-", $cha->created_at);
                            @endphp
                        { x: new Date({{$year}},{{$month}},{{$day}}), y: {{ $cha->total }} },
                        @endforeach
                    ]
                }]
            });
            chart.render();

            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        }

    </script>
</x-app-layout>
