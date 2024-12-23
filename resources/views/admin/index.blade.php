@extends('layouts.content') 
@section('main-content') 
<div class="m-24 mt-16"> 
    <div class="flex justify-center mb-4">
        <img src="{{ url('/img/logoRM.png') }}" alt="" class="w-24 align-middle justify-center">
    </div>
    <h2 class="text-5xl font-bold text-black dark:text-white text-center mb-4"> 
        Real Madrid's Player
    </h2> 
    <div class="text-end mb-5"> 
        <a href="{{ route('user.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-2xl p-3 text-md font-semibold">+ Add New Player</a> 
    </div> 
    @if (session('success')) 
    <div class="bg-green-100 text-green-800 border border-green-400 rounded-md p-4 mb-5"> 
        {{ session('success') }} 
    </div> 
    @endif 
    @if (session('error')) 
    <div class="bg-red-100 text-red-800 border border-red-400 rounded-md p-4 mb-5"> 
        {{ session('error') }} 
    </div> 
    @endif 

    <div class=" bg-gray-100 shadow-md rounded-3xl p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> 
            @forelse($users as $index => $row) 
                <div class="bg-white shadow-md rounded-3xl p-6">
                    <div class="text-center">
                        <h5 class="mb-3 text-6xl font-bold text-blue-800">#{{ $row->number }}</h5>
                        <div class="showPhoto mx-auto">
                            <div id="imagePreview" class="w-64 h-64 text-center rounded-3xl mx-auto" style="background-image:url('@if ($row->photo != '') {{ url('/') }}/uploads/{{ $row->photo }} @else {{ url('/img/avatar.png') }} @endif');"></div>
                        </div>
                        <h5 class="mb-3 mt-4 text-2xl font-bold text-black dark:text-gray-200">{{ $row->name }}</h5>
                        {{-- <p class="text-gray-600 dark:text-gray-400">{{ $row->email }}</p> --}}
                        <p class="text-md px-7 justify-start text-left text-gray-600 mb-2">Age: <strong> {{ $row->age }} y.o</strong> </p>
                        <p class="text-md px-7 justify-start text-left text-gray-600 mb-2">Nationality: <strong> {{ $row->country ?? 'Not Provided' }} </strong> </p>
                        <p class="text-md px-7 justify-start text-left text-gray-600 mb-4">
                            Playable Position: 
                            <strong>
                                @if(!empty($row->position))
                                {{ implode(', ', json_decode($row->position, true)) }}
                                @else
                                Not Provided
                                @endif
                            </strong>
                        </p>                
                        <p class="text-xl bg-blue-800 text-center text-white rounded-3xl p-2 mb-2">Market Value: <strong> €{{ $row->value }}</strong> </p>
                        <div class="mt-4 space-x-3">
                            <a href="{{ route('user.edit', ['id' => $row->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">Edit</a>
                            <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md" onClick="deleteFunction('{{ $row->id }}')">Delete</button>
                        </div>
                    </div>
                </div>
            @empty 
            <div class="flex justify-center">
                <div class="bg-yellow-100 text-yellow-800 border border-yellow-400 rounded-3xl p-4 text-center text-3xl">
                    No Users Found
                </div>
            </div>
            
            @endforelse
 
        </div> 

    </div>
</div> 

@include ('admin.modal_delete') 

@endsection 

@push('js') 
<script> 
    function deleteFunction(id) { 
        document.getElementById('delete_id').value = id; 
        $("#modalDelete").modal('show'); 
    } 
</script> 
@endpush 

<style> 
    .showPhoto > div { 
        background-size: cover; 
        background-repeat: no-repeat; 
        background-position: center;
    } 
</style>
