function login() {
    var xhttp = new XMLHttpRequest();
    const formDatas = new URLSearchParams(new FormData(LoginForm)).toString();
    xhttp.open("POST", "/user/login", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formDatas);
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState === 4) {
            responceArray = jsonDecode(this.responseText);
            // console.log(responceArray);
            if (responceArray['status']['status code'] === 200) {
                window.location = "/user/viewHomePage";
            } else {
                document.getElementById('errorMessage').innerHTML = responceArray['status']['message'];
            }
        }
    }
};

function jsonDecode(response) {
    return JSON.parse(response);
}

function getData() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "../api/products", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState === 4) {
            responceArray = jsonDecode(this.responseText);
            if (responceArray['status']['status code'] == 200) {
                dataArray = responceArray['data']['dataArray'];
                for (key in dataArray) {
                    dataArray2 = dataArray[key];
                    for (key2 in dataArray2) {
                        createProduct(dataArray2);
                    }
                }
            }
        }
    }
}

function createProduct(productDetails) {
    for (key in productDetails) {
        createProtectTable(key, productDetails[key])
    }
    createButton();
}

function createButton() {
    row = document.createElement('tr');
    button = document.createElement('input');
    button.type = "button";

    if (responceArray['data']['roll'] === 'b') {
        button.value = 'Buy';
        // button.onclick = removeProduct()
    } else {
        button.value = 'remove';
        // button.onclick = buyProduct()
    }
    cell1 = row.insertCell(0);
    cell1.appendChild(button)
    row.insertCell(cell1);
    cell2 = row.insertCell(0);
    productTable.appendChild(row);
    productTable.appendChild(document.createElement('tr'));
}

function createProtectTable(fieldName, fieldValue) {
    productTable = document.getElementById("productTable")
    var row = document.createElement('tr');

    if (fieldName == 'productid') {
        buttonId = fieldValue;
    } else {
        cell1 = row.insertCell(0);
        cell1.innerHTML = fieldName;
        cell2 = row.insertCell(0);
        cell2.innerHTML = fieldValue;
        productTable.appendChild(row);
    }
}

function sellProduct() {
    var xhttp = new XMLHttpRequest();
    const formDatas = new URLSearchParams(new FormData(productSellForm)).toString();
    xhttp.open("POST", "../api/product", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formDatas);
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState === 4) {
            responceArray = jsonDecode(this.responseText);
            if (responceArray['status']['status code'] === 201) {
                window.location = "/user/viewHomePage";
            } else {
                document.getElementById('errorMessage').innerHTML = responceArray['status']['message'];
            }
        }
    }
}

function createAccount() {
    var xhttp = new XMLHttpRequest();
    const formDatas = new URLSearchParams(new FormData(accountCreateForm)).toString();
    xhttp.open("POST", "../api/user", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(formDatas);
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState === 4) {
            responceArray = jsonDecode(this.responseText);
            if (responceArray['status']['status code'] === 201) {
                window.location = "../user/viewLoginPage";
            } else {
                document.getElementById('errorMessage').innerHTML = responceArray['status']['message'];
            }
        }
    }
}

function loadLoginBody() {
    console.log(this.responseText);
}

function removeProduct() {
    alert('Service Not available');
}

function buyProduct() {
    alert('Service Not available');
}