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