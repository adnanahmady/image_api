<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Image;
use Intervention\Image\ImageManagerStatic as Img;

class ImagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Upload Image to the uploads folder
     * 
     * @return Json
     */
    public function UploadImage(Request $request) {
        $file = $request->file('photo');
        
        $this->validate($request, [
            'photo' => 'required|file|mimes:jpg,jpeg,gif,png,bmp'
        ]);

        $token = str_random(16);
        $filename = uniqid(60) . $file->getClientOriginalName();
        $upload = 'uploads';
        if ($file->move($upload, $filename)) {
            $create = Image::create([
                'photo' => "{$upload}/{$filename}",
                'target_code' => $token
            ]);

            if ($create) {
                return response()->json([
                    'success' => 'photo uploaded successfully!',
                    'token' => $token
                ]);
            }
        }

        return response()->json([
            'error' => 'there is some problem. please try again.'
        ]);
    }

    /**
     * Give Image Url
     * 
     * @return Json
     */
    public function getImageUrl(Request $request, $url) {
        $imageUrl = Image::where([
            'target_code' => $url
        ])->first();

        if ($imageUrl) {
            $host = str_replace($request->path(), '', $request->url());
            return response()->json([
                'image_url' => $host . $imageUrl->photo
            ]);
        } else {
            return response()->json([
                'error' => 'there is no image with this code.'
            ]);
        }
    }

    /**
     * Redirect request to image
     * 
     * @return Image On true
     * 
     * @return Json On fails
     */
    public function getImagePhoto(Request $request, $url) {
        $imageUrl = Image::where([
            'target_code' => $url
        ])->first();

        if ($imageUrl) {
            $host = str_replace($request->path(), '', $request->url());
            return redirect($host . $imageUrl->photo);
        } else {
            return response()->json([
                'error' => 'there is no image with this code.'
            ]);
        }
    }

    /**
     * Get Image With a Custom size
     * 
     * @param $url target_code for geting image
     * @param $width Width of the image
     * @param $height Height of the image
     * 
     * @return ImageManagerStatic On true
     * 
     * @return Json On false
     */
    public function getImageWithCustomSize(Request $request, $url, $width, $height) {
        $imageUrl = Image::where([
            'target_code' => $url
        ])->first();

        if ($imageUrl) {
            $host = str_replace($request->path(), '', $request->url());
            $imagefile = $imageUrl->photo;
            $customsize = Img::make($imagefile)->resize($width, $height);

            return $customsize->response('jpg');
        } else {
            return response()->json([
                'error' => 'there is no image with this code.'
            ]);
        }
    }
}
