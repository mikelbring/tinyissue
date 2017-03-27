/*
 Modifica e usa come vuoi

 Creato da TurboLab.it - 01/01/2014 (buon anno!)
*/
CKEDITOR.dialog.add("tliyoutube2Dialog",function(b){return{title:b.lang.tliyoutube2.title,minWidth:400,minHeight:75,contents:[{id:"tab-basic",label:"Basic Settings",elements:[{type:"text",id:"youtubeURL",label:b.lang.tliyoutube2.txtUrl}]}],onOk:function(){var c=this.getValueOf("tab-basic","youtubeURL").trim().match(/v=([^&$]+)/i);if(null==c||""==c||""==c[0]||""==c[1])return alert(b.lang.youtube.invalidUrl),!1;var a=b.document.createElement("iframe");a.setAttribute("width","560");a.setAttribute("height",
"315");a.setAttribute("src","//www.youtube.com/embed/"+c[1]+"?rel\x3d0");a.setAttribute("frameborder","0");a.setAttribute("allowfullscreen","1");b.insertElement(a)}}});