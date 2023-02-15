<?php require_once 'app/models/UsersModel.php';

class SearchModel extends UsersModel
{
    public $search_id = [];
    public $min, $max;

    function __construct($min = '', $max = '')
    {
        $this->tablename = 'users';
        if (!empty($min)) $this->min = $min;
        else $this->min = 1;

        if (!empty($max)) $this->max = $max;
        else $this->max = 1000000000;

        $sql = "SELECT * FROM " . $this->tablename . " WHERE id >= ". $this->min . " AND id <= " . $this->max;

        $obj = $this->connection($sql);
        $people = [];

        while ($elem = $obj->fetch_assoc()) {
            array_push($people, $elem);
        }

        foreach ($people as $key => $person) {
            $people[$key] += ['age' => UsersModel::age($person['birthday'])];
            $people[$key]['gender'] = UsersModel::gender($person['gender']);
        }

        return $people;
    }

    function deletePersons($min, $max)
    {
        $sql = "DELETE FROM " . $this->tablename . " WHERE id >= " . $min . " AND id <= " . $max;
        $obj = $this->connection($sql);
    }
}
