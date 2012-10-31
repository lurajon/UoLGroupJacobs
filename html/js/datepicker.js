var curDate = new Date();
var todaysDate = new Date();

var datePicker = {
     
	// global variables for the datePicker
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
        
        /**
	 * Show the calendar
	 */
        showCalendar : function(element, targetId) {
            this.targetElement = document.getElementById(targetId);
            
            if (this.targetElement == null) {
                if (document.forms[0].elements[targetId])
		{
			this.targetElement = document.forms[0].elements[targetId];
		}
            }
            
            var positions = this.getOffset(this.targetElement);
            
            var calendarBody = document.createElement('div');
            calendarBody.setAttribute('id', 'calendar:popup');
            calendarBody.className = 'ui-calendar box-shadow';
            calendarBody.style.left = positions.left  + 'px';
            calendarBody.style.top = positions.top; + 'px';
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
        
	/**
	 * Update the content of the calendar when changing months
	 */
        updateCalendar : function(monthNumber) {
           
            var calendarBodyElement = document.getElementById('calendar:popup');
            var calendar = this.createCalendar(this.selectedDay, this.selectedMonth, this.selectedYear);
           
           calendarBodyElement.innerHTML = '';
           
           calendarBodyElement.appendChild(calendar);
        },
        
	/**
	 * Get the next month number
	 *
	 * If the next monthnumber exceeds a valid monthnumber, it starts at the first
	 * month
	 */
        getNextMonthNumber : function() {
            this.month++;
            if (this.month == 12) {
                this.month = 0;
                this.year++;
            }
        },
        
	/**
	 * Get the previous month number
	 *
	 * If the next month number is not a valid number, it returns the last month number (-1 = 11)
	 * 
	 */
        getPreviousMonthNumber : function() {
            this.month--;
            if (this.month == -1) {
                this.month = 11;
                this.year--;
            }
        },
        
	/**
	 * Create the calendar
	 */
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
        
	/**
	 * Adds highlight class to the element
	 * 
	 */
        highlightDay : function(element) {
            element.className = element.className + ' highlight';
        },
        
	/**
	 * Removes the highlight class for the element
	 * 
	 */
        resetHighlightDay : function(element) {
            element.className = element.className.replace(' highlight', '');
        },
        
	/**
	 * Select date in the calendar
	 * 
	 */
        pickDate : function(year,month,day) {
            month++;
            day	= day < 10 ? '0'+day : day;
            month	= month < 10 ? '0'+month : month;
            if (!this.targetElement) {
		alert('target for date is not set yet');
            }
	
            else {
		this.targetElement.value= day+'/'+ month +'/'+year;
		
		// set the selected values
		this.selectedDay = day;
		this.selectedMonth = month-1;
		this.selectedYear = year;
		
		// close the calendar
		this.closeCalendar();
            }
        },
        
	/**
	 * Close the calendar
	 */
        closeCalendar : function() {
            var element = document.getElementById('calendar:popup');
            element.parentNode.removeChild(element);
        },
        
	/**
	 * Get the real year number
	 */
        getRealYear : function(dateObj) {
            return (dateObj.getYear() % 100) + (((dateObj.getYear() % 100) < 39) ? 2000 : 1900);
        },
        
	/**
	 * Get the number of days for the given month and year
	 *
	 * Handles leap years
	 * 
	 */
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
        
	/**
	 * Get the offset for the element
	 * 
	 */
        getOffset : function (element) {
	        var x = 0;
		var y = 0;
	
		
		while( element && !isNaN( element.offsetLeft ) && !isNaN( element.offsetTop ) ) {
		    x += element.offsetLeft - element.scrollLeft;
		    y += element.offsetTop - element.scrollTop;
		    element = element.offsetParent;
		}
		return { top: y, left: x };
        }
}
