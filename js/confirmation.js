function submitConfirm() {
    let title = document.getElementById('note').value;
    let text  = document.getElementById('note-text').value;
    let nestgroup = document.getElementById('nestgroup').value;
    let categ = document.getElementById('note-categ').value;

    let result = confirm("Are you sure you want to proceed with these changes: \n" +
        "Title: " + title + "\n" +
        "Text: " + text + "\n" +
        "Nest Group: " + (nestgroup === "" ? "None" : nestgroup) + "\n" +
        "Category: " + categ);

    if(result) {
        document.getElementById("noteForm").submit();
    } else {
        return false;
    }
}

function submitNestConfirm() {
    let title = document.getElementById('nest').value;
    let text  = document.getElementById('nest-text').value;

    let result = confirm("Are you sure you want to proceed with these changes: \n" +
        "Nest Title: " + title + "\n" +
        "Nest Description: " + text + "\n");

    if(result) {
        document.getElementById("nestForm").submit();
    } else {
        return false;
    }
}
