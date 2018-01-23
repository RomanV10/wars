<?php

return ['allowed_apis' => [
    'star_wars_people' => [
      'class' => 'TestRoman\Wars\Actions\StarWars\StarWarsPeopleAction',
      'name' => 'StarWars'
    ],
    'poke_pokemon' => [
      'class' => 'TestRoman\Wars\Actions\Poke\PokePokemonAction',
      'name' => 'Pokemon'
    ],
  ],
];