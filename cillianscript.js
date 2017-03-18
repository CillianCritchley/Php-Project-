
function checkPass()
{

    var p = document.getElementById('newpass').value;
    var p2 = document.getElementById('newpasscopy').value;

    if(p == p2)
    {
        return true;
    }
    else{
        return false;
    }
}

/*
Refuses to submit the form if the input field is empty. assigns the value of the customer ID and accountID fields
to variables cus and acc. If the searchCustomer button is pressed at the same time as the customerID input
field is empty, it will return false and the form will not submit. An alert box will pop up informing the user
of this.  The same applies for the account ID field and the searchAccount button.
If neither of those conditions are met, the form submits as normal.

Two of the pages, OpenDeposit.html.php and Depositreport.html.php do not have accountID elements in the particular form that this
function is called by. I added a check so that if the accID element is not present on the page, the function
will not attempt to grab a value from it. Without this the function will not work on those two pages.

OpenDeposit.html.php page also has a final input field "deposit" for entering an opening balance.

 */
function checkEmpty(button)
{
    var cus = document.getElementById("customerID").value;
    if(document.getElementById("accID"))
    {
    var acc = document.getElementById("accID").value;
    }
    if(document.getElementById("deposit"))
    {
        var addDep = document.getElementById("deposit").value;
    }
    if(button == "searchCustomer" && cus == "")
    {
        alert("cannot submit empty field");
        return false
    }
    else if(button == "searchAccount" && acc == "")
    {
        alert("cannot submit empty field");
        return false;
    }
    else if(button == "addDeposit" && addDep == "")
    {
        alert("cannot submit empty field");
        return false;
    }
    else{
        return true;
    }
}

function  populate()
{
    var sel = document.getElementById("listbox");
    var result;
    result = sel.options[sel.selectedIndex].value;
    var personDetails = result.split(',');
    document.getElementById("customerID").value = personDetails[0];
    document.getElementById("customerIDHide").value = personDetails[0];

    document.getElementById("firstname").value = personDetails[1];
    document.getElementById("surname").value = personDetails[2];
    document.getElementById("addressLine1").value = personDetails[4];
    document.getElementById("addressLine2").value = personDetails[5];
    document.getElementById("addTown").value = personDetails[6];
    document.getElementById("addCounty").value = personDetails[7];
    document.getElementById("dateOfBirth").value = personDetails[3];

    return false;
}

function formCheck(check)
{
    /*if the value pulled from the database for this customer for addressLine2 is empty
     don't output it.
     */
    if(document.getElementById("addressLine2").value == "")
    {
        var address = document.getElementById("addressLine1").value + "\n                          "
            + document.getElementById("addTown").value + "\n                          "
            + document.getElementById("addCounty").value;
    }
    else {
        var address = document.getElementById("addressLine1").value + "\n                          "
            + document.getElementById("addressLine2").value + "\n                          "
            + document.getElementById("addTown").value + "\n                          "
            + document.getElementById("addCounty").value;
    }
    if(check == "reset")
    {
        return true;
    }
    else{
        return confirm("Customer Id:     " + document.getElementById("customerID").value +
            " \nName :              " +  document.getElementById("firstname").value + " " +  document.getElementById("surname").value +
            "\nDate of Birth:    " + document.getElementById("dateOfBirth").value +
            "\nAddress :           " +  address +
            "\n\n  Please confirm this is the correct Customer"
        ) ;

    }

}


function dateCheck() {
    var fromDate = Date.parse(document.getElementById("searchFrom").value);
    var toDate = Date.parse(document.getElementById("searchTo").value);
    var now = new Date();
    if (now < fromDate) {
        alert("Search From Date cannot be in the future");
        return false;
    }
    else if (now < toDate) {
        alert("cannot search into the future");
        return false;
    }
    else if (fromDate > toDate)
    {
        alert("Search From date cannot be greater than Search To Date");
        return false;
    }
    else{
        return true;
    }

}



window.onload = function(){
    document.getElementById('listbox').selectedIndex = -1;
}

