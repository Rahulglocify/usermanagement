<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Images;
use App\Models\ContactUs;
use Auth;
use Validator;
use GuzzleHttp\Client;
use Laravel\Passport\Client as OClient;

class UserController extends Controller
{

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            $success['message'] =  "User login successfully.";
            return response()->json($success);
        } else {
            $success['message'] =  "Unauthorised.";
            return response()->json($success);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $password = $request->password;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['message'] = "User register successfully.";
        return response()->json($success);
    }

    public function getTokenAndRefreshToken(OClient $oClient, $email, $password)
    {
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request('POST', 'http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $this->successStatus);
    }

    public function users()
    {
        $data['users'] = User::with('userProfile')->get();

        $response['success'] = true;
        $response['message'] = 'All users get successfully';
        $response['data'] = $data;

        return response()->json($response);
    }

    public function editUsers(Request $request)
    {
        $id = $request->id;
        $data['userDetail'] = User::with('userProfile')->find($id);
        $response['success'] = true;
        $response['message'] = 'Fetch single user details successfully';
        $response['data'] = $data;

        return response()->json($response);
    }

    public function deleteUsers(Request $request)
    {
        $id = $request->id;
        $userDelete = User::where('id', $id)->delete();
        $userProfileDelete = UserProfile::where('id', $id)->delete();
        $userGalleryDelete = Images::where('id', $id)->delete();

        $response['success'] = true;
        $response['message'] = 'User deleted successfully';
        return response()->json($response);
    }

    public function updateUser(Request $request)
    {
        //dd($request->all());
        $id = $request->userId;

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $response['success'] = true;
        $response['message'] = 'User details updated successfully';

        return response()->json($response);
    }

    public function contactus(Request $request)
    {
        //ContactUs
        $contact = ContactUs::create($request->all());

        $response['success'] = true;
        $response['message'] = 'Your query has been submitted successfully!';
        return response()->json($response);
    }
}
