<?php

namespace App\Http\Services\Upload;


class UploadService
{
    public function store($request)
    {
        if ($request->hasFile('thumb')) {
            try {
                $name = $request->file('thumb')->getClientOriginalName();

                $pathFull = 'uploads/' . date('Y/m/d');

                $request->file('thumb')->storeAs('public/' . $pathFull, $name );

                return '/storage/'. $pathFull . '/' . $name;
            } catch (\Exception $err) {
                return false;
            }
        }

    }
}
