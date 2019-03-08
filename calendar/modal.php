<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Create New Event</b></h4>
      </div>
      <div class="modal-body">
        <input class="form-control" type="text" id="event-title" placeholder="Event Title" autocomplete="off" /><br><br>
        <select class="form-control" id="event-type"  autocomplete="off">
          <option value="FIXED-TIME">Fixed Time Event</option>
          <option value="ALL-DAY">All Day Event</option>
        </select><br><br>
        <input class="form-control" type="text" id="event-start-time" placeholder="Event Start Time" autocomplete="off" /><br><br>
        <input class="form-control" type="text" id="event-end-time" placeholder="Event End Time" autocomplete="off" /><br><br>
        <input class="form-control" type="text" id="event-date" placeholder="Event Date" autocomplete="off" /><br><br>
        <input class="form-control" type="text" id="event-attendees" placeholder="Event Attendees" autocomplete="off" /><br><br>

      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="create-event">Create Event</button>
      </div>
    </div>
  </div>
</div>
