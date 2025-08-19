<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>FT Telecom - Dashboard</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com/3.4.14"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: { 
            inter: ['Inter', 'system-ui', 'sans-serif']
          },
          colors: {
            primary: {
              50: '#f8fafc',
              100: '#f1f5f9',
              200: '#e2e8f0',
              300: '#cbd5e1',
              400: '#94a3b8',
              500: '#64748b',
              600: '#475569',
              700: '#334155',
              800: '#1e293b',
              900: '#0f172a'
            },
            accent: {
              50: '#ecfdf5',
              100: '#d1fae5',
              200: '#a7f3d0',
              300: '#6ee7b7',
              400: '#34d399',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
              800: '#065f46',
              900: '#064e3b'
            },
            blue: {
              500: '#3b82f6',
              600: '#2563eb'
            },
            orange: {
              500: '#f59e0b',
              600: '#d97706'
            }
          },
          animation: {
            'fade-in': 'fadeIn 0.3s ease-out',
            'slide-in': 'slideIn 0.3s ease-out',
            'scale-in': 'scaleIn 0.2s ease-out',
            'modal-in': 'modalIn 0.2s ease-out',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(8px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            slideIn: {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(0)' }
            },
            scaleIn: {
              '0%': { transform: 'scale(0.95)', opacity: '0' },
              '100%': { transform: 'scale(1)', opacity: '1' }
            },
            modalIn: {
              '0%': { opacity: '0', transform: 'scale(0.95)' },
              '100%': { opacity: '1', transform: 'scale(1)' }
            }
          }
        }
      }
    }
  </script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script>

  <!-- Theme Script -->
  <script>
    (() => {
      const key = 'theme';
      const root = document.documentElement;
      const stored = localStorage.getItem(key);
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const initial = stored ?? (prefersDark ? 'dark' : 'light');
      root.classList.toggle('dark', initial === 'dark');
      root.dataset.theme = initial;
      
      window.toggleTheme = () => {
        const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
        root.classList.toggle('dark', next === 'dark');
        root.dataset.theme = next;
        localStorage.setItem(key, next);
      };
    })();
  </script>

  <style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 4px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(148, 163, 184, 0.3);
      border-radius: 2px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(148, 163, 184, 0.5);
    }

    /* Smooth transitions */
    * {
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Custom focus styles */
    button:focus,
    a:focus {
      outline: 2px solid #10b981;
      outline-offset: 2px;
    }

    /* Modal backdrop */
    .modal-backdrop {
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
  </style>
</head>

<body class="h-full bg-primary-50 dark:bg-primary-900 text-primary-900 dark:text-primary-50 font-inter antialiased">
<div
  x-data="{
    sidebarOpen: false,
    sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    notificationsOpen: false,
    userMenuOpen: false,
    currentTime: new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }),
    
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
      localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
    },
    
    closeAllModals() {
      this.notificationsOpen = false;
      this.userMenuOpen = false;
    }
  }"
  x-init="
    setInterval(() => {
      currentTime = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
    }, 1000);
  "
  class="min-h-screen flex"
>

  <!-- Mobile Overlay -->
  <div 
    x-show="sidebarOpen" 
    x-transition.opacity.duration.300ms
    class="fixed inset-0 z-40 bg-black/20 lg:hidden" 
    @click="sidebarOpen = false">
  </div>

  <!-- Sidebar -->
  <aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 ease-in-out
           bg-white dark:bg-primary-800 border-r border-primary-200 dark:border-primary-700"
    :class="{
      'w-16': sidebarCollapsed,
      'w-64': !sidebarCollapsed,
      '-translate-x-full lg:translate-x-0': !sidebarOpen,
      'translate-x-0': sidebarOpen
    }"
  >
    <!-- Logo -->
    <div class="flex items-center h-16 px-4 border-b border-primary-200 dark:border-primary-700">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-accent-500 rounded-lg flex items-center justify-center">
          <i data-lucide="radio" class="w-5 h-5 text-white"></i>
        </div>
        <div x-show="!sidebarCollapsed" class="animate-fade-in">
          <h1 class="font-semibold text-lg text-primary-900 dark:text-primary-50">FT Telecom</h1>
        </div>
      </div>
      
      <!-- Toggle Button -->
      <button
        @click="toggleSidebar()"
        class="ml-auto w-8 h-8 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
               flex items-center justify-center transition-colors hidden lg:flex"
      >
        <i :data-lucide="sidebarCollapsed ? 'panel-left-open' : 'panel-left-close'" class="w-4 h-4"></i>
      </button>
      
      <!-- Mobile Close -->
      <button
        @click="sidebarOpen = false"
        class="ml-auto w-8 h-8 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
               flex items-center justify-center transition-colors lg:hidden"
      >
        <i data-lucide="x" class="w-4 h-4"></i>
      </button>
    </div>

   <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
  <div
    x-data="{
      menuItems: [
        { id: 'dashboard', icon: 'layout-dashboard', label: 'Dashboard', href: @js(route('dashboard')), active: @js(request()->routeIs('dashboard')) },
        { id: 'users',     icon: 'users',            label: 'Usuários',  href: @js(route('users.index')), active: @js(request()->routeIs('users.*')) },
      ]
    }"
    x-init="$nextTick(() => lucide.createIcons())"
    x-effect="lucide.createIcons()"
  >
    <template x-for="item in menuItems" :key="item.id">
      <a
        :href="item.href"
        class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
               hover:bg-primary-100 dark:hover:bg-primary-700"
        :class="item.active
          ? 'bg-accent-50 dark:bg-accent-900/20 text-accent-600 dark:text-accent-400'
          : 'text-primary-600 dark:text-primary-300'">
        <i :data-lucide="item.icon" class="w-5 h-5 flex-shrink-0"></i>
        <span x-show="!sidebarCollapsed" class="font-medium" x-text="item.label"></span>
        <div x-show="item.active && !sidebarCollapsed" class="ml-auto w-2 h-2 bg-accent-500 rounded-full"></div>
        <div x-show="sidebarCollapsed"
             class="absolute left-full ml-2 px-3 py-2 bg-primary-900 dark:bg-primary-100 text-primary-50 dark:text-primary-900 
                    text-sm rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-50"
             x-text="item.label"></div>
      </a>
    </template>
  </div>
</nav>


    <!-- User Profile -->
    <div class="p-3 border-t border-primary-200 dark:border-primary-700">
      <div class="flex items-center gap-3 p-3 rounded-xl bg-primary-100 dark:bg-primary-700">
        <div class="w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center">
          <i data-lucide="user" class="w-4 h-4 text-white"></i>
        </div>
        <div x-show="!sidebarCollapsed" class="animate-fade-in">
          <p class="text-sm font-medium text-primary-900 dark:text-primary-50">Admin User</p>
          <p class="text-xs text-primary-500 dark:text-primary-400">admin@fttelecom.com</p>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col transition-all duration-300" :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'">
    <!-- Header -->
    <header class="h-16 bg-white dark:bg-primary-800 border-b border-primary-200 dark:border-primary-700 flex items-center px-6 relative">
      <!-- Mobile Menu Button -->
      <button
        @click="sidebarOpen = true"
        class="lg:hidden w-10 h-10 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
               flex items-center justify-center transition-colors mr-4"
      >
        <i data-lucide="menu" class="w-5 h-5"></i>
      </button>

      <!-- Page Title -->
      <div>
        <h1 class="text-xl font-semibold text-primary-900 dark:text-primary-50">Dashboard</h1>
        <p class="text-sm text-primary-500 dark:text-primary-400">Visão geral do sistema</p>
      </div>

      <!-- Header Actions -->
        <div class="ml-auto flex items-center gap-3">

          {{-- Softphone WebRTC global na Topbar --}}
          <x-webrtc-phone />

          <!-- Time -->
          <div class="hidden sm:flex items-center gap-2 px-3 py-2 bg-primary-100 dark:bg-primary-700 rounded-lg">
            <i data-lucide="clock" class="w-4 h-4 text-primary-500 dark:text-primary-400"></i>
            <span class="text-sm font-medium text-primary-700 dark:text-primary-300" x-text="currentTime"></span>
          </div>

        <!-- Theme Toggle -->
        <button
          @click="toggleTheme()"
          class="w-10 h-10 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
                 flex items-center justify-center transition-colors"
        >
          <i data-lucide="sun" class="w-5 h-5 dark:hidden"></i>
          <i data-lucide="moon" class="w-5 h-5 hidden dark:block"></i>
        </button>

        <!-- Notifications -->
        <div class="relative">
          <button 
            @click="notificationsOpen = !notificationsOpen; userMenuOpen = false"
            class="relative w-10 h-10 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
                   flex items-center justify-center transition-colors"
            :class="notificationsOpen ? 'bg-primary-100 dark:bg-primary-700' : ''"
          >
            <i data-lucide="bell" class="w-5 h-5"></i>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-orange-500 rounded-full"></div>
          </button>

          <!-- Notifications Modal -->
          <div 
            x-show="notificationsOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="notificationsOpen = false"
            class="absolute right-0 top-12 w-80 bg-white dark:bg-primary-800 rounded-2xl border border-primary-200 dark:border-primary-700 shadow-xl z-50"
          >
            <div class="p-4 border-b border-primary-200 dark:border-primary-700">
              <div class="flex items-center justify-between">
                <h3 class="font-semibold text-primary-900 dark:text-primary-50">Notificações</h3>
                <span class="text-xs bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 px-2 py-1 rounded-full">3 novas</span>
              </div>
            </div>
            
            <div class="max-h-96 overflow-y-auto">
              <!-- Notification Item -->
              <div class="p-4 border-b border-primary-100 dark:border-primary-700 hover:bg-primary-50 dark:hover:bg-primary-700/50 transition-colors">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-plus" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-primary-900 dark:text-primary-50">Novo usuário cadastrado</p>
                    <p class="text-xs text-primary-500 dark:text-primary-400 mt-1">João Silva se cadastrou no sistema</p>
                    <p class="text-xs text-primary-400 dark:text-primary-500 mt-1">há 2 minutos</p>
                  </div>
                </div>
              </div>

              <div class="p-4 border-b border-primary-100 dark:border-primary-700 hover:bg-primary-50 dark:hover:bg-primary-700/50 transition-colors">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 bg-accent-100 dark:bg-accent-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="check-circle" class="w-4 h-4 text-accent-600 dark:text-accent-400"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-primary-900 dark:text-primary-50">Backup concluído</p>
                    <p class="text-xs text-primary-500 dark:text-primary-400 mt-1">Backup automático realizado com sucesso</p>
                    <p class="text-xs text-primary-400 dark:text-primary-500 mt-1">há 15 minutos</p>
                  </div>
                </div>
              </div>

              <div class="p-4 hover:bg-primary-50 dark:hover:bg-primary-700/50 transition-colors">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-orange-600 dark:text-orange-400"></i>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-medium text-primary-900 dark:text-primary-50">Atualização disponível</p>
                    <p class="text-xs text-primary-500 dark:text-primary-400 mt-1">Nova versão do sistema disponível</p>
                    <p class="text-xs text-primary-400 dark:text-primary-500 mt-1">há 1 hora</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-4 border-t border-primary-200 dark:border-primary-700">
              <button class="w-full text-center text-sm text-accent-600 dark:text-accent-400 hover:text-accent-700 dark:hover:text-accent-300 font-medium">
                Ver todas as notificações
              </button>
            </div>
          </div>
        </div>

        <!-- User Menu -->
        <div class="relative">
          <button 
            @click="userMenuOpen = !userMenuOpen; notificationsOpen = false"
            class="w-10 h-10 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-700 
                   flex items-center justify-center transition-colors"
            :class="userMenuOpen ? 'bg-primary-100 dark:bg-primary-700' : ''"
          >
            <img src="https://via.placeholder.com/150" alt="User Avatar" class="w-8 h-8 rounded-full">
          </button>

          <!-- User Menu Modal -->
          <div 
            x-show="userMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="userMenuOpen = false"
            class="absolute right-0 top-12 w-64 bg-white dark:bg-primary-800 rounded-2xl border border-primary-200 dark:border-primary-700 shadow-xl z-50"
          >
            <div class="p-4 border-b border-primary-200 dark:border-primary-700">
              <p class="text-sm font-medium text-primary-900 dark:text-primary-50">Admin User</p>
              <p class="text-xs text-primary-500 dark:text-primary-400 mt-1">admin@fttelecom.com</p>
            </div>
            <div class="p-2">
              <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-primary-700 dark:text-primary-300 hover:bg-primary-100 dark:hover:bg-primary-700 transition-colors">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span>Perfil</span>
              </a>
              <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-primary-700 dark:text-primary-300 hover:bg-primary-100 dark:hover:bg-primary-700 transition-colors">
                <i data-lucide="settings" class="w-4 h-4"></i>
                <span>Configurações</span>
              </a>
              <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-primary-700 dark:text-primary-300 hover:bg-primary-100 dark:hover:bg-primary-700 transition-colors">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                <span>Ajuda</span>
              </a>
            </div>
            <div class="p-2 border-t border-primary-200 dark:border-primary-700">
              <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Sair</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6 overflow-y-auto">
      @yield('content')
    </main>
  </div>
</div>

<script>
  lucide.createIcons();
</script>

</body>
</html>



