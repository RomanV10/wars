<?php

namespace TestRoman\Wars\Actions;

use Vinelab\Http\Client as HttpClient;
use TestRoman\Wars\Models\RaitModel;

/**
 * Class AbstractParseAction
 *
 * @package TestRoman\Wars\Actions
 */
abstract class AbstractParseAction {
  protected $mappedFields = ['title' => 'name', 'url' => 'url'];
  protected $indexUrl = '';
  protected $urlToCall = '';
  public $oneUrl = '';
  protected $itemId = 0;
  private $apiId = 0;
  private $itemScore = 0;
  private $totalCountItems = 0;

  /**
   * AbstractParseAction constructor.
   *
   * @param int $api_id
   *  Api id from db.
   */
  public function __construct(int $api_id) {
    $this->apiId = $api_id;
  }

  /**
   * Get one api item.
   *
   * @return array
   *   Array with items fields.
   */
  public function getOne() : array {
    $this->buildOneUrl();
    $mapped_fields = $this->buildMappedFields($this->sendQuery($this->oneUrl));
    $this->setUrlForOne($mapped_fields);
    $this->setIdForOne($mapped_fields);
    $this->setRaitForOne($mapped_fields);
    $this->setRaitInPercentForOne($mapped_fields);
    return $mapped_fields;
  }

  /**
   * Get total count for api.
   *
   * @return int
   */
  protected function getTotalCount() : int {
    $indexResponse = $this->getIndex();
    return $this->totalCountItems = $indexResponse['count'] ?? 0;
  }

  /**
   * Get random api item id. Depend on total count.
   */
  protected function calculateRandomId() {
    $this->getTotalCount();
    $this->itemId = rand(1, $this->totalCountItems);
  }

  /**
   * Get index method for api.
   *
   * Need to know the total count.
   *
   * @return array
   *   Array with items, total count, etc...
   */
  protected function getIndex() : array {
    return $this->sendQuery($this->indexUrl);
  }

  /**
   * Send query to api.
   *
   * @param string $url
   *   Url where to send.
   *
   * @return array
   *   Array with query response.
   */
  protected function sendQuery(string $url) : array {
    return (array) (new HttpClient())->get($url)->json();
  }

  /**
   * Build url for one api item.
   */
  protected function buildOneUrl() {
    $this->calculateRandomId();
    $this->oneUrl = $this->urlToCall . $this->itemId;
  }

  /**
   * Build mapped field for api.
   *
   * @param array $response
   *   Response form api item.
   *
   * @return array
   *   Array with mapped fields.
   */
  protected function buildMappedFields(array $response) : array {
    $result = [];
    foreach ($this->mappedFields as $field_name => $mapped_field_name) {
      $result[$field_name] = $response[$mapped_field_name] ?? '';
    }

    return $result;
  }

  /**
   * Set url field to one item
   *
   * @param array $item
   *   Item array.
   */
  protected function setUrlForOne(array &$item) {
    $item['url'] = empty($item['url']) ? $this->oneUrl : $item['url'];
  }

  /**
   * Set item id field to item.
   *
   * @param array $item
   *   Item array.
   */
  protected function setIdForOne(array &$item) {
    $item['id'] = $this->itemId;
  }

  /**
   * Set score field to item.
   *
   * @param array $item
   *   Item array.
   */
  protected function setRaitForOne(array &$item) {
    $score = $this->itemScore = (new RaitModel())->getScore($this->itemId, $this->apiId);
    $item['score'] = $score;
  }

  /**
   * Set score in percent field to item.
   *
   * @param array $item
   *   Item array.
   */
  protected function setRaitInPercentForOne(array &$item) {
    if ($this->itemScore >= 100) {
      $score_percent = 100;
    }
    else if($this->itemScore <= 0) {
      $score_percent = 0;
    }
    else {
      $score_percent = $this->itemScore;
    }

    $item['score_percent'] = $score_percent;
  }

}
