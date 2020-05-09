window.onload = function () {
    const komment = document.querySelector('#kommentform #komment')
    const kommentEmail = document.querySelector('#kommentform #email')
    const kommentAuthor = document.querySelector('#kommentform #author')
    const kommentUrl = document.querySelector('#kommentform #author_url')
    const timeField = document.querySelector('#kommentform .cts')
    const submitField = document.querySelector('#kommentform input[type=submit]')
    const spamIndicatorProgress = document.querySelector('#kommentform .spam-indicator .progress')

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

    kommentEmail.style.display = 'none';
    kommentAuthor.style.display = 'none';
    kommentUrl.style.display = 'none';

    komment.addEventListener('focus', () => {
        setIndicator();
        kommentEmail.style.display = 'block';
        kommentAuthor.style.display = 'block';
        kommentUrl.style.display = 'block';
    });

};