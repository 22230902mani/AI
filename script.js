document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuToggle = document.createElement('div');
    menuToggle.className = 'menu-toggle';
    menuToggle.innerHTML = '☰';
    document.querySelector('nav .container').appendChild(menuToggle);
    
    menuToggle.addEventListener('click', function() {
        document.querySelector('.nav-links').classList.toggle('active');
    });

    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    });

    // Collaborator Filter
    const searchInput = document.querySelector('.search-filter input');
    const fieldFilter = document.getElementById('field-filter');
    const collabCards = document.querySelectorAll('.collab-card');
    
    function filterCollaborators() {
        const searchTerm = searchInput.value.toLowerCase();
        const fieldTerm = fieldFilter.value.toLowerCase();
        
        collabCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const matchesSearch = text.includes(searchTerm);
            const matchesField = fieldTerm === '' || text.includes(fieldTerm);
            
            card.style.display = (matchesSearch && matchesField) ? 'block' : 'none';
        });
    }

    if(searchInput && fieldFilter) {
        searchInput.addEventListener('input', filterCollaborators);
        fieldFilter.addEventListener('change', filterCollaborators);
    }

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});