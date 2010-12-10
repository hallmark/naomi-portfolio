
var SplashCoverflow = Class.create({
  initialize: function(boxes, frontIndex) {
    this.boxes = boxes;
    this.frontIndex = frontIndex;
    this.support = {};
    
    // from http://gist.github.com/373874
    // (heavyweight method would be to use http://www.modernizr.com/docs/#csstransitions)
    this.support.csstransitions =  (function(){
        var thisBody = document.body || document.documentElement,
        thisStyle = thisBody.style,
        support = thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.OTransition !== undefined || thisStyle.transition !== undefined;

        return support;
    })();
  },
  
  render: function() {
    this._initBoxes();
    this._attachEvents();
  },
  
  handleFrontClick: function(evt, el)
  {
    var link = this.boxes[el.boxIdx].link;
    
    if (link)
    {
      window.location = link;
    }
    else
    {
      var title = this.boxes[el.boxIdx].title;
      //js_growl.addMessage({msg:'Clicked on ' + title});
      alert('Clicked on ' + title);
    }
  },
  
  handleSideClick: function(evt, el)
  {
    this.positionBoxes(el.boxIdx, true);
  },
  
  _attachEvents: function() {
    // prototype 1.7...
    //var frontHandler = new Event.Handler('stage', 'click', '.in-front', handleFrontClick);
    //frontHandler.start();
    
    var self = this;
    Event.observe('stage', 'click', function(event) {
      var frontEl = Event.findElement(event, '.in-front');
      var backEl = Event.findElement(event, '.in-back');
      if (frontEl)
      {
        self.handleFrontClick(event, frontEl);
      }
      else if (backEl)
      {
        self.handleSideClick(event, backEl);
      }
    });
    
  },
  
  _initBoxes: function() {
    $('dummyFrontBox').remove();
    
    var stage = $('stage');
    for (var i=0; i<this.boxes.length; i++)
    {
      var aBox = new Element("div", {'class':'box', id:'box'+i}).update(
        new Element("img", {'src':this.boxes[i].imgSrc})
      );
      aBox.boxIdx = i;
      stage.appendChild(aBox);
    }
    
    this.positionBoxes(this.frontIndex, false);
  },
  
  repositionBox: function(aBox, newWidth, newHeight, newTop, newLeft, useTransitions)
  {
    if (useTransitions)
    {
      var curTop = parseInt(aBox.getStyle('top').replace("px", ""), 10);
      var curLeft = parseInt(aBox.getStyle('left').replace("px", ""), 10);
      new Effect.Move(aBox, {x: newLeft-curLeft, y: newTop-curTop, duration:0.4, transition: Effect.Transitions.sinoidal});
      
      var curWidth = aBox.getWidth();
      var pcnt = newWidth / curWidth * 100.0;
      //var curHeight = aBox.getHeight();
      new Effect.Scale(aBox, pcnt, {scaleMode: { originalHeight: newHeight/pcnt*100.0, originalWidth: newWidth/pcnt*100.0 }, duration:0.4, transition: Effect.Transitions.sinoidal})
    }
    else
    {
      aBox.setStyle({
        width: newWidth + 'px',
        height: newHeight + 'px',
        top: newTop + 'px',
        left: newLeft + 'px'
      });
    }
  },
  
  positionBoxes: function(newCenterIdx, useTransitions)
  {
    // 	-webkit-transition: left .4s ease-in-out, top .4s ease-in-out, -webkit-transform .4s ease-in-out, -webkit-box-shadow .4s linear, opacity .4s linear;
    
    
    // set position/styles of new center box
    var aBox = $('box'+newCenterIdx);
    aBox.setStyle({
      border: '1px solid white',
      margin: 0,
      'zIndex': 10
    });
    this.repositionBox(aBox, 425, 285, 0, 0, useTransitions);
    /*
    if (useTransitions)
    {
      var curTop = parseInt(aBox.getStyle('top').replace("px", ""), 10);
      var curLeft = parseInt(aBox.getStyle('left').replace("px", ""), 10);
      new Effect.Move(aBox, {x: -curLeft, y: -curTop, duration:0.4, transition: Effect.Transitions.sinoidal});
      
      var curWidth = aBox.getWidth();
      var pcnt = 425.0 / curWidth * 100.0;
      //var curHeight = aBox.getHeight();
      new Effect.Scale(aBox, pcnt, {scaleMode: { originalHeight: 285/pcnt*100.0, originalWidth: 425/pcnt*100.0 }, duration:0.4, transition: Effect.Transitions.sinoidal})
    }
    else
    {
      aBox.setStyle({
        width: 425,
        height: 285,
        top: 0,
        left: 0
      });
    }*/
    aBox.addClassName('in-front');
    aBox.removeClassName('in-back');
    
    // set positions/styles of LH boxes
    for (var i=0; i<newCenterIdx; i++) {
      aBox = $('box'+i);
      aBox.setStyle({
        /*width: 185,
        height: 125,*/
        border: 'none',
        margin: 0,
        'zIndex': 1 /*,
        top: 90,
        left: 115 - ( (newCenterIdx-i)*205 )*/
      });
      this.repositionBox(aBox, 185, 125, 90, 115 - ( (newCenterIdx-i)*205 ), useTransitions);
      aBox.addClassName('in-back');
      aBox.removeClassName('in-front');
    }

    // set positions/styles of RH boxes
    for (var i=newCenterIdx+1; i<this.boxes.length; i++) {
      aBox = $('box'+i);
      aBox.setStyle({
        /*width: 185,
        height: 125,*/
        border: 'none',
        margin: 0,
        'zIndex': 1 /*,
        top: 90,
        left: 127 + ( (i-newCenterIdx)*205 )*/
      });
      this.repositionBox(aBox, 185, 125, 90, 127 + ( (i-newCenterIdx)*205 ), useTransitions);
      aBox.addClassName('in-back');
      aBox.removeClassName('in-front');
    }
    
  }
  
});
