<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sp_specialite';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'SP_CODE_SQ_PK';
}
