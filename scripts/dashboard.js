document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.add-assignment-form');
    const addButton = document.querySelector('.add-btn');

    addButton.addEventListener('click', function() {
        if (form.classList.contains('show')) {
            form.classList.remove('show');
        } else {
            form.classList.add('show');
        }
        this.classList.toggle('rotate');
    });

    document.querySelector('#cancel-btn').addEventListener('click', function() {
        form.classList.remove('show');
        addButton.classList.remove('rotate');
    });

    document.addEventListener('click', function(event) {
        if (!form.contains(event.target) && !addButton.contains(event.target)) {
            form.classList.remove('show');
            addButton.classList.remove('rotate');
        }
    });
});