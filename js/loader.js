let clickableDivs = document.querySelectorAll('.clickable-div');
clickableDivs.forEach(function(div) {
    div.addEventListener('click', function() {
        // grabs the id from the attribute placed in each div
        let id = this.getAttribute('data-id');
        // checks if the access is currently for a nest or note
        let destinationUrl = this.classList.contains('nest') ? 'nestedit.php?id=' : 'noteedit.php?id=';
        destinationUrl += id;
        window.location.href = destinationUrl;
    });
});