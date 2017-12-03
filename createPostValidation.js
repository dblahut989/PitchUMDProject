window.onsubmit=isDataValid;

function isDataValid() {
    let title = document.getElementById("title").value;
    let description = document.getElementById("content").value;

    let message = "";

    if (title === "") {
        message += "Enter the title.\n";
    }

    if (description === "") {
        message += "Description is empty. Please explain your idea.\n";
    }

    let isValid = promptMsg(message);
    if (isValid) {
        return true;
    } else {
        return false;
    }
}

function promptMsg(message) {
    if (message !== "") {
        alert(message);
        return false;
    } else {
        let confirmMsg = "Do you want to post?";

        if (window.confirm(confirmMsg)) {
            return true;
        }else {
            return false;
        }
    }
}