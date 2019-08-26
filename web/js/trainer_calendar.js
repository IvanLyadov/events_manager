document.addEventListener("DOMContentLoaded", function(event) {
  function init() {
      scheduler.config.multi_day = false;
      scheduler.config.xml_date="%Y-%m-%d %H:%i";
      scheduler.init('scheduler_here',new Date(),"week");
      scheduler.load(urls.api, 'json');
      scheduler.setLoadMode("week");
      scheduler.config.first_hour = 8;
      scheduler.config.lightbox.sections = [
			{name:"description", height:50, map_to:"text", type:"textarea" , focus:true},
			{name:"Klient", height:30, map_to:"type", type:"select", options: JSON.parse(clients)},
			{name:"time", height:72, type:"time", map_to:"auto"}
		];
      // scheduler.config.time_step = 30;
      // scheduler.config.update_render = true;
      scheduler.config.details_on_dblclick = true;
      scheduler.config.details_on_create = true;

      var filters = {
        training: true,
        availability: false,
      };

      var monthesFNames = ["Sty","Lut","Mar","Kwi","Maj","Cze","Lip","Sie","Wrz","Paź","Lis","Gru"];
      var weekDayFNames = ["Nie", "Pon","Wto","Śro","Czw","Pią","Sob"];

      scheduler.templates.week_scale_date = function(date){
        var date_time = new Date(date);
        return   weekDayFNames[date_time.getDay()] +", "+ monthesFNames[date_time.getMonth()] + " "  + date_time.getDate();
      };

      scheduler.attachEvent('onEventAdded', function(id, event) {
        event.start_unix_date = new Date(event.start_date).getTime() / 1000;
        event.end_unix_date = new Date(event.end_date).getTime() / 1000;
        scheduler.updateEvent(event.id);
        eventService(urls.add_event, {id: id, event: event}, eventAdded);
      });

      scheduler.attachEvent('onEventDeleted', function(id, event) {
        eventService(urls.delete_event, {id: id, event: event});
      });

      scheduler.attachEvent('onEventChanged', function(id, event) {
        event.start_unix_date = new Date(event.start_date).getTime() / 1000;
        event.end_unix_date = new Date(event.end_date).getTime() / 1000;
        scheduler.updateEvent(event.id);
       eventService(urls.change_event, {id: id, event: event});
      });

    	function eventAdded(data){
				var result = JSON.parse(data);
        event.start_unix_date = new Date(event.start_date).getTime() / 1000;
        event.end_unix_date = new Date(event.end_date).getTime() / 1000;
					scheduler.changeEventId(result.client_id, result.new_id);
          return true;
			}

      function eventService (url, data, callback){
        $.ajax({
          url: url,
          type: 'POST',
          data: data,
        })
        .done(function(data) {
          if (callback) {
            callback(data);
          }
        })
      }

    }
  init();

});
