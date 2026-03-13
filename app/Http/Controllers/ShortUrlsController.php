<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ShortUrl;
use App\Models\Company;
use App\Services\ShortCodeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Access\AuthorizationException;
class ShortUrlsController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();

        $links = ShortUrl::join('users', 'users.id', '=', 'short_urls.user_id')
            ->join('companies', 'companies.id', '=', 'short_urls.company_id')
            ->select(
                'short_urls.*',
                'users.name as user_name',
                'companies.name as company_name'
            )
            ->latest('short_urls.id');

        if ($user->role_id == 2) {
            $links->where('short_urls.company_id', $user->company_id);
        }

        if ($user->role_id == 3) {
            $links->where('short_urls.user_id', $user->id);
        }

        $links = $links->paginate(10);


        return view('show_links' , ['links' => $links]);    
    }

    public function store(Request $request, ShortCodeService $shortCodeService)
    {

        $validator = Validator::make($request->all(), [
            'original_url' => ['required', 'url', 'max:2048'],
            // 'company_id' => ['required','exists:companies,id'],
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Flashes the errors to the session
                ->withInput(); 
        }

        
        try {
            // This calls the policy and check authorization
            $this->authorize('create', ShortUrl::class);

        } catch (AuthorizationException $e) {
            // Manually redirect back with the error message
            return redirect()->back()->withErrors(['authorization' => $e->getMessage()]);
        }
        $user = $request->user();

        $shortUrl = ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $request->string('original_url')->toString(),
            'code' => $shortCodeService->generateUniqueCode(),
        ]);

        return redirect()->back()->with('success', 'Link created successfully!'); 
    }    
    public function link(Request $request)
    {
        $user = $request->user();
        // if($user->role_id==1){
        //     $companies = Company::all();
        // }else{
        //     $companies = Company::where('id' , $user->company_id)->get();
        // }

        // $companies = Cache::remember('companies_list', 3600, function () {
        //     return Company::all();
        // });

        return view('link');
    }  
    public function resolve(Request $request, string $code)
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        return redirect()->away($shortUrl->original_url);
    }    
}
