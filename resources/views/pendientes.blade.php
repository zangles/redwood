<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    @if ($users->count() > 0)
                        <table class="min-w-full w-full divide-y divide-gray-200 ">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 30%">
                                    ASIGNAR A
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    @if(!$user->belongsToTeam(\App\Models\Team::find(env('ADMIN_TEAM_ID'))))
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <select class="form-select inline-flex" style="width: 200px" id="select-team-{{$user->id}}">
                                                    <option value="{{ \App\Models\Team::find(env('REDWOOD1_TEAM_ID'))->id }}">{{ \App\Models\Team::find(env('REDWOOD1_TEAM_ID'))->name }}</option>
                                                    <option value="{{ \App\Models\Team::find(env('REDWOOD2_TEAM_ID'))->id }}">{{ \App\Models\Team::find(env('REDWOOD2_TEAM_ID'))->name }}</option>
                                                </select>
                                                <button data-id="{{ $user->id }}" class="btn-change-team bg-green-500 hover:bg-green-600 active:bg-green-700 p-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            <!-- More people... -->
                            </tbody>
                        </table>
                    @else
                        <table class="min-w-full w-full divide-y divide-gray-200 bg-white">
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-gray-600 text-center">
                                    Sin miembros pendientes de agregar
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $(".btn-change-team").click(function() {
            let id = $(this).data('id');
            let team = $("#select-team-"+id).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('changeTeam') }}",
                data: {userId: id, teamId: team, _token: "{{ csrf_token() }}"},
            }).always(function (response) {
                location.reload();
            });
        })
    });
</script>
