function setLanguage(language) {
    console.log(language);
    return $.ajax({
        method: 'POST',
        dataType: 'json',
        url: `\/set-language`,
        data: {
            set_language: language
        },
        success: function(data) {
            setWords(data);
        }
    });
}

function setWords(data) {
    document.querySelector('title').innerHTML = data.title;
    document.querySelector('#header').innerHTML = data.wrapper.header;
    document.querySelector('#footer').innerHTML = data.wrapper.footer;
    document.querySelector('#find-by-id').innerHTML = data.find;
    document.querySelector('#search-min').setAttribute('placeholder', data.pretext.from);
    document.querySelector('#search-max').setAttribute('placeholder', data.pretext.to);
    document.querySelector('#call-add').innerHTML = data.add;
    document.querySelector('#table-id').innerHTML = data.fields.id;
    document.querySelector('#table-name').innerHTML = data.fields.name;
    document.querySelector('#table-surname').innerHTML = data.fields.surname;
    document.querySelector('#table-age').innerHTML = data.fields.age;
    document.querySelector('#table-gender').innerHTML = data.fields.gender;
    document.querySelector('#table-city').innerHTML = data.fields.city;
    document.querySelector('#table-action').innerHTML = data.fields.action;

    var delete_one = document.querySelectorAll('.delete-one');
    delete_one.forEach(function(button) {
        button.innerHTML = data.delete;
    });

    document.querySelector('.delete-found').innerHTML = data.delete_found;

    var span_gender = document.querySelector('#span-gender');
    console.log(span_gender.value);
    if (span_gender.value == 'male') {
        document.querySelector('#table-gender').innerHTML = data.gender.male;
    }
    else {
        document.querySelector('#table-gender').innerHTML = data.gender.female;
    }
}
