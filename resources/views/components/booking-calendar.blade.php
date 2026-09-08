@props(['tour'])

<div id="booking-calendar-container" class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="prev-month">&laquo; {{ __('Prev') }}</button>
        <h5 id="calendar-month-year" class="mb-0 fw-bold"></h5>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="next-month">{{ __('Next') }} &raquo;</button>
    </div>
    
    <div class="row g-1 text-center fw-bold mb-2 text-muted small">
        <div class="col">{{ __('Sun') }}</div>
        <div class="col">{{ __('Mon') }}</div>
        <div class="col">{{ __('Tue') }}</div>
        <div class="col">{{ __('Wed') }}</div>
        <div class="col">{{ __('Thu') }}</div>
        <div class="col">{{ __('Fri') }}</div>
        <div class="col">{{ __('Sat') }}</div>
    </div>
    
    <div id="calendar-grid" class="row g-1 text-center">
        <!-- JS will inject days here -->
    </div>
</div>

<style>
    .cal-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: not-allowed;
        background-color: #f8f9fa;
        color: #adb5bd;
    }
    .cal-day.available {
        cursor: pointer;
        background-color: #ffffff;
        color: #212529;
        border-color: var(--theme-primary);
        transition: all 0.2s;
    }
    .cal-day.available:hover {
        background-color: rgba(var(--theme-primary-rgb, 13, 110, 253), 0.1);
    }
    .cal-day.selected {
        background-color: var(--theme-primary);
        color: #ffffff;
        border-color: var(--theme-primary);
    }
    .cal-spots {
        font-size: 0.7rem;
        font-weight: normal;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tourId = {{ $tour->id }};
    const calendarGrid = document.getElementById('calendar-grid');
    const monthYearText = document.getElementById('calendar-month-year');
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    const selectedDateInput = document.getElementById('selected_date');
    const submitBtn = document.getElementById('add-to-cart-btn');
    
    let currentDate = new Date();
    let availabilities = {};
    let selectedDateStr = null;

    // Fetch availability natively using Fetch API (No React/Vue/Axios)
    fetch(`/api/availability/${tourId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                availabilities[item.date] = item.available_spots;
            });
            renderCalendar();
        })
        .catch(err => console.error('Error fetching availability:', err));

    function renderCalendar() {
        calendarGrid.innerHTML = '';
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        monthYearText.textContent = new Intl.DateTimeFormat('{{ app()->getLocale() }}', { month: 'long', year: 'numeric' }).format(currentDate);
        
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Blank spots for offset
        for (let i = 0; i < firstDay; i++) {
            const emptyCol = document.createElement('div');
            emptyCol.className = 'col';
            emptyCol.innerHTML = '<div class="cal-day opacity-0 border-0"></div>';
            calendarGrid.appendChild(emptyCol);
        }
        
        for (let day = 1; day <= daysInMonth; day++) {
            const dateObj = new Date(year, month, day);
            // Format YYYY-MM-DD
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            
            const col = document.createElement('div');
            col.className = 'col';
            
            const dayDiv = document.createElement('div');
            dayDiv.className = 'cal-day';
            dayDiv.textContent = day;
            
            const spots = availabilities[dateStr];
            
            if (spots > 0) {
                dayDiv.classList.add('available');
                const spotsSpan = document.createElement('span');
                spotsSpan.className = 'cal-spots d-block';
                spotsSpan.textContent = `${spots} {{ __('left') }}`;
                dayDiv.appendChild(spotsSpan);
                
                if (dateStr === selectedDateStr) {
                    dayDiv.classList.add('selected');
                }
                
                dayDiv.addEventListener('click', () => {
                    document.querySelectorAll('.cal-day.selected').forEach(el => el.classList.remove('selected'));
                    dayDiv.classList.add('selected');
                    selectedDateStr = dateStr;
                    selectedDateInput.value = dateStr;
                    if(submitBtn) submitBtn.disabled = false;
                });
            }
            
            col.appendChild(dayDiv);
            calendarGrid.appendChild(col);
        }
    }

    prevBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
});
</script>
