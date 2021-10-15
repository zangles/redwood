<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Periodos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                    @php
                        $start = $currentPeriod->start_date;
                        $end = $currentPeriod->end_date
                    @endphp
                    PERIODO ACTUAL: {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} - @if(is_null($end)) actualidad @else {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }} @endif
                </h2>
                <button class="finalizarPeriodo text-center mb-2 w-full h-20 bg-red-500 hover:bg-red-600 active:bg-red-700 p-2 font-black text-white  items-center space-x-2 rounded">
                    FINALIZAR PERIODO
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".finalizarPeriodo").click(function(){
               if(confirm('Esta seguro que quiere terminar el periodo?')) {
                   window.location.href = "{{ route('endPeriod') }}";
               }
            });
        })
    </script>
</x-app-layout>
