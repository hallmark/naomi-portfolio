/* jsGrowl Prototype Interface */

var jsGrowlInterface = {
  onload: function(jsg){
    Event.observe(window, 'load', function() {
      jsg.onload();
    });
  },
  insert: function(element,html){
    Element.insert(element,html);
  },
  fade:function(element,after_finish){
    Effect.Fade(element.id,{ duration: 1.0, afterFinish: after_finish });
  },
  appear: function(element){
    Effect.Appear(element.id,{ duration: .25, from: 0, to: .75 });
  },
  remove: function(element){
     element.remove(); 
  },
  fadeAndRemove: function(element,jsg,id){
    var f = function(){
      jsGrowlInterface.remove(element);
      jsg.removeMsg(id);
    };
    jsGrowlInterface.fade(element, f);
  }
  
};