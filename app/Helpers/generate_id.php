<?php

namespace App\Helpers;

use CodeIgniter\Database\ConnectionInterface;

function generate_id(ConnectionInterface &$db, $table, $primaryKey)
{
    $last_promo_id = 1;
    
    $query = $db->query('SELECT MAX(CAST(SUBSTRING('. $primaryKey .', 7) AS UNSIGNED)) AS last_id FROM ' . $table);
    $row = $query->getRow();
    
    if ($row->last_id !== null) {
        $last_promo_id = $row->last_id + 1;
    }
    
    $promo_id = 'promo-' . sprintf('%010d', $last_promo_id);

    return $promo_id;
}
