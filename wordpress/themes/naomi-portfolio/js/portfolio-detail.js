
YUI().use('node-base', function(Y) {
  
  function enablePrettyPhoto() {
    jQuery("a[rel^='lightBox']").prettyPhoto({
      animationSpeed: 'normal',
      animation_speed: 'normal',
      theme: 'facebook',
      social_tools: '',
      deeplinking: false,
      default_width: 601,
      default_height: 398
    });
  }
  
  function init() {
    if ( $$("a[rel^='lightBox']").length === 1 ) {
      enablePrettyPhoto();
    }
    
    Event.observe('projectsRows', 'click', function(event) {
      // did we click on a row label?
      var rowHdEl = Event.findElement(event, '.row-hd');
      if (rowHdEl)
      {
        // find the row element
        var row = Event.findElement(event, '.projects-row');
        if (row)
        {
          // if already active, do nothing
          if (!row.hasClassName('active'))
          {
            // close all other rows
            $$('#projectsRows .projects-row').each(function(s) {
              if (s !== row)
              {
                s.removeClassName('active');
              }
            });
           
            // open this row
            row.addClassName('active');
          }
        }
      }
    });
  }
  Y.on("domready", init);
});

