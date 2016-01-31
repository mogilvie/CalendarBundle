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
        new : null,
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
        $(document).on('submit', 'form[name="specshaper_calendar_event"]', Calendar.eventSubmitHandler);
        $(document).on('click', '#addInviteeButton', Calendar.addInviteeButtonClickHander);
        $(document).on('click', '.removeInviteeButton', Calendar.removeInviteeClickHandler);
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
    bindColorPicker: function () {
        $('#specshaper_calendar_event_bgColor').simplecolorpicker({theme: 'fontawesome'});
    },
    /**
     * Bind the datepickers to the modal datetime inputs.
     * 
     * @returns {undefined}
     */
    bindDatePickers: function () {
        $('input#specshaper_calendar_event_startDate').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
        $('input#specshaper_calendar_event_endDate').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
        $('input#specshaper_calendar_event_repeatUntil').datepicker({
            format: "dd M yyyy",
            autoclose: true
        });
    },
    addInviteeButtonClickHander: function (e) {
        e.preventDefault();

        var input = $('#emailAddressesInput');

        if (input.val().length === 0) {
            return;
        }

        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        
        var is_email = re.test(input.val());
        
        if (is_email) {
            input.removeClass("invalid").addClass("valid");
        }
        else {
            input.removeClass("valid").addClass("invalid");
        }
        
        Calendar.addInvitee(input.val());
    },
    addInvitee: function (newAddress) {


        var $collectionHolder = $('#inviteeContainer');

        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

//        newForm = prototype.replace('<td class="emailAddress">', '<td class="emailAddress">' + newAddress + );

        var html = $.parseHTML( newForm );

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        
        $(html).find("span.emailAddress").text(newAddress);
        $(html).find("input.hiddenEmailAddress").val(newAddress);

        // Display the form in the page in an li, before the "Add a tag" link li
        $collectionHolder.append(html);


    },
    removeInviteeClickHandler: function(e){
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $(this).closest('tr').remove();

    },
    getAddressesFromServer: function () {

        var url = Calendar.settings.addresses;

        $.ajax(
                {
                    url: url,
                    type: "GET",
                    success: function (html, textStatus, jqXHR)
                    {

                        $("#emailAddresses").html();

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                        var w = window.open();
                        var html = XMLHttpRequest.responseText;
                        $(w.document.body).html(html);
                    }
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

        var url = Calendar.settings.new;

        $.ajax(
                {
                    url: url,
                    type: "GET",
                    success: function (html, textStatus, jqXHR)
                    {
                        $("#eventModal").find('div.modal-body').replaceWith($(html).find('div.modal-body'));

                        Calendar.bindDatePickers();
                        Calendar.bindColorPicker();

                        var $eventModal = $('#eventModal');

                        $eventModal.find('#specshaper_calendar_event_startDate').datepicker("setDate", start.format('DD/MM/YYYY'));
                        $eventModal.find('#specshaper_calendar_event_endDate').datepicker("setDate", end.format('DD/MM/YYYY'));

                        $eventModal.find('#specshaper_calendar_event_startTime').val(start.format('HH:mm'));
                        $eventModal.find('#specshaper_calendar_event_endTime').val(end.format('HH:mm'));

                        $eventModal.modal('show');

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                        var w = window.open();
                        var html = XMLHttpRequest.responseText;
                        $(w.document.body).html(html);
                    }
                });


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

        var $form = $('form[name="specshaper_calendar_event"]');

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



