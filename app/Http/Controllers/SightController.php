<?php

namespace App\Http\Controllers;

use App\Models\Sight;

class SightController extends Controller
{
    public function show(Sight $sight)
    {
        return view('sights.show', [
            'sight' => $sight,
        ]);
    }
}
