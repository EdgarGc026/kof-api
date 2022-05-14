<?php

namespace App\Services\character;

use App\Models\Character;
use Goutte\Client;

class CharacterScrapingService {

  public function scraping() {
    $this->getCharactersProfile();
  }

  //Obtiene todos los datos del perfil de los monitos
  private function getCharactersProfile() : void {
    $client = new Client();
    $characters = Character::all();
    $this->executeCharacterScraping($characters, $client);
  }

  //Obtiene un solo monito
  public function singleCharacter($url) : void {
    $character = Character::where('url', $url)->first();
    $client = new Client();
    $crawler = $client->request('GET', $url);

    $avatarImage = $this->getCharacterImage($crawler);
    $leftArrayData = $this->getLeftDataProfile($crawler);
    $rightArrayData = $this->getRightDataProfile($crawler);
    $arrayCharacter = $this->mergeData($leftArrayData, $rightArrayData, $avatarImage);
    $this->saveCharacter($character, $arrayCharacter);
  }

  //Ejecuta para todos los monitos
  private function executeCharacterScraping($characters, $client) : void {
    foreach ($characters as $character) {
      $crawler = $client->request('GET', $character->url);

      $avatarImage = $this->getCharacterImage($crawler);
      $leftArrayData = $this->getLeftDataProfile($crawler);
      $rightArrayData = $this->getRightDataProfile($crawler);
      //$arrayCharacter = $this->mergeData($leftArrayData, $rightArrayData);
      $arrayCharacter = $this->mergeData($leftArrayData, $rightArrayData, $avatarImage);
      $this->saveCharacter($character, $arrayCharacter);
    }
  }

  private function saveCharacter( $character, $arrayCharacter ) {
    $updateCharacter = $character->update( [
      'fullname' => $arrayCharacter[ 'Nombre Completo' ] ?? null,
      'birthday' => $arrayCharacter[ 'Fecha de Nacimiento' ] ?? null,
      'weight' => $arrayCharacter[ 'Altura' ] ?? null,
      'height' => $arrayCharacter[ 'Peso' ] ?? null,
      'bloodType' => $arrayCharacter[ 'Tipo Sanguineo' ] ?? null,
      'relatives' => $arrayCharacter[ 'Familiares/Relaciones' ] ?? null,
      'occupation' => $arrayCharacter[ 'Ocupación' ] ?? null,
      'likes' => $arrayCharacter[ 'Gustos' ] ?? null,
      'hates' => $arrayCharacter[ 'Odia' ] ?? null,
      'hobbies' => $arrayCharacter[ 'Hobbies' ] ?? null,
      'favoriteFood' => $arrayCharacter[ 'Comida Favorita' ] ?? null,
      'sportSkill' => $arrayCharacter[ 'Deportes que Domina' ] ?? null,
      'specialSkill' => $arrayCharacter[ 'Habilidad Especial' ] ?? null,
      'favoriteMusic' => $arrayCharacter[ 'Musica Favorita' ] ?? null,
      'measures' => $arrayCharacter[ 'Medidas' ] ?? null,
      'guns' => $arrayCharacter[ 'Armas' ] ?? null,
      'fightStyle' => $arrayCharacter[ 'Estilo de Pelea' ] ?? null,
      'avatar' => $arrayCharacter[ 'Avatar' ] ?? null,
    ] );

    return back()->with('success', 'Se ha actualizado el perfil del monito');
  }

  private function getCharacterImage($crawler) : string | null {
    try {
      $image = $crawler->filter('table.darktable tbody tr td img')->attr('data-src');
      if(is_null($image)) {
        $image = $crawler->filter('table.darktable tbody tr td img')->attr('src');
      }

      return $image;
    } catch (\Exception $e) {
      echo "No se pudo obtener la imagen del monito";
      return null;
    }
  }

  //Obtiene los datos del lado izquierdo de la tabla
  private function getLeftDataProfile($crawler) : array {
    $data = [];
    $elementTd = $crawler->filter('table.darktable tbody tr')->filter('td');
    foreach ($elementTd as $key => $td) {
      if ($key % 2 != 0) {
        $data[$key] = $td->nodeValue;
      }
    }
    return $data;
  }

  //Obtiene los datos del lado derecho de la tabla
  private function getRightDataProfile($crawler) : array {
    $data = [];
    $elementTd = $crawler->filter('table.darktable tbody tr')->filter('td');
    foreach ($elementTd as $key => $td) {
      if ($key % 2 == 0) {
        $data[$key] = $td->nodeValue;
      }
    }
    return $data;
  }

  //Verificamos que ambos cumplan con su indice, de ser asi, se agrega en otro arreglo supremo.
  private function mergeData($leftArrayData, $rightArrayData, $avatarImage) : array {
    $arrayImage = ['Avatar' => $avatarImage];
    array_shift($rightArrayData);
    $combineArray = array_combine($leftArrayData, $rightArrayData);
    $arrFinal = array_merge($combineArray, $arrayImage);
    return $arrFinal;
  }

  public function utils($var) {
    echo "<pre>";
      print_r($var);
    echo "</pre>";
    //die();
  }
}
