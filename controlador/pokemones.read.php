<?php

include_once "../model/pokemones.php";

$pokemons = new \modelo\Pokemones();

$response = $pokemons->readPokemones();

unset($pokemons);

echo json_encode($response);