
<x-app-layout>
<div class="flex flex-col items-center justify-center mt-6">
    <h1 class="text-3xl text-center p-6">Welcome</h1>

<div class="card w-96 shadow-sm bg-gray-500">
  <div class="card-body items-center text-center">
    <h2 class="card-title font bold text-3xl">Program Structure Management System</h2>
    <p>center for program structure generation</p>
    <div class="card-actions mt-10">
      <a class="btn btn-primary px-6 w-full" href="{{ route('login') }}">Log in</a>
      <a class="btn btn-secondary px-6 w-full" href="{{ route('register') }}">Register</a>
    </div>
  </div>
</div>
</div>
</x-app-layout>
