<?php
$users = $_POST['users'];
$kitWords = $_POST['kitWords'];
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
                <label class="form-label m-2" id="find-by-id"><?= $kitWords['find']; ?></label>
            </div>
            <div class="form-group col">
                <input type="number" class="form-control mx-2" id="search-min" name="min" placeholder="<?= $kitWords['pretext']['from']; ?>" min="0">
            </div>
            <div class="form-group col">
                <input type="number" class="form-control mx-2" id="search-max" name="max" placeholder="<?= $kitWords['pretext']['to']; ?>" min="0">
            </div>
        </form>

        <form action="/" method="POST" class="text-end col mx-2 form-button-add">
            <button id="call-add" class="btn btn-success"><?= $kitWords['add']; ?></button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" id="list-people">
            <thead class="thead-dark">
                <tr>
                    <th id="table-id"><?= $kitWords['fields']['id']; ?></th>
                    <th id="table-name"><?= $kitWords['fields']['name']; ?></th>
                    <th id="table-surname"><?= $kitWords['fields']['surname']; ?></th>
                    <th id="table-age"><?= $kitWords['fields']['age']; ?></th>
                    <th id="table-gender"><?= $kitWords['fields']['gender']; ?></th>
                    <th id="table-city"><?= $kitWords['fields']['city']; ?></th>
                    <th id="table-action" class="delete_wrapper"><?= $kitWords['fields']['action']; ?></th>
                </tr>
            </thead>

            <tbody id="wrapper-people">
            <?php foreach($users as $user): ?>
                <tr id="person-<?= $user['id']; ?>" class="people">
                    <th><?= $user['id']; ?></th>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['surname']; ?></td>
                    <td><?= $user['age']; ?></td>
                    <td id="span-gender" style="display:none;"><?= $user['gender']; ?></td>
                    <td id="table-gender"><?= $kitWords['gender'][$user['gender']]; ?></td>
                    <td><?= $user['city']; ?></td>
                    <td class="delete_wrapper">
                        <form action="/" method="POST">
                            <button class="btn btn-danger delete-one" name="delete" id="delete-<?= $user['id']; ?>"><?= $_POST['kitWords']['delete']; ?></button>

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
                <button class="btn btn-danger my-2 delete-found" name="delete-list""><?= $_POST['kitWords']['delete-found']; ?></button>
            </form>
    </div>
</div>

<!-- ?????????? ?????? ???????????????????? ?????????? -->
<div class="w-25 mx-auto m-2 bg-light p-2" id="div-add">
    <form action="/" method="POST">
        <div class="form-group m-2">
            <label for="name" class="h4">??????</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" minlength="2" maxlength="50" required placeholder="????????">
            <small id="nameHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label for="surname" class="h4">??????????????</label>
            <input type="text" class="form-control" id="surname" name="surname" aria-describedby="surnameHelp" minlength="2" maxlength="50" required placeholder="????????????">
            <small id="surnameHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label for="birthday" class="h4">???????? ????????????????</label>
            <input type="date" class="form-control" id="birthday" name="birthday" aria-describedby="birthdayHelp" max="<?= $_POST['date'] ?>" required>
            <small id="birthdayHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2">
            <label><spawn class="h4">??????</spawn><br>
                <input type="radio" class="gender" name="gender" value="1" aria-describedby="genderHelp" checked> ?????????????? <br>
                <input type="radio" class="gender" name="gender" value="0" aria-describedby="genderHelp"> ??????????????
                <small id="genderHelp" class="form-text text-muted"></small>
            </label>
        </div>
        <div class="form-group m-2">
            <label for="city" class="h4">??????????</label>
            <input type="text" class="form-control" id="city" name="city" aria-describedby="cityHelp" minlength="2" maxlength="50" required placeholder="??????????">
            <small id="cityHelp" class="form-text text-muted"></small>
        </div>
        <div class="form-group m-2 text-center">
            <button id="reg-people" class="btn btn-success m-1">????????????????</button>
            <button id="close-add" class="btn btn-danger m-1">??????????????</button>
        </div>
    </form>
</div>
