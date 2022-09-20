<?php

namespace App\Actions\Image;

use Error;
use Illuminate\Support\Facades\File;

class DeleteImage
{

  private $basepath = 'storage/uploads';

  /** Delete image or images
   * @param array - array of data
   */

  public function destroy(string $path, $datas)
  {
    try {
      if (isset($datas[0])) {
        foreach ($datas as $key => $data) {
          $isobj = $data instanceof \Illuminate\Database\Eloquent\Model;
          $path = public_path($this->basepath . '/' . $path) . $isobj ? $data->value: $data;
          if (File::exists($path)) File::delete($path);
          if($isobj) $data->delete();
        }
      } else {
        $isobj = $datas instanceof \Illuminate\Database\Eloquent\Model;
        $path = public_path($this->basepath . '/' . $path) . $isobj ? $datas->value: $datas;
        if (File::exists($path)) File::delete($path);
        if($isobj) $datas->delete();
      }
      return [true ];
    } catch (\Throwable $th) {
      return [false, $th->getMessage()];
    }
  }


  /**
   * delete image only
   * @param string $path
   * @return null|string
   */
  public function deleteImageOnly($path)
  {
    try {
      $path_ = public_path($this->basepath . '/' . $path);
      if (File::exists($path_)) File::delete($path_);
      return null;
    } catch (\Throwable $th) {
      return $th->getMessage();
    }
  }

  /**
   * This function needs parent_model and child_model
   * @param int parent_id
   * @return int 
   */
}
