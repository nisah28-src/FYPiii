
@props(['title','count'=> 0])



<div {{ $attributes->merge(['class'=> 'stats stats-vertical lg:stats-horizontal shadow bg-slate-800/50 border border-slate-700 hover:border-primary']) }}>
  <div class="stat p-6 place-items-center">
    <h2 class="stat-title text-slate-400 text-xl uppercase tracking-widest font-semibold">{{ $title }}</h2>
    <span class="stat-title text-2xl font-extrabold text-white ">{{ $count }}</span>
    <div>
    {{ $slot }}
</div>
    
  </div>
</div>

