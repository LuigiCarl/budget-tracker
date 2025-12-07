@extends('layouts.docs')

@section('title', 'Error Codes')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">API Reference</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Error Codes</h1>
    <p class="text-lg text-muted-foreground">Understanding API error responses and status codes.</p>
</div>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for detailed error code documentation.
</x-docs.callout>
@endsection