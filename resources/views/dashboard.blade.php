<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">

            <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
                <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                    <tr>
                        <th data-priority="1">Nombre</th>
                        <th data-priority="2">Puntos</th>
                        <th data-priority="3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($players as $player)
                        @if(!$player->belongsToTeam(\App\Models\Team::find(env('PENDING_TEAM_ID')))
                         or $player->belongsToTeam(\App\Models\Team::find(env('ADMIN_TEAM_ID')))
                        )
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $player->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $player->currentTeam->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $player->getCurrentPeriodPoints() }}</div>
                                    <div class="text-sm text-gray-500"></div>
                                </td>
                                <td class="text-right">
                                    <button onclick="showModal(this)" class="h-8 px-4 text-sm bg-green-500 hover:bg-green-600 p-2 font-semibold text-white inline-flex items-center space-x-2 rounded show-modal" data-name="{{ $player->name }}" data-id="{{ $player->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('udashboard', ['id' => $player->id]) }}" class="h-8 px-4 text-sm bg-blue-400 hover:bg-blue-500 p-2 font-semibold text-white inline-flex items-center space-x-2 rounded"data-id="{{ $player->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50" style="display: none">
        <!-- modal -->
        <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3 " style="height: 500px">
            <!-- modal header -->
            <div class="border-b px-4 py-2 flex justify-between items-center">
                <h3 class="font-semibold text-lg modalTitle">Seleccionar Puntos</h3>
                <button class="text-black close-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <!-- modal body -->
            <div class="p-3 bg-gray-200" style="height: 400px">
                <div class="flex justify-center">
                    <div class="bg-white shadow-xl rounded-lg w-1/2">
                        <ul class="divide-y divide-gray-500 overflow-y-scroll" style="max-height: 380px">
                            @foreach($points as $point)
                                <li data-id="{{$point->id}}" data-point="{{$point->point}}" class="selectPoint p-4 @if($point->point > 0) bg-blue-300 hover:bg-blue-400 @else bg-red-300 hover:bg-red-400 @endif cursor-pointer">
                                    <div class="inline-block w-9/12">{{$point->name}}</div>
                                    <div class="inline-block w-2/12 font-extrabold">({{$point->point}})</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <select name="puntos" id="puntos" multiple style="display: none">
                    @foreach($points as $point)
                        <option value="{{ $point->id }}">{{ $point->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" id="pointUserId">
            </div>
            <div class="flex justify-end items-center w-100 border-t p-3">
                <button class="savePoints bg-blue-500 hover:bg-blue-600 active:bg-blue-700 px-3 py-1 rounded text-white">Asignar Puntos Seleccionados</button>
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
        var modal;
        $(document).ready(function(){
            var table = $('#example').DataTable( {
                responsive: true
            } )
                .columns.adjust()
                .responsive.recalc();

            modal = $(".modal");
            $(".show-modal").click(function() {

            })
            $(".close-modal").click(function(){
                modal.hide();
            })

            $(".selectPoint").click(function() {
                let point = $(this).data('point');

                if ($(this).hasClass('pointSelected')) {
                    if (point > 0) {
                        $(this).addClass('bg-blue-300');
                        $(this).addClass('hover:bg-blue-400');
                        $(this).removeClass('bg-blue-500');
                        $(this).removeClass('pointSelected');
                    } else {
                        $(this).addClass('bg-red-300');
                        $(this).addClass('hover:bg-red-400');
                        $(this).removeClass('bg-red-500');
                        $(this).removeClass('pointSelected');
                    }
                } else {
                    if (point > 0) {
                        $(this).removeClass('bg-blue-300');
                        $(this).removeClass('hover:bg-blue-400');
                        $(this).addClass('bg-blue-500');
                        $(this).addClass('pointSelected');
                    } else {
                        $(this).removeClass('bg-red-300');
                        $(this).removeClass('hover:bg-red-400');
                        $(this).addClass('bg-red-500');
                        $(this).addClass('pointSelected');
                    }
                }

                var arrPoints = [];
                $( ".pointSelected" ).each(function( index ) {
                    arrPoints.push($(this).data('id'));
                });

                $("#puntos").val(arrPoints);
            });

            $(".savePoints").click(function() {
                $.ajax({
                    method:"POST",
                    url: "{{ route('addPoints') }}",
                    data: { puntos: $("#puntos").val(), user: $("#pointUserId").val(), _token: "{{ csrf_token() }}"}
                }).always(function(response) {
                    location.reload();
                });
            });

        });

        function showModal(me) {
            let id = $(me).data('id');
            let name = $(me).data('name');
            $(".modalTitle").html('Seleccion de puntos para ' + name);
            $("#pointUserId").val(id);
            $("#puntos").val([]);


            $( ".pointSelected" ).each(function( index ) {
                let point = $(this).data('point');
                if (point > 0) {
                    $(this).addClass('bg-blue-300');
                    $(this).addClass('hover:bg-blue-400');
                    $(this).removeClass('bg-blue-500');
                    $(this).removeClass('pointSelected');
                } else {
                    $(this).addClass('bg-red-300');
                    $(this).addClass('hover:bg-red-400');
                    $(this).removeClass('bg-red-500');
                    $(this).removeClass('pointSelected');
                }
            });

            modal.show();
        }
    </script>
</x-app-layout>
