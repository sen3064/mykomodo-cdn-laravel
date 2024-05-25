<?php namespace Tests\Repositories;

use App\Models\MediaFile;
use App\Repositories\MediaFileRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MediaFileRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MediaFileRepository
     */
    protected $mediaFileRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->mediaFileRepo = \App::make(MediaFileRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_media_file()
    {
        $mediaFile = MediaFile::factory()->make()->toArray();

        $createdMediaFile = $this->mediaFileRepo->create($mediaFile);

        $createdMediaFile = $createdMediaFile->toArray();
        $this->assertArrayHasKey('id', $createdMediaFile);
        $this->assertNotNull($createdMediaFile['id'], 'Created MediaFile must have id specified');
        $this->assertNotNull(MediaFile::find($createdMediaFile['id']), 'MediaFile with given id must be in DB');
        $this->assertModelData($mediaFile, $createdMediaFile);
    }

    /**
     * @test read
     */
    public function test_read_media_file()
    {
        $mediaFile = MediaFile::factory()->create();

        $dbMediaFile = $this->mediaFileRepo->find($mediaFile->id);

        $dbMediaFile = $dbMediaFile->toArray();
        $this->assertModelData($mediaFile->toArray(), $dbMediaFile);
    }

    /**
     * @test update
     */
    public function test_update_media_file()
    {
        $mediaFile = MediaFile::factory()->create();
        $fakeMediaFile = MediaFile::factory()->make()->toArray();

        $updatedMediaFile = $this->mediaFileRepo->update($fakeMediaFile, $mediaFile->id);

        $this->assertModelData($fakeMediaFile, $updatedMediaFile->toArray());
        $dbMediaFile = $this->mediaFileRepo->find($mediaFile->id);
        $this->assertModelData($fakeMediaFile, $dbMediaFile->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_media_file()
    {
        $mediaFile = MediaFile::factory()->create();

        $resp = $this->mediaFileRepo->delete($mediaFile->id);

        $this->assertTrue($resp);
        $this->assertNull(MediaFile::find($mediaFile->id), 'MediaFile should not exist in DB');
    }
}
