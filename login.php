<?php include 'header.php'; ?>
<form action="auth.php" method="POST">
    <h1 style="margin-left:100px">LogIn</h1>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
<br>
    <a href="signup.php" >Don't have an account? Sign Up</a>
</form>

<?php include 'footer.php'; ?>

<style>
   form  a{
        margin-left:40px;
    }
    input{
        padding:10px;
        width:250px;
        margin:10px;
    }
    form{
        margin-left:450px;
    }
    button{
        padding:5px 30px;
        border:none;
        background-color:blue;
        border-radius:5px;
        margin-left:100px;
color:white;

    }
</style>
