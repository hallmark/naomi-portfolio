
/**
 * config {}:
 *   visible: boolean - whether to display the Fringe panel
 *   options []:
 *     name
 *     labels[] 0: falseLabel, 1: trueLabel
 *     type
 *     defaultValue
 */
var Fringe = Class.create({
  initialize: function(config) {
    this.config = config;
    this.configMap = {};
    
    // create (name->option) map and set value to default
    for ( var i=0; i<this.config.options.length; i++ ) {
      var anOpt = this.config.options[i];
      anOpt['value'] = anOpt.defaultValue;
      this.configMap[anOpt.name] = anOpt;
    }
  },
  
  render: function() {
    if (this.config.visible === true) {
      this._createPanel();
    }
  },
  
  _createPanel: function() {
    var self = this;
    
    // create the container panel for the buttons!
    var panel = new Element('div', {'class':'fringe-panel', 'style':'position:fixed; top:10px; right:10px; width:170px; height:50px; z-index: 100; background-color:#CCbC7C'});
    document.body.appendChild(panel);
    
    for ( var i=0; i<this.config.options.length; i++ ) {
      var anOpt = this.config.options[i];
      var btn = new Element('a', {'href':'#', 'class':'button', 'style':''}).update(anOpt.labels[0]);
      panel.appendChild(btn);
      btn.observe('click', function(event) {
        var el = btn;
        var opt = anOpt;
        self.handleOptionClick(el, opt);
        
        event.stop();
        return false;
      });
    }
  },
  
  handleOptionClick: function(el, opt)
  {
    opt.value = !(opt.value);
    var labelIdx = (opt.value) ? 1 : 0;
    el.update(opt.labels[labelIdx]);
  },
  
  getValue: function(name) {
    var opt = this.getOptionByName(name);

    if ( opt === undefined ) {
      return undefined;
    }
    
    return opt.value;
  },
  
  getOptionByName: function(name) {
    return this.configMap[name];
  },
  
  foo: function()
  {
  }
  
});
