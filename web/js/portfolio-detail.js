
YUI().use('node-base', function(Y) {
  
  function setNavClasses() {
    if ( $(document.body).hasClassName('page-cat-documentary') )
    {
      $$("div.nav-cat-documentary")[0].addClassName('active');
    }
    else if ( $(document.body).hasClassName('page-cat-video') )
    {
      $$("div.nav-cat-video")[0].addClassName('active');
    }
    else if ( $(document.body).hasClassName('page-cat-exhibits') )
    {
      $$("div.nav-cat-exhibits")[0].addClassName('active');
    }
    else if ( $(document.body).hasClassName('page-cat-designs') )
    {
      $$("div.nav-cat-designs")[0].addClassName('active');
    }
  }
  
  function enablePrettyPhoto() {
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
      animationSpeed: 'normal',
      animation_speed: 'normal',
      theme: 'facebook',
      default_width: 601,
      default_height: 398
    });
  }
  
  function init() {
    setNavClasses();
    
    if ( $$("a[rel^='prettyPhoto']").length === 1 ) {
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

