$('form').submit(function () {
    return false;
});

let call_add = document.querySelector('#call-add');
let div_add = document.querySelector('#div-add');
let close_add = document.querySelector('#close-add');
let people = document.querySelector('#people');

call_add.addEventListener('click', () => {
    div_add.style.display = 'block';
    people.style.display = 'none';
});

close_add.addEventListener('click', () => {
    div_add.style.display = 'none';
    people.style.display = 'block';
});




let firstname = document.querySelector('#name');
let surname = document.querySelector('#surname');
let birthday = document.querySelector('#birthday');
let gender = document.querySelector('.gender');
let city = document.querySelector('#city');
let reg_people = document.querySelector('#reg-people');

reg_people.addEventListener('click', () => {
    let data = checkNewPerson(
        firstname.value,
        surname.value,
        birthday.value,
        gender.value,
        city.value);
    data.then(createPerson);
});

function checkNewPerson(name, surname, birthday, gender, city) {
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/`,
        data: {
            name: name,
            surname: surname,
            birthday: birthday,
            gender: gender,
            city: city
        }
    });
}

function createPerson(response) {
    var error_name = document.querySelector('#nameHelp');
    var error_surname = document.querySelector('#surnameHelp');
    var error_birthday = document.querySelector('#birthdayHelp');
    var error_gender = document.querySelector('#genderHelp');
    var error_city = document.querySelector('#cityHelp');

    if (typeof response.error == 'undefined') {
        reload();
        div_add.style.display = 'none';
        people.style.display = 'block';

        document.querySelector('#name').value = '';
        document.querySelector('#surname').value = '';
        document.querySelector('#birthday').value = '';
        document.querySelector('#city').value = '';
    }
    else if (response.error == 'name') {
        error_name.innerHTML = 'Некорректное имя';
        error_surname.innerHTML = '';
        error_birthday.innerHTML = '';
        error_gender.innerHTML = '';
        error_city.innerHTML = '';
    }
    else if (response.error == 'surname') {
        error_name.innerHTML = '';
        error_surname.innerHTML = 'Некорректная фамилия';
        error_birthday.innerHTML = '';
        error_gender.innerHTML = '';
        error_city.innerHTML = '';
    }
    else if (response.error == 'birthday') {
        error_name.innerHTML = '';
        error_surname.innerHTML = '';
        error_birthday.innerHTML = 'Некорректная дата';
        error_gender.innerHTML = '';
        error_city.innerHTML = '';
    }
    else if (response.error == 'gender') {
        error_name.innerHTML = '';
        error_surname.innerHTML = '';
        error_birthday.innerHTML = '';
        error_gender.innerHTML = 'Некорректный пол';
        error_city.innerHTML = '';
    }
    else if (response.error == 'city') {
        error_name.innerHTML = '';
        error_surname.innerHTML = '';
        error_birthday.innerHTML = '';
        error_gender.innerHTML = '';
        error_city.innerHTML = 'Некорректный город';
    }
}

function deletePerson(id) {
    $('form').submit(function () {
        return false;
    });
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/`,
        data: {
            delete_person: id
        },
        success: function(data) {
            if (data.delete == 'approved') {
                var person = document.querySelector(`#person-${id}`);
                person.style.display = 'none';
            }
        }
    });
}



var search_min = document.querySelector('#search-min');
var search_max = document.querySelector('#search-max');

search_min.oninput = function() {
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/search`,
        data: {
            search_min: search_min.value,
            search_max: search_max.value
        },
        success: function(data) {
            updateList(data, search_min.value, search_max.value);
        }
    });
};

search_max.oninput = function() {
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/search`,
        data: {
            search_min: search_min.value,
            search_max: search_max.value
        },
        success: function(data) {
            updateList(data, search_min.value, search_max.value);
        }
    });
};

let list_id = [];

function updateList(data, min, max) {
    var wrapper_people = document.querySelector('#wrapper-people');
    wrapper_people.innerHTML = '';
    var get_id = [];

    data.response.forEach(function(person) {
        var new_person = document.createElement('tr');
        new_person.setAttribute('id', `person-${person.id}`);
    
        var id_person = document.createElement('th');
        id_person.innerHTML = `${person.id}`;
        new_person.appendChild(id_person);
    
        var name_person = document.createElement('td');
        name_person.innerHTML = `${person.name}`;
        new_person.appendChild(name_person);
    
        var surname_person = document.createElement('td');
        surname_person.innerHTML = `${person.surname}`;
        new_person.appendChild(surname_person);
    
        var age_person = document.createElement('td');
        age_person.innerHTML = `${person.age}`;
        new_person.appendChild(age_person);
    
        var gender_person = document.createElement('td');
        gender_person.innerHTML = `${person.gender}`;
        new_person.appendChild(gender_person);
    
        var city_person = document.createElement('td');
        city_person.innerHTML = `${person.city}`;
        new_person.appendChild(city_person);

        var delete_person = document.createElement('td');
        delete_person.setAttribute('class', 'delete_wrapper');
    
        var form = document.createElement('form');
        form.setAttribute('action', '/');
        form.setAttribute('method', 'POST');
    
        var button_delete = document.createElement('button');
        button_delete.setAttribute('class', 'btn btn-danger');
        button_delete.setAttribute('name', 'delete');
        button_delete.setAttribute('id', `delete-${person.id}`);
        button_delete.innerHTML = 'Удалить';
    
        var script_person = document.createElement('script');
        script_person.innerHTML = `setId(${person.id});`;
        
        form.appendChild(button_delete);
        form.appendChild(script_person);
        delete_person.appendChild(form);
        new_person.appendChild(delete_person);
        wrapper_people.appendChild(new_person);
        
        get_id.push(`${person.id}`);
    });
    list_id = get_id;

    if (list_id.length >= 1 && ((min != '' && min != 0) || (max != '' && max != 0))) {
        document.querySelector('#delete-list').style.display = 'block';
    }
    else document.querySelector('#delete-list').style.display = 'none';
}

let delete_list = document.querySelector('#delete-list');

delete_list.addEventListener('click', () => {
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/search`,
        data: {
            delete_list: list_id
        },
        success: function() {
            reload();
        }
    });
});

function reload() {
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/search`,
        data: {
            search_min: 1,
            search_max: ''
        },
        success: function(data) {
            updateList(data, search_min.value, search_max.value);
            document.querySelector('#delete-list').style.display = 'none';
            document.querySelector('#search-min').value = '';
            document.querySelector('#search-max').value = '';
        }
    });
}