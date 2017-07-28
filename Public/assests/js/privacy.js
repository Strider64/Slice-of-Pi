var yesCheck = document.getElementById("yesCheck");
var noCheck = document.getElementById("noCheck");

if (typeof (yesCheck) != 'undefined' && yesCheck != null)
{
    yesCheck.addEventListener('click', function () {
        document.getElementById('imgBtn').style.display = "block";
    });

    noCheck.addEventListener('click', function () {
        document.getElementById('imgBtn').style.display = "none";
    });
}
