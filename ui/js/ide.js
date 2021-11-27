let editor;

window.onload = function () {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/c_cpp");
}

function changeLanguage() {
    let language = $("#languages").val();
    switch (language) {
        case 'c' || 'cpp': {
            editor.session.setMode("ace/mode/c_cpp")
            break;
        }
        case 'php': {
            editor.session.setMode("ace/mode/php")
            break;
        }
        case 'python': {
            editor.session.setMode("ace/mode/python")
            break;
        }
        case 'node': {
            editor.session.setMode("ace/mode/javascript")
            break;
        }
    }
}

function executeCode() {
    // noinspection JSUnresolvedVariable
    const instance = axios.create({
        baseURL: "http://127.0.0.1/WorkStation/online-ide/app",
    });

    const formDate = new FormData();
    formDate.append('language', $("#languages").val())
    formDate.append('code', editor.getSession().getValue())
    instance.post('/compiler.php', formDate)
        .then(({data, status}) => {
            $(".output").text(data)
        })
        .catch((error) => {
            console.log(error);
        })
}
