@php 
    //Arreglo de íconos 
    $links = [ 
        [ 
            'name' => 'Dashboard', 
            'icon' => 'fa-solid fa-gauge', 
            'href' => route('admin.dashboard'), 
            'active' => request()->routeIs('admin.dashboard'), 
        ], 
        [ 
            'header' => 'Gestión', 
        ], 
        [ 
            'name' => 'Roles y permisos', 
            'icon' => 'fa-solid fa-shield-halved', 
            'href' => route('admin.roles.index'), 
            'active' => request()->routeIs('admin.roles.*'), 
        ], 
    ]; 
@endphp 
  
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray
700" 
    aria-label="Sidebar"> 
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800"> 
        <ul class="space-y-2 font-medium"> 
            @foreach ($links as $link) 
                <li> 
                    {{-- Revisa si existe definido una llave llamada 'header' --}} 
                    @isset($link['header']) 
                        <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase"> 
                            {{ $link['header'] }} 
                        </div> 
                        {{-- Si no existe, usa la etiqueta como estaba definida antes --}} 
                    @else 
                        <a href="{{ $link['href'] }}" 
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white 
hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-100' : '' }}"> 
                            <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500"> 
                                <i class="{{ $link['icon'] }}"></i> 
                            </span> 
                            <span class="ms-3">{{ $link['name'] }}</span> 
                        </a> 
                    @endisset 
                </li> 
            @endforeach 
        </ul> 
    </div> 
 </aside>