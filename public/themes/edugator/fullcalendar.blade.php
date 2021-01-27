@extends(theme('dashboard.layout'))

@section('content')
    @php
    $user_id = $auth_user->id;

    $enrolledCount = \App\Enroll::whereUserId($user_id)->whereStatus('success')->count();
    $wishListed = \Illuminate\Support\Facades\DB::table('wishlists')->whereUserId($user_id)->count();

    $myReviewsCount = \App\Review::whereUserId($user_id)->count();
    $purchases = $auth_user->purchases()->take(10)->get();
    @endphp
    123
    @if ($purchases->count() > 0 || 1 == 1)
        <h4 class="my-4"> {{ sprintf(__t('my_last_purchases'), $purchases->count()) }} </h4>
       asdf
   
            <div class="container">
                <div class="response"></div>
                <div id='calendar'></div>
            </div>
            asdf

    @endif
@endsection

@section('page-js')

<script>
    $(document).ready(function () {
           
          var SITEURL = "{{url('/')}}";
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
   
          var calendar = $('#calendar').fullCalendar({
              editable: true,
              events: SITEURL + "booking",
              displayEventTime: true,
              editable: true,
              eventRender: function (event, element, view) {
                  if (event.allDay === 'true') {
                      event.allDay = true;
                  } else {
                      event.allDay = false;
                  }
              },
              selectable: true,
              selectHelper: true,
              select: function (start, end, allDay) {
                  var title = prompt('Event Title:');
   
                  if (title) {
                      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
   
                      $.ajax({
                          url: SITEURL + "booking/create",
                          data: 'title=' + title + '&amp;start=' + start + '&amp;end=' + end,
                          type: "POST",
                          success: function (data) {
                              displayMessage("Added Successfully");
                          }
                      });
                      calendar.fullCalendar('renderEvent',
                              {
                                  title: title,
                                  start: start,
                                  end: end,
                                  allDay: allDay
                              },
                      true
                              );
                  }
                  calendar.fullCalendar('unselect');
              },
               
              eventDrop: function (event, delta) {
                          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                          $.ajax({
                              url: SITEURL + 'booking/update',
                              data: 'title=' + event.title + '&amp;start=' + start + '&amp;end=' + end + '&amp;id=' + event.id,
                              type: "POST",
                              success: function (response) {
                                  displayMessage("Updated Successfully");
                              }
                          });
                      },
              eventClick: function (event) {
                  var deleteMsg = confirm("Do you really want to delete?");
                  if (deleteMsg) {
                      $.ajax({
                          type: "POST",
                          url: SITEURL + 'booking/delete',
                          data: "&amp;id=" + event.id,
                          success: function (response) {
                              if(parseInt(response) > 0) {
                                  $('#calendar').fullCalendar('removeEvents', event.id);
                                  displayMessage("Deleted Successfully");
                              }
                          }
                      });
                  }
              }
   
          });
    });
   
    function displayMessage(message) {
      $(".response").html("<div class='success'>"+message+"</div>");
      setInterval(function() { $(".success").fadeOut(); }, 1000);
    }


  </script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
@endsection
