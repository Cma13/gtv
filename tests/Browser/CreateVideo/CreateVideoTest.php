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
        $thematicArea = $this->createThematicArea($pointOfInterest->id);
        $description = 'This is a description';

        $this->assertDatabaseCount('videos', 0);

        $this->browse(function (Browser $browser) use ($pointOfInterest, $thematicArea, $description) {
            $browser->loginAs(User::find(1))
                ->visitRoute('videos.index')
	            ->pause(100)
                ->assertSee('Listado de vídeos')
                ->click('@add-button')
	            ->pause(100)
                ->attach('@input-video', Storage::path('videoTest/sampleVideo.mp4'))
                ->pause(500)
                ->select('@points', $pointOfInterest->id)
                ->pause(100)
                ->select('@areas', $thematicArea->id)
                ->pause(100)
                ->type('@description', $description)
                ->pause(100)
                ->click('@crear')
                ->pause(100);
        });
        $this->assertDatabaseCount('videos', 1);
    }
}
