const contactForm = document.querySelector('#contact-form');
const searchForClientsForm = document.querySelector('#search-for-clients-form');

// Функция добавления клиента
contactForm.addEventListener('submit', (event) => {

    event.preventDefault();

    const sourceID = document.querySelector('#contact-source-id').value;

    let name = document.querySelector('#contact-name');
    let phone = document.querySelector('#contact-phone');
    let email = document.querySelector('#contact-email');

    let contactMessageBlock = document.querySelector('#contact-message-block');

    let out = '';

    const ajax = async () => {
        const response = await fetch('php/add_client.php', {
            method: 'POST',
            body: new FormData(contactForm),
        });

        if (!response.ok) {
            throw new Error(response.status);
        } else {
            const data = await response.json();

            const responseDataArray = [];

            for (const value of data) {
                switch (value) {
                    case 'error-empty-fields':
                        responseDataArray.push('<p class="failed-message-sending"><strong>*Пожалуйста, заполните все поля формы!</strong></p>');
                        break;
                    case 'error-name':
                        responseDataArray.push('<p class="failed-message-sending"><strong>*Пожалуйста, введите правильное имя пользователя от 2 до 50 букв на кириллице!</strong></p>');
                        break;
                    case 'error-phone':
                        responseDataArray.push('<p class="failed-message-sending"><strong>*Пожалуйста, введите правильный номер телефона пользователя в формате +77777777777</strong></p>');
                        break;
                    case 'error-email':
                        responseDataArray.push('<p class="failed-message-sending"><strong>*Пожалуйста, введите корректный адрес электронной почты!</strong></p>');
                        break;
                    case 'error-once-a-day':
                        responseDataArray.push(`<p class="failed-message-sending"><strong>*Данные для источника контактов id: ${sourceID} можно будет добавить только на следующий день!</strong></p>`);
                        break;
                    case 'successfully':
                        responseDataArray.push('<p class="successful-message-sending"><strong>Контакт добавлен!</p>');
                        name.value = '';
                        phone.value = '';
                        email.value = '';
                        break;
                }
            }
            for (let i = 0; i < responseDataArray.length; i++) {
                out += responseDataArray[i];
            }

            contactMessageBlock.innerHTML = out;
        }
    };
    ajax()
        .catch(error => (contactMessageBlock.innerHTML = `<p class="failed-message-sending"><strong>${error}</strong></p>`));
    setTimeout(() => {
        contactMessageBlock.innerHTML = '';
    }, 3000)

});

// Функция поиска клиентов по номеру телефону
searchForClientsForm.addEventListener('keyup', () => {

    let searchForClientsFormList = document.querySelector('#search-for-clients-by-phone-list');

    let searchForClientsByPhoneMessageBlock = document.querySelector('#search-for-clients-by-phone-message-block');

    let out = '';

    searchForClientsFormList.innerHTML = ``;

    const ajax = async () => {
        const response = await fetch('php/search_client_list.php', {
            method: 'POST',
            body: new FormData(searchForClientsForm),
        });

        if (!response.ok) {
            throw new Error(response.status);
        } else {
            const data = await response.json();

            const responseDataArray = [];

            for (const value of data) {
                switch (value) {
                    case 'error-empty-fields':
                        responseDataArray.push('<p class="failed-message-sending"><strong>*Введена пустая строка!</strong></p>');
                        break;
                    case 'nothing-found':
                        responseDataArray.push(`<p class="failed-message-sending"><strong>*По вашему запросу ниего не найдено!</strong></p>`);
                        break;
                    default:
                        out += `<div class="col-lg-12"><div class="card border border-dark p-3 mt-3"><p class="text-left mt-3"><a href="contacts.php?phone=${value.phone}" target="_blank">${value.phone}</a></p><div class="dropdown-divider" style="border-bottom: 2px dashed rgba(0,0,0,.5) !important;"></div></div></div>`;
                        break;
                }
            }
            for (let i = 0; i < responseDataArray.length; i++) {
                out += responseDataArray[i];
            }
            searchForClientsByPhoneMessageBlock.innerHTML = out;
        }
    };
    ajax()
        .catch(error => (searchForClientsByPhoneMessageBlock.innerHTML = `<p class="failed-message-sending"><strong>${error}</strong></p>`));
});