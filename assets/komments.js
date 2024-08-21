function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        // call on next available tick
        setTimeout(fn, 1)
    } else {
        document.addEventListener('DOMContentLoaded', fn)
    }
}

docReady(function () {
    kommentFormInit()
    replyLinksInit()
})

const kommentFormInit = () => {
    const kommentForm = document.querySelector('#kommentform')

    if (!kommentForm) {
        console.error('Komment form not found')
        return
    }

    const kommentFormLoader = kommentForm.querySelector('.loader')
    const kommentFormMsg = kommentForm.querySelector('.user-feedback')

    kommentForm.addEventListener('submit', (event) => {
        event.preventDefault()
        const formAction = kommentForm.action

        kommentFormLoader.classList.add('visible')
        kommentFormMsg.classList.remove('msg-error')
        kommentFormMsg.classList.remove('msg-success')
        kommentFormMsg.classList.remove('visible')

        fetch(formAction, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Return-Type': 'json' },
            body: JSON.stringify(Object.fromEntries(new FormData(event.target))),
        })
            .then(function (response) {
                kommentFormLoader.classList.remove('visible')

                if (response.status !== 200) {
                    throw response
                }

                return response.json()
            })
            .then((response) => {
                kommentFormMsg.innerHTML = `<p>${response.message}</p>`
                kommentFormMsg.classList.add('msg-success')
                kommentFormMsg.classList.add('visible')
                kommentForm.reset()
            })
            .catch((response) => {
                const error = response.json()
                const message = error.message || 'An error occurred'

                kommentFormMsg.innerHTML = `<p>${message}</p>`
                kommentFormMsg.classList.add('msg-error')
                kommentFormMsg.classList.add('visible')
            })
    })
}

const replyLinksInit = () => {
    const replyLinks = document.querySelectorAll('.kommentReply')
    const formReplyTo = document.querySelector('#kommentform input[name=replyTo]')
    const formReplyHandle = document.querySelector('#kommentform input[name=replyHandle]')
    const formReplyHandleDisplay = document.querySelector('#kommentform .replyHandleDisplay')

    if (!replyLinks || !formReplyTo || !formReplyHandle || !formReplyHandleDisplay) {
        return
    }

    replyLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const kommentId = event.target.dataset.id
            const kommentHandle = event.target.dataset.handle

            formReplyTo.value = kommentId
            formReplyHandle.value = kommentHandle
            formReplyHandleDisplay.innerHTML = `<a href="#komment_${kommentId}">@${kommentHandle}</a>`
        })
    })
}
