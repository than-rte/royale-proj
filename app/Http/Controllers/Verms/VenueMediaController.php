<?php

namespace App\Http\Controllers\Verms;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VenueMediaController extends Controller
{
    public function index(Venue $venue)
    {
        $images = $venue->images;
        $selectedImages = [];
        foreach ($images as $image) {
            $selectedImages[] = [
                'id' => $image->id,
                'src' => url($image->src),
                'alt' => $image->alt,
            ];
        }

        $data = [
            'id' => $venue->id,
            // 'images' => $venue->images,
            'images' => $selectedImages,
        ];
        return inertia("Verms/Venues/Edit/Media", ['venue' => $data]);
    }

    public function upload(Request $request, Venue $venue)
    {
        if ($request->has('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $filenameWithExtension = $file->hashName();
                $filenameOnly = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
                $extension = $file->extension();
                $rules = array('file' => 'required|mimes:png,jpg,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                $validator = Validator::make(array('file' => $file), $rules);
                if (!$validator->fails()) {
                    $filenameWithTime =  $filenameOnly . time();
                    $filePath = $file->storeAs('public/venues', $filenameWithTime . '.' . $extension);
                    $fileUrl =  Storage::url($filePath);
                    $venue->images()->create([
                        'src' => $fileUrl,
                        'alt' => $filenameWithTime . '.' . $extension,
                    ]);
                    
                }
            }
        }

        $images = $venue->images;
        $selectedImages = [];
        foreach ($images as $image) {
            $selectedImages[] = [
                'id' => $image->id,
                'src' => url($image->src),
                'alt' => $image->alt,
            ];
        }

        $data = [
            'id' => $venue->id,
            // 'images' => $venue->images,
            'images' => $selectedImages,
        ];
        return inertia("Verms/Venues/Edit/Media", ['venue' => $data]);
    }
}
