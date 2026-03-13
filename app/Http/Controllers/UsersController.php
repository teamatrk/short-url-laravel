<?php

namespace App\Http\Controllers;
// use App\RoleName;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
class UsersController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request){ 
        $request->user()->load('company');
        return view('dashboard',['USER' => $request->user()]);
    }
    public function store( Request $request)
    {



        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            // 'role' => ['required', 'in:'.RoleName::ADMIN.','.RoleName::MEMBER],
            // 'role' => ['required', Rule::in(RoleName::all())],
            'company_id' => ['nullable', 'exists:companies,id'],
            'password' => ['required' , 'min:4'],
        ]);


        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422); 
            
            return redirect()->back()
                ->withErrors($validator) 
                ->withInput();  
        }

        $role = $request->integer('role_id');
        $companyId = $request->integer('company_id');
        $authUser = $request->user();


 
        $response = Gate::inspect('invite_user', [$companyId, $role]);

        if ($response->denied()) {

            return back()->withErrors(['message' => $response->message()]);

        }
        
        
 
        
 


        $user = User::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
            'company_id' => $companyId,
            'role_id' => $role,
        ]);



        return redirect()->back()->with('success', 'User invited successfully!');
    }

    public function invite(Request $request){

        $user = $request->user();
        $user->load('company');
        // if($user->role_id==1){
        //     $companies = Company::all();
        // }else{
        //     $companies = Company::where('id' , $user->company_id)->get();
        // }

        $companies = Cache::remember('companies_list', 3600, function () {
            return Company::all();
        });
        return view('invite' , ['companies' => $companies , 'roles' => Role::all() , 'USER'=>$user]);
    }
}
