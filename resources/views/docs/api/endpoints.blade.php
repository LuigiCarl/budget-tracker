@extends('layouts.docs')

@section('title', 'API Endpoints')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>API Endpoints</h1>

<p class="text-xl text-muted-foreground">
    Comprehensive reference for all available API endpoints.
</p>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for detailed API endpoint documentation.
</x-docs.callout>
@endsection