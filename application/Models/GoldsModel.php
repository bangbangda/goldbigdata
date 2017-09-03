<?php namespace APP\Models;

use \CodeIgniter\Model;

class GoldsModel extends Model{

    protected $table = 'golds';
    protected $primaryKey = 'id';
    protected $allowedFields = ['variety', 'latestpri', 'openpri', 'maxpri', 'minpri', 'limit', 'yespri', 'totalvol', 'time', 'create_date'];
    protected $useTimestamps = true;
}

?>
