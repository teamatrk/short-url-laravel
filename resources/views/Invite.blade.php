


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 mr-10 mb-10 ml-10">
                <form action="{{ route('create_invite') }}" id="inviteForm" method="post">
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
                    @if($USER->company)
                    <div class="row mt-10">
                        <div class="col-md-2">
                            My Company
                        </div>
                        <div class="col-md-10">
                            <b>{{$USER->company->name}}</b>
                        </div>

                    </div>
                    @endif
                    <div class="row mt-10">
                        <div class="col-md-2">
                            Company
                        </div>
                        <div class="col-md-6">
                            <select name="company_id" class="form-control">
                                <option value="">--Select Company--</option>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Role
                        </div>
                        <div class="col-md-6">
                            <select name="role_id" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->role}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">Name</div>
                        <div class="col-md-6"><input class="form-control" type="text" name="name" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Email</div>
                        <div class="col-md-6"><input class="form-control" type="email" name="email" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">password</div>
                        <div class="col-md-6"><input class="form-control" type="password" name="password" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6"><input class="btn btn-primary" type="submit" value="Submit"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function(){


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#inviteForm').submit(function(e){

        e.preventDefault();

        $.ajax({

            url: "{{ route('create_invite') }}",
            type: "POST",
            data: $(this).serialize(),

            success:function(response){

                $('#response').html(response.message);

            },

            error:function(error){

                console.log(error);

            }

        });

    });
});
</script>