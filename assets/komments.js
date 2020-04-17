window.onload = function () {

    const komment = document.querySelector('#kommentform #komment')
    const kommentEmail = document.querySelector('#kommentform #email')
    const kommentAuthor = document.querySelector('#kommentform #author')
    const kommentUrl = document.querySelector('#kommentform #author_url')
    const timeField = document.querySelector('#kommentform .cts')
    const submitField = document.querySelector('#kommentform input[type=submit]')
    const spamIndicatorProgress = document.querySelector('#kommentform .spam-indicator .progress')

    let duration = {
        start: 0,
        end: 0,
        indicator: 0,
        timer: null
    }

    const setIndicator = () => {

        if (duration.indicator > 0) {
            return
        }

        submitField.disabled = true;

        duration.timer = window.setInterval(() => {
            duration.indicator += 10;
            spamIndicatorProgress.style.width = `${duration.indicator}%`

            // TODO
            if (duration.indicator > 25) {
                spamIndicatorProgress.style.background = 'orange'
            }

            if (duration.indicator > 50) {
                spamIndicatorProgress.style.background = 'yellowgreen'
            }

            if (duration.indicator > 75) {
                spamIndicatorProgress.style.background = 'green'
            }

            if (duration.indicator >= 100) {
                spamIndicatorProgress.style.background = 'green'
                spamIndicatorProgress.style.height = '0';
                submitField.disabled = false;

                duration.end = Math.round(Date.now() / 1000);
                timeField.value = duration.end - duration.start

                window.clearInterval(duration.timer)
            }
        }, 1000)
    }

    kommentEmail.style.display = 'none';
    kommentAuthor.style.display = 'none';
    kommentUrl.style.display = 'none';

    komment.addEventListener('focus', () => {
        duration.start = Math.round(Date.now() / 1000);
        setIndicator();
        kommentEmail.style.display = 'block';
        kommentAuthor.style.display = 'block';
        kommentUrl.style.display = 'block';
    });

};