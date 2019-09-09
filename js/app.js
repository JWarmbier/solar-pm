/*Login or Registration Form Submit*/
$(document).ready(function() {
    $("#login_form, #registration_form").submit(function (e) {
        e.preventDefault();
        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    window.location.href = "./";
                }
            }
        });
    });
});

$(document).ready(function() {
    $("#update_profile_form").submit(function (e) {
        e.preventDefault();
        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    $('#successModal').modal('show');
                }
            }
        });
    });
});

$(document).ready(function() {
    $("#password_form").submit(function (e) {
        e.preventDefault();
        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    $('#successPassword').modal('show');
                }
            }
        });
    });
});

$(document).ready(function() {
    $("#new-project-form").submit(function (e) {
        e.preventDefault();

        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    window.location.href = "new-project.php?action=success";
                }
            }
        });
    });
});

$(document).ready(function() {
    $("#new-element-form").submit(function (e) {
        e.preventDefault();

        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    window.location.href = "list-of-elements.php";
                }
            }
        });
    });
});

$(document).ready(function() {
    $("#edit-element-form").submit(function (e) {
        e.preventDefault();

        var obj = $(this), action = obj.attr('name'); /*Define variables*/
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&Action=" + action,
            cache: false,
            success: function (JSON) {
                if (JSON.error != '') {
                    $("#" + action + " #display_error").show().html(JSON.error);
                } else {
                    window.location.href = "list-of-elements.php";
                }
            }
        });
    });
});

$("#amount").keyup(function (e){
    var val = $(this).val();

    if(val.length == 0  || (!isNaN(val) && val.length > 0) ){
        $("#amount_error").hide();
        if(!Number.isInteger(Number(val))){
            $("#amount_error").show();
        }
    } else if (isNaN(val)){
        $("#amount_error").show();
    }
});

$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#btnOkUpdate, #btnOkPassword").click(function(e){
   e.preventDefault();
    window.location.href = "./my-account.php";
});
$("#btn-add-person").click(function(e){
    var handler = document.getElementById("select-person");
    var list = document.getElementById('team-project-list');
    var person = handler.options[handler.selectedIndex];

    var liNode = document.createElement("li");
    var inputNode = document.createElement("input");

    inputNode.type = "hidden";
    inputNode.name = "coworker[]";
    inputNode.value = person.value;

    liNode.classList.add("list-group-item");
    liNode.innerHTML = person.innerHTML;

    liNode.appendChild(inputNode);

    list.appendChild(liNode);

    person.remove();

    $('#new-person').modal('hide');
});