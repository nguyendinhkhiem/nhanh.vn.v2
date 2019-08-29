/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // const files = require.context('./', true, /\.vue$/i);
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// const app = new Vue({
//     el: '#app',
// });

$(document).ready(function() {
    $('#create-info').submit(function(e) {
        e.preventDefault();
        $('.loading').addClass('active')
        var pick_name = $(this).find('#pick_name').val();
        var pick_address = $(this).find('#pick_address').val();
        var pick_province = $(this).find('#pick_province').val();
        var pick_district = $(this).find('#pick_district').val();
        var pick_ward = $(this).find('#pick_ward').val();
        var pick_street = $(this).find('#pick_street').val();
        var pick_tel = $(this).find('#pick_tel').val();
        var pick_email = $(this).find('#pick_email').val();

        var data = {
            'pick_name': pick_name,
            'pick_address': pick_address,
            'pick_province': pick_province,
            'pick_district': pick_district,
            'pick_ward': pick_ward,
            'pick_street': pick_street,
            'pick_tel': pick_tel,
            'pick_email': pick_email
        }

        window.axios.post('/create-info', {
                params: data
            })
            .then(function(response) {
                if (response.status == 200) {
                    window.location.href = window.location.href
                }
            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .finally(function() {
                // always executed
            });
    })

    $('.choice_type_search .list .item').click(function() {
        var type = $(this).attr('data-type');
        var text = $(this).text();
        var inpuType = $(this).closest('.choice_type_search').find('#type_serch_input')

        inpuType.val(type);
        $(this).closest('.choice_type_search').find('.type_current_order .name').html(text);

        $(this).closest('.choice_type_search').removeClass('gt_active')
    });

    $('.type_current_order').click(function(e) {
        e.preventDefault();

        if ($(this).closest('.choice_type_search').hasClass('gt_active')) {
            $(this).closest('.choice_type_search').removeClass('gt_active')
        } else {
            $(this).closest('.choice_type_search').addClass('gt_active');
        }
    })

    $('.response_search').css({
        'display': 'none'
    })

    $('#search_order').submit(function(e) {
        e.preventDefault();
        $('.loading').addClass('active')
        var type = $(this).find('#type_serch_input').val();
        var input = $(this).find('#search_order_input').val();


        if (input.length > 0) {
            window.axios.get('/search-orders', {
                    params: {
                        type: type,
                        value: input
                    }
                })
                .then(function(response) {
                    if (response.data && response.data.length > 0) {
                        var htmlItem = '';
                        for (var i = 0; i < response.data.length; i++) {
                            var item = response.data[i];
                            if (item.order && item.order.length > 0) {
                                for (var iOrder = 0; iOrder < item.order.length; iOrder++) {
                                    var itemOrder = item.order[iOrder]
                                    htmlItem += '<tr class="item">';
                                    htmlItem += '<th scope="row"><input class="item-order-nhanh" type="checkbox" name="order_id_nhanh" data-idNhanh="' + itemOrder.id_nhanhvn + '" data-status="' + itemOrder.statusCode + '"></th>';
                                    htmlItem += '<td>' + (i + 1) + '</td>';
                                    htmlItem += '<td>' + itemOrder.id_nhanhvn + '</td>';
                                    htmlItem += '<td>' + itemOrder.createdDateTime + '</td>';
                                    htmlItem += '<td>' + itemOrder.customerName + '</td>';
                                    htmlItem += '<td>' + itemOrder.customerMobile + '</td>';
                                    htmlItem += '<td>' + itemOrder.statusName + '</td>';
                                    try {
                                        if (itemOrder.products) {
                                            var productJson = JSON.parse(itemOrder.products);
                                            if (productJson && productJson.length > 0) {
                                                var nameProducts = '';
                                                for (var iPrd = 0; iPrd < productJson.length; iPrd++) {
                                                    var product = productJson[iPrd];
                                                    if (iPrd > 0) {
                                                        nameProducts += '<br> ' + product.name;
                                                    } else {
                                                        nameProducts += product.name;
                                                    }
                                                }
                                                htmlItem += '<td>' + nameProducts + '</td>';
                                            } else {
                                                htmlItem += '<td>Lỗi hiển thị</td>';
                                            }
                                        }
                                    } catch (e) {
                                        htmlItem += '<td>Lỗi hiển thị</td>';
                                    }
                                    htmlItem += '<td>' + itemOrder.calcTotalMoney + '</td>';
                                    if (item.status == "CONTAIN_DB") {
                                        htmlItem += '<td>Đã có trong hệ thống</td>';
                                    }

                                    if (item.status == "GET_NHANH.VN") {
                                        htmlItem += '<td>Clone Nhanh.vn</td>';
                                    }
                                    htmlItem += '</tr>';
                                }

                                $('#list_order_search ').html(htmlItem)
                                $('.response_search').css({
                                    'display': 'block'
                                })

                            }
                        }
                        $('.loading').removeClass('active')
                    }
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        } else {
            if (type == 'handoverId') {
                alert('Bạn hãy nhập ID Biên bản bàn giao');
                $('.loading').removeClass('active')
            }

            if (type == 'id') {
                alert('Bạn hãy nhập ID Đơn Hàng');
                $('.loading').removeClass('active')
            }

            if (type == 'customerMobile') {
                alert('Bạn hãy nhập Số Điện Thoại Khách Hàng')
                $('.loading').removeClass('active')
            }
        }
    })


    var array_id_nhanh = [];
    $('.item-order-nhanh').click(function(e) {
        var id_nhanh = $(this).attr('data-idnhanh');
        var statusCode = $(this).attr('data-status');

        if ($(this).is(":checked") == true) {
            if (statusCode != 'SoldOut') {
                array_id_nhanh.push(id_nhanh)
            } else {
                alert('Order bạn chọn sản phẩm đã hết hàng');
                $(this).prop('checked', false);
            }
        } else {
            var list_array_new = array_id_nhanh.filter(function(item) {
                return item != id_nhanh
            })

            array_id_nhanh = list_array_new
        }

        console.log('array_id_nhanh ', array_id_nhanh)
    });

    function checkAllPageList() {
        $('#choice_all').click(function() {
            array_id_nhanh = [];
            var $listItemOrder = $('.list_order_search .item');
            if ($(this).is(":checked") == true) {
                if ($listItemOrder.length > 0 && $listItemOrder) {
                    for (var i = 0; i < $listItemOrder.length; i++) {
                        var $item = jQuery($listItemOrder[i]);

                        if ($item.find('.item-order-nhanh').attr('data-status') != 'SoldOut') {
                            var id_nhanh = $item.find('.item-order-nhanh').attr('data-idnhanh');
                            $item.find('.item-order-nhanh').prop("checked", true);

                            array_id_nhanh.push(id_nhanh)
                        }
                    }
                }
            } else {
                if ($listItemOrder.length > 0 && $listItemOrder) {
                    for (var i = 0; i < $listItemOrder.length; i++) {
                        var $item = jQuery($listItemOrder[i]);

                        $item.find('.item-order-nhanh').prop("checked", false);
                    }
                }
            }
        })
    }

    checkAllPageList();

    $('#info-call-ghtk').submit(function(e) {
        e.preventDefault();
        $('.loading').addClass('active')
        if (array_id_nhanh && array_id_nhanh.length > 0) {
            var info_received = $('#info-received option:selected').attr('data-id')
            var calcShip = $('#money_ship option:selected').attr('data-ship')

            window.axios.post('/create-order-ghtk', {
                    params: {
                        data_id: array_id_nhanh,
                        info_received: info_received,
                        calcShip: calcShip
                    }
                })
                .then(function(response) {
                    console.log('response ', response)
                    if (response.status == 200) {
                        $('.loading').removeClass('active')
                        alert('Bạn đã đăng ký thành công lên Giao Hàng Tiết Kiệm');
                        window.location.href = window.location.href;
                    }
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });

        } else {
            alert('Bạn chưa chọn Order')
        }
    });

    var array_id_ghtk = [];

    $('.button-cancle').click(function(e) {
        e.preventDefault();
        $('.loading').addClass('active')
        if (array_id_ghtk && array_id_ghtk.length > 0) {
            window.axios.post('/cancle-order-ghtk', {
                    params: {
                        data_label: array_id_ghtk
                    }
                })
                .then(function(response) {
                    console.log('response ', response)
                    if (response.status == 200) {
                        $('.loading').removeClass('active')
                        alert('Bạn đã huỷ thành công Đơn Hàng');
                        window.location.href = window.location.href;
                    }
                })
                .catch(function(error) {
                    $('.loading').removeClass('active')
                    alert('Bạn đã huỷ thành công Đơn Hàng');
                    window.location.href = window.location.href;
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        } else {
            $('.loading').removeClass('active')
        }
    });

    $('.list_order_search .item-ghtk-nhanh').click(function(e) {
        var id_ghtl = $(this).attr('data-ghtk');
        var statusCode = $(this).attr('data-status');

        if ($(this).is(":checked") == true) {
            if (statusCode != '-1') {
                array_id_ghtk.push(id_ghtl)
            } else {
                alert('Đơn hàng đã được xoá');
                $(this).prop('checked', false);
            }
        } else {
            var list_array_new = array_id_ghtk.filter(function(item) {
                return item != id_ghtl
            })

            array_id_ghtk = list_array_new
        }

        console.log('array_id_ghtk ', array_id_ghtk)
    })

    $('#choice_all_ghtk').click(function() {
        array_id_ghtk = [];
        var $listItemGHTK = $('.list_order_search .item-ghtk');
        if ($(this).is(":checked") == true) {
            if ($listItemGHTK.length > 0 && $listItemGHTK) {
                for (var i = 0; i < $listItemGHTK.length; i++) {
                    var $item = jQuery($listItemGHTK[i]);

                    if ($item.find('.item-ghtk-nhanh').attr('data-status') != '-1') {
                        var id_nhanh = $item.find('.item-ghtk-nhanh').attr('data-ghtk');
                        $item.find('.item-ghtk-nhanh').prop("checked", true);

                        array_id_ghtk.push(id_nhanh)
                    }
                }
            }
        } else {
            if ($listItemGHTK.length > 0 && $listItemGHTK) {
                for (var i = 0; i < $listItemGHTK.length; i++) {
                    var $item = jQuery($listItemGHTK[i]);

                    $item.find('.item-ghtk-nhanh').prop("checked", false);
                }
            }
        }
    })

    $('#search_order_list').submit(function(e) {
        e.preventDefault();
        $('.loading').addClass('active')
        var type = $(this).find('#type_serch_input').val();
        var input = $(this).find('#search_order_input').val();

        if (input.length > 0) {
            window.axios.post('/api/sort-order/list', {
                    params: {
                        type: type,
                        value: input
                    }
                })
                .then(function(response) {
                    if (response.data.success == true) {
                        if (response.data.listOrders && response.data.listOrders.length > 0) {
                            var htmlItem = '';

                            for (var i = 0; i < response.data.listOrders.length; i++) {
                                var order = response.data.listOrders[i];

                                htmlItem += '<tr class="item">';
                                htmlItem += '<th scope="row"><input class="item-order-nhanh" type="checkbox" name="order_id_nhanh" data-idNhanh="' + order.id_nhanhvn + '" data-status="' + order.statusCode + '"></th>';
                                htmlItem += '<td><a href="/order/' + order.id + '">' + order.id_nhanhvn + '</a></td>';
                                htmlItem += '<td>' + order.createdDateTime + '</td>';
                                htmlItem += '<td>' + order.customerName + '</td>';
                                htmlItem += '<td>' + order.customerMobile + '</td>';
                                htmlItem += '<td>' + order.statusName + '</td>';
                                try {
                                    if (order.products) {
                                        var productJson = JSON.parse(order.products);
                                        if (productJson && productJson.length > 0) {
                                            var nameProducts = '';
                                            for (var iPrd = 0; iPrd < productJson.length; iPrd++) {
                                                var product = productJson[iPrd];
                                                if (iPrd > 0) {
                                                    nameProducts += '<br> ' + product.name;
                                                } else {
                                                    nameProducts += product.name;
                                                }
                                            }
                                            htmlItem += '<td>' + nameProducts + '</td>';
                                        } else {
                                            htmlItem += '<td>Lỗi hiển thị</td>';
                                        }
                                    }
                                } catch (e) {
                                    htmlItem += '<td>Lỗi hiển thị</td>';
                                }
                                htmlItem += '<td>' + order.calcTotalMoney + '</td>';
                                if (order.label_GHTK) {
                                    htmlItem += '<td>' + order.label_GHTK + '</td>';
                                } else {
                                    htmlItem += '<td>Chưa lên GHTK</td>';
                                }
                                htmlItem += '</tr>';

                                $('#search_list_order_clone').html(htmlItem)
                                $('.pagination').remove()
                            }
                        }
                        $('.loading').removeClass('active');
                        checkAllPageList();
                    }
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        } else {
            if (type == 'handoverId') {
                alert('Bạn hãy nhập ID Biên bản bàn giao')
            }

            if (type == 'id') {
                alert('Bạn hãy nhập ID Đơn Hàng')
            }

            if (type == 'customerMobile') {
                alert('Bạn hãy nhập Số Điện Thoại Khách Hàng')
            }

            $('.loading').removeClass('active')
        }
    })

    //search order new 27/8
    $('#search_order_list_info').submit(function(e) {
        e.preventDefault();

        $('.loading').addClass('active')
        var type = $(this).find('#type_serch_input').val();
        var input = $(this).find('#search_order_input').val();

        window.axios.post('/api/sort-order/keyword', {
                params: {
                    type: type,
                    value: input
                }
            })
            .then(function(response) {
                if (response.data.success == true) {
                    if (response.data.listOrders && response.data.listOrders.length > 0) {
                        var htmlItem = '';

                        for (var i = 0; i < response.data.listOrders.length; i++) {
                            var order = response.data.listOrders[i];

                            htmlItem += '<tr class="item">';
                            htmlItem += '<th scope="row"><input class="item-order-nhanh" type="checkbox" name="order_id_nhanh" data-idNhanh="' + order.id_nhanhvn + '" data-status="' + order.statusCode + '"></th>';
                            htmlItem += '<td><a href="/order/' + order.id + '">' + order.id_nhanhvn + '</a></td>';
                            htmlItem += '<td>' + order.label_GHTK + '</td>';
                            htmlItem += '<td>' + order.customerName + '</td>';
                            htmlItem += '<td>' + order.customerMobile + '</td>';
                            try {
                                if (order.products) {
                                    var productJson = JSON.parse(order.products);
                                    if (productJson && productJson.length > 0) {
                                        var nameProducts = '';
                                        for (var iPrd = 0; iPrd < productJson.length; iPrd++) {
                                            var product = productJson[iPrd];
                                            if (iPrd > 0) {
                                                nameProducts += '<br> ' + product.name;
                                            } else {
                                                nameProducts += product.name;
                                            }
                                        }
                                        htmlItem += '<td>' + nameProducts + '</td>';
                                    } else {
                                        htmlItem += '<td>Lỗi hiển thị</td>';
                                    }
                                }
                            } catch (e) {
                                htmlItem += '<td>Lỗi hiển thị</td>';
                            }
                            htmlItem += '<td>' + order.calcTotalMoney + '</td>';
                            htmlItem += '<td>' + order.statusName + '</td>';
                            htmlItem += '<td>' + checkStatus(order.statusGHTK) + '</td>';
                            if (order.label_GHTK) {
                                htmlItem += '<td><div class="cancle_ghtk" data-label="' + order.label_GHTK + '">Huỷ Đơn</div></td>';
                            } else {
                                htmlItem += '<td></td>';
                            }
                            htmlItem += '</tr>';

                            $('#search_list_order_clone').html(htmlItem)
                            $('.pagination').remove()
                        }
                    } else {
                        alert('Không tìm thấy kết quả!');
                    }
                    $('.loading').removeClass('active');
                    checkAllPageList();
                }
            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .finally(function() {
                // always executed
            });
    });

    function checkStatus(type) {
        $name = '';
        switch (type) {
            case '-1':
                $name = 'Đã Huỷ';
                break;
            case '5':
                $name = 'Thành Công';
                break;
            case '4':
                $name = 'Đang shipping';
                break;
            case '2':
                $name = 'Đang shipping';
                break;
            case '10':
                $name = 'Cần xử lý';
                break;
            case '20':
                $name = 'Đang chuyển hoàn';
                break;
            case '21':
                $name = 'Đã hoàn';
                break;
            default:
                return '';
        }

        return $name;
    }

    $('#info-call-ghtk-new').submit(function(e) {
        e.preventDefault();
        $('.loading').addClass('active');

        if (array_id_nhanh && array_id_nhanh.length > 0) {
            var info_received = $('#info-received option:selected').attr('data-id')
            var calcShip = 1;

            window.axios.post('/create-order-ghtk', {
                    params: {
                        data_id: array_id_nhanh,
                        info_received: info_received,
                        calcShip: calcShip
                    }
                })
                .then(function(response) {
                    // console.log('response ', response.data)
                    if (response.status == 200) {
                        if (response.data.length > 0 && response.data) {
                            var htmlRespon = '';
                            for (var i = 0; i < response.data.length; i++) {
                                var respon = response.data[i];

                                htmlRespon += '<div class="item">'
                                htmlRespon += '<p><span>' + (i + 1) + ':</span>  ' + respon.message + '</p>';
                                if (respon.error) {
                                    htmlRespon += '<p>' + respon.error.ghtk_label + '</p>';
                                }
                                htmlRespon += '</div>';
                            }

                            $('#ketqua_create_ghtk').html(htmlRespon);
                            $('#exampleModalCenterListOrder').modal('show')
                        }
                        $('.loading').removeClass('active')
                    }
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });

        } else {
            alert('Bạn chưa chọn Order')
            $('.loading').removeClass('active')
        }
    })

    //js 28/8
    $('.action_list .contain').click(function(e) {
        e.preventDefault();

        var $list = jQuery('.list_action');

        if ($list.hasClass('gt_active')) {
            $list.removeClass('gt_active')
        } else {
            $list.addClass('gt_active')
        }
    })

    $('.current_numberPage').click(function(e) {
        e.preventDefault();

        var $listNumber = jQuery('.number_show_order .list_number');

        if ($listNumber.hasClass('gt_active')) {
            $listNumber.removeClass('gt_active')
        } else {
            $listNumber.addClass('gt_active')
        }
    });

    var array_id_ghtk_new = [];
    $('#search_list_order_clone .cancle_ghtk').click(function(e) {
        e.preventDefault();
        // $('.loading').addClass('active');

        var label_GHTK = jQuery(this).attr('data-label');
        array_id_ghtk_new.push(label_GHTK);

        $('#exampleModalCancleGHTK').modal('show');

        $('#comfrim-cancle').click(function(e){
            $('#exampleModalCancleGHTK').modal('hide');
            $('.loading').addClass('active');
            window.axios.post('/cancle-order-ghtk', {
                    params: {
                        data_label: array_id_ghtk_new
                    }
                })
                .then(function(response) {
                    console.log('response ', response)
                    if (response.status == 200) {
                        $('.loading').removeClass('active')
                        alert('Bạn đã huỷ thành công Đơn Hàng');
                        array_id_ghtk_new = []
                        window.location.href = window.location.href;
                    }
                })
                .catch(function(error) {
                    $('.loading').removeClass('active')
                    alert('Bạn đã huỷ thành công Đơn Hàng');
                    array_id_ghtk_new = []
                    window.location.href = window.location.href;
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        });

        $('#comfrim-close').click(function(e){
             e.preventDefault();
             array_id_ghtk_new = []
             $('#exampleModalCancleGHTK').modal('hide');
        })
    })
})
