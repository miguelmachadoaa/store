<section class="py-16 bg-[#0d0e12] text-gray-300 relative border-t border-[#1f242e]">
    
    {{-- Grid técnico de fondo --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-10 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">

        {{-- Encabezado de la sección --}}
        <div class="flex justify-between items-end mb-10 border-b border-[#262b36] pb-4">
            <div>
                <h2 class="text-xl font-bold uppercase tracking-wider text-white [font-family:'Orbitron',sans-serif]">
                    Latest_Logs / Últimas Noticias
                </h2>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-mono mt-1">
                    System updates and technical documentation
                </p>
            </div>

            <a href="{{ route('blog.index') }}"
               class="text-blue-500 hover:text-blue-400 font-mono text-xs uppercase tracking-widest transition flex items-center gap-1 group">
                Fetch_All <span class="transform group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        {{-- Grid de Artículos --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}"
                   class="bg-[#14161d] border border-[#262b36] rounded-sm overflow-hidden hover:border-blue-500/50 transition duration-200 flex flex-col group h-full shadow-xl">

                    {{-- Imagen Destacada con filtro industrial --}}
                    @if($post->image)
                        <div class="h-48 w-full overflow-hidden relative border-b border-[#262b36]">
                            <div class="absolute inset-0 bg-blue-500/5 mix-blend-color z-10 pointer-events-none"></div>
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 class="h-full w-full object-cover filter grayscale contrast-125 group-hover:scale-105 transition duration-300">
                        </div>
                    @else
                        {{-- Placeholder técnico por si no hay imagen --}}
                        <div class="h-48 w-full bg-[#1b1e26] border-b border-[#262b36] flex items-center justify-center font-mono text-[10px] text-gray-600 uppercase tracking-widest">
                            No_Image_Asset
                        </div>
                    @endif

                    {{-- Cuerpo del Post --}}
                    <div class="p-5 flex flex-col flex-1">
                        
                        <h3 class="text-base font-bold text-white uppercase tracking-wide group-hover:text-blue-400 transition duration-150 line-clamp-2 [font-family:'Orbitron',sans-serif]">
                            {{ $post->title }}
                        </h3>

                        <p class="text-xs text-gray-400 font-mono mt-3 line-clamp-3 leading-relaxed flex-1">
                            {{ $post->excerpt }}
                        </p>

                        {{-- Footer del Post (Metadata) --}}
                        <div class="mt-5 pt-3 border-t border-[#1f242e] flex items-center justify-between font-mono text-[10px] text-gray-500 uppercase tracking-wider">
                            <span class="flex items-center gap-1">
                                <span class="text-blue-500">■</span> {{ $post->created_at->format('d M, Y') }}
                            </span>
                            <span class="text-blue-500 font-bold group-hover:underline">[Read_More]</span>
                        </div>
                    </div>

                </a>
            @endforeach

        </div>

    </div>
</section>