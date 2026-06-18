<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StoreImageService;

class StoreImageController extends Controller
{
    public function store(Request $request, StoreImageService $svc)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $file = $request->file('image');
        $name = $svc->saveImage($file);
        $url = $svc->getImageUrl($name);

        return response()->json(['name' => $name, 'url' => $url], 201);
    }

    public function destroy($name, StoreImageService $svc)
    {
        $svc->deleteImage($name);
        return response()->noContent();
    }
}
