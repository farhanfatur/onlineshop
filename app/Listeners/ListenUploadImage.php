<?php

namespace App\Listeners;

use App\Events\EventUploadImage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ListenUploadImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventUploadImage $event)
    {
        $file = $event->file;
        $image = $event->nameImage;

        $file->move(storage_path('app/public/product/'), $image);
            
        Image::make(storage_path('app/public/product/'.$image))->resize(320, 240)->save(storage_path('app/public/product/medium/medium_'.$image));

        Image::make(storage_path('app/public/product/'.$image))->resize(160, 120)->save(storage_path('app/public/product/thumbnail/thumbnail_'.$image));
    }
}
