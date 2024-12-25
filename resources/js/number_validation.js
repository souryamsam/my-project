function isonlyNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function isNumberKey(evt,id)
{
    try{
        var charCode = (evt.which) ? evt.which : event.keyCode;
    if(charCode==46){
        var txt=document.getElementById(id).value;
        if(!(txt.indexOf(".") > -1)){
            return true;
        }
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
        return false;
    return true;
    }
    catch(w){
        alert(w);
    }
}

function isNumberKeywithSlash(evt,id)
{
    try{
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if(charCode==92){
            var txt=document.getElementById(id).value;
            if(!(txt.indexOf("/") > -1)){
                return true;
            }
        }
        if (charCode > 93 && (charCode < 48 || charCode > 57) )
            return false;
        return true;
    }
    catch(w){
        alert(w);
    }
}