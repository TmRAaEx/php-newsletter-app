<?php

namespace App\Models;
use CodeIgniter\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $allowedFields = 
    ['user_id',
     'newsletter_id',
      'subscribed_at',
      'unsubscribed_at',];
}
