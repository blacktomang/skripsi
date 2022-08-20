<?php

namespace App\Http\Controllers;

use App\Actions\Image\DeleteImage;
use App\Actions\Image\UploadImage;
use App\Traits\JsonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, JsonTrait;

    protected UploadImage $uploadImageAction;
    protected DeleteImage $deleteImageAction;


    function __construct(
        UploadImage $uploadImageAction,
        DeleteImage $deleteImageAction
    ) {
        $this->uploadImageAction = $uploadImageAction;
        $this->deleteImageAction = $deleteImageAction;
    }
}
