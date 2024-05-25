<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MediaFile;

class MediaFileApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_media_file()
    {
        $mediaFile = MediaFile::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/media_files', $mediaFile
        );

        $this->assertApiResponse($mediaFile);
    }

    /**
     * @test
     */
    public function test_read_media_file()
    {
        $mediaFile = MediaFile::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/media_files/'.$mediaFile->id
        );

        $this->assertApiResponse($mediaFile->toArray());
    }

    /**
     * @test
     */
    public function test_update_media_file()
    {
        $mediaFile = MediaFile::factory()->create();
        $editedMediaFile = MediaFile::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/media_files/'.$mediaFile->id,
            $editedMediaFile
        );

        $this->assertApiResponse($editedMediaFile);
    }

    /**
     * @test
     */
    public function test_delete_media_file()
    {
        $mediaFile = MediaFile::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/media_files/'.$mediaFile->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/media_files/'.$mediaFile->id
        );

        $this->response->assertStatus(404);
    }
}
