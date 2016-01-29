/**
 * Custom class to initialise and interact with the FullCalendar.js plugin.
 * 
 * The class sets up the FullCalendar plugin, and contains all the event
 * handlers and ajax calls back to the Symfony2 controller.
 * 
 * @type type
 */
Calendar = {
    settings: {
        loader: null,
        update: null,
        updateDateTime: null,
        calendar: null,
        currentEvent: null
    },
    init: function (options) {
        Calendar.settings = $.extend(Calendar.settings, options);
        this.bindUIActions();
    },
    bindUIActions: function () {
        $(document).on('ready', Calendar.onReady);
        $(document).on('click', '#submitButton', Calendar.submitButtonClickHander);
        $(document).on('submit', 'form[name="specshaper_calendar_persisted_event"]', Calendar.eventSubmitHandler);
    },
    /**
     * Prepare the calendar and modals.
     * 
     * @returns {undefined}
     */
    onReady: function () {

        Calendar.bindDatePickers();
        Calendar.bindColorPicker();

        Calendar.settings.calendar = $('#calendar-holder');

        Calendar.settings.calendar.fullCalendar({
            header: {
                left: 'prev, next',
                center: 'title',
                right: 'month, agendaWeek, agendaDay,'
            },
            editable: true,
            droppable: true,
            lazyFetching: true,
//            timeFormat: {
//                // for agendaWeek and agendaDay
//                agenda: 'h:mmt', // 5:00 - 6:30
//
//                // for all other views
//                '': 'h:mmt'         // 7p
//            },
//            eventRender: function(event, eventElement) {
//          
////                if(event)
////                    eventElement.find("div.fc-content").prepend("<img src='" + event.imageurl +"' width='12' height='12'>");
//                
//            },
            eventSources: [
                {
                    url: Calendar.settings.loader,
                    type: 'POST',
                    // A way to add custom filters to your event listeners
                    data: {
                    },
                    error: function () {
                        // TODO Translate error
                        alert('Error loading events!');
                    }
                }
            ],
            selectable: true,
            selectHelper: true,
            select: Calendar.select,
            eventClick: Calendar.eventClickHandler,
            eventResize: Calendar.eventResizeHandler,
            eventDrop: Calendar.eventDropHandler
        });

    },
    bindColorPicker: function() {
        $('#specshaper_calendar_persisted_event_bgColor').simplecolorpicker({theme: 'fontawesome'});
    },
    /**
     * Bind the datepickers to the modal datetime inputs.
     * 
     * @returns {undefined}
     */
    bindDatePickers: function () {
        $('input#specshaper_calendar_persisted_event_startDate').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
        $('input#specshaper_calendar_persisted_event_endDate').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
        $('input#specshaper_calendar_persisted_event_repeatUntil').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
    },
    
    /**
     * Function called when calendar dates are selected.
     * 
     * Get the selection start and end times, then open the new event modal.
     * 
     * @param {type} start
     * @param {type} end
     * @param {type} allDay
     * @returns {undefined}
     */
    select: function (start, end, allDay) {

        var $eventModal = $('#eventModal');

        $eventModal.find('#specshaper_calendar_persisted_event_startDate').datepicker("setDate", start.format('DD/MM/YYYY'));
        $eventModal.find('#specshaper_calendar_persisted_event_endDate').datepicker("setDate", end.format('DD/MM/YYYY'));

        $eventModal.find('#specshaper_calendar_persisted_event_startTime').val(start.format('HH:MM'));
        $eventModal.find('#specshaper_calendar_persisted_event_endTime').val(end.format('HH:MM'));

        $eventModal.modal('show');
    },
    /**
     * Function fired when a user selected a calendar event.
     * 
     * Loads the event using ajax to get data from back end and populate the
     * modal.
     * 
     * Show the modal.
     * 
     * @param {type} calEvent
     * @param {type} jsEvent
     * @param {type} view
     * @returns {undefined}
     */
    eventClickHandler: function (calEvent, jsEvent, view) {

        jsEvent.preventDefault();

        var route = Calendar.settings.update;

        var url = route.replace('PLACEHOLDER', calEvent.id);

        $.ajax(
                {
                    url: url,
                    type: "GET",
                    success: function (html, textStatus, jqXHR)
                    {
                        $("#eventModal").find('div.modal-body').replaceWith($(html).find('div.modal-body'));
                        Calendar.bindDatePickers();
                        Calendar.bindColorPicker();
                        $("#eventModal").modal('show');

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                        var w = window.open();
                        var html = XMLHttpRequest.responseText;
                        $(w.document.body).html(html);
                    }
                });
    },
    /**
     * Modal submit button clicked then triggers the form submit button.
     * 
     * @returns {undefined}
     */
    submitButtonClickHander: function () {
        $(document).find('#eventSubmitButton').click();
    },
    /**
     * Event modal submit click handler.
     * 
     * Serilize the modal form and submit via ajax.
     * 
     * Process the update depending if it is a new post or updated put method.
     * 
     * @param {type} e
     * @returns {undefined}
     */
    eventSubmitHandler: function (e) {

        e.preventDefault();

        var $form = $('form[name="specshaper_calendar_persisted_event"]');

        // Serialize the form.
        var postData = $form.serializeArray();

        var formURL = $form.attr("action");

        var type = $form.attr("method");

        if ($form.find("input[name='_method']").val() === "PUT") {
            type = "PUT";
        }

        $.ajax(
                {
                    url: formURL,
                    type: type,
                    data: postData,
                    success: function (html, textStatus, jqXHR)
                    {
                        if (type === "PUT") {
                            Calendar.updateEventInCalendar(html);
                        } else {
                            Calendar.addEventToCalendar(html);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                        var w = window.open();
                        var html = XMLHttpRequest.responseText;
                        $(w.document.body).html(html);
                    }
                });

        $('#eventModal').modal('hide');

    },
    /**
     * Add an event to the calendar.
     * 
     * @param {type} event
     * @returns {undefined}
     */
    addEventToCalendar: function (event) {

        Calendar.settings.calendar.fullCalendar('renderEvent', event, true);

        Calendar.settings.calendar.fullCalendar('unselect');

    },
    /**
     * Update an event in the calendar.
     * 
     * @param {type} event
     * @returns {undefined}
     */
    updateEventInCalendar: function (event) {

        $('#calendar-holder').fullCalendar('removeEvents', [event.id]);

        Calendar.addEventToCalendar(event);

    },
    /**
     * Confim if the change is intentional and update.
     * 
     * @todo  Add a modal confirmation.
     * @param {type} event
     * @param {type} delta
     * @param {type} revertFunc
     * @returns {undefined}
     */
    eventResizeHandler: function (event, delta, revertFunc) {

//        alert(event.title + " end is now " + event.end.format());
//
//        if (!confirm("is this okay?")) {
//            revertFunc();
//        }
        Calendar.updateDateTime(event);


    },
    /**
     * Confim if the change is intentional and update.
     * 
     * @todo  Add a modal confirmation.
     * @param {type} event
     * @param {type} delta
     * @param {type} revertFunc
     * @returns {undefined}
     */
    eventDropHandler: function (event, delta, revertFunc) {

//        alert(event.title + " was dropped on " + event.start.format());
//
//        if (!confirm("Are you sure about this change?")) {
//            revertFunc();
//        }

        Calendar.updateDateTime(event);

    },
    /**
     * Function to send the updated time to the backend.
     * 
     * @todo Add a success message.
     * @param {type} event
     * @returns {undefined}
     */
    updateDateTime: function (event) {

        var route = Calendar.settings.updateDateTime;

        var url = route.replace('PLACEHOLDER', event.id);

        var postData = {
            "start": event.start.format(),
            "end": event.end.format()
        };

        $.ajax(
                {
                    url: url,
                    data: postData,
                    type: "PUT",
                    success: function (html, textStatus, jqXHR)
                    {

//                        $("#eventModal").find('div.modal-body').replaceWith($(html).find('div.modal-body'));
//                        Calendar.bindDatePickers();
//                        $("#eventModal").modal('show');

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                        var w = window.open();
                        var html = XMLHttpRequest.responseText;
                        $(w.document.body).html(html);
                    }
                }
        );
    }

};



