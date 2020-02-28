<html>

<head>
    <script src="../../Public/View/JavaScript/userJS.js"></script>
</head>

<body>
    <h1>Product Sell Form</h1>
    <form method="POST" name='productSellForm' onsubmit="sellProduct(event);return false;">
        <table>
            <tr>
                <td>Product Name </td>
                <td> <input type="text" name="productname" required></td>
            </tr>
            <tr>
                <td>Price </td>
                <td> <input type="text" name="price" required></td>
            </tr>
            <tr>
                <td>Productcount </td>
                <td> <input type="text" name="productcount" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="SellProduct"></td>
                <td></td>
            </tr>
        </table>
        <form>
</body>

</html>