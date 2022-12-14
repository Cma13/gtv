<?php

namespace Tests\Browser\CreateVideo;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateVideoTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testICanCreateAVideo()
    {
        $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);
        $description = 'This is a description';

        $this->assertDatabaseCount('videos', 0);

        $this->browse(function (Browser $browser) use ($pointOfInterest, $description) {
            $browser->loginAs(User::find(1))
                ->visitRoute('videos.index')
	            ->pause(100)
                ->assertSee('Listado de vídeos')
                ->click('@add-button')
	            ->pause(100)
                ->attach('@input-video', Storage::path('videoTest/sampleVideo.mp4'))
                ->pause(500)
                ->select('@points', $pointOfInterest->id)
                ->pause(500)
                ->type('@description', $description)
                ->pause(200)
                ->click('@crear')
                ->pause(500);
        });
        $this->assertDatabaseCount('videos', 1);
    }
}
