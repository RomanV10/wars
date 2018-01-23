<?php

namespace TestRoman\Wars\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use TestRoman\Wars\Actions\WarsAction;
use TestRoman\Wars\Actions\RatingAction;

/**
 * Class WarController
 *
 * @package TestRoman\Wars\Controllers
 */
class WarController extends BaseController
{

  /**
   * Save enabled api.
   *
   * @param \Illuminate\Http\Request $request
   *   Request.
   *
   * @return array
   *   Array with saved ipi.
   */
  public function saveEnabledApis(Request $request) {
    return (new WarsAction())->saveEnabledApis($request);
  }

  /**
   * Show random api items.
   *
   * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showRandomApisItems() {
    return view('show-items', ['items' => (new WarsAction())->showRandomApisItems()]);
  }

  /**
   * Get random api.
   *
   * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getEnabledApis() {
    return view('show-apis', ['enabled_apis' => (new WarsAction())->showEnabledApis()]);
  }

  /**
   * Add score for api items.
   *
   * @param \Illuminate\Http\Request $request
   *  Request.
   *
   * @return array
   *
   */
  public function addApiItemScore(Request $request) {
    return (new RatingAction())->addApiItemScore($request);
  }

}
