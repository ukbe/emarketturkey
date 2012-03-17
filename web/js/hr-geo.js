
		google.load('visualization', '1', {'packages': ['geomap'], 'language': 'tr'});

		var mylist;
		var sehirler;

		google.setOnLoadCallback(drawMap);

function doit(n) {
		$('#_neighborNames').addClass('fg-button-off');
		$('#_cityNames').addClass('fg-button-off');
		drawMap(n);
		populateButton(n);
}

$(document).ready(function() {

		mylist = $('#multi_box ul:eq(0)');
		sehirler = mylist.children('li').get();

		var cList 	= new Array();
		var subList = new Array();
		var BIGList = new Array();
		var EU_Array= new Array();
		var 
		ASe_Array = [],
		ASs_Array = [],
		ASc_Array = [],
		ASm_Array = [],
		ASp_Array = [],

		AFe_Array = [],
		AFc_Array = [],
		AFn_Array = [],
		AFs_Array = [],
		AFw_Array = [],

		AMn_Array = [],
		AMl_Array = [],
		AMs_Array = [],
		AMc_Array = [],

		EUe_Array = [],
		EUn_Array = [],
		EUs_Array = [],
		EUw_Array = [],

		OCE_Array = [], 
		null_Array= [];

		jQuery.getJSON('/uploads/geomap-countries.query', function(data) {
			jQuery.each(data, function (i, h) {
					cList[i] = Array (h.cnt, h.abr, h.nam);
			});
			for (i=0; i < cList.sort().length; i++) {
					$('li.'+cList[i][0]+' ul').append('<li><a href="javascript:doit(\''+cList[i][1]+'\')">'+cList[i][2]+'</a></li>');
			}
		})

//.success(function() { 	alert("second success"); })
//.error(function() { alert("error"); })

		.complete(function() {
				$('#_regionMaps').css('text-align','left').menu({
					content: $('#_regionMaps').next().html(),
					backLink: false,
					showSpeed: 400
				});
			doit('TR');
		});

		$('#_helpMenu').button().click( function(){ help();return false; });

		function help() {
			$('#map_canvas_screen_bg').slideToggle('slow', function(){ $('#map_canvas_screen').show() });
		}

});

		function sehirCikar(n) {			//alert($('#multi_box li:eq('+n+')').text());
			$('#multi_box li:eq('+n+')').css('color','#333').fadeOut('300', function(){sehirler.splice(n, 1);});
			sehirYazdir(sehirler);
		}
		function sehirEkle(name, abbr) {
			sehirler.push('<span class="ui-corner-all">'+abbr+'</span><em>'+name+'</em>');
		}

		function populateButton(country) {
      var neighborList = '<ul>';
      var cityList = '<ul>';
			var query = "http://hr.geek.emt/tr/profile/locationQuery?cc="+country+"&nb=1&lc=1";

			$.getJSON(query,
				function(j){
		      //alert('neighbors: '+j.neighbours.length+', and cities: '+j.cities.length);
		      //alert(j.neighbors[3].cn);
		      for (var i = 0; i < j.neighbours.length; i++) {
		        	if (j.neighbours[i].CN != '')
		        		neighborList += '<li><a href="javascript:doit(\'' + j.neighbours[i].CC + '\')">' + j.neighbours[i].CN + '</a></li>';
		      }
		      for (var i = 0; i < j.cities.length; i++) {
		        		cityList += '<li><a href="javascript:checkCity(\''+country+','+j.cities[i].RC+'\')">' + j.cities[i].RN + '</a></li>';
		      }
		      neighborList+= '</ul>';
		      cityList 		+= '</ul>';
		      $('#_neighborNames').removeClass('fg-button-off').find('em span').text('('+ j.neighbours.length+')').parent().parent().menu({ content: neighborList });
		      $('#_cityNames').removeClass('fg-button-off').find('em span').text('('+ j.cities.length+')').parent().parent().menu({ content: cityList });
				});

		}

    function drawMap(country) {
			if (typeof country != 'string') country = '';
			$('#map_container div:eq(0)').addClass('my_geomap');

			var myMap = new google.visualization.DataTable({"cols":[{"id":"","label":"\u015fehir","pattern":"","type":"string"},{"id":"","label":"İş İlanı","pattern":"","type":"number"},{"id":"HoverText","label":"HOVER","pattern":"","type":"string"}],"rows":[{"c":[{"v":"TR-01","f":null},{"v":0,"f":null},{"v":"Adana","f":null}]},{"c":[{"v":"TR-02","f":null},{"v":0,"f":null},{"v":"Ad\u0131yaman","f":null}]},{"c":[{"v":"TR-03","f":null},{"v":0,"f":null},{"v":"Afyon","f":null}]},{"c":[{"v":"TR-04","f":null},{"v":0,"f":null},{"v":"A\u011fr\u0131","f":null}]},{"c":[{"v":"TR-05","f":null},{"v":0,"f":null},{"v":"Amasya","f":null}]},{"c":[{"v":"TR-06","f":null},{"v":230,"f":null},{"v":"Ankara","f":null}]},{"c":[{"v":"TR-07","f":null},{"v":80,"f":null},{"v":"Antalya","f":null}]},{"c":[{"v":"TR-08","f":null},{"v":15,"f":null},{"v":"Artvin","f":null}]},{"c":[{"v":"TR-09","f":null},{"v":20,"f":null},{"v":"Ayd\u0131n","f":null}]},{"c":[{"v":"TR-10","f":null},{"v":0,"f":null},{"v":"Bal\u0131kesir","f":null}]},{"c":[{"v":"TR-11","f":null},{"v":0,"f":null},{"v":"Bilecik","f":null}]},{"c":[{"v":"TR-12","f":null},{"v":0,"f":null},{"v":"Bing\u00f6l","f":null}]},{"c":[{"v":"TR-13","f":null},{"v":0,"f":null},{"v":"Bitlis","f":null}]},{"c":[{"v":"TR-14","f":null},{"v":8,"f":null},{"v":"Bolu","f":null}]},{"c":[{"v":"TR-15","f":null},{"v":3,"f":null},{"v":"Burdur","f":null}]},{"c":[{"v":"TR-16","f":null},{"v":90,"f":null},{"v":"Bursa","f":null}]},{"c":[{"v":"TR-17","f":null},{"v":12,"f":null},{"v":"\u00c7anakkale","f":null}]},{"c":[{"v":"TR-18","f":null},{"v":0,"f":null},{"v":"\u00c7ank\u0131r\u0131","f":null}]},{"c":[{"v":"TR-19","f":null},{"v":0,"f":null},{"v":"\u00c7orum","f":null}]},{"c":[{"v":"TR-20","f":null},{"v":25,"f":null},{"v":"Denizli","f":null}]},{"c":[{"v":"TR-21","f":null},{"v":30,"f":null},{"v":"Diyarbak\u0131r","f":null}]},{"c":[{"v":"TR-22","f":null},{"v":13,"f":null},{"v":"Edirne","f":null}]},{"c":[{"v":"TR-23","f":null},{"v":0,"f":null},{"v":"Elaz\u0131\u011f","f":null}]},{"c":[{"v":"TR-24","f":null},{"v":0,"f":null},{"v":"Erzincan","f":null}]},{"c":[{"v":"TR-25","f":null},{"v":15,"f":null},{"v":"Erzurum","f":null}]},{"c":[{"v":"TR-26","f":null},{"v":40,"f":null},{"v":"Eski\u015fehir","f":null}]},{"c":[{"v":"TR-27","f":null},{"v":60,"f":null},{"v":"Gaziantep","f":null}]},{"c":[{"v":"TR-28","f":null},{"v":0,"f":null},{"v":"Giresun","f":null}]},{"c":[{"v":"TR-29","f":null},{"v":0,"f":null},{"v":"G\u00fcm\u00fc\u015fhane","f":null}]},{"c":[{"v":"TR-30","f":null},{"v":0,"f":null},{"v":"Hakkari","f":null}]},{"c":[{"v":"TR-31","f":null},{"v":10,"f":null},{"v":"Hatay","f":null}]},{"c":[{"v":"TR-32","f":null},{"v":1,"f":null},{"v":"Isparta","f":null}]},{"c":[{"v":"TR-33","f":null},{"v":10,"f":null},{"v":"\u0130\u00e7el","f":null}]},{"c":[{"v":"TR-34","f":null},{"v":410,"f":null},{"v":"\u0130stanbul","f":null}]},{"c":[{"v":"TR-35","f":null},{"v":120,"f":null},{"v":"\u0130zmir","f":null}]},{"c":[{"v":"TR-36","f":null},{"v":1,"f":null},{"v":"Kars","f":null}]},{"c":[{"v":"TR-37","f":null},{"v":0,"f":null},{"v":"Kastamonu","f":null}]},{"c":[{"v":"TR-38","f":null},{"v":26,"f":null},{"v":"Kayseri","f":null}]},{"c":[{"v":"TR-39","f":null},{"v":0,"f":null},{"v":"K\u0131rklareli","f":null}]},{"c":[{"v":"TR-40","f":null},{"v":0,"f":null},{"v":"K\u0131r\u015fehir","f":null}]},{"c":[{"v":"TR-41","f":null},{"v":69,"f":null},{"v":"Kocaeli","f":null}]},{"c":[{"v":"TR-42","f":null},{"v":33,"f":null},{"v":"Konya","f":null}]},{"c":[{"v":"TR-43","f":null},{"v":5,"f":null},{"v":"K\u00fctahya","f":null}]},{"c":[{"v":"TR-44","f":null},{"v":6,"f":null},{"v":"Malatya","f":null}]},{"c":[{"v":"TR-45","f":null},{"v":21,"f":null},{"v":"Manisa","f":null}]},{"c":[{"v":"TR-46","f":null},{"v":0,"f":null},{"v":"Kahramanmara\u015f","f":null}]},{"c":[{"v":"TR-47","f":null},{"v":0,"f":null},{"v":"Mardin","f":null}]},{"c":[{"v":"TR-48","f":null},{"v":13,"f":null},{"v":"Mu\u011fla","f":null}]},{"c":[{"v":"TR-49","f":null},{"v":1,"f":null},{"v":"Mu\u015f","f":null}]},{"c":[{"v":"TR-50","f":null},{"v":0,"f":null},{"v":"Nev\u015fehir","f":null}]},{"c":[{"v":"TR-51","f":null},{"v":2,"f":null},{"v":"Ni\u011fde","f":null}]},{"c":[{"v":"TR-52","f":null},{"v":1,"f":null},{"v":"Ordu","f":null}]},{"c":[{"v":"TR-53","f":null},{"v":6,"f":null},{"v":"Rize","f":null}]},{"c":[{"v":"TR-54","f":null},{"v":26,"f":null},{"v":"Sakarya","f":null}]},{"c":[{"v":"TR-55","f":null},{"v":7,"f":null},{"v":"Samsun","f":null}]},{"c":[{"v":"TR-56","f":null},{"v":0,"f":null},{"v":"Siirt","f":null}]},{"c":[{"v":"TR-57","f":null},{"v":3,"f":null},{"v":"Sinop","f":null}]},{"c":[{"v":"TR-58","f":null},{"v":10,"f":null},{"v":"Sivas","f":null}]},{"c":[{"v":"TR-59","f":null},{"v":28,"f":null},{"v":"Tekirda\u011f","f":null}]},{"c":[{"v":"TR-60","f":null},{"v":9,"f":null},{"v":"Tokat","f":null}]},{"c":[{"v":"TR-61","f":null},{"v":15,"f":null},{"v":"Trabzon","f":null}]},{"c":[{"v":"TR-62","f":null},{"v":0,"f":null},{"v":"Tunceli","f":null}]},{"c":[{"v":"TR-63","f":null},{"v":5,"f":null},{"v":"\u015eanl\u0131urfa","f":null}]},{"c":[{"v":"TR-64","f":null},{"v":1,"f":null},{"v":"U\u015fak","f":null}]},{"c":[{"v":"TR-65","f":null},{"v":6,"f":null},{"v":"Van","f":null}]},{"c":[{"v":"TR-66","f":null},{"v":0,"f":null},{"v":"Yozgat","f":null}]},{"c":[{"v":"TR-67","f":null},{"v":0,"f":null},{"v":"Zonguldak","f":null}]},{"c":[{"v":"TR-68","f":null},{"v":0,"f":null},{"v":"Aksaray","f":null}]},{"c":[{"v":"TR-69","f":null},{"v":0,"f":null},{"v":"Bayburt","f":null}]},{"c":[{"v":"TR-70","f":null},{"v":0,"f":null},{"v":"Karaman","f":null}]},{"c":[{"v":"TR-71","f":null},{"v":0,"f":null},{"v":"K\u0131r\u0131kkale","f":null}]},{"c":[{"v":"TR-72","f":null},{"v":0,"f":null},{"v":"Batman","f":null}]},{"c":[{"v":"TR-73","f":null},{"v":0,"f":null},{"v":"\u015e\u0131rnak","f":null}]},{"c":[{"v":"TR-74","f":null},{"v":3,"f":null},{"v":"Bart\u0131n","f":null}]},{"c":[{"v":"TR-75","f":null},{"v":0,"f":null},{"v":"Ardahan","f":null}]},{"c":[{"v":"TR-76","f":null},{"v":0,"f":null},{"v":"I\u011fd\u0131r","f":null}]},{"c":[{"v":"TR-77","f":null},{"v":5,"f":null},{"v":"Yalova","f":null}]},
				{"c":[{"v":"TR-78","f":null},{"v": 4,"f":null},{"v":"Karab\u00fck","f":null}]},
				{"c":[{"v":"TR-79","f":null},{"v": 2,"f":null},{"v":"Kilis","f":null}]},
				{"c":[{"v":"TR-80","f":null},{"v": 2,"f":null},{"v":"Osmaniye","f":null}]},
				{"c":[{"v":"TR-81","f":null},{"v": 4,"f":null},{"v":"Düzce","f":null}]},
				{"c":[{"v":"GR-L","f":null}, {"v":20,"f":null},{"v":"Notio Aigaio","f":null}]},
				{"c":[{"v":"GR-E","f":null}, {"v":10,"f":null},{"v":"Thessalia","f":null}]},
				{"c":[{"v":"GR-F","f":null}, {"v":13,"f":null},{"v":"Ionia Nisia","f":null}]},
				{"c":[{"v":"GR-I","f":null}, {"v": 3,"f":null},{"v":"Attiki","f":null}]},
				{"c":[{"v":"IT-82","f":null},{"v": 5,"f":null},{"v":"Sicilia","f":null}]},
				{"c":[{"v":"IT-62","f":null},{"v":22,"f":null},{"v":"Lazio","f":null}]},
				{"c":[{"v":"IT-34","f":null},{"v":20,"f":null},{"v":"Veneto","f":null}]},
				{"c":[{"v":"IT-72","f":null},{"v":10,"f":null},{"v":"Campania","f":null}]},
				{"c":[{"v":"SA-01","f":null},{"v":27,"f":null},{"v":"$NAME","f":null}]}
				],"p":null}, 0.6);

			var options = {};
			options['title'] = 'Report by Geography';
			options['region'] = country;
			//options['colors'] = [0xFFB581, 0xFF8747, 0xc06000]; //orange colors ;
			options['dataMode'] = 'regions';

			var container = document.getElementById('map_canvas');
			var geomap = new google.visualization.GeoMap(container);

		  google.visualization.events.addListener(
				geomap,'regionClick',function(e) {

				if (e['region'].length == 2) 
					{
						doit(e['region']);
						return false;
					}
				else 
				{
					//alert(e['region']); //return false;
	
					var rowindex = myMap.getFilteredRows([{column: 0, value:e['region']}]);
					var sehir = myMap.getValue(rowindex[0],2);
					var ulke = myMap.getValue(rowindex[0],0).substr(0,2);
					var sehirIndex = jQuery.inArray('<span>'+ulke+'</span><em>'+sehir+'</em>', sehirler);
	
				    if (sehirIndex < 0) {
				    		sehirEkle(sehir, ulke);
				    } else {
								sehirCikar(sehirIndex);
		    		}
	
					function sehirYazdir(names) {
						$('#multi_box ul:eq(0)').html("<li onclick='sehirCikar($(this).index())'>" + names.sort().join("</li>\r\n<li onclick='sehirCikar($(this).index())'>") + "</li>\r\n");
					}
	
					sehirler.sort(function(a, b) {
					   var compA = $(a).text().toLowerCase();
					   var compB = $(b).text().toLowerCase();
					   return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
					})
	
					sehirYazdir(sehirler);
				}
		  });

			//alert(myMap.toJSON());
			//alert(myMap.getValue(0,1));
      geomap.draw(myMap, options);
/*
			google.visualization.events.addListener(
				geomap, 'drawingDone', function() {
					alert('go');
			});
*/
    };

// -------------------------------------------------------- //

    $(function(){
	    	// BUTTONS
	    	$('.fg-button').hover(
	    		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
	    		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
	    	);

	    	// MENUS
/*
				$.getJSON("cities.php",
					{id: 1}, 
					function(j){
			      var lists = '<ul>';
			      for (var i = 0; i < j.length; i++) {
			        lists += '<li><a href="javascript:doit(\'' + j[i].rid + '\')">' + j[i].rname + '</a></li>';
			      }
			      lists += '</ul>';
			      //alert(lists);
			      $('#_regionNames').menu({ content: lists });
					});
*/
/*
			$.get('cities.php', function(data){
				$('#_regionNames').menu({ content: data });
			});
*/
//			$('#_regionNames').menu({ content: $('#_regionNames').next().html() });

    });
