<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\VideoItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('videos');

        Video::factory(10)->create()->each(function (Video $video) {
            VideoItem::factory()->create([
                'video_id' => $video->id,
            ]);
        });
    }
}
