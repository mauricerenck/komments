window.onload = function () {
    const komment = document.querySelector('#kommentform #komment')
    const kommentForm = document.querySelector('#kommentform')
    const kommentEmail = document.querySelector('#kommentform #email')
    const kommentAuthor = document.querySelector('#kommentform #author')
    const kommentUrl = document.querySelector('#kommentform #author_url')
    const timeField = document.querySelector('#kommentform .cts')
    const submitField = document.querySelector('#kommentform input[type=submit]')
    const spamIndicatorProgress = document.querySelector('#kommentform .spam-indicator .progress')
    const sendingIndicator = document.querySelector('#kommentform .loader')
    const formFeedback = document.querySelector('#kommentform .form-feedback')

    let duration = {
        indicator: 0,
        timer: null,
        current: 0
    }

    const setIndicator = () => {

        if (duration.current > 0) {
            return
        }

        timeField.value = 0;
        submitField.disabled = true;

        duration.timer = window.setInterval(() => {
            duration.indicator += 10;
            spamIndicatorProgress.style.width = `${duration.indicator}%`

            if (duration.indicator > 25) {
                spamIndicatorProgress.classList.add('orange')
            }

            if (duration.indicator > 50) {
                spamIndicatorProgress.classList.add('yellow')
            }

            if (duration.indicator > 75) {
                spamIndicatorProgress.classList.add('green')
            }

            if (duration.indicator >= 100) {
                spamIndicatorProgress.classList.add('done')
                submitField.disabled = false;

                window.clearInterval(duration.timer)
            }

            duration.current++;
            timeField.value = duration.current
        }, 1000)
    }


    const sendKomment = (event) => {
        if (!kommentForm) {
            return true
        }
        event.preventDefault();

        const kommentFormAction = kommentForm.action;
        sendingIndicator.classList.remove('loading-invisible');

        window.fetch(kommentFormAction, {
            method: 'post',
            headers: { 'Content-Type': 'application/json', 'X-Return-Type': 'json' },
            body: JSON.stringify(Object.fromEntries(new FormData(event.target))),
        })
            .then(function (response) {
                sendingIndicator.classList.add('loading-invisible');
                if (!response.ok) {
                    throw response;
                }

                return response;
            })
            .then((response) => {
                response.json().then(message => {
                    formFeedback.classList.remove('error')
                    formFeedback.classList.add('moderation-note')
                    formFeedback.innerHTML = message.message
                    kommentForm.reset();
                })
            })
            .catch((error) => {
                error.json().then(error => {
                    formFeedback.classList.add('error')
                    formFeedback.classList.remove('moderation-note')
                    formFeedback.innerHTML = error.message

                })
            })
    }

    kommentEmail.style.display = 'none';
    kommentAuthor.style.display = 'none';
    kommentUrl.style.display = 'none';

    komment.addEventListener('focus', () => {
        setIndicator();
        kommentEmail.style.display = 'block';
        kommentAuthor.style.display = 'block';
        kommentUrl.style.display = 'block';
    });

    kommentForm.addEventListener('submit', (event) => {
        sendKomment(event);
    });

};