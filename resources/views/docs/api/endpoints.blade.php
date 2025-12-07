@extends('layouts.docs')

@section('title', 'API Endpoints')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">API Reference</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">API Endpoints</h1>
    <p class="text-lg text-muted-foreground">Comprehensive reference for all available API endpoints.</p>
</div>

<x-docs.callout type="info" title="Coming Soon">
    This section is under development. Check back soon for detailed API endpoint documentation.
</x-docs.callout>
@endsection