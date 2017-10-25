<?php namespace APP\Models;

use \CodeIgniter\Model;

class ApplyModel extends Model{

    protected $table = 'apply';
    protected $primaryKey = 'id';
    protected $allowedFields = ['photo_name', 'name', 'pinyin', 'sex','id_number', 'nation', 'birthday', 'phone',
        'qq', 'email', 'domicile', 'address', 'region', 'number', 'marital_status', 'health', 'german_level',
        'degree_of_education', 'criminal_record', 'date_section_1_1', 'date_section_1_2', 'resume_1', 'date_section_2_1',
        'date_section_2_2', 'resume_2', 'date_section_3_1', 'date_section_3_2', 'resume_3', 'contacts_and_phone', 'nursing_experience', 'reason', 'remarks'];
    protected $useTimestamps = true;
}

?>
