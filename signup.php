<?php include 'header.php'; ?>
<form action="auth.php" method="POST"><br>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
    <input type="text" name="city" placeholder="City" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <button type="submit" name="register">Sign Up</button>
</form>
<?php include 'footer.php'; ?>

<style>
    form{
        text-align:center;
    }
    input{
        padding:5px;
        margin:10px;
    }
</style>
