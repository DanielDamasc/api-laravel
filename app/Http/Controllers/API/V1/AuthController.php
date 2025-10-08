<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::guard('web')->attempt($credentials)) {
            $token = Auth::user()->createToken(
                name: "auth_token",
                abilities: ['*'],
            );

            return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
        }

        abort(401, "Usuário não encontrado");
    }

    public function register(Request $request, User $user) {

        $dados = $request->only('name', 'email', 'password');
        // $dados['password'] = bcrypt($dados['password']);

        $user = $user->create($dados);

        if(!$user) {
            abort(500, "Erro ao criar o usuário");
        }

        return response()->json([
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function logout() {
        $user = auth()->user();
        $user->tokens()->delete(); // Remove todos os tokens do user.

        // auth()->user()->currentAccessToken()->delete();

        return response()->json([], 204);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
