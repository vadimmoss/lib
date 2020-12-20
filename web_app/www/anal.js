let array = [];
let viewsArray = [];
let viewsDatesArray = [];
let ratesDatesArray = [];
let ViewsByDateCal = [];
let viewsByRegionArray = [];
let usersByAgeArray = [];


function getDownloadsData() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/rates')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            for (let rate in xhr.response) {
                let document_name = xhr.response[i].document_name;
                let count_rates = parseInt(xhr.response[i].count_rates);
                let average_rating = parseInt(xhr.response[i].average_rating);
                var result = [document_name, count_rates];
                array.push(result)
                i++;
            }
        }
        return array;
    }
    xhr.send();
}


function getRateData() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/rates')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            for (let rate in xhr.response) {
                let document_name = xhr.response[i].title;
                let count_rates = parseInt(xhr.response[i].count_rates);
                let average_rating = parseInt(xhr.response[i].average_rating);
                var result = [document_name, count_rates];
                array.push(result)
                i++;
            }
        }
        return array;
    }
    xhr.send();
}

function getViewsData() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/topViews')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            // console.log(Object.keys(xhr.response[0]));
            for (let [key, value] in xhr.response) {
                console.log(xhr.response)
                let document_name = xhr.response[i].title;
                let count_views = parseInt(xhr.response[i].count_views);
                var result = [document_name, count_views];
                viewsArray.push(result)
                i++;
            }
        }
        return viewsArray;
    }
    xhr.send();
}


function getUsersByAge() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/usersByAge')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            let i = 0;
            // console.log(Object.keys(xhr.response[0]));
            for (let [key, value] in xhr.response) {
                let age = parseInt(xhr.response[i].age);
                let count_users = parseInt(xhr.response[i].count_users);
                var result = [age, count_users];
                usersByAgeArray.push(result)
                i++;
            }
        }
        return viewsArray;
    }
    xhr.send();
}

getUsersByAge();

function getViewsByRegion() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/viewsByRegion')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let i = 0;
            var result = [];
            for (let [key, value] in xhr.response) {
                let view_region = xhr.response[i].view_region;
                let count_views = parseInt(xhr.response[i].count_views);
                result = [view_region, count_views];
                viewsByRegionArray.push(result)
                console.log('gggggggggggggggggggggggggggggggggggggggg')
                console.log(viewsByRegionArray)
                console.log('fggggggggggggggggggggggggggggggggggggg')

                i++;
            }

        }

        return viewsByRegionArray;

    }
    xhr.send();
}

getViewsByRegion()


function getViewsByDate() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/viewsByDate')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            // console.log(Object.keys(xhr.response[0]));
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_views);
                let view_dates = new Date(xhr.response[i].view_dates);
                var result = [view_dates, count_views, 0];
                viewsDatesArray.push(result);
                i++;
            }
        }
        return viewsDatesArray;
    }
    xhr.send();
}


function getRatesByDate() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/ratesByDate')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            // console.log(Object.keys(xhr.response[0]));
            for (let [key, value] in xhr.response) {

                let count_views = parseInt(xhr.response[i].count_rates);
                let view_dates = new Date(xhr.response[i].rates_dates);
                var result = [view_dates, 0, count_views];
                ratesDatesArray.push(result);
                i++;
            }
        }
        return ratesDatesArray;
    }
    xhr.send();
}

getViewsByDate();
getRatesByDate();
getRateData();
getViewsData();

setTimeout(function () {
    createChart(array, 'gr1', 'За оцінками:');
    createChart(viewsArray, 'gr2', 'За популярністю:');
}, 200)


createDateChart(viewsDatesArray, 'chart_div3');
createDateChart(ratesDatesArray, 'chart_div4');
let finalArray = [viewsDatesArray].concat(ratesDatesArray);
setTimeout(function () {
    for (var c = viewsDatesArray, i = 0; i < ratesDatesArray.length; i++) viewsDatesArray.push(ratesDatesArray[i]);
    console.log(viewsDatesArray)
    viewsDatesArray.sort(function (a, b) {
        return a[0] - b[0];
    });
    const result = viewsDatesArray.filter(word => new Date(word[0]).getFullYear() === 2020);
    createDateChart2(result, 'curve_chart');
}, 500);


function createChart(array, selector, title) {

    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(array);
        var options = {
            'title': title,
            'width': 600,
            'height': 300
        };
        var chart = new google.visualization.PieChart(document.getElementById(selector));
        chart.draw(data, options);
    });
}


function createDateChart(array, selector) {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(array);
        var options = {
            'title': 'How Much Pizza I Ate Last Night',
            hAxis: {
                format: 'd',
            },
            'width': 400,
            'height': 300
        };
        var chart = new google.visualization.LineChart(document.getElementById(selector));
        chart.draw(data, options);
    });
}

function createDateChart2(array, selector) {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(function () {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Topping');
        data.addColumn('number', 'Views');
        data.addColumn('number', 'Rates');
        data.addRows(array);
        var options = {
            hAxis: {
                format: 'd',
            },
            'width': 600,
            'height': 300
        };
        var chart = new google.visualization.LineChart(document.getElementById(selector));
        chart.draw(data, options);
    });
}

function getViewsByDateCal() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/analytics/viewsByDate')
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.response);
            let i = 0;
            // console.log(Object.keys(xhr.response[0]));
            for (let [key, value] in xhr.response) {
                let count_views = parseInt(xhr.response[i].count_views);
                let view_dates = new Date(xhr.response[i].view_dates);
                var result = [view_dates, count_views, 1];
                ViewsByDateCal.push(result);
                i++;
            }
        }
        return ViewsByDateCal;
    }
    xhr.send();
}

getViewsByDateCal()


setTimeout(function () {
    let array01 = [];
    for (let i = 0; i < ViewsByDateCal.length; i++) {
        array01.push(ViewsByDateCal[i].slice(0, 2))
    }
    console.log('ppppppppppppppppppppppppppppppppppppppppppp')
    console.log(array01)
    console.log('pppppppppppppppppppppppppppppppppppppppppppp')
    const result = array01.filter(word => new Date(word[0]).getFullYear() === 2020);
    drawChart(result);
}, 1000)


google.charts.load("current", {packages: ["calendar"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart(array) {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({type: 'date', id: 'Date'});
    dataTable.addColumn({type: 'number', id: 'Won/Loss'});
    dataTable.addRows(array);

    var chart = new google.visualization.Calendar(document.getElementById('curve_chart3'));
    var options = {
        height: 250,
        calendar: {cellSize: 22},

    };
    chart.draw(dataTable, options);
}


google.charts.load('current', {
    'packages': ['geochart'],
    // Note: you will need to get a mapsApiKey for your project.
    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
});
google.charts.setOnLoadCallback(drawMarkersMap);

function drawMarkersMap() {
    var data = google.visualization.arrayToDataTable([
        ['City', 'Population', 'Area'],
        ['Dnipro', 2761477, 1285.31],
        ['Milan', 1324110, 181.76],
        ['Naples', 959574, 117.27],
        ['Turin', 907563, 130.17],
        ['Palermo', 655875, 158.9],
        ['Genoa', 607906, 243.60],
        ['Bologna', 380181, 140.7],
        ['Florence', 371282, 102.41],
        ['Fiumicino', 67370, 213.44],
        ['Anzio', 52192, 43.43],
        ['Ciampino', 38262, 11]
    ]);

    var options = {
        region: 'UA',
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}
    };

    var chart = new google.visualization.GeoChart(document.getElementById('curve_chart4'));
    chart.draw(data, options);
}


// google.charts.load("current", {packages:["corechart"]});
// google.charts.setOnLoadCallback(drawChart3);

setTimeout(function () {
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart3);

    function drawChart3() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Перегляди');
        data.addColumn('number', 'Завантаження');
        console.log('eeeeeeeee' + viewsByRegionArray)
        console.log(viewsByRegionArray)
        console.log(viewsByRegionArray)
        data.addRows(viewsByRegionArray);
        var options = {
            title: 'My Daily Activities',
            pieHole: 0.5,
            height: 400,
        };

        var chart = new google.visualization.PieChart(document.getElementById('curve_chart5'));
        chart.draw(data, options);
    }
}, 300);


setTimeout(function () {
    console.log(usersByAgeArray)
    google.charts.load('current', {'packages': ['bar']});
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Вік');
        data.addColumn('number', 'Кількість');
        data.addRows(usersByAgeArray);

        var options = {
            title: 'Chess opening moves',
            width: 600,
            height: 400,
            legend: {position: 'none'},
            bars: 'horizontal', // Required for Material Bar Charts.
            axes: {
                x: {
                    0: {side: 'top', label: 'Percentage'} // Top x-axis.
                }
            },
            bar: {groupWidth: "90%"}
        };

        var chart = new google.charts.Bar(document.getElementById('curve_chart6'));
        chart.draw(data, options);
    }
}, 200)

