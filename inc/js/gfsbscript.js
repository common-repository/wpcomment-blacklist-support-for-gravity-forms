
function addformsid(){
    var values = Array.prototype.slice.call(document.querySelectorAll('#selectform option:checked'),0).map(function(v,i,a) {
                                                                                                           return v.value;
                                                                                                           });
    var checkinput = document.getElementById("selectedform").value;
    
    if (checkinput !== ""){
        
        document.getElementById("selectedform").value += ","+values;
    }else{
        document.getElementById("selectedform").value += values;
        
    }
}
function removeformsid(){
    //var e = document.getElementById("selectform");
    document.getElementById("selectedform").value = "";
}
