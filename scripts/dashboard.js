document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.add-assignment-form');
    const editForm = document.querySelector('.edit-assignment-form');
    const addButton = document.querySelector('.add-btn');
    const cancelButton = document.querySelector('#cancel-btn');
    const cancelEditButton = document.querySelector('#cancel-edit-btn');
    const assignmentForm = document.getElementById('assignment-form');
    const editAssignmentForm = document.getElementById('edit-assignment-form');

    addButton.addEventListener('click', function () {
        form.classList.toggle('show');
        this.classList.toggle('rotate');
    });

    cancelButton.addEventListener('click', function () {
        form.classList.remove('show');
        addButton.classList.remove('rotate');
    });

    cancelEditButton.addEventListener('click', function () {
        editForm.classList.remove('show');
    });

    document.addEventListener('click', function (event) {
        if (!form.contains(event.target) && !addButton.contains(event.target)) {
            form.classList.remove('show');
            addButton.classList.remove('rotate');
        }
        if (!editForm.contains(event.target) && !event.target.classList.contains('edit-btn')) {
            editForm.classList.remove('show');
        }
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const assignment = JSON.parse(this.getAttribute('data-assignment'));
            showEditForm(assignment);
        });
    });

    window.showEditForm = function (assignment) {
        document.getElementById('edit-assignment-id').value = assignment.id;
        document.getElementById('edit-assignment-title').value = assignment.title;
        document.getElementById('edit-assignment-classname').value = assignment.classname;
        document.getElementById('edit-assignment-duedate').value = new Date(assignment.duedate).toISOString().split('T')[0];
        document.getElementById('edit-assignment-assigntype').value = assignment.assigntype;
        editForm.classList.add('show');
    };
});

document.querySelectorAll('.bar').forEach(bar => {
    const current = parseFloat(bar.getAttribute('data-current'));
    const max = parseFloat(bar.getAttribute('data-max'));
    const min = parseFloat(bar.getAttribute('data-min'));

    const percentage = ((current - min) / (max - min) * 100) + '%';
    bar.style.setProperty('--percentage', percentage);
});

let assignmentToDelete = null;
const deleteModal = document.getElementById('delete-confirm');
const cancelDelete = document.getElementById('cancel-delete');
const confirmDelete = document.getElementById('confirm-delete');
const loadingOverlay = document.getElementById('loading-overlay');

function showDeleteConfirm(assignmentId) {
    assignmentToDelete = assignmentId;
    deleteModal.style.display = 'block';
}

cancelDelete.addEventListener('click', () => {
    deleteModal.style.display = 'none';
    assignmentToDelete = null;
});

confirmDelete.addEventListener('click', () => {
    if (assignmentToDelete) {
        loadingOverlay.style.display = 'flex';
        fetch('delete_assignment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: assignmentToDelete })
        })
            .then(() => {
                window.location.reload();
            });
    }
    deleteModal.style.display = 'none';
});

// Close modal if clicking outside
window.addEventListener('click', (e) => {
    if (e.target === deleteModal) {
        deleteModal.style.display = 'none';
        assignmentToDelete = null;
    }
});