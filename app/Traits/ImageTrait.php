<?php

namespace App\Traits;

use Error;
use Illuminate\Support\Facades\File;

class ImageTrait
{

  private $image;
  private $parent_model;
  private $child_model;
  private $path_image = "uploads/images";

  function __construct($parent_model = null, $child_model = null, $image = [])
  {
    $this->image = $image;
    $this->parent_model = $parent_model;
    $this->child_model = $child_model;
  }

  /**
   * @param int id - it could be id or the model itself
   * @return string
   */
  public function upload($parent_column, $id): string
  {
    $return_image_name = "";
    if (is_array($this->image)) {
      for ($i = 0; $i < count($this->image); $i++) {
        if (isset($this->image[$i])) {
          $hashed_name = $this->image[$i]->hashName();
          $image_name = time() . $hashed_name;
          $this->image[$i]->move(public_path($this->path_image), $image_name);
          $this->child_model::create([
            $parent_column => $id,
            'value' =>  $image_name,
          ]);
          $return_image_name = $return_image_name . ',' . $image_name;
        }
      }
    } else {
      $hashed_name = $this->image->hashName();
      $image_name = time() . $hashed_name;
      $this->image->move(public_path($this->path_image), $image_name);
      $return_image_name = $image_name;
    }
    return $return_image_name;
  }

  /**
   * @param array - array of data
   */
  public function delete($datas)
  {
    try {
      // dd(isset($datas[0]));
      if (isset($datas[0])) {
        foreach ($datas as $key => $data) {
          File::delete(public_path($this->path_image) .'/'. $data->value);
          $data->delete();
        }
      } else {
        File::delete(public_path($this->path_image) .'/'. $datas->value);
        $datas->delete();
      }
    } catch (\Throwable $th) {
      // env('APP_DEBUG') ? 
      throw new Error($th->getMessage());
      // : 
      // throw new Error('error');
    }
  }

  /**
   * This function needs parent_model and child_model
   * @param int parent_id
   * @return int 
   */
  public function count($parent_column, $parent_id): int
  {
    return $this->child_model::where($parent_column, $parent_id)->count();
  }
}
