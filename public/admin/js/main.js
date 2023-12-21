$(document).on("submit", "#form-change-password", function (e) {
    e.preventDefault();
    $("#password-change").removeClass("is-invalid");
    $("#confirm-password-change").removeClass("is-invalid");

    let password = $("#password-change").val();
    let confirm_password = $("#confirm-password-change").val();

    if (password != confirm_password) {
        $("#form-change-password").removeClass("was-validated");
        $("#password-change").addClass("is-invalid");
        $("#confirm-password-change").addClass("is-invalid");
        $("#confirm-password-change").next().text("Mật khẩu không trùng khớp!");
    } else if (password.length < 6 || confirm_password.length < 6) {
        $("#form-change-password").removeClass("was-validated");
        $("#password-change").addClass("is-invalid");
        $("#confirm-password-change").addClass("is-invalid");
        $("#confirm-password-change").next().text("Mật khẩu ít nhất 6 kí tự!");
    } else {
        $.ajax({
            url: "{{URL::to('/admin/change-password')}}",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                password,
            },
            success: function (data) {
                if (data.status == 200) {
                    $("#modal-change-password").modal("hide");
                    $("#password-change").val("");
                    $("#confirm-password-change").val("");
                    $("#confirm-password-change")
                        .next()
                        .text("Vui lòng nhập lại mật khẩu!");
                    show_alert(
                        '<i class="fa-solid fa-circle-check"></i>',
                        data.message,
                        "success"
                    );
                }
            },
            error: function (data) {
                console.log(data);
            },
        });
    }
});

function formattedTime(time) {
    return moment.utc(time).local().format("DD/MM/YYYY HH:mm");
}

function set_pagination(data) {
    $(".pagination").empty();
    $(".pagination").append(`
        ${
            data.current_page != 1
                ? `<li class="page-item"><a class="page-link" href="${data.prev_page_url}"><span aria-hidden="true">&laquo;</span></a></li>`
                : ""
        }

        ${data.links
            .slice(1, -1)
            .map(
                (value) =>
                    `<li class="page-item ${
                        value.active ? "active" : ""
                    }"><a class="page-link" href="${value.url}">${
                        value.label
                    }</a></li>`
            )
            .join("")}
                 
        ${
            data.current_page != data.last_page
                ? `<li class="page-item"><a class="page-link" href="${data.next_page_url}">  <span aria-hidden="true">&raquo;</span></a></li>`
                : ""
        }
    `);
}

function format_currency(currency) {
    return parseFloat(currency).toLocaleString("it-IT", {
        style: "currency",
        currency: "VND",
    });
}

function convert_to_slug(name, slug) {
    $(name).keyup(function () {
        let convertedString = $(this)
            .val()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
        convertedString = convertedString.replace(/\s+/g, "-").toLowerCase();
        $(slug).val(convertedString);
    });
}

function show_modal_confirm_delete(
    title,
    data_name,
    data_id,
    data_class = "single"
) {
    $("#modal-title-confirm-delete").text(title);
    $("#btn-submit-confirm-delete").attr(data_name, data_id);
    $("#btn-submit-confirm-delete").attr("data-class", data_class);
    $("#modal-confirm-delete").modal("show");
}

let isAlertShowing = false;

function show_alert(icon, message, type) {
    if (isAlertShowing) {
        isAlertShowing = false;
        $(".alert-container").hide();
        $(".alert-container").removeClass("show-animation");
        $(".alert-container").removeClass("hide-animation");
        show_alert(icon, message, type);
        return;
    }

    isAlertShowing = true;

    $(".alert-container").empty();
    $(".alert-container").append(
        `<div class="alert alert-${type} d-flex align-items-center" role="alert">
            ${icon}
            <div>${message}</div>
        </div>`
    );

    $(".alert-container").show();
    $(".alert-container").addClass("show-animation");

    setTimeout(function () {
        $(".alert-container").removeClass("show-animation");
        $(".alert-container").addClass("hide-animation");
        setTimeout(function () {
            $(".alert-container").hide();
            $(".alert-container").removeClass("hide-animation");
            isAlertShowing = false;
        }, 1000);
    }, 2500);
}
