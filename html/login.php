<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link rel="stylesheet" href="../css/mainForm.css">
</head>
<body>
    <div class="title">
        <h1>Welcome to FCI FYP Management System</h1>
    </div>
    <div class="main">
        <h1>Log In Form</h1>
        <h3>Enter your login credentials</h3>
        <form action="loginfunc.php" method="post">
            <p class="col-25">
                <label for="role">Role</label>
            </p>
            <p class="col-75">
                <select name="role" required>
                    <option value="">Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                    <option value="supervisor">Supervisor</option>
                </select>
            </p>
            <p class="col-25">
                <label for="numberID">Number ID</label>
            </p>
            <p class="col-75">
                <input type="text" name="numberID" placeholder="Enter your identification number" required/>
            </p>

            <p class="col-25">
                <label for="password">Password:</label>
            </p>
            <p class="col-75">
                <input type="password" name="password" placeholder="The password must be length between 6 and 12" 
                required pattern="[A-Za-z0-9]{6,12}"/>
            </p>
            <p>
                <input type="submit" name="login" value="Log In">
            </p>
        </form>
        <p>Not registered?
            <a href="signup.php" style="text-decoration: none;">
                Create an account
            </a>
        </p>
    </div>
</body>
</html>
