function generarInputNombre() {
    let div = $(".nombre");


    div.append("<br><input id='name'/>");

    let input= $("#name");

    input.attr({
        "type": "text",
        "class": "form-control {% if errors['userName'] %} has-error {% endif %}",
        "placeholder": "new name user",
        "name":"userName"
    });


}
function generarInputEmail() {
    let div = $(".email");


    div.append("<br><input id='email'/>");

    let input= $("#email");

    input.attr({
        "type": "email",
        "class": "form-control {% if errors['email'] %} has-error {% endif %}",
        "placeholder": "new email user",
        "name":"userEmail"
    });


}
function generarInputPass() {
    let div = $(".pass");


    div.append("<br><input id='pass1'/>");
    div.append("<br><input id='pass2'/>");

    let input1= $("#pass1");
    let input2= $("#pass2");

    input1.attr({
        "type": "password",
        "class": "form-control {% if errors['pass1'] %} has-error {% endif %}",
        "placeholder": "old password",
        "name":"pass1"
    });
    input2.attr({
        "type": "password",
        "class": "form-control {% if errors['pass2'] %} has-error {% endif %}",
        "placeholder": "new password",
        "name":"pass2"
    });
}