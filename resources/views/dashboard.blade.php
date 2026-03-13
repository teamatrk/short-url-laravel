<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                

                <h1 class="mt-8 text-2xl font-medium text-gray-900">
                    Welcome {{$USER->name}}
                </h1>






            </div>

            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                <div>
                    <div class="flex items-center">

                        <h2 class="ms-3 text-xl font-semibold text-gray-900">
                            <a href="{{route('invite')}}">Invite user</a>
                        </h2>
                    </div>




                </div>

                <div>
                    <div class="flex items-center">

                        <h2 class="ms-3 text-xl font-semibold text-gray-900">
                            <a href="{{route('link')}}">Create Link</a>
                        </h2>
                    </div>


                </div>

                <div>
                    <div class="flex items-center">

                        <h2 class="ms-3 text-xl font-semibold text-gray-900">
                            <a href="{{route('show_links')}}">Show Links</a>
                        </h2>
                    </div>

                </div>


            </div>

            </div>
        </div>
    </div>
</x-app-layout>
