$("#equipmentLi").on("mouseenter", function() {
    if (window.innerWidth < 769) {
        setTimeout(function() {
            $("#equipment").css("display", "block");
        }),
            300;
    } else {
        $("#equipment").css("display", "block");
    }
});
$("#equipmentLi").on("mouseleave", function() {
    $("#equipment").css("display", "none");
});

$("#equipment").on("mouseenter", function() {
    $(this).css("display", "block");
});
$("#equipment").on("mouseleave", function() {
    $(this).css("display", "none");
});

$("#furnitureLi").on("mouseenter", function() {
    if (window.innerWidth < 769) {
        setTimeout(function() {
            $("#furniture").css("display", "block");
        }),
            300;
    } else {
        $("#furniture").css("display", "block");
    }
});
$("#furnitureLi").on("mouseleave", function() {
    $("#furniture").css("display", "none");
});

$("#furniture").on("mouseenter", function() {
    $(this).css("display", "block");
});
$("#furniture").on("mouseleave", function() {
    $(this).css("display", "none");
});

$("#accessoriesLi").on("mouseenter", function() {
    if (window.innerWidth < 769) {
        setTimeout(function() {
            $("#accessories").css("display", "block");
        }),
            300;
    } else {
        $("#accessories").css("display", "block");
    }
});
$("#accessoriesLi").on("mouseleave", function() {
    $("#accessories").css("display", "none");
});

$("#accessories").on("mouseenter", function() {
    $(this).css("display", "block");
});
$("#accessories").on("mouseleave", function() {
    $(this).css("display", "none");
});

// Zamykanie

$("#furnitureClose").on("click", function() {
    $("#furniture").css("display", "none");
});

$("#accessoriesClose").on("click", function() {
    $("#accessories").css("display", "none");
});
$("#equipmentClose").on("click", function() {
    $("#equipment").css("display", "none");
});
