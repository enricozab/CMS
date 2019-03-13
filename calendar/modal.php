<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Create New Event</b></h4>
      </div>
      <div class="modal-body">
        <label>Title <span style="font-weight:normal; color:red;"> *</span></label>
        <input class="form-control" type="text" id="event-title" placeholder="Enter title" autocomplete="off" />
        <br>
        <label>Event Type <span style="font-weight:normal; color:red;"> *</span></label>
        <select class="form-control" id="event-type"  autocomplete="off">
          <option value="" disabled selected>Select Event Type</option>
          <option value="FIXED-TIME">Fixed Time Event</option>
          <option value="ALL-DAY">One Day Event</option>
        </select>
        <br>
        <div id="datearea" class="form-group" hidden>
          <label>Date <span style="font-weight:normal; color:red;"> *</span></label>
          <input class="form-control" type="text" id="event-date" placeholder="Enter Date" autocomplete="off"/>
        </div>
        <div id="timearea" class="form-group" hidden>
          <div class="row">
            <div class="col-sm-6">
              <label>Start Date & Time <span style="font-weight:normal; color:red;"> *</span></label>
              <input class="form-control" type="text" id="event-start-time" placeholder="Event Start Time" autocomplete="off" />
            </div>
            <div class="col-sm-6">
              <label>End Date & Time <span style="font-weight:normal; color:red;"> *</span></label>
              <input class="form-control" type="text" id="event-end-time" placeholder="Event End Time" autocomplete="off" />
            </div>
          </div>
        </div>
        <label>Attendee(s) <span style="font-weight:normal; color:red;"> *</span></label>
        <input class="form-control" type="text" id="event-attendees" placeholder="Event Attendees" autocomplete="off" /><br><br>

      </div>
      <div class="modal-footer">
        <button type="button" id="create-event" class="btn btn-primary" data-dismiss="modal">Create Event</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
      </div>
      <div class="modal-body">
        <p id="message"></message>
      </div>
      <div class="modal-footer">
        <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
