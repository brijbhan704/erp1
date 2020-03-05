<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyFolderGallery extends Model
{
    protected $table = 'company_folder_galleries';
    protected $fillable = ['company_id', 'folder_name'];
    protected $hidden = ['_token'];
    
}
