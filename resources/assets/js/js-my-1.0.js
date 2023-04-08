// JavaScript Document
function showLoading(){ $('#loading').css({visibility:"visible"}).css({opacity:"1"});}
//hide loading bar
function hideLoading(){ $('#loading').fadeTo(200, 0);};
var ansclose = false; window.onbeforeunload = ansout; function ansout(){ if (ansclose)return "Precaución de Cierre!";}