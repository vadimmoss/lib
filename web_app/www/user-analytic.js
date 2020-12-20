let userActivity = [];
let userRatesForCalendarActivity = [];

function getUsersByAge() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/getUserActivity')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            let i = 0;
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_views);
                let view_dates = new Date(xhr.response[i].view_dates);
                var result = [view_dates, count_views];
                userActivity.push(result)
                i++;
            }
        }
        return userActivity;
    }
    xhr.send();
}

getUsersByAge();

getUsersRates();

getUsersRatesForCalendar();
setTimeout(function () {
    console.log(userActivity)
    google.charts.load("current", {packages: ["calendar"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({type: 'date', id: 'Date'});
        dataTable.addColumn({type: 'number', id: 'Won/Loss'});
        dataTable.addRows(userActivity);


        var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

        var options = {
            height: 250,
            calendar: {cellSize: 21},
        };

        chart.draw(dataTable, options);
    }
}, 200)


setTimeout(function () {
    google.charts.load("current", {packages: ["calendar"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({type: 'date', id: 'Date'});
        dataTable.addColumn({type: 'number', id: 'Won/Loss'});
        dataTable.addRows(userRatesForCalendarActivity);


        var chart = new google.visualization.Calendar(document.getElementById('calendar_basic2'));

        var options = {
            height: 250,
            calendar: {cellSize: 21},
        };

        chart.draw(dataTable, options);
    }
}, 200)

let userViewsActivity = [];
let userRatesActivity = [];

function getUsersViews() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/getUserViews')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            let i = 0;
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_views);
                let view_dates = new Date(xhr.response[i].view_dates);
                var result = [view_dates, count_views, 0];
                userViewsActivity.push(result)
                i++;
            }
        }
        return userActivity;
    }
    xhr.send();
}

getUsersViews();

function getUsersRates() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/getUserRates')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            let i = 0;
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_rates);
                let view_dates = new Date(xhr.response[i].rates_dates);
                var result = [view_dates, 0, count_views];
                userRatesActivity.push(result)
                i++;
            }
        }
        return userRatesActivity;
    }
    xhr.send();
}

getUsersRates();

function getUsersRatesForCalendar() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/getUserRates')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            let i = 0;
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_rates);
                let view_dates = new Date(xhr.response[i].rates_dates);
                var result = [view_dates, count_views];
                userRatesForCalendarActivity.push(result)
                i++;
            }
        }
        return userRatesForCalendarActivity;
    }
    xhr.send();
}

setTimeout(function () {
    for (var c = userViewsActivity, i = 0; i < userRatesActivity.length; i++) userViewsActivity.push(userRatesActivity[i]);
    console.log(userViewsActivity)
    userViewsActivity.sort(function (a, b) {
        return a[0] - b[0];
    });
    const result = userViewsActivity.filter(word => new Date(word[0]).getFullYear() === 2020);
    createDateChart2(result, 'columnchart_material');
}, 500);

function createDateChart2(array, selector) {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Topping');
        data.addColumn('number', 'Перегляди');
        data.addColumn('number', 'Завантаження');
        data.addRows(array);
        var options = {
            hAxis: {
                format: 'd',
            },
            'width': 550,
            'height': 350
        };
        var chart = new google.visualization.LineChart(document.getElementById(selector));
        chart.draw(data, options);
    });
}