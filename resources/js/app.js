import './bootstrap';
// app.js

document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', function () {
        this.classList.toggle('active');
    });
});


 
