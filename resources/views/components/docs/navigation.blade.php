<div class="w-full">
    <!-- Getting Started Section -->
    <div class="pb-4">
        <h4 class="mb-1 rounded-md px-2 py-1 text-sm font-semibold">Getting Started</h4>
        <div class="grid grid-flow-row auto-rows-max text-sm">
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.index') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.index') }}">
                Introduction
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.installation') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.installation') }}">
                Installation
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.quickstart') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.quickstart') }}">
                Quick Start
            </a>
        </div>
    </div>

    <!-- API Documentation Section -->
    <div class="pb-4">
        <h4 class="mb-1 rounded-md px-2 py-1 text-sm font-semibold">API Reference</h4>
        <div class="grid grid-flow-row auto-rows-max text-sm">
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.api.authentication') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.api.authentication') }}">
                Authentication
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.api.endpoints') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.api.endpoints') }}">
                Endpoints
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.api.errors') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.api.errors') }}">
                Error Codes
            </a>
        </div>
    </div>

    <!-- Components Section -->
    <div class="pb-4" x-data="{ open: {{ request()->is('docs/components*') ? 'true' : 'false' }} }">
        <button @click="open = !open" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>Components</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.components.buttons') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.components.buttons') }}">
                Buttons
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.components.forms') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.components.forms') }}">
                Forms
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.components.cards') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.components.cards') }}">
                Cards
            </a>
        </div>
    </div>

    <!-- Advanced Section -->
    <div class="pb-4" x-data="{ open: {{ request()->is('docs/deployment') || request()->is('docs/testing') || request()->is('docs/troubleshooting') ? 'true' : 'false' }} }">
        <button @click="open = !open" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>Advanced</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.deployment') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.deployment') }}">
                Deployment
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.testing') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.testing') }}">
                Testing
            </a>
            <a class="group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('docs.troubleshooting') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}" 
               href="{{ route('docs.troubleshooting') }}">
                Troubleshooting
            </a>
        </div>
    </div>
</div>

<!-- Alpine.js for collapsible sections -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>