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

$(document).ready(function() {
    $("#update-project-form").submit(function (e) {
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
                    window.location.href = "my-projects.php";
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
    var btn = document.createElement("button");
    var pTag = document.createElement("p");

    btn.type = "button";
    btn.classList.add("btn");
    btn.value = person.value;
    btn.innerHTML = "Usuń";
    btn.classList.add("btn");
    btn.classList.add("btn-primary");
    btn.classList.add("btn-sm");
    btn.classList.add("float-right");
    btn.classList.add("btn-remove-person");
    btn.addEventListener("click",btnRemovePerson);

    pTag.id = "p-coworker-id-" + person.value;
    pTag.innerHTML = person.innerHTML;
    pTag.classList.add("float-left");

    inputNode.type = "hidden";
    inputNode.name = "coworker[]";
    inputNode.value = person.value;

    liNode.id = "li-coworker-id-" + person.value;
    liNode.classList.add("list-group-item");

    liNode.appendChild(pTag);
    liNode.appendChild(inputNode);
    liNode.appendChild(btn);

    list.appendChild(liNode);

    person.remove();

    $('#new-person').modal('hide');
});

$(".btn-remove-person").click(btnRemovePerson);


function btnRemovePerson(e){
    var li = document.getElementById("li-coworker-id-"+$(this).val());
    var p = document.getElementById("p-coworker-id-"+$(this).val());
    var selectList = document.getElementById("select-person");

    var option = document.createElement("option");
    option.value = $(this).val();
    option.innerHTML = p.innerHTML;

    selectList.appendChild(option);
    li.remove();
}

$(document).ready(function() {
    showElement();

});
$(document).ready(function(){
    $('#select-element').on("change", showElement);
});

function showElement(){
    $('.div-element').hide();
    var el = $("#select-element").children("option:selected").val();
    $('#element-id-' + el).show();
}


$("#btn-add-element").click(function (e) {
    var table = document.getElementById("table-list-of-elements");
    var id = $("#select-element").children("option:selected").val();
    var element = document.getElementById("element-id-" + id);

    var name = element.querySelector("#name").value;
    var parameter = element.querySelector("#parameter").value;
    var amount = element.querySelector("#amount").value;
    var category = element.querySelector("#category").value;
    var datasheet = element.querySelector("#datasheet").value;

    var tr = document.createElement("tr");
    var tdName = document.createElement("td");
    tdName.innerHTML = name;
    var tdParameter = document.createElement("td");
    tdParameter.innerHTML = parameter;
    var tdAmount = document.createElement("td");
    tdAmount.innerHTML = amount;
    var tdCategory = document.createElement("td");
    tdCategory.innerHTML = category;
    var tdDatasheet = document.createElement("td");
    var aDatasheet = document.createElement("a");
    aDatasheet.href = datasheet;
    aDatasheet.classList.add("btn");
    aDatasheet.classList.add("btn-primary");
    aDatasheet.classList.add("btn-sm");
    aDatasheet.innerHTML = "Dokumentacja";
    tdDatasheet.appendChild(aDatasheet);
    var tdZapotrzebowanie = document.createElement("td");
    var inputID = document.createElement("input");
    inputID.type = "hidden";
    inputID.value = id;
    inputID.name = "elements[]";
    var inputAmount = document.createElement("input");
    inputAmount.name = "amountOfElements[]";
    inputAmount.type = "number";
    inputAmount.value = 0;
    inputAmount.min = 0;
    inputAmount.pattern = "^[0-9]";
    tdZapotrzebowanie.appendChild(inputID);
    tdZapotrzebowanie.appendChild(inputAmount);


    tr.appendChild(tdName);
    tr.appendChild(tdParameter);
    tr.appendChild(tdAmount);
    tr.appendChild(tdCategory);
    tr.appendChild(tdDatasheet);
    tr.appendChild(tdZapotrzebowanie);

    table.appendChild(tr);
    element.remove();
    $("#select-element").children("option:selected").remove();
    showElement();
});