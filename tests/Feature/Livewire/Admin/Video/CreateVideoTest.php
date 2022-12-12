<?php

namespace Tests\Feature\Livewire\Admin\Video;

use App\Http\Livewire\Admin\Video\CreateVideo;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CreateVideoTest extends TestCase
{
    public function testFileFieldIsRequiredWhenCreatingAVideo()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('videos', 0);

        Livewire::test(CreateVideo::class)
            ->set('createForm.pointOfInterest', $pointOfInterest->id)
            ->set('createForm.description', 'Video description')
            ->call('save')
            ->assertHasErrors(['createForm.file' => 'required']);

        $this->assertDatabaseCount('videos', 0);
    }

    public function testPointOfInterestFieldIsRequiredWhenCreatingAVideo()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('videos', 0);

        $file = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');

        Livewire::test(CreateVideo::class)
            ->set('createForm.file', $file)
            ->set('createForm.description', 'Video description')
            ->call('save')
            ->assertHasErrors(['createForm.pointOfInterest' => 'required']);

        $this->assertDatabaseCount('videos', 0);
    }

    public function testDescriptionFieldIsRequiredWhenCreatingAVideo()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('videos', 0);

        $file = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');

        Livewire::test(CreateVideo::class)
            ->set('createForm.file', $file)
            ->set('createForm.pointOfInterest', $pointOfInterest->id)
            ->set('createForm.description', '')
            ->call('save')
            ->assertHasErrors(['createForm.description' => 'required']);

        $this->assertDatabaseCount('videos', 0);
    }

    public function testDescriptionFieldIsAStringWhenCreatingAVideo()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('videos', 0);

        $file = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');

        Livewire::test(CreateVideo::class)
            ->set('createForm.file', $file)
            ->set('createForm.pointOfInterest', $pointOfInterest->id)
            ->set('createForm.description', 12345)
            ->call('save')
            ->assertHasErrors(['createForm.description' => 'string']);

        $this->assertDatabaseCount('videos', 0);
    }

    public function testDescriptionFieldHasMaxLengthWhenCreatingAVideo()
    {
        $adminUser = $this->createAdmin();
        $place = $this->createPlace();
        $pointOfInterest = $this->createPointOfInterest($place->id);

        $this->actingAs($adminUser);

        $this->assertDatabaseCount('videos', 0);

        $file = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');

        Livewire::test(CreateVideo::class)
            ->set('createForm.file', $file)
            ->set('createForm.pointOfInterest', $pointOfInterest->id)
            ->set('createForm.description', \str_repeat('a', 2001))
            ->call('save')
            ->assertHasErrors(['createForm.description' => 'max']);

        $this->assertDatabaseCount('videos', 0);
    }
}
