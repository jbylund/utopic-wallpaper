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

$(document).ready(function ()
{
  update_sidebar_class(); // run after finishing the load 
  $(window).scroll(function ()
  {
    update_sidebar_class(); // run at every scroll
  });
});

