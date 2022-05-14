<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Character;

class CharacterWeb extends Controller {

  public function index() {
    return view('index', [
      'characters'=> Character::latest()->paginate()
    ]);
  }
}
