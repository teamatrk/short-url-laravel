


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 mr-10 mb-10 ml-10">
                <form action="{{ route('create_link') }}" id="inviteForm" method="post">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="row mt-10">
                        <div class="col-md-2">
                            Target URL 
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="original_url" required="required">
                        </div>
                    </div>

                    <div class="row mt-10">
                        <div class="col-md-2"></div>
                        <div class="col-md-6"><input class="btn btn-primary" type="submit" value="Submit"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

