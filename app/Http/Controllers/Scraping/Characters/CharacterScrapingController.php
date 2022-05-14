<?php

namespace App\Http\Controllers\Scraping\Characters;

use App\Http\Controllers\Controller;
use App\Services\character\CharacterService;

class CharacterScrapingController extends Controller {

  public function characterSync(CharacterService $characterService) {
    $characterService->characterSync();
  }

  public function characterScraping(CharacterService $characterService) {
    $characterService->characterScraping();
  }

  //Metodo de prueba (Para un solo monito)
  public function singleCharacter(CharacterService $characterService) {
    $characterService->singleCharacter();
  }
}
