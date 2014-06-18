if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}

function update_sidebar_class()
{
  var wintop = $(this).scrollTop(); // number of pixels hidden before
  var winbot = $(this).scrollTop() + $(window).height(); // last row displayed on screen
  var excluded_top = false;
  var excluded_bot = false;

  if (winbot < $('#header').height() + 1) // bottom of the header is not on the page
  {
    $('#rightcontents').attr('class', 'hiddena');
  }
  else if (wintop > $(document).height() - $('#footer').height()) // top of the footer is not on the page
  {
    $('#rightcontents').attr('class', 'hiddenb');
  }
  else
  {
    if (wintop < $('#header').height() + 1)
    {
      excluded_top = true;
    }
    if (wintop + $("#rightcontents").height() > $(document).height() - $('#footer').height())
    {
      excluded_bot = true;
    }
    if (excluded_top)
    {
      if (excluded_bot)
      {
        $('#rightcontents').attr('class', 'excluded_both');
      }
      else
      {
        $('#rightcontents').attr('class', 'excluded_top');
      }
    }
    else if (excluded_bot)
    {
      $('#rightcontents').attr('class', 'excluded_bot');
    }
    else
    {
      $('#rightcontents').attr('class', 'all_visible');
    }
  }
}

function shrink_size(frameId, delta_x, delta_y) {
  var frameOffset = $(frameId).offset();
  var frameWidth  = $(frameId).width() - delta_x;
  var frameHeight = $(frameId).height() - delta_y;
  return ([frameOffset.left, frameOffset.top, frameOffset.left + frameWidth, frameOffset.top + frameHeight]);
}

function update_draggables()
{
  $(".draggable").draggable({
    revert: 'invalid',
    helper: 'clone',
    snap: '.droptarget',
    snapMode: 'inner',
    zIndex: 100,
    containment: shrink_size("#wrapper",170,300), // these are the entrysize dimensions - dropsize dimensions
    start: function(e, ui) {
      var x = $(ui.helper);
      var y = $(ui.helper);
      $(ui.helper).addClass("dropsize");
    },
    cursorAt: {left: 75, top: 45} // these are half the dropsize dimensions
  });

  $(".droptarget").droppable({
    tolerance: 'pointer',
    drop: function( event, ui ) {
      $(this).addClass("dropped");
      $(this).empty(); 
      // check if it already contains a photo, if so need to "reactivate" that one
      if ($(ui.draggable).hasClass("entryphoto")) // if its an entry photo then make the original not draggable
      {
        ui.helper.removeClass();
        var src = ui.helper.attr('src');
        var title = ui.helper.attr('title');
        $(this).append('<img src="{0}" title="{1}" class="{2} {3} {4}">'.format(src,title,"dropped","dropsize","voted"));
        $(ui.draggable).draggable('disable');
      }
      else // otherwise it can stay draggable
      {
        var src = ui.draggable.attr('src');
        var title = ui.draggable.attr('title');
        $(this).append('<img src="{0}" title="{1}" class="{2} {3} {4}">'.format(src,title,"dropped","dropsize","voted"));
        $(ui.draggable).remove();
      }
      $(".voted").draggable({
          revert: false,
          snap: '.droptarget',
          snapMode: 'inner',
          containment: '#wrapper',
          revert: function(valid) {
            if(!valid) {
              $(this).remove();
              // need to reactivate the parent draggable
            }
            return false;
          }
        });
    }
  });
}

$(document).ready(function ()
{
  update_draggables();
  update_sidebar_class(); // run after finishing the load 

  $(window).scroll(function () // run at every scroll
  {
    update_sidebar_class();
  });

  $(window).resize(function() // run at every resize
  {
    update_draggables();
    update_sidebar_class();
  });
});

