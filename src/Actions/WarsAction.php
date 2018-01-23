<?php

namespace TestRoman\Wars\Actions;

use Illuminate\Http\Request;
use TestRoman\Wars\Models\RaitModel;
use TestRoman\Wars\Models\ApiModel;

/**
 * Class WarsAction
 *
 * @package TestRoman\Wars\Actions
 */
class WarsAction {
  /**
   * All allowed api from config.
   *
   * @var array
   */
  private $allowedApis = [];

  /**All enabled api from db.
   *
   * @var array
   */
  private $enabledApis = [];

  /**
   * All api to save from query.
   *
   * @var array
   */
  private $apisToSave = [];

  /**
   * ALl api to delete from query.
   *
   * @var array
   */
  private $apisToDelete = [];

  /**
   * Api model
   *
   * @var \TestRoman\Wars\Models\ApiModel
   */
  private $apiModel;

  /**
   * Number api from where to select item.
   *
   * @var int
   */
  private $numberApisToShowForWar = 2;

  /**
   * WarsAction constructor.
   */
  public function __construct() {
    $this->apiModel = new ApiModel();
    $this->enabledApis = $this->getEnabledApis();
    $this->allowedApis = $this->getAllowedApis();
  }

  /**
   * Show random api items.
   *
   * @return array
   *   Array with api item.
   */
  public function showRandomApisItems() : array {
    $apis = $this->getRandomApis();

    return $this->buildRandomApisItems($apis);
  }

  /**
   * Show enabled api
   *
   * @return array
   *   Array with enabled and allowed api.
   */
  public function showEnabledApis () : array {
    return $this->compareEnabledWithAvaibleApis();
  }


  /**
   * Build result to show random api with random items.
   *
   * @param array $apis
   *   Array with api settings.
   *
   * @return array
   *   Array with build info.
   */
  public function buildRandomApisItems(array $apis) : array {
    $result = [];
    foreach ($apis as $index => $setting) {
      $api_machine_name = $setting['name'];
      $api_class =  $this->getApiClass($api_machine_name);
      $api_id = $setting['id'];
      if (class_exists($api_class) && !empty($one_item = (new $api_class($api_id))->getOne())) {
        $this->addApiNameToItem($one_item, $api_machine_name);
        $this->addApiIdToItem($one_item, $api_id);
        $result[] = $one_item;
      }
    }
    return $result;
  }

  /**
   * Add api name to api item.
   *
   * @param array $item
   *   Item array.
   * @param string $api_machine_name
   *   Api machine_name.
   */
  private function addApiNameToItem(array &$item, string $api_machine_name) {
    $item['api_name'] = $this->allowedApis[$api_machine_name]['name'];
  }

  /**
   * Add api id to api item.
   *
   * @param array $item
   *   Item array.
   * @param $id
   *   Api id.
   */
  private function addApiIdToItem(array &$item, $id) {
    $item['api_id'] = $id;
  }

  /**
   * Get allowed api from config.
   *
   * @return array
   *   Array with api settings.
   */
  public function getAllowedApis () {
    $dir_path = dirname(__FILE__, 2);
    $config = include $dir_path . '/config.php';

    return $this->allowedApis = (!empty($config['allowed_apis']) && is_array($config['allowed_apis'])) ? $config['allowed_apis'] : [];
  }

  /**
   * Get enabled api from db.
   *
   * @return array
   *   Array with api.
   */
  public function getEnabledApis () {
    $result = [];
    $apis = $this->apiModel::all()->toArray();
    if ($apis) {
      foreach ($apis as $api) {
        $result[$api['id']] = $api['name'];
      }
    }

    return $this->enabledApis = $result;
  }

  /**
   * Compare enabled api with allowed.
   *
   * @return array
   *  Array with api.
   */
  public function compareEnabledWithAvaibleApis () {
    $result = [];
    if (!empty($this->allowedApis)) {
      foreach ($this->allowedApis as $field_machine_name => $settings) {
        $result[$field_machine_name] = $settings;
        $result[$field_machine_name]['enabled'] = (in_array($field_machine_name, $this->enabledApis)) ? TRUE : FALSE;
      }
    }

    return $result;
  }

  /**
   * Save enabled api.
   *
   * @param \Illuminate\Http\Request $request
   *   Request.
   *
   * @return array
   *   Array with enabled api.
   */
  public function saveEnabledApis (Request $request) {
    $enabled_apis = $request->input('value') ?? [];
    $this->prepareToSaveAllowedApis($enabled_apis);
    $this->apiModel->mergeApiMultiply($this->apisToSave);
    if ($this->apisToDelete) {
      (new RaitModel())->removeAllRaitsForApiMultiply(array_keys($this->apisToDelete));
      $this->apiModel->deleteApiMultiply($this->apisToDelete);
    }

    return array_values($this->getEnabledApis());
  }

  /**
   * Prepare api from request to save.
   *
   * @param array $enabled_apis
   *  Enabled api array.
   */
  public function prepareToSaveAllowedApis (array $enabled_apis) {
    $enabled_apis = array_flip($enabled_apis);
    $this->apisToSave = array_keys(array_intersect_key($this->allowedApis, $enabled_apis));

    $to_delete = array_keys(array_diff_key($this->allowedApis, $enabled_apis));
    $this->apisToDelete = array_intersect($this->enabledApis, $to_delete);
  }

  /**
   * Get random saved api from db.
   *
   * @return array
   *  Array with api.
   */
  public function getRandomApis() : array {
    $apis = $this->apiModel::inRandomOrder()->take($this->numberApisToShowForWar)->get()->toArray();
    return !empty($apis) ? $apis : [];
  }

  /**
   * Get api class to build item.
   *
   * @param string $api_name
   *   Api machine name.
   *
   * @return string
   *   Class name.
   */
  private function getApiClass(string $api_name) : string {
    return $this->allowedApis[$api_name]['class'] ?? '';
  }

}
