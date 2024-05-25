<?php

namespace App\Repositories;

use App\Models\MediaFile;
use App\Repositories\BaseRepository;

/**
 * Class MediaFileRepository
 * @package App\Repositories
 * @version June 16, 2022, 11:15 am UTC
*/

class MediaFileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'file_name',
        'file_path',
        'file_resize_200',
        'file_resize_250',
        'file_resize_400',
        'file_size',
        'file_type',
        'file_extension',
        'create_user',
        'update_user',
        'app_id',
        'app_user_id',
        'file_width',
        'file_height'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MediaFile::class;
    }
}
