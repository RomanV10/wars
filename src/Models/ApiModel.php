<?php

namespace TestRoman\Wars\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiModel extends Model
{
  /**
   * @var bool
   */
  public $timestamps = false;
  protected $fillable = ['name'];
  protected $table = 'api';

  /**
   * @param $apis
   */
  public function mergeApiMultiply($apis) {
    foreach ($apis as $api) {
      ApiModel::updateOrCreate(['name' => $api]);
    }
  }

  /**
   * @param $apis
   */
  public function deleteApiMultiply($apis) {
    if ($apis) {
      DB::table(ApiModel::getTable())->whereIn('name', $apis)->delete();
    }
  }

}
