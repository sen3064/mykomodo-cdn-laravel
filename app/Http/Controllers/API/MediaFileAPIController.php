<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMediaFileAPIRequest;
use App\Http\Requests\API\UpdateMediaFileAPIRequest;
use App\Models\MediaFile;
use App\Repositories\MediaFileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Image;
use Response;

/**
 * Class MediaFileController
 * @package App\Http\Controllers\API
 */

class MediaFileAPIController extends AppBaseController
{
    /** @var  MediaFileRepository */
    private $mediaFileRepository;

    public function __construct(MediaFileRepository $mediaFileRepo)
    {
        $this->mediaFileRepository = $mediaFileRepo;
    }

    /**
     * Display a listing of the MediaFile.
     * GET|HEAD /mediaFiles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $mediaFiles = $this->mediaFileRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($mediaFiles->toArray(), 'Media Files retrieved successfully');
    }

    /**
     * Store a newly created MediaFile in storage.
     * POST /mediaFiles
     *
     * @param CreateMediaFileAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMediaFileAPIRequest $request)
    {
        // $input = $request->all();

        // $mediaFile = $this->mediaFileRepository->create($input);

        // return $this->sendResponse($mediaFile->toArray(), 'Media File saved successfully');
        // return response()->json($request->all());
        $gallery = [];
        $prefix = $request->prefix;
        // dd($request->all());
        foreach ($request->allFiles() as $k => $v) {
            if(is_array($v)){
                $gallery[$k]=[];
                // dd($gallery);
                foreach($v as $vk){
                    $gallery[$k][]=$this->saveMedia($vk,$prefix);
                    // $gallery[$k][]=$vk->getClientOriginalName();
                }
            }else{
                if(strpos($k,'gallery')!=''){
                    $gallery['gallery'][]=$this->saveMedia($v,$prefix);
                }else{
                    $gallery[$k] = $this->saveMedia($v,$prefix);
                }
                // $gallery[$k] = $this->saveMedia($v,$prefix);
                // $gallery[$k] = $v->getClientOriginalName();
            }
        }
        return response()->json($gallery);
    }

    protected function saveMedia($k, $prefix)
    {
        // dd($k);
        $media=null;
        $res = getimagesize($k->getPathname());
        $imagepath = "0000/" . Auth::id() . "/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
        $galimg = $prefix . '-' . $k->getClientOriginalName();
        $size = $k->getSize();
        $width = $res[0];
        $height = $res[1];
        $mime = $res['mime'];
        $k->move(public_path("uploads/" . $imagepath), $galimg);
        $check_media = MediaFile::where('file_path',$imagepath.$galimg)->latest('id')->first();
        if($check_media){
            $media = MediaFile::find($check_media->id);
        }else{
            $media = new MediaFile();
        }
        $media->file_name = $galimg;
        $media->file_path = $imagepath . $galimg;
        $media->file_size = $size;
        $media->file_type = $mime;
        $media->file_extension = $k->getClientOriginalExtension();
        $media->create_user = Auth::id();
        $media->file_width = $width;
        $media->file_height = $height;
        $media->save();
        $img = Image::make("uploads/" . $media->file_path);
        $img->resize(400, 350)->orientate();
        $path400 = $imagepath . '400x350/';
        if (!file_exists(public_path("uploads/" . $path400))) {
            mkdir(public_path("uploads/" . $path400), 0775, true);
        }
        $img->save(public_path("uploads/" . $path400 . $galimg));
        $media->file_resize_400 = $path400 . $galimg;
        $media->save();
        $img->resize(250, 200)->orientate();
        $path250 = $imagepath . '250x200/';
        if (!file_exists(public_path("uploads/" . $path250))) {
            mkdir(public_path("uploads/" . $path250), 0775, true);
        }
        $img->save(public_path("uploads/" . $path250 . $galimg));
        $media->file_resize_250 = $path250 . $galimg;
        $media->save();
        $img->resize(200, 150)->orientate();
        $path200 = $imagepath . '200x150/';
        if (!file_exists(public_path("uploads/" . $path200))) {
            mkdir(public_path("uploads/" . $path200), 0775, true);
        }
        $img->save(public_path("uploads/" . $path200 . $galimg));
        $media->file_resize_200 = $path200 . $galimg;
        $media->save();
        return $media;
    }
    /**
     * Display the specified MediaFile.
     * GET|HEAD /mediaFiles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MediaFile $mediaFile */
        $mediaFile = $this->mediaFileRepository->find($id);

        if (empty($mediaFile)) {
            return $this->sendError('Media File not found');
        }

        return $this->sendResponse($mediaFile->toArray(), 'Media File retrieved successfully');
    }

    /**
     * Update the specified MediaFile in storage.
     * PUT/PATCH /mediaFiles/{id}
     *
     * @param int $id
     * @param UpdateMediaFileAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediaFileAPIRequest $request)
    {
        $input = $request->all();

        /** @var MediaFile $mediaFile */
        $mediaFile = $this->mediaFileRepository->find($id);

        if (empty($mediaFile)) {
            return $this->sendError('Media File not found');
        }

        $mediaFile = $this->mediaFileRepository->update($input, $id);

        return $this->sendResponse($mediaFile->toArray(), 'MediaFile updated successfully');
    }

    /**
     * Remove the specified MediaFile from storage.
     * DELETE /mediaFiles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MediaFile $mediaFile */
        $mediaFile = $this->mediaFileRepository->find($id);

        if (empty($mediaFile)) {
            return $this->sendError('Media File not found');
        }

        $mediaFile->delete();

        return $this->sendSuccess('Media File deleted successfully');
    }
}
