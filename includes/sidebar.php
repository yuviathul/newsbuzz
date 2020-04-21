<?php
include ('csrf.php');
?>
<style>
    /* COMPACT CAPTCHA */

    .capbox {
        background-color: #BBBBBB;
        background-image: linear-gradient(#BBBBBB, #9E9E9E);
        border: #2A7D05 0px solid;
        border-width: 2px 2px 2px 20px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        display: inline-block;
        padding: 5px 8px 5px 8px;
        border-radius: 4px 4px 4px 4px;
    }

    .capbox-inner {
        font: bold 12px arial, sans-serif;
        color: #000000;
        background-color: #E3E3E3;
        margin: 0px auto 0px auto;
        padding: 3px 10px 5px 10px;
        border-radius: 4px;
        display: inline-block;
        vertical-align: middle;
    }

    #CaptchaDiv {
        color: #000000;
        font: normal 25px Impact, Charcoal, arial, sans-serif;
        font-style: italic;
        text-align: center;
        vertical-align: middle;
        background-color: #FFFFFF;
        user-select: none;
        display: inline-block;
        padding: 3px 14px 3px 8px;
        margin-right: 4px;
        border-radius: 4px;
    }

    #CaptchaInput {
        border: #38B000 2px solid;
        margin: 3px 0px 1px 0px;
        width: 105px;
    }

</style>
<div class="well">

    <h4>Search</h4>
    <form method="POST" action="search.php">
        <div class="input-group">
            <input pattern="[A-Za-z0-9_]{1,32}" title="special characters are not allowed" name="search" type="text" class="form-control" required>
            <span class="input-group-btn">
                            <button style ="height: 34px;color: black;" name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
        </div>
    </form>

</div>


<?php if(!isset($_SESSION['id'])){ ?>
<div class="well">
    <h4>Login</h4>
    <form method="POST" action="login.php"  onsubmit="return checkform(this);">
        <input type="hidden" name="_token" class="form-control" value="<?php echo $_session['_token'];?>"
                    <div class="">
        <input pattern="[A-Za-z0-9_]{1,32}" title="special characters are not allowed" name="user_name" type="text" class="form-control" placeholder="Enter Username" required>
        <br>


<div class="input-group">
    <input name="user_password" style="width:321px" type="password" class="form-control" placeholder="Enter Passsword" required>
</div>
<!-- START CAPTCHA -->
<br>
<div class="capbox">

    <div id="CaptchaDiv"></div>

    <div class="capbox-inner">
        Type the number:<br>

        <input type="hidden" id="txtCaptcha">
        <input type="text" name="CaptchaInput" id="CaptchaInput" size="15"><br>

    </div>
</div>
<br><br>
<!-- END CAPTCHA -->

<br>
<span class="input-group-btn">
                            <button name="login" class="btn btn-primary" type="submit">
Submit
                        </button>
                        </span>
</div>
</form>
<script type="text/javascript">

    // Captcha Script

    function checkform(theform){
        var why = "";

        if(theform.CaptchaInput.value == ""){
            why += "- Please Enter CAPTCHA Code.\n";
        }
        if(theform.CaptchaInput.value != ""){
            if(ValidCaptcha(theform.CaptchaInput.value) == false){
                why += "- The CAPTCHA Code Does Not Match.\n";
            }
        }
        if(why != ""){
            alert(why);
            return false;
        }
    }

    var a = Math.ceil(Math.random() * 9)+ '';
    var b = Math.ceil(Math.random() * 9)+ '';
    var c = Math.ceil(Math.random() * 9)+ '';
    var d = Math.ceil(Math.random() * 9)+ '';
    var e = Math.ceil(Math.random() * 9)+ '';

    var code = a + b + c + d + e;
    document.getElementById("txtCaptcha").value = code;
    document.getElementById("CaptchaDiv").innerHTML = code;

    // Validate input against the generated number
    function ValidCaptcha(){
        var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
        var str2 = removeSpaces(document.getElementById('CaptchaInput').value);
        if (str1 == str2){
            return true;
        }else{
            return false;
        }
    }

    // Remove the spaces from the entered and generated code
    function removeSpaces(string){
        return string.split(' ').join('');
    }
</script>
</div>
<?php }?>
<a href="register.php"> <img src="image/registernow.gif" alt="HTML5 Icon" style="width:358px;height:140px;"></a>

