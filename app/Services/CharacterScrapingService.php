<?php

namespace App\Services;

use App\Models\Character;
use Goutte\Client;


class CharacterScrapingService {
  //Kyo data
  public static $START_SONGS = 77;
  public static $END_SONGS = 94;
  public static $START_ACTOR_VOICE = 95;
  public static $END_ACTOR_VOICE = 101;
  public static $START_APPEARANCE = 102;
  public static $END_APPEARANCE = 146;

  public function scrapingGeneralCharacterInformation() {
    $client = new Client();
    $characters = Character::all();
    foreach ($characters as $character) {
      $crawler = $client->request('GET', $character->url);
      $this->parseHTML($crawler);
    }
  }

  public function characterTest(){
    $client = new Client();
    $crawler = $client->request('GET', 'https://kof.fandom.com/es/wiki/Andy_Bogard');
    $this->parseToHTML($crawler);
  }

  private function saveProfileData($arrTemp){
   for($i = 0; $i < count($arrTemp); $i += 2){
     echo $i ."=>" .$arrTemp[$i];
   }
  }


  //Obtiene el menu de la pagina, esto puede variar mucho.
  private function parseToHTML($crawler){
    $arrTemp = [];
    $nodes = $crawler->filter('div.mw-parser-output ul')->children('li');
    foreach($nodes as $node => $value){
      $arrTemp[] = $value->nodeValue;
    }

    dd($arrTemp);

    //$this->getSongsData($arrTemp);
    //$this->getAppearancesData($arrTemp);
    //$this->getVoiceActorData($arrTemp);
  }

  private function getSongsData($arrTemp){
    for($i = self::$START_SONGS; $i <= self::$END_SONGS; $i++){
      $songs[] = $arrTemp[$i];
    }
    return $songs;
  }

  private function getAppearancesData($arrTemp){
    for($i = self::$START_APPEARANCE; $i <= self::$END_APPEARANCE; $i++){
      $appearances[] = $arrTemp[$i];
    }
    return$appearances;
  }

  private function getVoiceActorData($arrTemp){
    for($i = self::$START_ACTOR_VOICE; $i <= self::$END_ACTOR_VOICE; $i++){
      $appearances[] = $arrTemp[$i];
    }
    return $appearances;
  }
}
