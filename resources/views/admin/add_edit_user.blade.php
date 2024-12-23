@extends('layouts.content')

@section('main-content')
<div class="container mx-auto p-4">
    <div class="w-full max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-2xl font-semibold mb-6">{{ $title }}</h3>

            <form class="space-y-6" method="post" action="@if (isset($edit->id)) {{ route('user.update', ['id' => $edit->id]) }}@else{{ route('user.store') }} @endif" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input class="form-control mt-1 block w-full px-4 py-2 rounded-md border border-gray-300" type="text" name="name" placeholder="Enter Name" value="@if (isset($edit->id)) {{ $edit->name }}@else {{ old('name') }} @endif">
                    @error('name')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input class="form-control mt-1 block w-full px-4 py-2 rounded-md border border-gray-300" type="number" name="age" placeholder="Enter Age" value="@if (isset($edit->id)) {{ $edit->age }}@else {{ old('age') }} @endif">
                    @error('age')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country" class="block text-sm font-medium text-gray-700">Nationality</label>
                    <select name="country" id="country" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-300" required>
                        <option value="">-- Choose Nationality --</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" @if(old('country') == $country) selected @endif>{{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="position" class="block text-sm font-medium text-gray-700">Playable Position</label>
                    <div class="space-y-2">
                        @foreach($positions as $position)
                            <div class="flex items-center">
                                <input class="form-check-input" type="checkbox" name="position[]" id="position_{{ $loop->index }}" value="{{ $position }}" @if(in_array($position, old('position', []))) checked @endif>
                                <label class="ml-2 text-sm text-gray-700" for="position_{{ $loop->index }}">{{ $position }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('position')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="number" class="block text-sm font-medium text-gray-700">Jersey Number</label>
                    <select name="number" id="number" class="form-control mt-1 block w-full px-4 py-2 rounded-md border border-gray-300" required>
                        <option value="">-- Choose Jersey Number --</option>
                        @foreach($availableNumbers as $number)
                            <option value="{{ $number }}" @if(isset($user) && $user->number == $number) selected @endif>{{ $number }}</option>
                        @endforeach
                    </select>
                    @error('number')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="value" class="block text-sm font-medium text-gray-700">Market Value</label>
                    <input class="form-control mt-1 block w-full px-4 py-2 rounded-md border border-gray-300" type="number" name="value" placeholder="Enter Market Value" value="@if (isset($edit->id)) {{ $edit->value }}@else {{ old('value') }} @endif">
                    @error('value')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                    <div class="flex justify-center items-center">
                        <div class="avatar-upload text-center">
                            <input type="file" id="imageUpload" name="photo" accept=".png, .jpg, .jpeg" onchange="previewImage(this)" class="hidden">
                            <label for="imageUpload" class="cursor-pointer text-white mb-3 p-2 rounded-md bg-blue-500">Choose Photo</label>
                            <div class="w-64 h-64 text-center rounded-3xl mx-auto" id="imagePreview" style="@if (isset($edit->id) && $edit->photo != '') background-image:url('{{ url('/') }}/uploads/{{ $edit->photo }}')@else background-image: url('{{ url('/img/avatar.png') }}') @endif"></div>
                        </div>
                    </div>
                    
                    @error('photo')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('user.index') }}" class="btn btn-danger px-4 py-2 bg-red-500 text-white rounded-md">Cancel</a>
                    <input type="submit" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded-md" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script type="text/javascript">
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").css('background-image', 'url(' + e.target.result + ')');
                $("#imagePreview").hide();
                $("#imagePreview").fadeIn(700);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
