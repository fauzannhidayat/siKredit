<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed z-40 inset-y-0 left-0 w-64 bg-white border-r border-slate-200 transform transition-transform duration-150 ease-in-out lg:static lg:translate-x-0 flex flex-col">

    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 shrink-0">
        <div>
            <h1 class="font-semibold text-slate-900 leading-5">PT Capella Multidana</h1>
            <p class="text-xs text-slate-500">Pengajuan Pembiayaan</p>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600" aria-label="Tutup menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        <a href="{{ route('pengajuan.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition
                  {{ request()->routeIs('pengajuan.*') ? 'bg-yellow-500 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Pengajuan Kredit
        </a>


    </nav>

    <div class="border-t border-slate-200 p-3 shrink-0">
        <p class="text-xs text-slate-400 px-3">&copy; {{ date('Y') }} Capella Multidana</p>
    </div>

</aside>