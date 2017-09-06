var myButton = document.getElementById('slider');
var mobileHeader = document.getElementById('mobile-header');
console.log(myButton);

myButton.addEventListener("click", function (event) {
    console.log(this.style.left);
    if (this.style.left === '0px') {
        this.style.left = '-200px';
        //mobileHeader.style.left = '30px';
    } else {
        this.style.left = "0px";
        //mobileHeader.style.left = '230px';
    }

});