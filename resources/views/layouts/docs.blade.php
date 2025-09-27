<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Documentation' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        border: 'hsl(var(--border))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        muted: 'hsl(var(--muted))',
                        'muted-foreground': 'hsl(var(--muted-foreground))',
                        popover: 'hsl(var(--popover))',
                        'popover-foreground': 'hsl(var(--popover-foreground))',
                        card: 'hsl(var(--card))',
                        'card-foreground': 'hsl(var(--card-foreground))',
                        primary: 'hsl(var(--primary))',
                        'primary-foreground': 'hsl(var(--primary-foreground))',
                        secondary: 'hsl(var(--secondary))',
                        'secondary-foreground': 'hsl(var(--secondary-foreground))',
                        accent: 'hsl(var(--accent))',
                        'accent-foreground': 'hsl(var(--accent-foreground))',
                        destructive: 'hsl(var(--destructive))',
                        'destructive-foreground': 'hsl(var(--destructive-foreground))',
                        ring: 'hsl(var(--ring))',
                    },
                }
            }
        }
    </script>

    <!-- Prism.js for syntax highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>

    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 222.2 84% 4.9%;
            --card: 0 0% 100%;
            --card-foreground: 222.2 84% 4.9%;
            --popover: 0 0% 100%;
            --popover-foreground: 222.2 84% 4.9%;
            --primary: 222.2 47.4% 11.2%;
            --primary-foreground: 210 40% 98%;
            --secondary: 210 40% 96%;
            --secondary-foreground: 222.2 47.4% 11.2%;
            --muted: 210 40% 96%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --accent: 210 40% 96%;
            --accent-foreground: 222.2 47.4% 11.2%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --border: 214.3 31.8% 91.4%;
            --ring: 222.2 84% 4.9%;
        }

        .dark {
            --background: 222.2 84% 4.9%;
            --foreground: 210 40% 98%;
            --card: 222.2 84% 4.9%;
            --card-foreground: 210 40% 98%;
            --popover: 222.2 84% 4.9%;
            --popover-foreground: 210 40% 98%;
            --primary: 210 40% 98%;
            --primary-foreground: 222.2 47.4% 11.2%;
            --secondary: 217.2 32.6% 17.5%;
            --secondary-foreground: 210 40% 98%;
            --muted: 217.2 32.6% 17.5%;
            --muted-foreground: 215 20.2% 65.1%;
            --accent: 217.2 32.6% 17.5%;
            --accent-foreground: 210 40% 98%;
            --destructive: 0 62.8% 30.6%;
            --destructive-foreground: 210 40% 98%;
            --border: 217.2 32.6% 17.5%;
            --ring: 212.7 26.8% 83.9%;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: hsl(var(--border));
            border-radius: 2px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--muted-foreground));
        }

        /* Code block styles */
        pre[class*="language-"] {
            background: hsl(var(--muted)) !important;
            border: 1px solid hsl(var(--border));
            border-radius: 0.5rem;
            margin: 1rem 0;
            position: relative;
        }

        .dark pre[class*="language-"] {
            background: hsl(var(--card)) !important;
        }

        code[class*="language-"], pre[class*="language-"] {
            color: hsl(var(--foreground)) !important;
        }

        .copy-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s;
        }

        pre:hover .copy-button {
            opacity: 1;
        }

        /* Prose styles */
        .prose {
            max-width: none;
            color: hsl(var(--foreground));
        }

        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: hsl(var(--foreground));
            font-weight: 600;
        }

        .prose h1 {
            font-size: 2.25rem;
            line-height: 2.5rem;
            margin-bottom: 1rem;
        }

        .prose h2 {
            font-size: 1.875rem;
            line-height: 2.25rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid hsl(var(--border));
        }

        .prose h3 {
            font-size: 1.5rem;
            line-height: 2rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .prose h4 {
            font-size: 1.25rem;
            line-height: 1.75rem;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .prose p {
            margin-bottom: 1rem;
            line-height: 1.75;
        }

        .prose a {
            color: hsl(var(--primary));
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .prose a:hover {
            text-decoration: none;
        }

        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose blockquote {
            border-left: 4px solid hsl(var(--border));
            padding-left: 1rem;
            margin: 1.5rem 0;
            color: hsl(var(--muted-foreground));
            font-style: italic;
        }

        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .prose th, .prose td {
            border: 1px solid hsl(var(--border));
            padding: 0.5rem 1rem;
            text-align: left;
        }

        .prose th {
            background: hsl(var(--muted));
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-background text-foreground antialiased">
    <!-- Mobile menu overlay -->
    <div id="mobile-overlay" class="fixed inset-0 z-40 bg-black/50 hidden lg:hidden"></div>

    <!-- Header -->
    <header class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="container flex h-14 items-center">
            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="mr-4 lg:hidden">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="mr-4 flex">
                <a class="mr-6 flex items-center space-x-2" href="{{ route('docs.index') }}">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    <span class="hidden font-bold sm:inline-block">
                        {{ config('app.name', 'Laravel') }} Docs
                    </span>
                </a>
            </div>

            <!-- Desktop navigation -->
            <nav class="flex items-center space-x-6 text-sm font-medium">
                <a class="transition-colors hover:text-foreground/80 text-foreground" href="{{ route('docs.index') }}">
                    Documentation
                </a>
                <a class="transition-colors hover:text-foreground/80 text-foreground/60" href="{{ route('api.docs') }}">
                    API
                </a>
            </nav>

            <!-- Spacer -->
            <div class="flex flex-1 items-center justify-between space-x-2 md:justify-end">
                <div class="w-full flex-1 md:w-auto md:flex-none">
                    <!-- Search can be added here -->
                </div>
                <nav class="flex items-center">
                    <!-- Dark mode toggle -->
                    <button id="theme-toggle" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10">
                        <svg id="theme-toggle-dark-icon" class="hidden h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2L13.09 8.26L20 9L14 14.74L15.18 21.02L10 18L4.82 21.02L6 14.74L0 9L6.91 8.26L10 2Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </header>

    <div class="border-b border-border">
        <div class="container flex-1 items-start md:grid md:grid-cols-[220px_minmax(0,1fr)] md:gap-6 lg:grid-cols-[240px_minmax(0,1fr)] lg:gap-10">
            
            <!-- Left Sidebar -->
            <aside id="sidebar" class="fixed top-14 z-30 -ml-2 hidden h-[calc(100vh-3.5rem)] w-full shrink-0 md:sticky md:block transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out lg:translate-x-0">
                <div class="relative overflow-hidden h-full bg-background md:bg-transparent">
                    <div class="h-full w-full overflow-y-auto custom-scrollbar py-6 pr-6 lg:py-8">
                        
                        @yield('sidebar')
                        
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="relative py-6 lg:gap-10 lg:py-8 xl:grid xl:grid-cols-[1fr_300px]">
                <div class="mx-auto w-full min-w-0">
                    
                    @if(isset($breadcrumbs))
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            @foreach($breadcrumbs as $breadcrumb)
                                <li class="inline-flex items-center">
                                    @if(!$loop->first)
                                        <svg class="w-3 h-3 text-muted-foreground mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    @endif
                                    @if($loop->last)
                                        <span class="text-sm font-medium text-muted-foreground">{{ $breadcrumb['title'] }}</span>
                                    @else
                                        <a href="{{ $breadcrumb['url'] }}" class="text-sm font-medium text-foreground hover:text-primary transition-colors">
                                            {{ $breadcrumb['title'] }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                    @endif

                    <div class="prose max-w-none">
                        @yield('content')
                    </div>

                    <!-- Page navigation -->
                    @if(isset($previousPage) || isset($nextPage))
                    <div class="flex flex-row items-center justify-between border-t border-border pt-4 mt-8">
                        @if(isset($previousPage))
                        <a href="{{ $previousPage['url'] }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-muted-foreground">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15,18 9,12 15,6"></polyline>
                            </svg>
                            {{ $previousPage['title'] }}
                        </a>
                        @else
                        <div></div>
                        @endif

                        @if(isset($nextPage))
                        <a href="{{ $nextPage['url'] }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-muted-foreground">
                            {{ $nextPage['title'] }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9,18 15,12 9,6"></polyline>
                            </svg>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Right Sidebar (Table of Contents) -->
                <div class="hidden text-sm xl:block">
                    <div class="sticky top-16 -mt-10 h-[calc(100vh-3.5rem)] overflow-y-auto custom-scrollbar pt-4">
                        <div class="pb-4">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <p class="font-semibold text-foreground">On This Page</p>
                            </div>
                            <div data-toc class="border-l border-border"></div>
                        </div>
                        
                        @yield('toc')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode functionality
        const themeToggle = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        // Check for saved theme preference or default to system preference
        const theme = localStorage.getItem('theme') || 
                     (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }

        themeToggle.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        });

        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('hidden');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Code copy functionality
        document.addEventListener('DOMContentLoaded', () => {
            // Add copy buttons to code blocks
            const codeBlocks = document.querySelectorAll('pre[class*="language-"]');
            
            codeBlocks.forEach((block) => {
                const button = document.createElement('button');
                button.className = 'copy-button inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-6 w-6 text-zinc-50 hover:bg-zinc-700';
                button.innerHTML = `
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                    </svg>
                `;
                
                button.addEventListener('click', async () => {
                    const code = block.querySelector('code').textContent;
                    await navigator.clipboard.writeText(code);
                    
                    button.innerHTML = `
                        <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20,6 9,17 4,12"/>
                        </svg>
                    `;
                    
                    setTimeout(() => {
                        button.innerHTML = `
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                            </svg>
                        `;
                    }, 2000);
                });
                
                block.appendChild(button);
            });
        });

        // Auto-generate table of contents
        document.addEventListener('DOMContentLoaded', () => {
            const tocContainer = document.querySelector('[data-toc]');
            if (!tocContainer) return;

            const headings = document.querySelectorAll('.prose h2, .prose h3, .prose h4');
            if (headings.length === 0) {
                tocContainer.innerHTML = '<p class="text-sm text-muted-foreground">No headings found</p>';
                return;
            }

            const tocList = document.createElement('ul');
            tocList.className = 'space-y-2';

            headings.forEach((heading, index) => {
                // Generate ID if not present
                if (!heading.id) {
                    heading.id = heading.textContent
                        .toLowerCase()
                        .replace(/\s+/g, '-')
                        .replace(/[^a-z0-9\-]/g, '')
                        .replace(/^-+|-+$/g, '');
                }

                const li = document.createElement('li');
                const link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent;
                
                // Add click handler for smooth scrolling
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetElement = document.getElementById(heading.id);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Update URL without triggering page reload
                        history.replaceState(null, null, '#' + heading.id);
                        
                        // Update active link
                        document.querySelectorAll('[data-toc] a').forEach(a => a.classList.remove('text-primary', 'font-medium'));
                        link.classList.add('text-primary', 'font-medium');
                    }
                });
                
                link.className = `block py-1 text-sm transition-colors hover:text-foreground cursor-pointer ${
                    heading.tagName === 'H2' ? 'font-medium text-foreground border-l-2 border-transparent hover:border-primary pl-3' : 
                    heading.tagName === 'H3' ? 'text-muted-foreground pl-6 hover:text-foreground' : 
                    'text-muted-foreground pl-9 text-xs hover:text-foreground'
                }`;

                li.appendChild(link);
                tocList.appendChild(li);
            });

            tocContainer.appendChild(tocList);

            // Add scroll spy functionality
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Remove active class from all links
                        document.querySelectorAll('[data-toc] a').forEach(a => {
                            a.classList.remove('text-primary', 'font-medium', 'border-primary');
                            a.classList.add('border-transparent');
                        });
                        
                        // Add active class to current section link
                        const activeLink = document.querySelector(`[data-toc] a[href="#${entry.target.id}"]`);
                        if (activeLink) {
                            activeLink.classList.add('text-primary', 'font-medium');
                            if (entry.target.tagName === 'H2') {
                                activeLink.classList.remove('border-transparent');
                                activeLink.classList.add('border-primary');
                            }
                        }
                    }
                });
            }, {
                rootMargin: '-20% 0% -35% 0%'
            });

            headings.forEach(heading => observer.observe(heading));
        });
    </script>
</body>
</html>