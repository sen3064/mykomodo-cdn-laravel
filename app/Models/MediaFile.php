<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MediaFile
 * @package App\Models
 * @version June 16, 2022, 11:15 am UTC
 *
 * @property string $file_name
 * @property string $file_path
 * @property string $file_resize_200
 * @property string $file_resize_250
 * @property string $file_resize_400
 * @property string $file_size
 * @property string $file_type
 * @property string $file_extension
 * @property integer $create_user
 * @property integer $update_user
 * @property integer $app_id
 * @property integer $app_user_id
 * @property integer $file_width
 * @property integer $file_height
 */
class MediaFile extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'media_files';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'file_name' => 'string',
        'file_path' => 'string',
        'file_resize_200' => 'string',
        'file_resize_250' => 'string',
        'file_resize_400' => 'string',
        'file_size' => 'string',
        'file_type' => 'string',
        'file_extension' => 'string',
        'create_user' => 'integer',
        'update_user' => 'integer',
        'app_id' => 'integer',
        'app_user_id' => 'integer',
        'file_width' => 'integer',
        'file_height' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'file_name' => 'nullable|string|max:255',
        'file_path' => 'nullable|string|max:255',
        'file_resize_200' => 'nullable|string|max:255',
        'file_resize_250' => 'nullable|string|max:255',
        'file_resize_400' => 'nullable|string|max:255',
        'file_size' => 'nullable|string|max:255',
        'file_type' => 'nullable|string|max:255',
        'file_extension' => 'nullable|string|max:255',
        'create_user' => 'nullable|integer',
        'update_user' => 'nullable|integer',
        'deleted_at' => 'nullable',
        'app_id' => 'nullable|integer',
        'app_user_id' => 'nullable|integer',
        'file_width' => 'nullable|integer',
        'file_height' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
