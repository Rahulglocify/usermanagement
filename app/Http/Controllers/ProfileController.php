<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Event;
use App\Models\Images;
use App\Events\NewUsers;
use App\Http\Traits\ArtistTrait;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProfileController extends Controller
{
    use ArtistTrait;

    public function dashboard()
    {
        $ip = "112.196.2.226";
        $data = \Location::get($ip);
        // dd($data);
        $userDetail =  User::with('userProfile')->find(Auth::id());
        // dd($userDetail->userProfile->user_id);
        return view('dashboard');
    }

    public function users()
    {
        $users = User::all();
        event(new \App\Events\SendMessage());
        return view('users.index', compact('users'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;

        $fileName = null;
        if (request()->hasFile('profile_image')) {
            $file = request()->file('profile_image');
            $fileName = $file->getClientOriginalName();
            $file->move('./uploads/user/', $fileName);
        }
        $data = [
            'dob' => $request->dob,
            'gender' => $request->gender,
            'about' => $request->about,
        ];
        if ($fileName) {
            $data['profile_image'] = $fileName;
        }
        $userProfile = UserProfile::where('user_id', Auth::id())->update($data);

        return redirect()->back()->with('success', 'Profile Updated successfully!');
    }


    public function gallery()
    {
        //dd($this->getAllImages(Auth::id()));
        //dd(Auth::user()->images);
        return view('gallery.index');
    }

    public function addGallery()
    {
        return view('gallery.add');
    }

    public function postGallery(Request $request)
    {
        if (request()->hasFile('image')) {
            foreach ($request->image as $image) {
                $fileName = time() . $image->getClientOriginalName();
                $image->move('./uploads/image/', $fileName);
                $gallery = new Images;
                $gallery->image =  $fileName;
                $gallery->user_id = Auth::id();
                $gallery->save();
            }
        }

        return redirect()->back()->with('success', 'Image added successfully!');
    }

    public function fullcalender(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->where('user_id', Auth::id())
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('calender.fullcalender');
    }

    public function postCalender(Request $request)
    {
        switch ($request->type) {
            case 'add':

                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'user_id' => Auth::id(),
                ]);
                return response()->json($event);
                break;

            case 'update':

                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'user_id' => Auth::id(),
                ]);
                return response()->json($event);
                break;

            case 'delete':

                $event = Event::find($request->id)->delete();
                return response()->json($event);
                break;
            default:
                # code...
                break;
        }
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAgk83I1M:APA91bG4RZL4CmkqJMUaLBOZABJ6FsHReQZjCSClqDSrlaD8yxGRyBqfYtE5RErmNLqW-PIvflZ5if3TMCd4Sd6ZV79ZbjBrbgvBcv4f4s4BDmjC_QACmC8y4rVXSFSfsHopG3mMw_AZ';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Test',
                "body" => 'Test Message',
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        dd($response);
    }

    public function mobileNoVerify()
    {
        if (Auth::user()->mobile_verify == 1) {
            return redirect()->back();
        }
        return view('mobile.mobileverify');
    }

    public function mobileNoUpdate(Request $request)
    {
        $update = User::where('id', Auth::id())->update(['mobile' => $request->number, 'mobile_verify' => 1]);
        return 1;
    }

    public function webcam()
    {
        return view('webcam.webcam');
    }

    public function postWebcam(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->name;

        $myimgName = null;
        if (request()->hasFile('image')) {
            $myimg = $request->image;
            $destinationPath = "uploads/user/";
            $web_capture_part = explode(";base64,", $myimg);
            $image_type_aux = explode("image/", $web_capture_part[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($web_capture_part[1]);
            $myimgName = uniqid() . '.png';
            //$file = $destinationPath . $myimgName;
            $myimg->move($destinationPath, $myimgName);
        }
        $data = [];
        if ($myimgName) {
            $data['profile_image'] = $myimgName;
        }
        
        $userProfile = UserProfile::where('user_id', Auth::id())->update($data);

        return redirect()->back()->with('success', 'Profile Updated successfully!');
    }
}
