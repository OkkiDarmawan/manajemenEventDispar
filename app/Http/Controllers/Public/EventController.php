<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
      public function show(Event $event)
    {
        $event->load([
            'lombas',
            'workshops',
        ]);

        return view(
            'public.event.show',
            compact('event')
        );
    }
}
