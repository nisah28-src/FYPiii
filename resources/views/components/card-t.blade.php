@props(['title'])

<div {{ $attributes->merge(['class' => 'card bg-base-100 w-96 shadow-sm'])}}
  
  <div class="card-body items-center text-center">
    <h2 class="card-title text-xl font-bold">{{ $title }}</h2>
    <div>
        {{ $slot }}
    </div>
    <div class="card-actions justify-end">
      <button class="btn btn-primary">Login</button>
      <button class="btn btn-primary">Register</button>
    </div>
  </div>
</div>