<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;

class IndexController extends Controller
{
    public function newsletter(Request $request)
    {
        $data = $request->all();
        $checkExistEmail = Newsletter::where('email', $request->email)->count();
        if ($checkExistEmail > 0) {
            $response['message'] =  "This E-mail address is already registered for newsletter.";
            $response['status'] =  false;
            return response()->json($response);
        }
        $insert = Newsletter::create($data);
        $response['message'] =  "E-mail address successfully registered for newsletter.";
        $response['status'] =  true;
        return response()->json($response);
    }
}
