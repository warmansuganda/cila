/* Sets time in clock div and calls itself every second */
/**
 * Clock plugin
 * Copyright (c) 2010 John R D'Orazio (donjohn.fmmi@gmail.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Turns a jQuery dom element into a dynamic clock
 *
 * @timestamp defaults to clients current time
 *   $("#mydiv").clock();
 *   >> will turn div into clock using client computer's current time
 * @timestamp server-side example:
 *   Say we have a hidden input with id='timestmp' the value of which is determined server-side with server's current time
 *   $("#mydiv").clock({"timestamp":$("#timestmp").val()});
 *   >> will turn div into clock passing in server's current time as retrieved from hidden input
 *
 * @format defaults to 12 hour format,
 *   or if langSet is indicated defaults to most appropriate format for that langSet
 *   $("#mydiv").clock(); >> will have 12 hour format
 *   $("#mydiv").clock({"langSet":"it"}); >> will have 24 hour format
 *   $("#mydiv").clock({"langSet":"en"}); >> will have 12 hour format
 *   $("#mydiv").clock({"langSet":"en","format":"24"}); >> will have military style 24 hour format
 *   $("#mydiv").clock({"calendar":true}); >> will include the date with the time, and will update the date at midnight
 *
 */

;(function($) {
    $.clock = {
        version: "2.0.1",
        locale: {}
    };
    t = [];
    $.fn.clock = function(d) {
        var c = {
            it: {
                weekdays: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"],
                months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"]
            },
            en: {
                weekdays: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
            },
            es: {
                weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "May", "junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
            },
            de: {
                weekdays: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
                months: ["Januar", "Februar", "März", "April", "könnte", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"]
            },
            fr: {
                weekdays: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
                months: ["Janvier", "Février", "Mars", "Avril", "May", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"]
            },
            ru: {
                weekdays: ["???????????", "???????????", "???????", "?????", "???????", "???????", "???????"],
                months: ["??????", "???????", "????", "??????", "???", "????", "????", "??????", "????????", "???????", "??????", "???????"]
            },
            id: {
                "weekdays":['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                "months":['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        };
        return this.each(function() {
            $.extend(c, $.clock.locale);
            d = d || {};
            d.timestamp = d.timestamp || "z";
            y = new Date().getTime();
            d.sysdiff = 0;
            if (d.timestamp != "z") {
                d.sysdiff = d.timestamp - y
            }
            d.langSet = d.langSet || "en";
            d.format = d.format || ((d.langSet != "en") ? "24" : "12");
            d.calendar = d.calendar || "true";
            d.timer = d.timer || "true";
            if (!$(this).hasClass("jqclock")) {
                $(this).addClass("jqclock");
            }
            var e = function(g) {
                    if (g < 10) {
                        g = "0" + g
                    }
                    return g;
                },
                f = function(j, n) {
                    var r = $(j).attr("id");
                    if (n == "destroy") {
                        clearTimeout(t[r]);
                    } else {
                        m = new Date(new Date().getTime() + n.sysdiff);
                        var p = m.getHours(),
                            l = m.getMinutes(),
                            v = m.getSeconds(),
                            u = m.getDay(),
                            i = m.getDate(),
                            k = m.getMonth(),
                            q = m.getFullYear(),
                            o = "",
                            z = "",
                            t = "",
                            w = n.langSet;
                        if (n.format == "12") {
                            o = " AM";
                            if (p > 11) {
                                o = " PM"
                            }
                            if (p > 12) {
                                p = p - 12
                            }
                            if (p === 0) {
                                p = 12
                            }
                        }
                        p = e(p);
                        l = e(l);
                        v = e(v);
                        if (n.calendar != "false") {
                            z = ((w == "en") ? "<span class='clockdate'>" + c[w].weekdays[u] + ", " + c[w].months[k] + " " + i + ", " + q + "</span>" : "<span class='clockdate'>" + c[w].weekdays[u] + ", " + i + " " + c[w].months[k] + " " + q + "</span>");
                        }
                        if (n.timer != "false") {
                            t = "<span class='clocktime'>" + p + " : " + l + " : " + v + o + "</span>";
                        }
                        $(j).html(z + t);
                        t[r] = setTimeout(function() {
                            f($(j), n)
                        }, 1000);
                    }
                };
            f($(this), d);
        });
    };
    return this;
}(jQuery));
