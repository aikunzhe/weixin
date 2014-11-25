
    function $(id)
    {
        return document.getElementById(id);
    }

	//创建 XMLHttpRequest 对象
	function getXmlHttpObject(){
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  return xmlhttp;
	}
    
    function tmp()
    {
     //1.获取按键 兼容


      //按下按键 就会产生对象。不按下按键，就会产生空值
    　 var currKey=0,e=e||event;
  　   currKey=e.keyCode||e.which||e.charCode;
  　　var keyName = String.fromCharCode(currKey);
   　alert("按键码: " + currKey + " 字符: " + keyName);  
  //配合元素标签使用
 // <body onkeydown="move(event)"></body>
  
   
   
   
   
   
 //2.遍历对象所有的方法 所有的属性名称和值
 
  var obj = '';//填对象
  var props;
  // 开始遍历
  for ( var p in obj ) 
  { // p 为属性、方法名称，obj[p]为对应属性的值
  props = p + " = " + obj [ p ] ;
     // 最后显示所有的属性
   document.writeln ( '属性：'+props +'<br>') ;
  } 
    
    }
   