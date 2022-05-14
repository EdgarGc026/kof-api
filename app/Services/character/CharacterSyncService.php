<?php

namespace App\Services\character;

use App\Models\Character;
use Goutte\Client;
use Illuminate\Http\JsonResponse;

class CharacterSyncService {

  /**
   * @return JsonResponse
   */
  public function sync() : JsonResponse {
    try {
      $url = 'https://kof.fandom.com/es/wiki/Personajes';
      $characterData = $this->scrapingData($url);
      $this->saveData($characterData);
      $this->getUrlCharacters();
      return response()->json(['message' => 'Character Sync Successfully'], 201);
    } catch (\Exception $e) {
      return response()->json( [ 'message' => 'Error in Character Sync' ], 500 );
    }
  }

  /**
   * @param $url
   * @return array
   */
  private function scrapingData( $url) : array {
    $client = new Client();
    $crawler = $client->request('GET', $url);
    $characterFirstPart = $this->getFirstPartOfCharacter($crawler);
    $characterSecondPart = $this->getSecondPartOfCharacter($crawler);
    $characterArray = array_merge($characterFirstPart, $characterSecondPart);
    return $characterArray;
  }

  /**
   * @param $characterData
   * @return void
   */
  private function saveData( $characterData) : void {
    foreach ($characterData as $character) {
      if(!Character::where('name', $character)->first()) {
        Character::create([ 'name' => $character]);
      }
    }
  }

  /**
   * @return void
   */
  private function getUrlCharacters() : void {
    $characters = Character::all();
    foreach($characters as $character){
      $url = 'https://kof.fandom.com/es/wiki/'.$character->name;
      $result = !$character->url ? Character::where('id', $character->id)->update(['url' => $url]) : null;
    }
  }

  /**
   * @param $crawler
   * @return array
   */
  private function getFirstPartOfCharacter( $crawler) : array {
    $elementTd = $crawler->filter('table tbody tr')->children('td');
    $names = $elementTd->children('a')->extract(['href']);
    $arrayData = $this->getCharacterProfile($names);
    return $arrayData;
  }

  /**
   * @param $crawler
   * @return array
   */
  private function getSecondPartOfCharacter( $crawler) : array {
    $elementTd = $crawler->filter('table tbody tr')->children('td');
    $names = $elementTd->children('p > a')->extract(['href']);
    $arrayData = $this->getCharacterProfile($names);
    return $arrayData;
  }

  /**
   * @param $names
   * @return array
   */
  private function getCharacterProfile( $names) : array {
    $arrayNames = [];
    foreach($names as $name) {
      $name = str_replace('/es/wiki/', '', $name);
      $arrayNames[] = $name;
    }
    return $arrayNames;
  }
}
