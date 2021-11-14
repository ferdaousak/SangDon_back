<?php

namespace App\Http\Controllers;

use App\Http\Middleware\JwtMiddleware;
use App\Models\Typesang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::user();
        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_naissance' => 'required|date_format:Y-m-d',
            'sexe' => 'required|string|in:homme,femme',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'ville_id' => 'required|exists:villes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'date_naissance' => $request->get('date_naissance'),
            'sexe' => $request->get('sexe'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'ville_id' => $request->get('ville_id'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getCode());
        }
        return $user;
    }

    public function delete(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (Hash::check($request->header('password'), $user->password)) {
            $user->delete();
            return response()->json('user deleted', 200);
        } else
            return response()->json('password incorrect', 400);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'date_naissance' => 'date_format:Y-m-d',
            'sexe' => 'string|in:homme,femme',
            'ville_id' => 'exists:villes,id',
            'type_sang_id' => 'exists:type_sangs,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = $this->getAuthenticatedUser();
        $name = $request->get('name');
        $sexe = $request->get('sexe');
        $date_naissance = $request->get('date_naissance');
        $ville_id = $request->get('ville_id');
        $type_sang_id = $request->get('type_sang_id');

        if ($name != "")
            $user->name = $name;
        if ($date_naissance != "")
            $user->date_naissance = $date_naissance;
        if ($ville_id != "")
            $user->ville_id = $ville_id;
        if ($type_sang_id != "")
            $user->type_sang_id = $type_sang_id;
        if ($sexe != "")
            $user->sexe = $sexe;
        $user->save();
        return response()->json('user updated', 200);
    }

    public function deleteUser($id)
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin") {
            $user1 = User::find($id);
            $user1->delete();
            return response()->json('user deleted', 200);
        } else
            return response()->json('you are not an admin', 400);
    }

    public function updateUser($id, Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin") {

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'date_naissance' => 'date_format:Y-m-d',
                'sexe' => 'string|in:homme,femme',
                'ville_id' => 'exists:villes,id',
                'type_sang_id' => 'exists:type_sangs,id',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $user1 = User::find($id);
            $name = $request->get('name');
            $sexe = $request->get('sexe');
            $date_naissance = $request->get('date_naissance');
            $ville_id = $request->get('ville_id');
            $type_sang_id = $request->get('type_sang_id');

            if ($name != "")
                $user1->name = $name;
            if ($date_naissance != "")
                $user1->date_naissance = $date_naissance;
            if ($ville_id != "")
                $user1->ville_id = $ville_id;
            if ($type_sang_id != "")
                $user1->type_sang_id = $type_sang_id;
            if ($sexe != "")
                $user1->sexe = $sexe;
            $user1->save();
            return response()->json('user updated', 200);
        } else
            return response()->json('you are not an admin', 400);
    }

    public function allUsers()
    {
        $user = $this->getAuthenticatedUser();
        if ($user->type == "admin")
            return User::all();
        else
            return response()->json('you are not an admin', 400);
    }

    public function getTypeSangs()
    {
        return response(Typesang::all());
    }
}
