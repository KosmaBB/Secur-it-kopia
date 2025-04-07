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
    const typKontaRadios = document.querySelectorAll('input[name="account_type"]');
    const firmaDiv = document.querySelector('.company');
    const submitButton = document.querySelector('.button');

    typKontaRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'company') {
                firmaDiv.style.display = 'block'; // Pokaż sekcję dla firmy
                submitButton.textContent = 'Zarejestruj firmę'; // Zmień tekst przycisku
            } else {
                firmaDiv.style.display = 'none'; // Ukryj sekcję dla firmy
                submitButton.textContent = 'Zarejestruj użytkownika'; // Przywróć tekst przycisku
            }
        });
    });

    // Inicjalnie ustaw widoczność
    if (document.querySelector('#company').checked) {
        firmaDiv.style.display = 'block';
    } else {
        firmaDiv.style.display = 'none';
    }
});

function toggleUserData(checkbox) {
    const fields = ['first_name', 'last_name', 'email', 'country_code', 'phone_number'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (checkbox.checked) {
            field.removeAttribute('readonly');
            field.value = '';
        } else {
            field.setAttribute('readonly', 'readonly');
            if (field.dataset.defaultValue) {
                field.value = field.dataset.defaultValue;
            }
        }
    });
}

// Funkcja do obliczania ceny zbiorczej pojedynczego produktu
function calculateProductTotalPrice(price, quantity) {
    return price * quantity;
}

// Funkcja do obliczania ceny końcowej wszystkich produktów w koszyku
function calculateFinalPrice() {
    const productTotalPrices = document.querySelectorAll('.product-total-price');
    let finalPrice = 0;

    productTotalPrices.forEach((priceElement) => {
        finalPrice += parseFloat(priceElement.textContent);
    });

    return finalPrice.toFixed(2);
}

// Aktualizacja ceny zbiorczej dla każdego produktu
const itemQuantities = document.querySelectorAll('.item-quantity-select');
itemQuantities.forEach((quantitySelect) => {
    const priceElement = quantitySelect.closest('.koszyk-item').querySelector('.product-total-price');
    const price = parseFloat(quantitySelect.dataset.price);

    quantitySelect.addEventListener('change', () => {
        const inputField = quantitySelect.nextElementSibling;
        if (quantitySelect.value === 'other') {
            quantitySelect.style.display = 'inline-block';
            inputField.style.display = 'inline-block';
            inputField.focus();
        } else {
            inputField.style.display = 'none';
            inputField.value = 0;
            const quantity = parseInt(quantitySelect.value, 10);
            const productTotalPrice = calculateProductTotalPrice(price, quantity);
            priceElement.textContent = productTotalPrice.toFixed(2);

            // Aktualizacja ceny końcowej
            const finalPriceElement = document.getElementById('finalPrice');
            finalPriceElement.textContent = calculateFinalPrice();

            // Aktualizacja ilości w bazie danych
            let idServiceToOrder = quantitySelect.dataset.id;
            fetch(`update_quantity.php?id_service_to_order=${idServiceToOrder}&amount=${quantity}`)
            .then(response => {
                if (!response.ok)
                    throw new Error('Błąd podczas aktualizacji ilości');

                return response.json();
            })
            .then(data => console.log("Odpowiedź:", data))
            .catch(error => console.error("Błąd:", error));
        }
    });
});

// Obsługa pola tekstowego dla ilości
const itemQuantityInputs = document.querySelectorAll('.item-quantity-input');
itemQuantityInputs.forEach((inputField) => {
    const priceElement = inputField.closest('.koszyk-item').querySelector('.product-total-price');
    const price = parseFloat(inputField.dataset.price);

    inputField.addEventListener('input', () => {
        const quantity = parseInt(inputField.value, 10);
        if (!isNaN(quantity) && quantity > 0) {
            const productTotalPrice = calculateProductTotalPrice(price, quantity);
            priceElement.textContent = productTotalPrice.toFixed(2);

            // Aktualizacja ceny końcowej
            const finalPriceElement = document.getElementById('finalPrice');
            finalPriceElement.textContent = calculateFinalPrice();

            // Aktualizacja ilości w bazie danych
            let idServiceToOrder = inputField.dataset.id;
            fetch(`update_quantity.php?id_service_to_order=${idServiceToOrder}&amount=${quantity}`)
            .then(response => {
                if (!response.ok)
                    throw new Error('Błąd podczas aktualizacji ilości');

                return response.json();
            })
            .then(data => console.log("Odpowiedź:", data))
            .catch(error => console.error("Błąd:", error));
        }
    });
});

// Inicjalna aktualizacja ceny końcowej
document.addEventListener('DOMContentLoaded', () => {
    const finalPriceElement = document.getElementById('finalPrice');
    finalPriceElement.textContent = calculateFinalPrice();
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".item-quantity").forEach(select => {
        select.addEventListener("change", function () {
            let idServiceToOrder = this.dataset.id;  // Pobieranie ID usługi
            let newAmount = parseInt(this.value);   // Nowa ilość
            let price = parseFloat(this.dataset.price); // Cena jednostkowa
            
            if (isNaN(newAmount) || isNaN(price)) {
                console.error("Błąd: Nieprawidłowe dane wejściowe.");
                return;
            }

            let totalPriceElement = this.closest(".koszyk-item").querySelector(".product-total-price");
            totalPriceElement.textContent = (newAmount * price).toFixed(2);

            fetch(`update_quantity.php?id_service_to_order=${idServiceToOrder}&amount=${newAmount}`)
            .then(response => {
                if (!response.ok)
                    throw new Error('jakis wyjatek')

                return response
            })
            .then(data => console.log("Odpowiedź:", data))
            .catch(error => console.error("Błąd:", error));
        });
    });
});

const userPageLink = document.querySelector('.user-page-link');
const logoutButton = document.querySelector('.logout-button');

if (userPageLink && logoutButton) {
  userPageLink.addEventListener('mouseenter', () => {
    logoutButton.style.display = 'block';
  });

  userPageLink.addEventListener('mouseleave', () => {
    setTimeout(() => {
      if (!logoutButton.matches(':hover')) {
        logoutButton.style.display = 'none';
      }
    }, 300);
  });
}
document.addEventListener("DOMContentLoaded", () => {
    const algorithmFlow = document.querySelector(".algorithm-flow");
    const algorithmBoxes = document.querySelectorAll(".algorithm-box");
    let delay = 0;

    algorithmBoxes.forEach((box, index) => {
        // Animacja pojawiania się boxów
        setTimeout(() => {
            box.style.opacity = "1";
            box.style.transform = "scale(1)";

            // Dodanie animacji pisania tekstu dla title
            const title = document.createElement("div");
            title.classList.add("typing");
            title.textContent = box.dataset.title;
            box.appendChild(title);

            // Tworzenie boxa content
            const contentBox = document.createElement("div");
            contentBox.classList.add("algorithm-content");
            contentBox.innerHTML = box.dataset.content;
            contentBox.style.position = "absolute";
            contentBox.style.left = `${box.offsetLeft + box.offsetWidth + 40}px`; // Pozycjonowanie na prawo od boxa title
            contentBox.style.top = `${box.offsetTop - 10}px`; // Przesunięcie w górę o 10px
            algorithmFlow.appendChild(contentBox);

            // Dodanie strzałki poziomej
            const horizontalArrow = document.createElement("div");
            horizontalArrow.classList.add("algorithm-connector");
            horizontalArrow.style.position = "absolute";
            horizontalArrow.style.left = `${box.offsetLeft + box.offsetWidth}px`;
            horizontalArrow.style.top = `${box.offsetTop + box.offsetHeight / 2}px`; // Wyśrodkowanie w pionie
            horizontalArrow.style.width = `${contentBox.offsetLeft - (box.offsetLeft + box.offsetWidth)}px`;
            algorithmFlow.appendChild(horizontalArrow);

            setTimeout(() => {
                horizontalArrow.style.transform = "scaleX(1)";
            }, 500);

            // Dodanie strzałki pionowej
            if (index < algorithmBoxes.length - 1) {
                const verticalArrow = document.createElement("div");
                verticalArrow.classList.add("algorithm-connector-vertical");
                verticalArrow.style.position = "absolute";
                verticalArrow.style.left = `${box.offsetLeft + box.offsetWidth / 2 - 2}px`; // Wyśrodkowanie
                verticalArrow.style.top = `${box.offsetTop + box.offsetHeight}px`; // Dolna krawędź
                const nextBox = algorithmBoxes[index + 1];
                verticalArrow.style.height = `${nextBox.offsetTop - (box.offsetTop + box.offsetHeight)}px`;
                algorithmFlow.appendChild(verticalArrow);

                setTimeout(() => {
                    verticalArrow.style.transform = "scaleY(1)";
                }, 500);
            }

            // Animacja pojawiania się content boxa
            setTimeout(() => {
                contentBox.style.opacity = "1";
                contentBox.style.transform = "scale(1)";
            }, 1000);
        }, delay);

        delay += 3000; // Opóźnienie między kolejnymi boxami
    });

    // Obsługa kliknięcia na box title
    algorithmBoxes.forEach((box, index) => {
        box.addEventListener("click", () => {
            const contentBox = document.querySelectorAll(".algorithm-content")[index];
            const horizontalArrow = document.querySelectorAll(".algorithm-connector")[index];
            const verticalArrow = document.querySelectorAll(".algorithm-connector-vertical")[index];

            // Sprawdzenie stanu widoczności
            if (contentBox.style.opacity === "1") {
                // Ukrywanie elementów
                const contentText = contentBox.querySelector(".typing");
                if (contentText) {
                    contentText.style.animation = "deleteText 0.5s forwards";
                }

                setTimeout(() => {
                    contentBox.style.animation = "hideBox 0.5s forwards";
                }, 500);

                setTimeout(() => {
                    if (horizontalArrow) {
                        horizontalArrow.style.animation = "retractArrow 0.5s forwards";
                    }
                }, 1000);
            } else {
                // Pokazywanie elementów
                contentBox.style.animation = "showBox 0.5s forwards";

                setTimeout(() => {
                    if (horizontalArrow) {
                        horizontalArrow.style.animation = "extendArrow 0.5s forwards";
                    }
                }, 500);

                setTimeout(() => {
                    const contentText = contentBox.querySelector(".typing");
                    if (contentText) {
                        contentText.style.animation = "fadeInText 0.5s forwards";
                    }
                }, 1000);
            }
        });
    });
});