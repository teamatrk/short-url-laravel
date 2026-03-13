<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Short Links') }}
        </h2>
    </x-slot>
        

        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>User</th>
                <th>Original URL</th>
                <th>Short Code</th>

                <th>Created</th>
            </tr>

            @foreach($links as $link)
            <tr>
                <td>{{ $link->id }}</td>
                <td>{{ $link->company_name }}</td>
                <td>{{ $link->user_name }}</td>
                <td>{{ $link->original_url }}</td>
                <td>{{ $link->code }}</td>
                <td>{{ $link->created_at }}</td>
            </tr>
            @endforeach
        
        </table>
        <div class="row mt-10">
            <div class="col-md-8">{{ $links->links() }}</div>
        </div>

</x-app-layout>