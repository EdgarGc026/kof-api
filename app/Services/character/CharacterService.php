<?php

namespace App\Services\character;

class CharacterService {

  public function characterSync() {
    $characterSync = new CharacterSyncService();
    $characterSync->sync();
  }

  public function characterScraping() {
    $characterScraping = new CharacterScrapingService();
    $characterScraping->scraping();
  }

  public function singleCharacter() {
    $characterScraping = new CharacterScrapingService();
    $characterScraping->singleCharacter('https://kof.fandom.com/es/wiki/Zero_(clon)');
  }
}
