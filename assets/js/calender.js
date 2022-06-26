var content = document.getElementById("january");
var button = document.getElementById("month");
button.onclick = function()
{
    if (january.className == "active")
    {
        //shrink col-7
        january.className = "open";
    }
    else
    {
        //expand the col-7
        january.className = "";
    }
};