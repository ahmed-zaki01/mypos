// image preview
$(document).ready(function () {
    $('.delete').click(function (e) {
        //"use strict";
        e.preventDefault();
        // var that = $(this);

        var noty = new Noty({
            text: 'Are you sure you want to delete?',
            type: 'warning',
            layout: 'topRight',
            killer: true,
            buttons: [
                Noty.button('Yes', 'btn btn-success mr-2', function () {
                    $(this).closest('form').submit();
                }),
                Noty.button('No', 'btn btn-primary', function () {
                    noty.close();
                })
            ]
        });
        noty.show();
    });

    // end of image preview

    $(".img-input").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]); // convert to base64 string
        }
    });
});


// handle create order
$(document).ready(function () {
    // handle add product
    $(".add-product-btn").click(function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var name = $(this).data("name");
        var price = $(this).data("price");

        var orderListContent = `
            <tr>
                <td class="table-col">${name}</td>
                <td class="table-col"><input type="number" name="products[${id}][quantity]" data-price="${price}" class="quantity-input" min="1" value="1"></td>
                <td class="table-col product-price">${$.number(price, 2)}</td>
                <td class="table-col"><button class="btn btn-sm btn-danger delete-prod-btn" data-id="${id}"><i class="fa fa-trash"></i></button></td>
            </tr>
        `;

        $(".order-list").append(orderListContent);

        calculateTotalPrice();

        // disable button if clicked
        $(this).removeClass("btn-success").addClass("btn-default disabled");
    });

    // handle actions if delete button is clicked
    $("body").on("click", ".delete-prod-btn", function () {
        var id = $(this).data("id");

        $(this).closest("tr").remove();
        $("#product-" + id).removeClass("btn-default disabled").addClass("btn-success");
        calculateTotalPrice();
    });


    $('body').on('change keyup', '.quantity-input', function () {
        $unitPrice = Number($(this).data('price'));
        $quantity = Number($(this).val());
        $(this).closest('tr').find('.product-price').html($.number($unitPrice * $quantity, 2));
        calculateTotalPrice();
    });
});

$('.add-order').click(function () {
    alert("hello from add")
});

// calculate total price
function calculateTotalPrice() {
    var totalPrice = 0;
    $('.order-list .product-price').each(function () {
        totalPrice += parseFloat($(this).html().replace(/,/g, ''));
    });

    if (totalPrice > 0) {
        $('#add-order-btn').removeClass('disabled');
    } else {
        $('#add-order-btn').addClass('disabled');
    }

    $('.total-price').html($.number(totalPrice, 2));
}
