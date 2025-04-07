function resetujPola() {
    var formularz = document.getElementById("MyForm");
    formularz.reset();
}

// Dropdown button code
const dropdown = document.querySelectorAll('.dropdown');

dropdown.forEach(e => {
    const dropdowntop = e.querySelectorAll('.dropdown-top');
    const dropdownitems = e.querySelectorAll('.dropdown-item');
    const link = e.querySelectorAll('a');
    const icon = e.querySelectorAll('i');

    dropdowntop.forEach(btn => {
        btn.addEventListener('click', e => {
            btn.classList.toggle('active');
            icon.forEach(e => {
                e.className = e.className === 'fa-solid fa-caret-down' ? 'fa-solid fa-bars' : 'fa-solid fa-caret-down'; 
            });
            link.forEach(e => {
                e.classList.toggle('active');
            });
            e.preventDefault();
            for (let i = 0; i < dropdownitems.length; i++) {
                dropdownitems[i].classList.toggle('active');
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const typKontaRadios = document.querySelectorAll('input[name="typ_konta"]');
    const firmaDiv = document.querySelector('.firma');
    const submitButton = document.querySelector('.button');

    typKontaRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'firma') {
                firmaDiv.style.display = 'block'; // Pokaż sekcję dla firmy
                submitButton.textContent = 'Zarejestruj firmę'; // Zmień tekst przycisku
            } else {
                firmaDiv.style.display = 'none'; // Ukryj sekcję dla firmy
                submitButton.textContent = 'Zarejestruj użytkownika'; // Przywróć tekst przycisku
            }
        });
    });

    // Inicjalnie ustaw widoczność
    if (document.querySelector('#firma').checked) {
        firmaDiv.style.display = 'block';
    } else {
        firmaDiv.style.display = 'none';
    }
});
