<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model {
  protected $fillable = [
    'id', 'name', 'url', 'fullname', 'birthday', 'weight',
    'height', 'bloodType', 'relatives', 'occupation', 'likes',
    'hates', 'hobbies', 'favoriteFood', 'sportSkill', 'specialSkill',
    'favoriteMusic', 'measures', 'guns', 'fightStyle', 'avatar'
  ];

  protected $guarded = [];

  public function characterProfile() {
    return $this->hasOne(Character::class);
  }
}
