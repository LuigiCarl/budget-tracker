<div class="w-full" x-data="{ 
    openSections: {
        gettingStarted: {{ request()->routeIs('docs.index') || request()->routeIs('docs.installation') || request()->routeIs('docs.quickstart') ? 'true' : 'false' }},
        features: {{ request()->routeIs('docs.features.*') ? 'true' : 'false' }},
        api: {{ request()->routeIs('docs.api.*') ? 'true' : 'false' }},
        advanced: {{ request()->routeIs('docs.deployment') || request()->routeIs('docs.testing') || request()->routeIs('docs.troubleshooting') ? 'true' : 'false' }}
    }
}">
    <!-- Getting Started Section -->
    <div class="pb-4">
        <button @click="openSections.gettingStarted = !openSections.gettingStarted" 
                class="flex w-full items-center justify-between rounded-md px-2 py-1.5 text-sm font-semibold hover:bg-accent hover:text-accent-foreground transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#6366F1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Getting Started</span>
            </div>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': openSections.gettingStarted }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="openSections.gettingStarted" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.index') ? 'bg-[#6366F1]/10 text-[#6366F1] font-medium border-l-2 border-[#6366F1] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.index') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                Introduction
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.installation') ? 'bg-[#6366F1]/10 text-[#6366F1] font-medium border-l-2 border-[#6366F1] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.installation') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Installation
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.quickstart') ? 'bg-[#6366F1]/10 text-[#6366F1] font-medium border-l-2 border-[#6366F1] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.quickstart') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Quick Start
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="pb-4">
        <button @click="openSections.features = !openSections.features" 
                class="flex w-full items-center justify-between rounded-md px-2 py-1.5 text-sm font-semibold hover:bg-accent hover:text-accent-foreground transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#8B5CF6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Features</span>
            </div>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': openSections.features }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="openSections.features" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.features.dashboard') ? 'bg-[#8B5CF6]/10 text-[#8B5CF6] font-medium border-l-2 border-[#8B5CF6] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.features.dashboard') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.features.transactions') ? 'bg-[#8B5CF6]/10 text-[#8B5CF6] font-medium border-l-2 border-[#8B5CF6] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.features.transactions') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                Transactions
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.features.budgets') ? 'bg-[#8B5CF6]/10 text-[#8B5CF6] font-medium border-l-2 border-[#8B5CF6] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.features.budgets') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                Budgets
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.features.accounts') ? 'bg-[#8B5CF6]/10 text-[#8B5CF6] font-medium border-l-2 border-[#8B5CF6] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.features.accounts') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                Accounts
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.features.categories') ? 'bg-[#8B5CF6]/10 text-[#8B5CF6] font-medium border-l-2 border-[#8B5CF6] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.features.categories') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                Categories
            </a>
        </div>
    </div>

    <!-- API Reference Section -->
    <div class="pb-4">
        <button @click="openSections.api = !openSections.api" 
                class="flex w-full items-center justify-between rounded-md px-2 py-1.5 text-sm font-semibold hover:bg-accent hover:text-accent-foreground transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#10B981]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                <span>API Reference</span>
            </div>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': openSections.api }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="openSections.api" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.api.authentication') ? 'bg-[#10B981]/10 text-[#10B981] font-medium border-l-2 border-[#10B981] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.api.authentication') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                Authentication
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.api.endpoints') ? 'bg-[#10B981]/10 text-[#10B981] font-medium border-l-2 border-[#10B981] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.api.endpoints') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Endpoints
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.api.errors') ? 'bg-[#10B981]/10 text-[#10B981] font-medium border-l-2 border-[#10B981] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.api.errors') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Error Handling
            </a>
        </div>
    </div>

    <!-- Advanced Section -->
    <div class="pb-4">
        <button @click="openSections.advanced = !openSections.advanced" 
                class="flex w-full items-center justify-between rounded-md px-2 py-1.5 text-sm font-semibold hover:bg-accent hover:text-accent-foreground transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#F59E0B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Advanced</span>
            </div>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': openSections.advanced }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="openSections.advanced" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 -translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.deployment') ? 'bg-[#F59E0B]/10 text-[#F59E0B] font-medium border-l-2 border-[#F59E0B] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.deployment') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                Deployment
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.testing') ? 'bg-[#F59E0B]/10 text-[#F59E0B] font-medium border-l-2 border-[#F59E0B] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.testing') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Testing
            </a>
            <a class="group flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm transition-colors {{ request()->routeIs('docs.troubleshooting') ? 'bg-[#F59E0B]/10 text-[#F59E0B] font-medium border-l-2 border-[#F59E0B] -ml-[17px] pl-[15px]' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}" 
               href="{{ route('docs.troubleshooting') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Troubleshooting
            </a>
        </div>
    </div>
</div>

<!-- Alpine.js for collapsible sections -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>