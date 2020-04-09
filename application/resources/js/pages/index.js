$(function () {
    //Widgets count
    $('.count-to').countTo();

    //Sales count to
    $('.sales-count-to').countTo({
        formatter: function (value, options) {
            return '$' + value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, ' ').replace('.', ',');
        }
    });
});

//Call to reddit endpoint ????????=========================================================================
$.ajax({
    url: "https://www.reddit.com/r/coronavirus.json?limit=4",
    method: 'GET',
    data: {
        q: ''
    }
}).done(function (data) {
    let x = data.data.children;
    let y = $("#reddit_list");
    let z = "";
    for (var prop in x) {
        z += '<li>';
        z += '<a href="' + x[prop].data.url + '" style="color: white;">';
        z += trimLength(x[prop].data.title, 50);
        z += '<a>';
        z += '</li>';
    }
    y.append(z);
});

twitterCall('ostanidoma');
twitterCall('CoronavirusCroatia');

//Call to twitter endpoint ????????=========================================================================
function twitterCall(param){
    $.ajax({
        url: "api/status/twitter?hashtag=" + param,
        method: 'GET',
        data: {
            q: ''
        }
    }).done(function (data) {
        let x =JSON.parse(data);
        let y = $("#" + param);
        let z = "";
        let w = 0;
        (x.statuses.length > 6) ? w = 6 : w = x.statuses.length;
        for (i = 0; i < w; i++) {
            z += '<li>';
            z += trimLength(x.statuses[i].text, 50);
            z += '</li>';  
        } 
        y.append(z);
    });
}

//Trim string helper ????????=========================================================================
function trimLength(text, maxLength) {
    text = $.trim(text);
    let ellipsis = "...";

    if (text.length > maxLength) {
        text = text.substring(0, maxLength - ellipsis.length)
        return text.substring(0, text.lastIndexOf(" ")) + ellipsis;
    }
    else
        return text;
}


