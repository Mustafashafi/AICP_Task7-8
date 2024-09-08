<?php include 'header.php'; ?>
<style>
    input{
        padding:5px;
        margin:5px;
    }
    textarea{
        margin:5px;
        width:49.6%;
        padding:20px;
    }
    button{
        margin-left:300px;
    }
</style>
<form action="business.php" method="POST">
    <input type="text" name="business_name" placeholder="Business Name" required>
    <select name="category" required style="padding:6px;
        margin:5px;">
        <option value="Food">Food</option>
        <option value="Healthcare">Healthcare</option>
        <option value="Hotels">Hotels</option>
        <option value="Education">Education</option>
    </select>
    <input type="text" name="address" placeholder="Address" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <button type="submit" name="add_business">Add Business</button>
</form>
<?php include 'footer.php'; ?>
