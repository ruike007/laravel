function validate()
{
    var pw1 = username=document.regform.password.value;
    var pw2 =userneme=document.regform.password2.value;
    if(pw1 == pw2)
    {
        document.getElementById("tish1").innerHTML="<font color='green'>两次密码相同</font>";
        document.getElementById("submit").disable = false;
    }
    else
    {
        document.getElementById("tishi").innerHTML="<font color='red'>两次密码不相同</font>";
        document.getElementById("submit").disable = true;
    }
}