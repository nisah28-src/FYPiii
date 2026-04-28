<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Program;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Enums\RoleEnum;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
            $roles= Role::all();
            $programs= Program::all();
        return view('auth.register', compact ('roles','programs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required'],
            'program_id' => ['nullable'],
        ]);

        $roleId = $request->role_id;
        $progId= $request->program_id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($roleId ,['program_id' => $progId]);

        event(new Registered($user));
        Auth::login($user);

        $role= \App\Enums\RoleEnum::from($request->role_id);

        if ($role === RoleEnum::staff){
        return redirect()-> route('staff.dashboard');
       }

       if ($role === RoleEnum::HOP){
        return redirect()->route('hop.dashboard');
       }

       if ($role === RoleEnum::HOD){
        return redirect()->route('hod.dashboard');
       }


       return redirect()->route('/dashboard');

    }

    public function getPrograms($roleId){
        if ($roleId == Role::HOP){
            return Program::all();
        } 
        
        return response()->json([]);
    }
}
