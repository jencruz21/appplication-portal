const months = [
    "January",
    "Febraury",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];

const date = new Date();

document.getElementById("_month").innerHTML = months[date.getMonth()];
document.getElementById("_year").innerHTML = date.getFullYear();
document.getElementById("_date").innerHTML = date.getDate();
