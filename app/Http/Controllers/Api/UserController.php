<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $valid_arr = [
                "email" => "required|email",
                "password" => "required"
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()) {
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }

            Log::channel("daily")->info("UserController.login() email " . $request->email);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                Log::channel("daily")->info("UserController.login() Invalid Credential");
                return $this->sendError('Invalid Credential', null, 400);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                Log::channel("daily")->info("UserController.login() Invalid Credential");
                throw new \Exception('Invalid Credential');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
            return $this->sendResponse($data, 'Authenticated');
        } catch (Exception $error) {
            Log::channel("daily")->info("UserController.login() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Login Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function login_get(Request $request)
    {
        return $this->sendError('Unauthorized', null, 401);
    }
    public function register(Request $request)
    {
        try {
            $valid_arr = [
                'nama_lengkap'  => 'required',
                'email'         => 'required|string|email|max:50|unique:users',
                'password'      => 'required|min:6',
                'no_hp'         => 'required|min:9|regex:/(0)[0-9]{9}/'
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()) {
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }

            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => hash::make($request->password),
                'no_hp' => $request->no_hp,
                'email_verified_at' => date('Y-m-d'),
            ]);
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ];
            return $this->sendResponse($data, 'Successfull Register');
        } catch (Exception $error) {
            Log::channel("daily")->info("UserController.registration() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Registration Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function show(User $user)
    {
        try {
            $user = Auth::user($user);
            return $this->sendResponse($user, 'Succesfull get user');
        } catch (Exception $error) {
            return $this->sendError('Show Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function update(Request $request, User $user)
    {
        try {
            $auth = Auth::user($user);
            $valid_arr = [
                'nama_lengkap' => 'required',
                'email' => 'required|string|email|max:50|unique:users,email,' . $auth['id'] . ',id',
                'no_hp' => 'required|min:9|regex:/(0)[0-9]{9}/',
                'company' => 'required',
                'divisi' => 'required',
                'foto' => 'mimes:jpg,jpeg,png'
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()) {
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }
            $userUpdate = User::find($auth['id']);
            if ($userUpdate == null) {
                return $this->sendError('Invalid Validation', ["id" => ["Profile not found"]], 400);
            }
            $update = [
                "email" => $request->email,
                "nama_lengkap" => $request->nama_lengkap,
                "no_hp" => $request->no_hp,
                "company" => $request->company,
                "divisi" => $request->divisi,
            ];
            if ($request->password != "") {
                $update['password'] = hash::make($request->password);
            }
            if ($request->hasFile("foto")) {
                $foto = $request->file("foto");
                if ($foto->getSize() > 1000000)
                    return $this->sendError('Invalid Validation', ["foto" => ["Max file size 100 KB. Uploaded image size " . ($foto->getSize() / 1000) . " KB"]], 400);
                $filename = date("YmdHis") . "." . $foto->extension();
                Storage::putFileAs("public/images/", $foto, $filename);
                $filename = $filename;
                $update["foto"] = $filename;
            }
            $userUpdate->update($update);

            return $this->sendResponse($user, 'Successfull Update');
        } catch (Exception $error) {
            Log::channel("daily")->info("UserController.update() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Update Failed', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->noContent();
    }
}
