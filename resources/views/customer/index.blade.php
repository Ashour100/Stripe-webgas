<x-app-layout>

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        All customers
    </h2>
</x-slot>
@dd($customer['data'])
@endsection
</x-app-layout>