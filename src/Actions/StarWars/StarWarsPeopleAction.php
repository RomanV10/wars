<?php
namespace TestRoman\Wars\Actions\StarWars;

use TestRoman\Wars\Actions\AbstractParseAction;

/**
 * Class StarWarsPeopleAction
 *
 * @package TestRoman\Wars\Actions\StarWars
 */
class StarWarsPeopleAction extends AbstractParseAction {
  protected $indexUrl = 'https://swapi.co/api/people?format=json';
  protected $urlToCall = 'https://swapi.co/api/people/';

}