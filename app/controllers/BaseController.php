<?php 
require_once 'app/core/Controller.php';
require_once 'app/models/UsersModel.php';
require_once 'app/models/SearchModel.php';

class BaseController extends Controller
{
    private $users, $search;

    function actionBase()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            if (isset($_REQUEST['delete_person'])) {
                echo $this->deletePerson($_REQUEST['delete_person']);
                return;
            }
            else {
                return $this->createPerson($_REQUEST);
            }
        }
        else {
            $this->users = new UsersModel();
        }

        $_POST['users'] = $this->users->__construct();
        $_POST['date'] = date('Y-m-d');
        $_POST['kitWords'] = $this->kitWords;

        echo $this->users->age;

        $this->view->show('base');
    }

    private function deletePerson($id)
    {
        $this->users = new UsersModel();
        $this->users->deletePerson($id);
        return json_encode(array('delete' => 'approved'));
    }

    private function createPerson($data)
    {
        $this->users = new UsersModel($data);
        if (isset($this->users->error)) {
            echo json_encode(array('error' => $this->users->error));
            return;
        }
        else {
            echo json_encode(array('person' => $this->users));
            return; 
        }
    }

    function actionSearch()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            if (isset($_REQUEST['search_min']) && isset($_REQUEST['search_max'])) {
                $min = $_REQUEST['search_min'];
                $max = $_REQUEST['search_max'];
                $this->search = new SearchModel;

                echo json_encode(array('response' => $this->search->__construct($min, $max)));
                return; 
            }
            if (isset($_REQUEST['delete_list'])) {
                $this->search = new SearchModel;

                if (!empty($_REQUEST['delete_list'])) $min = array_shift($_REQUEST['delete_list']);
                else return;

                if (!empty($_REQUEST['delete_list'])) $max = array_pop($_REQUEST['delete_list']);
                else $max = 1000000000;
                
                $this->search->deletePersons($min, $max);
                
                echo json_encode(array('first' => $min, 'last' => $max));
                return; 
            }
        }
    }

    function actionSetLanguage()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            if (isset($_REQUEST['set_language'])) {
                setcookie('language', $_REQUEST['set_language']);

                $this->kitWords = include('app/components/language/' . $_REQUEST['set_language'] . '.php');
                echo json_encode((array)$this->kitWords);
                return; 
            }
        }
    }
}
