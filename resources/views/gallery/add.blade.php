<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Dashboard') }} --> Welcome {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong>{{ $message }}</strong>
            </div>
        @endif
                <form  action="{{url('add-gallery')}}" method="post" enctype="multipart/form-data">
                 @csrf

                   <div class="form-group">
                     <lable>Image</lable>
                     <input type="file" name="image[]" multiple class="form-control">
                   </div>

                   <div class="form-group">
                     <input type="submit" class="btn btn-success" value="Update">
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
