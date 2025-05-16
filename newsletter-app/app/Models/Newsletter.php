<?php 
namespace App\Models;
use CodeIgniter\Model;


class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $primaryKey = 'id';


    protected $allowedFields = [
        'name',
        'description',
        'customer_id', //owner
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}