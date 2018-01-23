<?php

namespace TestRoman\Wars\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class RaitModel
 * @package TestRoman\Wars\Models
 *
 */
class RaitModel extends Model
{
  /**
   * @var bool
   */
  public $timestamps = false;

  /**
   * @var array
   */
  protected $fillable = ['api_id', 'item_id', 'score'];

  /**
   * @var string
   */
  protected $table = 'rait';

  /**
   * @var array
   */
  protected $primaryKey = ['api_id', 'item_id'];

  /**
   * @var bool
   */
  public $incrementing = false;

  /**
   * Hook to use multi primary keys.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query) {
    if (is_array($this->primaryKey)) {
      foreach ($this->primaryKey as $pk) {
        $query->where($pk, '=', $this->original[$pk]);
      }
      return $query;
    }else{
      return parent::setKeysForSaveQuery($query);
    }
  }

  /**
   * Get score for api item.
   *
   * @param int $item_id
   *  Item id.
   * @param int $api_id
   *  APi id.
   *
   * @return int
   *   Score number.
   */
  public function getScore(int $item_id, int $api_id) : int {
    $result = $this::where('item_id', $item_id)
      ->where('api_id', $api_id)
      ->first();
    return (is_null($result)) ? 0 : $result->score;
  }

  /**
   * Remove all score for api.
   *
   * @param array $api_ids
   *   Api id.
   */
  public function removeAllRaitsForApiMultiply(array $api_ids) {
    if ($api_ids) {
      DB::table(RaitModel::getTable())->whereIn('api_id', $api_ids)->delete();
    }
  }

}
