<?php
/**
 * @author       Amin Mahmoudi (MasterkinG)
 * @copyright    Copyright (c) 2019 - 2022, MsaterkinG32 Team, Inc. (https://masterking32.com)
 * @link         https://masterking32.com
 * @Github       https://github.com/masterking32/wow-telegram
 * @Description  It's not masterking32 framework !
 */

include 'config.php';
if (empty($_SESSION["CM_Login"])) {
    header('location:./index.php');
    exit();
}
?>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        (function (e) {
            "use strict";
            e.fn.textTyper = function (t) {
                var n = {
                    typingClass: "typing",
                    beforeAnimation: function () {
                    },
                    afterAnimation: function () {
                    },
                    speed: 10,
                    nextLineDelay: 400,
                    startsFrom: 0,
                    repeatAnimation: false,
                    repeatDelay: 4e3,
                    repeatTimes: 1,
                    cursorHtml: '<span class="cursor">|</span>'
                }, r = e.extend({}, n, t);
                this.each(function () {
                    var t = e(this), n = 1, i = "typingCursor";
                    var s = t, o = s.length, u = [];
                    while (o--) {
                        u[o] = e.trim(e(s[o]).html());
                        e(s[o]).html("")
                    }
                    t.init = function (e) {
                        var n = r.beforeAnimation;
                        if (n) n();
                        t.animate(0)
                    };
                    t.animate = function (o) {
                        var a = s[o], f = r.typingClass, l = r.startsFrom;
                        e(a).addClass(f);
                        var c = setInterval(function () {
                            var f = r.cursorHtml;
                            f = e("<div>").append(e(f).addClass(i)).html();
                            e(a).html(u[o].substr(0, l) + f);
                            l++;
                            if (u[o].length < l) {
                                clearInterval(c);
                                o++;
                                if (s[o]) {
                                    setTimeout(function () {
                                        e(a).html(u[o - 1]);
                                        t.animate(o)
                                    }, r.nextLineDelay)
                                } else {
                                    e(a).find("." + i).remove();
                                    if (r.repeatAnimation && (r.repeatTimes == 0 || n < r.repeatTimes)) {
                                        setTimeout(function () {
                                            t.animate(0);
                                            n++
                                        }, r.repeatDelay)
                                    } else {
                                        var h = r.afterAnimation;
                                        if (h) h()
                                    }
                                }
                            }
                        }, r.speed)
                    };
                    t.init()
                });
                return this
            }
        })(jQuery)
        $(document).ready(function () {
            $('.command').hide();
            $('input[type="text"]').focus();
            $('#home').addClass('open');
            $('#home').textTyper({
                speed: 1,
                afterAnimation: function () {
                    $('.command').fadeIn();
                    $('input[type="text"]').focus();
                    $('input[type="text"]').val('');
                }
            });
            $('input[type="text"]').keyup(function (e) {
                if (e.which == 13) {
                    $('.command').hide();
                    $('#output').hide();
                    $('#home').text("");
                    var destination = $('input[type="text"]').val();
                    if (destination == 'logout' || destination == 'exit') {
                        window.location.replace("./logout.php");
                        return;
                    } else {
                        $.post("ajax.php", {command: destination}, function (result) {
                            $('#output').html(result);
                            $('.open').textTyper({
                                speed: 1,
                                afterAnimation: function () {
                                    $('#output').fadeIn();
                                    $('.command').fadeIn();
                                    $('input[type="text"]').focus();
                                    $('input[type="text"]').val('');
                                }
                            });
                        });
                    }
                }
            });
        });
    </script>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Inconsolata:400,700);

        html {
            background: #fff;
            overflow-y: scroll;
        }

        body {
            font: .875em/1.6 'Inconsolata', monospace;
            color: #181818;
            font-weight: 400;
            max-width: 28em;
            padding: 1em;
            margin: 1% 0;
        }

        ::selection {
            background: #eee
        }

        ::-webkit-selection {
            background: #eee
        }

        ::-moz-selection {
            background: #eee
        }

        a {
            color: #181818;
        }

        a:hover, a:focus {
            background: #181818;
            color: #fff;
        }

        h2 {
            font-size: 1em;
            font-weight: 400;
        }

        p {
            margin-bottom: -10px;
        }

        abbr {
            cursor: help;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1em 0 0;
        }

        span {
            display: block;
            color: #999;
            line-height: 1;
        }

        kbd {
            font-family: 'Inconsolata', monospace;
            border: 1px solid #999;
            text-transform: uppercase;
            padding: 0 .2em;
        }

        input[type="text"] {
            max-width: 10em;
            border: none;
            font-family: inherit;
            background: #fff;
            padding: 0 .5em;
        }

        input[type="text"]:focus {
            background: #fff;
            color: #000;
            outline: none;
        }

        .command {
            display: block;
            max-width: 20em;
            color: #181818;
            font-weight: 700;
            margin: 2em 0;
        }

        section {
            display: none;
        }

        .open {
            display: block;
        }
        .command {
            padding-top: 10px;
        }
    </style>
</head>
<body>
<main>
    <section id="home" class="home">
        <h2>TrinityCore/Mangos/AzerothCore Management Terminal</h2>
        <p><span>Type 'commands' + <kbd>Enter</kbd> -- for available commands.</span></p>
        <p><span>Type 'logout' or 'exit' + <kbd>Enter</kbd> -- logout from panel.</span></p>
    </section>
    <section id="output"></section>
    <section class="command">WorldServer:/$<input type="text"></section>
</main>
</body>
</html>