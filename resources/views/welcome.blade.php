
<x-app-layout>
<div class="hero min-h-[calc(100vh-64px)] bg-base-200">
        <div class="hero-content text-center">
            
            <div class="max-w-md flex flex-col items-center">
                
                <h1 class="text-3xl text-centerfont-extrabold mb-8 tracking-tight">
                    <span class="bg-red-500 bg-clip-text text-transparent">
                        Welcome
                    </span>
                </h1>

                <div class="card w-full sm:w-96 bg-base-100 shadow-2xl border border-base-300 overflow-hidden">
                    
                    <div class="h-2 w-full bg-gradient-to-r from-primary via-red-500 to-secondary"></div>

                    <div class="card-body p-10">
                        <div class="flex justify-center mb-2">
                            <div class="badge badge-outline badge-sm opacity-50 uppercase tracking-widest font-bold">System v1.0</div>
                        </div>

                        <h2 class="card-title justify-center text-center font-bold text-2xl leading-tight">
                            Program Structure <br> Management System
                        </h2>
                        
                        <p class="text-sm opacity-70 mt-2 italic text-center">
                            "The center for program structure generation"
                        </p>

                        <div class="card-actions flex flex-col gap-3 mt-8">
                            <a class="btn btn-primary btn-block shadow-md hover:scale-[1.02] transition-all" 
                               href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Log in
                            </a>
                            
                            <div class="divider text-xs opacity-40 uppercase">OR</div>

                            <a class="btn btn-outline btn-secondary btn-block hover:scale-[1.02] transition-all" 
                               href="{{ route('register') }}">
                                Create New Account
                            </a>
                        </div>
                    </div>
                </div>

                <p class="mt-8 text-xs opacity-40 uppercase tracking-widest font-semibold">
                    &copy; {{ date('Y') }} UNITEN Software Engineering
                </p>
            </div>

        </div>
    </div>
</x-app-layout>


