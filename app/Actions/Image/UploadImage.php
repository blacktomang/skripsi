<?php

namespace App\Actions\Image;


class UploadImage
{

  private $basepath = "storage/uploads/";

  /**
   * Upload multiple images and create related model meta data
   */
  public function uploadAndCreate(
    string $parent_column,
    string | int $id,
    string $child_model,
    array $images,
    string $path
  ) {
    try {
      $filenames = [];
      for ($i = 0; $i < count($images); $i++) {
        if (isset($images[$i])) {
          $hashed_name = $images[$i]->hashName();
          $image_name = time() . $hashed_name;
          $images[$i]->move(public_path($this->basepath . '/' . $path), $image_name);
          $child_model::create([
            $parent_column => $id,
            'value' =>  $image_name,
          ]);
          array_push($filenames,$image_name);
        }
      }
      return $filenames;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * This will only upload the image and return the filename without any create actions
   */
  public function uploadAndGetFileName($image, string $path): string
  {
    $hashed_name = $image->hashName();
    $image_name = time() . $hashed_name;
    $image->move(public_path($this->basepath . $path), $image_name);
    return $image_name;
  }


  /**
   * count if the images
   */
  public function count($child_model, $parent_column, $parent_id): int
  {
    return $child_model::where($parent_column, $parent_id)->count();
  }
}
