<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $image = new Image();
        $image->event_id = $request->event_id;
        $image->image_path = 'images/' . $imageName;
        $image->save();

        return response()->json(['success' => 'Image uploaded successfully!']);
    }
}
