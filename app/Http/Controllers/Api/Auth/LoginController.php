<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Model\Project\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotificationEmail;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function index(LoginRequest $request)
    {
        // check username for login is name or email
        $usernameLabel = Str::contains($request->username, '@') ? 'email' : 'name';

        $attempt = auth()->guard('web')->attempt([
            $usernameLabel => $request->username,
            'password' => $request->password,
        ]);

        if (! $attempt) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $user = auth()->guard('web')->user();

        $tokenResult = $user->createToken($user->name);

        $tokenResult->token->is_mobile = $request->input('is_mobile') ?? null;
        $tokenResult->token->os_name = $request->input('os_name') ?? null;
        $tokenResult->token->os_version = $request->input('os_version') ?? null;
        $tokenResult->token->browser_name = $request->input('browser_name') ?? null;
        $tokenResult->token->browser_version = $request->input('browser_version') ?? null;
        $tokenResult->token->mobile_vendor = $request->input('mobile_vendor') ?? null;
        $tokenResult->token->mobile_model = $request->input('mobile_model') ?? null;
        $tokenResult->token->engine_name = $request->input('engine_name') ?? null;
        $tokenResult->token->engine_version = $request->input('engine_version') ?? null;
        $tokenResult->token->save();

        $response = $user;
        $response->access_token = $tokenResult->accessToken;
        $response->token_type = 'Bearer';
        $response->token_id = $tokenResult->token->id;
        $response->token_expires_in = $tokenResult->token->expires_at->timestamp;

        if ($request->header('Tenant')) {
            $project = Project::where('code', $request->header('Tenant'))->first();

            if ($project) {
                $response->tenant_code = $project->code;
                $response->tenant_name = $project->name;
                $response->tenant_address = $project->address;
                $response->tenant_phone = $project->phone;
                $response->tenant_owner_id = $project->owner_id;
                $response->tenant_package_id = $project->package_id;
                $response->permissions = tenant($user->id)->getPermissions();
                $response->branches = tenant($user->id)->branches;
                $response->branch = null;
                $response->warehouses = tenant($user->id)->warehouses;
                $response->warehouse = null;
                foreach ($response->branches as $branch) {
                    if ($branch->pivot->is_default) {
                        $response->branch = $branch;
                    }
                }
                foreach ($response->warehouses as $warehouse) {
                    if ($warehouse->pivot->is_default) {
                        $response->warehouse = $warehouse;
                    }
                }
            }
        }

        $users = DB::connection('tenant')->table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->where('mobile_vendor', $tokenResult->token->mobile_vendor)
            ->where('mobile_model', $tokenResult->token->mobile_model)
            ->get();

        \Log::info('v: ' . $tokenResult->token->mobile_vendor . 'm: ' . $tokenResult->token->mobile_model . 'u: ' . $user->id. ' = '.$users->count());
        if ($users->count() == 0) {
            Mail::to($user->email)->send(new LoginNotificationEmail(
                "https://cloud.point.red/auth/forgot-password",
                $user->name,
                $tokenResult->token->mobile_vendor,
                $tokenResult->token->mobile_model,
            ));
        }
        
        return response()->json([
            'data' => $response,
        ]);
    }
}
