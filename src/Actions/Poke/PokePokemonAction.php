<?php
namespace TestRoman\Wars\Actions\Poke;

use TestRoman\Wars\Actions\AbstractParseAction;

/**
 * Class PokePokemonAction
 *
 * @package TestRoman\Wars\Actions\Poke
 */
class PokePokemonAction extends AbstractParseAction {
  protected $indexUrl = 'https://pokeapi.co/api/v2/pokemon/';
  protected $urlToCall = 'https://pokeapi.co/api/v2/pokemon/';

}