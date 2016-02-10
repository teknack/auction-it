
function filterdata(msg){
	var wordarray = msg.split(' ');
	var i;
	$.getJSON("offensivewords.json", function(result){
		$.each(result, function(i, field){
	        var index = wordarray.indexOf(field);
	        var wordlength = field.length;
	        var temp[];
	        for(i = 0 ; i < wordlength ; i++){
	        	temp[i] = "*";
	        }
	        var newword = temp.toString();
	        if(index > -1){
	        	wordarray[index] = newword;
	        }
	    }
	}
	var newstring = wordarray.toString();
	return newstring;
}
