<?php

namespace App;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class CompanyGallery extends Model
{
  protected $table = 'company_gallery';
  protected $fillable = ['company_id','image_url'];
  protected $hidden = ['_token'];
 
  public function company(){
    return $this->belongsTo('App\Company');
  }
}
