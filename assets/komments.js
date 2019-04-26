function replyToComment(self) {
    document.querySelector('.komment-reply-indicator .komment-gravatar').innerHTML = '<img src="https://www.gravatar.com/avatar/' + self.dataset.gravatar + '?s=100" alt="gravatar">';
    document.querySelector('.komment-reply-indicator .komment-author').innerHTML = '@' + self.dataset.author;
    document.querySelector('#replyTo').value = self.dataset.slug;
}

window.onload = function () {
    [...document.querySelectorAll('.komment-reply')]
        .forEach(a => { a.onclick = function() { replyToComment(this) }; });
};