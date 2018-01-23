<?php

namespace TestRoman\Wars\Actions;

use TestRoman\Wars\Models\RaitModel;
use Illuminate\Http\Request;

/**
 * Class RatingAction
 * @package TestRoman\Wars\Actions
 */
class RatingAction{

  /**
   * Rait model.
   * @var \TestRoman\Wars\Models\RaitModel
   */
  private $raitModel;

  /**
   * RatingAction constructor.
   */
  public function __construct() {
    $this->raitModel = new RaitModel();
  }

  /**
   * Add score from request to api.
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function addApiItemScore(Request $request) {
     $this->setSelectedItemScore($request);
     $this->setNotSelectedItemScore($request);
     return [1];
  }

  /**
   * Add score for selected item.
   *
   * @param \Illuminate\Http\Request $request
   *   Request.
   */
  private function setSelectedItemScore(Request $request) {
    $selected_items = $this->retrieveSelectedItems($request);
    $api_id = key($selected_items);
    $item_id = current($selected_items);
    $score = $this->raitModel->getScore($item_id, $api_id);
    $this->raitModel::updateOrCreate(['item_id' => $item_id, 'api_id' => $api_id], ['score' => ++$score]);
  }

  /**
   * Add score for not selected item.
   *
   * Can be less zero.
   *
   * @param \Illuminate\Http\Request $request
   *   Request.
   */
  private function setNotSelectedItemScore(Request $request) {
    $other_items = $this->retrieveOtherItems($request);
    $api_id = key($other_items);
    $item_id = current($other_items);
    $score = $this->raitModel->getScore($item_id, $api_id);
    $this->raitModel::updateOrCreate(['item_id' => $item_id, 'api_id' => $api_id], ['score' => --$score]);
  }

  /**
   * Retrieve selected item form request.
   *
   * @param \Illuminate\Http\Request $request
   *  Request.
   *
   * @return array
   *   Array with selected item.
   */
  private function retrieveSelectedItems(Request $request) {
    $result = [];
    if ($request->has('selectedItem')){
      $seleceted = $request->get('selectedItem');
      foreach ($seleceted as $value) {
        $result += $value;
      }
    }
    return $result;
  }

  /**
   * Retrieve not selected item form request.
   *
   * @param \Illuminate\Http\Request $request
   *  Request.
   *
   * @return array
   *   Array with selected item.
   */
  private function retrieveOtherItems(Request $request) {
    $result = [];
    if ($request->has('otherItems')){
      $seleceted = $request->get('otherItems');
      foreach ($seleceted as $value) {
        $result += $value;
      }
    }
    return $result;
  }
}