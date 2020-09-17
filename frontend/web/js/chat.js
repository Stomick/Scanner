var tkn = $('#token').attr('data-id');
var usid = $('#user_id').attr('data-id');
var pid = $('#page_id').attr('data-id');

socket.emit('joinToRoom', {roomId: pid, userId: usid}, function (tet) {
});
/*
document.getElementById('picField').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            socket.emit('general-photo', {
                photo: fr.result
            }, function (err, info) {
                chatUpdate(usid, null, fr.result, null, info.result.date);
                $('#mtext').innerHTML = '';
            })
        }
        fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
}

 */
$(document).ready(function () {

    $('.send_message').click(function () {
        var images = $('.upphoto');
        if(images && images.length){
            $.each(images , function (i,img) {
                socket.emit('message', {
                    userId: usid,
                    roomId: pid,
                    photo: img.src
                }, function (err, info) {
                });
                $(img).parent().remove();
            })
        }
        if ($('#mtext')[0].innerText !== '') {
            socket.emit('message', {
                userId: usid,
                roomId: pid,
                text: $('#mtext')[0].innerText
            });
            $('#mtext')[0].innerText = '';

        }
    });
    $('#chat_inner_text').scrollTop($('#chat_inner_text')[0].scrollHeight);
    var t = '';
    var explode = function () {
        t = '';

        $('#typinginfo').text(t);
    };
    setInterval(explode, 3000);
    socket.on("writes", function (data) {
            if (data.id != usid) {

                if (t == '') {
                    t = '.';
                } else if (t == '.') {
                    t = '..';
                } else if (t == '..') {
                    t = '...';
                } else {
                    t = '';
                }
                $('#typinginfo').text(data.name + ' набирает сообщение' + t);
            }
        }
    );

    socket.on("message", function (datas) {
        $.each(datas.messages, function (i, item) {
            chatUpdate(item);
        })
    });

});

function getFormattedDate(date) {
    var year = date.getFullYear();

    var month = (1 + date.getMonth()).toString();
    month = month.length > 1 ? month : '0' + month;

    var day = date.getDate().toString();
    day = day.length > 1 ? day : '0' + day;

    var hour = date.getHours().toString();
    hour = hour.length > 1 ? hour : '0' + hour;

    var min = date.getMinutes().toString();
    min = min.length > 1 ? min : '0' + min;


    return ' ' + hour + ':' + min + ' ' + month + '.' + day + '.' + year;
}

function chatUpdate(ms) {
    console.log(ms.date)
    if (ms.date !== undefined) {
        var dt = getFormattedDate(new Date(ms.date));
    } else {
        var dt = getFormattedDate(new Date());
    }
    var m = '';
    var p = ''
    if (ms.text != null) {
        m = ms.text
    } else if (ms.photo != null) {
        p = '<div class="img_mess_block"><a href="'+ms.photo+'" data-fancybox="gallery"><img data-high-res-src="'+ms.photo+'" src="'+ms.photo+'" alt="image"></a></div>';
    }
    var us = '';
    var str = '<div class="one_message ' + (ms.id != usid ? 'float_left' : 'float_right') + '">' +
        '<p class="title">' +
        '<span class="sender">' + (ms.id == usid ? 'Вы писали ' : ms.name) + '</span>' +
        '<span class="mess_date">' + dt + ' </span>' +
        '</p>' + p + (m !== '' ? '<p class="mess_text ' + (ms.id == usid ? 'pink' : 'green') + '">' + ms.text + '</p>': '') +
    '</div>';
    $('#chat_inner_text').append(str);
    $('#chat_inner_text').scrollTop($('#chat_inner_text')[0].scrollHeight);

}

function openbox(id) {
    $("#" + id)[0].style.display == 'none' ? $("#" + id).show('fast') : $("#" + id).hide('100');
}

$('#mtext').mousedown(function () {
    if (this.innerText == "") {
        this.innerText = '';
    }
});
/*
        $('.message_text').mouseenter(function () {
            this.style.height = 'auto';
        }).mouseout(function () {
            this.style.height = '45px';
        });
*/
//                $('#chat_inner_text').scrollTop($('#chat_inner_text')[0].scrollHeight);
$(document).keypress(function (event) {

    if (document.activeElement.id === 'mtext') {
        if (event.charCode === 13) {
            event.preventDefault();
            $('.send_message').click();
            $('#mtext')[0].innerText = "";
        } else {
            socket.emit('writes', {
                roomId: pid
            }, function (err, info) {

            })
        }
    }
})
//var text = document.getElementById("mtext")/*.onchange =


$(document).ready(function () {

    $('.smile').click(function () {
        var text = document.getElementById('mtext');
        text.innerHTML = text.innerHTML + this.innerHTML;
    });
    $('#id_smile_block .smile').click(function () {
        $('#message_to_org').val($('#message_to_org').val() + this.innerText);
    })
    $('#id_smile_block').mouseleave(function () {
        $(this).hide(100);
    })
    $('#id_smile_block_2 .smile').click(function () {
        $('#message_to_org').val($('#message_to_org').val() + this.innerText);
    })
    $('#id_smile_block_2').mouseleave(function () {
        $(this).hide(100);
    })
})