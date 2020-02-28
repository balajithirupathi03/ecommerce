<html>

<head>
    <script src="../Public/View/JavaScript/userJS.js"></script>
    <link rel="stylesheet" href="../../Public/View/Css/login.css" type="text/css">

</head>
<h1>User Registration Form</h1>
<body>
    <form method="post" name='accountCreateForm' onsubmit="createAccount(event);return false;" >
        <table>
            <tr>
                <td colspan="2" id='errorMessage'></td>
            </tr>
            <tr>
                <td>Name</td>
                <td> : <input type="text" name="name" pattern="^[A-Za-z]*\s*[A-Za-z]*$" placeholder="Enter your Name" required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><input type="radio" name="gender" value="m" checked> Male
                    <input type="radio" name="gender" value="f"> Female
                    <input type="radio" name="gender" value="other"> Other </td>
            </tr>
            <tr>
                <td>Mail Id </td>
                <td> : <input type="email" name="mailid" placeholder="Enter your Mail" required> </td>
            </tr>
            <tr>
                <td>Contect Number</td>
                <td> : <input type="text" name="contactnumber" pattern="[6-9][0-9]{9}" placeholder="+91" required></td>
            </tr>
                <input name="roleid" value="1" checked hidden>
            <tr>
                <td>Country</td>
                <td> : <input type="radio" name="country" value="in"> India
                    <input type="radio" name="country" value="us"> USA
                    <input type="radio" name="country" value="jp"> Japan
                    <input type="radio" name="country" value="uk"> UK
                    <input type="radio" name="country" value="my" checked> Malaysia </td>
            </tr>
            <tr>
                <td>Password </td>
                <td> : <input type="password" name="password" required></td>
            </tr>
            <tr>
                <td><input type='submit' name='CreateAccount'></td>
                <td></td>
            </tr>
        </table>
    </form>
</body>

</html>