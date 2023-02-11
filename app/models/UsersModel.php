<?php require_once 'app/core/Model.php';

class UsersModel extends Model
{
    public $error;
    public $id, $name, $surname, $birthday, $age, $gender, $city;

    function __construct($data = [])
    {
        $this->tablename = 'users';

        if (!empty($data)) {
            return $this->validatePerson($data);
        }
        else {
            $people = $this->getList();

            foreach ($people as $key => $person) {
                $people[$key] += ['age' => self::age($person['birthday'])];
                $people[$key]['gender'] = self::gender($person['gender']);
            }

            return $people;
        }
    }

    private function validatePerson($data)
    {
        if ($this->validWord($data['name']) == TRUE) $this->name = $data['name'];
        else return $this->error = 'name';

        if ($this->validWord($data['surname']) == TRUE) $this->surname = $data['surname'];
        else return $this->error = 'surname';

        if ($this->validDate($data['birthday']) == TRUE) $this->birthday = $data['birthday'];
        else return $this->error = 'birthday';

        if ($data['gender'] == 0 || $data['gender'] == 1) $this->gender = $data['gender'];
        else return $this->error = 'gender';

        if ($this->validWord($data['city']) == TRUE) $this->city = $data['city'];
        else return $this->error = 'city';
        
        $this->id = $this->getLine() + 1;
        $this->createPerson();

        $this->age = self::age($this->birthday);
        $this->gender = self::gender($this->gender);
    }

    private function createPerson() {
        $this->insertList([$this->id, $this->name, $this->surname, $this->birthday, $this->gender, $this->city]);
    }

    private function validWord($word)
    {
        $reg = '/^[А-ЯЁA-Z]{1}[а-яёa-z -]{1,49}$/u';
        if (preg_match($reg, $word)) return TRUE;
        else return FALSE;
    }

    private function validDate($date)
    {
        $reg = '/^(19[0-9][0-9]|20[0-9][0-9])[\-](0[1-9]|1[012])[\-](0[1-9]|[12][0-9]|3[01])$/';
        if (preg_match($reg, $date)) return TRUE;
        else return FALSE;
    }

    // Функция для преобразования даты рождения в возраст
    static function age($birthday)
    {
        $age = floor((strtotime("now") - strtotime($birthday)) / YEARINSECONDS);
        if ($age == 1 || ($age%10 == 1 && $age != 11)) {
            return $age . " год";
        }
        else if (($age >=2 && $age <= 4) || ($age%10 >=2 && $age%10 <= 4 && $age >=22)) {
            return $age . " года";
        }
        else if ($age == 0 || ($age >= 5 && $age <= 20) || $age%10 == 5) {
            return $age . " лет";
        }
    }

    // Функция для преобразования пола из двоичной систему в текстовую
    static function gender($gender)
    {
        if ($gender == '1') return 'Мужчина';
        if ($gender == '0') return 'Женщина';
    }

    public function deletePerson($id)
    {
        $this->deleteList(['id' => $id]);
    }
}