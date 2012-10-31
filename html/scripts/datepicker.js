var curDate = new Date();
var todaysDate = new Date();

var datePicker = {
     
        curDay: curDate.getDate(),
        curMonth: curDate.getMonth(),
        curYear: (curDate.getYear() % 100) + (((curDate.getYear() % 100) < 39) ? 2000 : 1900),
        
        selectedDay: curDate.getDate(),
        selectedMonth: curDate.getMonth(),
        selectedYear: (curDate.getYear() % 100) + (((curDate.getYear() % 100) < 39) ? 2000 : 1900),
	
	day: curDate.getDate(),
        month: curDate.getMonth(),
        year: (curDate.getYear() % 100) + (((curDate.getYear() % 100) < 39) ? 2000 : 1900),
        
        dayNames: ['Su', 'Mo', 'Tu','We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthMaxDays : [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        monthMaxDaysLeap : [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
        hideSelectTags : [],
        targetElement : null,
        
        test : function() {
            document.writeln("Test");
        
        },
        
        // show the calendar
        showCalendar : function(element, targetId) {
            this.targetElement = document.getElementById(targetId);
            
            if (this.targetElement == null) {
                if (document.forms[0].elements[targetId])
		{
			this.targetElement = document.forms[0].elements[targetId];
		}
            }
            
            var positions = this.getParentOffset(element);
            
            var calendarBody = document.createElement('div');
            calendarBody.setAttribute('id', 'calendar:popup');
            calendarBody.className = 'ui-calendar box-shadow';
            calendarBody.style.left = positions[0]  + 'px';
            calendarBody.style.top = positions[1]; + 'px';
            //calendarBody.style.backgroundColor = '#333333';
            calendarBody.style.display='block';
            calendarBody.style.position='absolute';
            
            this.targetElement.parentNode.appendChild(calendarBody);
            
            var matchDate = new RegExp('^([0-9]{2})-([0-9]{2})-([0-9]{4})$');
            var m = matchDate.exec(element.value);
            
            if (m == null) {
		var calendar = this.createCalendar(this.selectedDay, this.selectedMonth, this.selectedYear);
                
                calendarBody.appendChild(calendar);
		//showCalenderBody(calendar);
            }
	
        },
        
        updateCalendar : function(monthNumber) {
           
            var calendarBodyElement = document.getElementById('calendar:popup');
            var calendar = this.createCalendar(this.selectedDay, this.selectedMonth, this.selectedYear);
           
           calendarBodyElement.innerHTML = '';
           
           calendarBodyElement.appendChild(calendar);
        },
        
        getNextMonthNumber : function() {
            this.month++;
            if (this.month == 12) {
                this.month = 0;
                this.year++;
            }
        },
        
        getPreviousMonthNumber : function() {
            this.month--;
            if (this.month == -1) {
                this.month = 11;
                this.year--;
            }
        },
        
        createCalendar : function(day, month, year) {
            
            var tableElement = document.createElement('table');
            
		year = this.year;
		month = this.month;
		day = this.day;
            
            
            var yearFound = false;
            
            	 // first day of the month.
            var fristDayOfMonthObj = new Date(year, month, 1);
            var firstDayOfMonth = fristDayOfMonthObj.getDay();

	    firstRow = true;
            var x	= 0;
            var d	= 0;
            var trs = []
            var rowIndex = 0;
            
            var menuRowElement = document.createElement('tr');
	    menuRowElement.className = 'nav-bar';
            var prevMonthCellElement = document.createElement('td');
	    
	    if (year < this.curYear || (year == this.curYear && month <= this.curMonth)) {
		var disabledLink = document.createElement('span');
		disabledLink.className = 'disabled';
		prevMonthCellElement.appendChild(disabledLink);
	    } else {
            var prevLinkElement = document.createElement('a');
		prevLinkElement.className = 'ui-icon prev-link';
		prevLinkElement.setAttribute('onclick', 'datePicker.updateCalendar(datePicker.getPreviousMonthNumber());');
		prevMonthCellElement.appendChild(prevLinkElement);
	    }
            menuRowElement.appendChild(prevMonthCellElement);
            
            var selectedMonthYearInfoElement = document.createElement('td');
            selectedMonthYearInfoElement.className = 'current-title';
            selectedMonthYearInfoElement.colSpan = 5;
            selectedMonthYearInfoElement.style.textAlign = 'center';
            selectedMonthYearInfoElement.innerHTML = this.monthNames[this.month] + ' ' + this.year;
            menuRowElement.appendChild(selectedMonthYearInfoElement);
            
            var nextMonthCellElement = document.createElement('td');
            var nextLinkElement = document.createElement('a');
            nextLinkElement.className = 'ui-icon next-link';
            nextLinkElement.setAttribute('onclick', 'datePicker.updateCalendar(datePicker.getNextMonthNumber());');
            
            nextMonthCellElement.appendChild(nextLinkElement);
            menuRowElement.appendChild(nextMonthCellElement);
            
            tableElement.appendChild(menuRowElement);
            
            var daysRow = document.createElement('tr');
            daysRow.className = 'ui-calendar-hdr';
            
            for (var i = 0; i < this.dayNames.length; i++) {
                var dayCell = document.createElement('th');
                dayCell.innerHTML = this.dayNames[i];
                daysRow.appendChild(dayCell);
            }
            
            tableElement.appendChild(daysRow);
            
            while (d <= this.getDaysPerMonth(month, year)) {
		if (firstRow) {
			
                    trs[rowIndex] = document.createElement('tr');
                    tableElement.appendChild(trs[rowIndex]);
                   	
                    if (firstDayOfMonth > 0) {
				
                        while (x < firstDayOfMonth) {
                            var tdElement = document.createElement('td');
                           
                            trs[rowIndex].appendChild(tdElement);
			    x++;
		    	}
	    	}
    
    		firstRow = false;
	    	var d = 1;
            }

	    if (x % 7 == 0) {
                rowIndex++;
			
                trs[rowIndex] = document.createElement("tr");
                tableElement.appendChild(trs[rowIndex]);
	    }
	
            var id = null;
            var className = null;
            var title = null;
	    
            if (day && d == this.selectedDay && month == this.selectedMonth && year == this.selectedYear ) {
		
                id = 'calenderChoosenDay';
		className = 'choosenDay';
		title = 'this day is currently selected';
	    
            } else if (d == this.curDay && month == this.curMonth && year == this.curYear) {
		
                id = 'calenderToDay';
		className = 'toDay';
		title = 'this day today';
	    
            } else {
		
                id = null;
		className = 'normalDay';
		title = null;
		
            }
		
            var td = document.createElement("td");
	    td.className = className;
	    
            if (id == null) {
		td.id = id;
	    }
		
            if (title == null) {
		td.title = title;
	    }
		
            td.setAttribute('onmouseover','datePicker.highlightDay(this)');
            td.setAttribute('onmouseout', 'datePicker.resetHighlightDay(this)');
           	
		if (this.targetElement) {
			if (year <= this.curYear && month <= this.curMonth && d < this.curDay) {
				td.className = 'disabled';	
			} else {
				td.setAttribute('onclick', 'datePicker.pickDate(' + year +', '+ month +', '+ d + ');');
			}
		} else {
	        td.style.cursor = 'default';
            }
		td.appendChild(document.createTextNode(d));
		trs[rowIndex].appendChild(td);
		x++;
		d++;
            }
            
            return tableElement;
        
        },
        
        highlightDay : function(element) {
            element.className = element.className + ' highlight';
        },
        
        resetHighlightDay : function(element) {
            element.className = element.className.replace(' highlight', '');
        },
        
        pickDate : function(year,month,day) {
            month++;
            day	= day < 10 ? '0'+day : day;
            month	= month < 10 ? '0'+month : month;
            if (!this.targetElement) {
		alert('target for date is not set yet');
            }
	
            else {
		this.targetElement.value= day+'/'+ month +'/'+year;
		this.selectedDay = day;
		this.selectedMonth = month-1;
		this.selectedYear = year;
		
		this.closeCalendar();
            }
        },
        
        closeCalendar : function() {
            var element = document.getElementById('calendar:popup');
            element.parentNode.removeChild(element);
        },
        
        getRealYear : function(dateObj) {
            return (dateObj.getYear() % 100) + (((dateObj.getYear() % 100) < 39) ? 2000 : 1900);
        },
        
        getDaysPerMonth : function(month, year) {
            if ((year % 4) == 0) {
		if ((year % 100) == 0 && (year % 400) != 0) {
		    return this.monthMaxDays[month];
		}
                
                return this.monthMaxDaysLeap[month];
            } else {
                return this.monthMaxDays[month];
            }
        },
        
        getParentOffset : function (element) {
            var top = 0;
            var left = 0;
            
            if (element.offsetParent) {
                do {
                    left += element.offsetLeft;
		    top += element.offsetTop;
                    
                } while (element = element.offsetParent);
            }
            
            return [left, top];
        }
}

function showCalender(elPos, tgtEl)
{
	targetEl = false;

	if (document.getElementById(tgtEl))
	{
		targetEl = document.getElementById(tgtEl);
	}
	else
	{
		if (document.forms[0].elements[tgtEl])
		{
			targetEl = document.forms[0].elements[tgtEl];
		}
	}
	var calTable = document.getElementById('calenderTable');

	var positions = [0,0];
	var positions = getParentOffset(elPos, positions);	
	calTable.style.left = positions[0]+'px';		
	calTable.style.top = positions[1]+'px';			

	calTable.style.display='block';

	var matchDate = new RegExp('^([0-9]{2})-([0-9]{2})-([0-9]{4})$');
	var m = matchDate.exec(targetEl.value);
	if (m == null)
	{
		var calendar = createCalender(false, false, false);
		showCalenderBody(calendar);
	}
	else
	{
		if (m[1].substr(0, 1) == 0)
			m[1] = m[1].substr(1, 1);
		if (m[2].substr(0, 1) == 0)
			m[2] = m[2].substr(1, 1);
		m[2] = m[2] - 1;
		trs = createCalender(m[3], m[2], m[1]);
		showCalenderBody(trs);
	}

	hideSelect(document.body, 1);
}
