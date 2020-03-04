const action = document.getElementsByClassName('action-button');
const result = document.getElementById('number');

for (let i = 0; i < action.length; i++) {
    action[i].addEventListener('click', function () {
        i++;
        result.value = i ;
    });
}