function handleOnline() {
    $("#connectionText").text("Back online"), $("#bottomSheetInternet").css("background", "#0ab30a"), $(
        "#bottomSheetInternet").css("transform", "translateY(0)"), setTimeout(() => {
            $("#bottomSheetInternet").css("transform", "translateY(100%)")
        }, 2500)
}

function handleOffline() {
    $("#connectionText").text("No internet connection!"), $("#bottomSheetInternet").css("background", "red"), $(
        "#bottomSheetInternet").css("transform", "translateY(0)"), setTimeout(() => {
            $("#bottomSheetInternet").css("transform", "translateY(100%)")
        }, 2500)
}
$(window).on("online", function () {
    handleOnline()
}), $(window).on("offline", function () {
    handleOffline()
}), $(document).ready(function () {
    localStorage.getItem("show_user_details") || ($("#bottomSheet").css("transform", "translateY(0)"), $(
        "#overlay").show()), $(".openSheetBtn").click(function () {
            $("#bottomSheet").css("transform", "translateY(0)"), $("#overlay").show()
        }), $("#closeSheetBtn, #overlay").click(function () {
            $("#bottomSheet").css("transform", "translateY(100%)"), $("#overlay").hide()
        })
}), $.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
}), $(".cat_navigation").on("change", function (t) {
    var e = $(this);
    $("html, body").animate({
        scrollTop: $("#" + e.val()).offset().top
    }, 2e3)
}), $(document).ready(function () {
    $("#myModal").on("show", function () {
        $("body").addClass("modal-open")
    }).on("hidden", function () {
        $("body").removeClass("modal-open")
    }), $("#cart_btn").on("click", function (t) {
        $.post("/getcartmodaldata", {}, function (t) {
            $("#cart_modal .modal-body").html(t)
        }), $("#cart_modal").modal("show")
    }), $("#order_btn").on("click", function (t) {
        $.post("/getordermodaldata", {
            table_id: mtable_id
        }, function (t) {
            $("#order_modal .modal-body").html(t)
        }), $("#order_modal").modal("show")
    }), $(".add_to_cart").on("click", function (t) {
        if (!navigator.onLine) return handleOffline(), !1;
        var e = {
            itemId: $(this).attr("data-itemId")
        };
        $.post("/addtocart", e, function (t) {
            var e = t;
            "success" == e.status && $(".bottom_cart_amount").html(
                mcurrency + e.cart_amount).show(),
                Swal.fire({
                    position: "top-end",
                    icon: e.status,
                    title: e.msg,
                    showConfirmButton: !1,
                    timer: 1500
                })
            $("#cart_btn").removeClass('cart-zoom-down');
            $("#cart_btn").addClass('cart-zoom-up');
            setTimeout(() => {
                $("#cart_btn").removeClass('cart-zoom-up');
            }, 1000);
        })
    }), $(document).on("click", ".remove_from_cart", function (t) {
        if (!navigator.onLine) return swal("Error", "Please connect internet!", "error"), !1;
        t.preventDefault(), $this = $(this);
        var e = {
            itemId: $(this).attr("data-itemId")
        };
        $.post("/removecart", e, function (t) {
            var e = t;
            "success" == e.status && ($this.parent().parent().parent().parent().remove(), e
                .cart_amount.length > 1 ? $(".bottom_cart_amount").html(e.cart_amount)
                    .show() : $(".bottom_cart_amount").html("").hide()), Swal.fire({
                        position: "top-end",
                        icon: e.status,
                        title: e.msg,
                        showConfirmButton: !1,
                        timer: 1500
                    })
        })
    }), $("#place_order_form").on("submit", function (t) {
        if (!navigator.onLine) return swal("Error", "Please connect internet!", "error"), !1;
        t.preventDefault();
        var e = ($this = $(this)).serialize();
        $.post("/placeorder", e, function (t) {
            var e = t;
            Swal.fire({
                position: "top-end",
                icon: e.status,
                title: e.msg,
                showConfirmButton: !1,
                timer: 1500
            }), "success" == e.status && setTimeout(function () {
                location.reload(!1)
            }, 1500)
        })
    }), $("#addUserInfo").on("submit", function (t) {
        t.preventDefault();
        var e = $(this);
        $.post("/adduserinfo", e.serialize(), function (t, e) {
            Swal.fire({
                title: t.msg,
                icon: t.status,
                showConfirmButton: !1,
                timer: 2e3
            }), "success" == t.status && (localStorage.setItem("show_user_details", !0),
                $("#bottomSheet").css("transform", "translateY(100%)"), $("#overlay")
                    .hide())
        })
    })
});
var menu_position, menu_bar = document.querySelector(".sc-bottom-bar"),
    menu_item = document.querySelectorAll(".sc-menu-item"),
    menu_indicator = document.querySelector(".sc-nav-indicator"),
    menu_current_item = document.querySelector(".sc-current");
menu_position = menu_current_item.offsetLeft - 16, menu_indicator.style.left = menu_position + "px", menu_bar.style
    .backgroundPosition = menu_position - 8 + "px";