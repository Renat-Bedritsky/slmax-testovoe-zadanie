<?php
$users = $_POST['users'];
?>
<script>
function setId(id) {
    var person_id = document.querySelector(`#delete-${id}`);

    person_id.addEventListener('click', () => {
        deletePerson(id);
    });
}
</script>

<div id="people">
    <div class="row my-3">
        <form action="/search" method="POST" class="row col w-50">
            <div class="form-group col">
                <label class="form-label m-2">Найти по ID</label>
            </div>
            <div class="form-group col">
                <input type="number" class="form-control mx-2" id="search-min" name="min" placeholder="От" min="0">
            </div>
            <div class="form-group col">
                <input type="number" class="form-control mx-2" id="search-max" name="max" placeholder="До" min="0">
            </div>
        </form>

        <form action="/" method="POST" class="text-end col mx-2">
            <button id="call-add" class="btn btn-success">Добавить</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" id="list-people">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>День рождения</th>
                    <th>Пол</th>
                    <th>Город</th>
                    <th class="delete_wrapper">Действие</th>
                </tr>
            </thead>

            <tbody id="wrapper-people">
            <?php foreach($users as $user): ?>
                <tr id="person-<?= $user['id']; ?>" class="people">
                    <th><?= $user['id']; ?></th>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['surname']; ?></td>
                    <td><?= $user['age']; ?></td>
                    <td><?= $user['gender']; ?></td>
                    <td><?= $user['city']; ?></td>
                    <td class="delete_wrapper">
                        <form action="/" method="POST">
                            <button class="btn btn-danger" name="delete" id="delete-<?= $user['id']; ?>">Удалить</button>

                            <script>
                                setId(<?= $user['id'] ?>);
                            </script>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
            <form action="/search" method="POST" id="delete-list" class="text-end mx-2">
                <button class="btn btn-danger my-2" name="delete-list"">Удалить найденных</button>
            </form>
    </div>
</div>

<!-- Форма для добавления людей -->
<div class="w-25 mx-auto m-2 bg-light p-2" id="div-add">
    <form action="/" method="POST">
        <div class="form-group m-2">
            <label for="name" class="h4">Имя</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" minlength="2" maxlength="50" required placeholder="Иван">
            <small id="nameHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label for="surname" class="h4">Фамилия</label>
            <input type="text" class="form-control" id="surname" name="surname" aria-describedby="surnameHelp" minlength="2" maxlength="50" required placeholder="Иванов">
            <small id="surnameHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label for="birthday" class="h4">Дата рождения</label>
            <input type="date" class="form-control" id="birthday" name="birthday" aria-describedby="birthdayHelp" max="<?= $_POST['date'] ?>" required>
            <small id="birthdayHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label><spawn class="h4">Пол</spawn><br>
                <input type="radio" class="gender" name="gender" value="1" aria-describedby="genderHelp" checked> Мужчина <br>
                <input type="radio" class="gender" name="gender" value="0" aria-describedby="genderHelp"> Женщина
                <small id="genderHelp" class="form-text text-muted"></small>
            </label>
        </div>
        <div class="form-group m-2">
            <label for="city" class="h4">Город</label>
            <input type="text" class="form-control" id="city" name="city" aria-describedby="cityHelp" minlength="2" maxlength="50" required placeholder="Минск">
            <small id="cityHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2 text-center">
            <button id="reg-people" class="btn btn-success m-1">Добавить</button>
            <button id="close-add" class="btn btn-danger m-1">Закрыть</button>
        </div>
    </form>
</div>